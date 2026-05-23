<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaga;
use App\Models\Avaliacao;
use App\Mail\GarcomAprovado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class VagaController extends Controller
{
    // Lista de vagas com busca e paginação
    public function index(Request $request)
    {
        $query = Vaga::query();

        if ($request->filled('busca')) {
            $query->where('titulo_vaga', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_vaga', $request->status);
        }

        $vagas = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('vagas.index', compact('vagas'));
    }

    // Detalhes de uma vaga
    public function show($id)
    {
        $vaga = Vaga::where('vaga_id', $id)->firstOrFail();
        $restaurante = DB::table('restaurantes')
            ->where('restaurante_id', $vaga->restaurante_id)
            ->first();

        $totalCandidatos = DB::table('candidaturas')->where('vaga_id', $id)->count();

        // Verifica se o garçom já se candidatou
        $jaCandidatou = false;
        if (Auth::user()->tipo === 'garcom') {
            $jaCandidatou = DB::table('candidaturas')
                ->where('vaga_id', $id)
                ->where('usuario_id', Auth::id())
                ->exists();
        }

        return view('vagas.show', compact('vaga', 'restaurante', 'totalCandidatos', 'jaCandidatou'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('vagas.create');
    }

    // Salva os dados no banco
    public function store(Request $request)
    {
        $request->validate([
            'titulo'           => 'required|string|min:5|max:100',
            'valor_pago'       => 'required|numeric|min:10',
            'data_hora_inicio' => 'required|date|after:now',
        ], [
            'titulo.required'          => 'O título da vaga é obrigatório.',
            'titulo.min'               => 'O título deve ter pelo menos 5 caracteres.',
            'valor_pago.numeric'       => 'O valor deve ser um número válido.',
            'valor_pago.min'           => 'O valor da diária não pode ser menor que R$ 10,00.',
            'data_hora_inicio.required' => 'A data e hora de início são obrigatórias.',
            'data_hora_inicio.after'   => 'A data de início deve ser no futuro.',
        ]);

        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();

        if (!$restaurante) {
            return redirect()->back()->with('error', 'Perfil de restaurante não encontrado.');
        }

        Vaga::create([
            'restaurante_id'   => $restaurante->restaurante_id,
            'titulo_vaga'      => strip_tags($request->titulo),
            'descricao'        => strip_tags($request->descricao),
            'tipo_contrato'    => 'Freelancer',
            'valor_diaria'     => $request->valor_pago,
            'status_vaga'      => 'aberta',
            'data_hora_inicio' => $request->data_hora_inicio,
        ]);

        return redirect()->route('vagas.index')->with('sucesso', 'Vaga publicada com sucesso!');
    }

    // Fechar vaga manualmente
    public function fechar($id)
    {
        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
        $vaga = Vaga::where('vaga_id', $id)
            ->where('restaurante_id', $restaurante->restaurante_id)
            ->firstOrFail();

        $vaga->update(['status_vaga' => 'fechada']);

        return redirect()->back()->with('sucesso', 'Vaga encerrada com sucesso.');
    }

    // Reabrir vaga
    public function reabrir($id)
    {
        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
        $vaga = Vaga::where('vaga_id', $id)
            ->where('restaurante_id', $restaurante->restaurante_id)
            ->firstOrFail();

        $vaga->update(['status_vaga' => 'aberta']);

        return redirect()->back()->with('sucesso', 'Vaga reaberta com sucesso.');
    }

    // Ver candidatos de uma vaga
    public function verCandidatos($id)
    {
        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
        $vaga = DB::table('vagas')
            ->where('vaga_id', $id)
            ->where('restaurante_id', $restaurante->restaurante_id)
            ->first();

        if (!$vaga) {
            return redirect()->route('vagas.index')->with('error', 'Vaga não encontrada ou acesso negado.');
        }

        $candidaturas = DB::table('candidaturas')
            ->join('users', 'candidaturas.usuario_id', '=', 'users.id')
            ->where('candidaturas.vaga_id', $id)
            ->select('candidaturas.*', 'users.name as nome_garcom', 'users.email', 'users.id as user_id')
            ->get();

        // Avaliações já feitas pelo restaurante nesta vaga
        $avaliacoesFeitas = Avaliacao::where('vaga_id', $id)
            ->where('avaliador_id', Auth::id())
            ->pluck('avaliado_id')
            ->toArray();

        return view('vagas.candidatos', compact('vaga', 'candidaturas', 'avaliacoesFeitas'));
    }

    // Aprovar candidato
    public function aprovarCandidato($candidaturaId)
    {
        $candidatura = DB::table('candidaturas')->where('id', $candidaturaId)->first();

        if (!$candidatura) {
            return redirect()->back()->with('error', 'Candidatura não encontrada.');
        }

        $vaga = DB::table('vagas')->where('vaga_id', $candidatura->vaga_id)->first();
        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();

        if ($vaga->restaurante_id !== $restaurante->restaurante_id) {
            return redirect()->back()->with('error', 'Ação não autorizada.');
        }

        DB::transaction(function () use ($candidatura, $vaga) {
            DB::table('candidaturas')
                ->where('id', $candidatura->id)
                ->update(['status' => 'aceito']);

            DB::table('vagas')
                ->where('vaga_id', $vaga->vaga_id)
                ->update(['status_vaga' => 'fechada']);
        });

        // Enviar e-mail de notificação ao garçom
        try {
            $garcom = DB::table('users')->where('id', $candidatura->usuario_id)->first();
            $dataFormatada = $vaga->data_hora_inicio
                ? date('d/m/Y \à\s H:i', strtotime($vaga->data_hora_inicio))
                : 'A definir';

            Mail::to($garcom->email)->send(new GarcomAprovado(
                nomeGarcom:      $garcom->name,
                tituloVaga:      $vaga->titulo_vaga,
                nomeRestaurante: $restaurante->nome_fantasia,
                dataHora:        $dataFormatada,
                valor:           'R$ ' . number_format($vaga->valor_diaria, 2, ',', '.'),
            ));
        } catch (\Exception $e) {
            // E-mail falhou, mas a aprovação já foi salva — não quebra o fluxo
        }

        return redirect()->back()->with('sucesso', 'Garçom contratado! Um e-mail de confirmação foi enviado.');
    }

    // Garçom se candidata a uma vaga
    public function candidatar($id)
    {
        if (Auth::user()->tipo !== 'garcom') {
            return redirect()->back()->with('error', 'Apenas garçons podem se candidatar.');
        }

        $vaga = Vaga::where('vaga_id', $id)->first();
        if (!$vaga) {
            return redirect()->back()->with('error', 'Vaga não encontrada.');
        }

        $jaCandidatado = DB::table('candidaturas')
            ->where('vaga_id', $id)
            ->where('usuario_id', Auth::id())
            ->exists();

        if ($jaCandidatado) {
            return redirect()->back()->with('error', 'Você já se candidatou a esta vaga!');
        }

        DB::table('candidaturas')->insert([
            'vaga_id'    => $id,
            'usuario_id' => Auth::id(),
            'status'     => 'pendente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('sucesso', 'Candidatura enviada com sucesso!');
    }

    // Agenda do garçom
    public function minhaAgenda()
    {
        if (Auth::user()->tipo !== 'garcom') {
            return redirect('/dashboard')->with('error', 'Acesso não autorizado.');
        }

        $trabalhos = DB::table('candidaturas')
            ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
            ->join('restaurantes', 'vagas.restaurante_id', '=', 'restaurantes.restaurante_id')
            ->join('users as u_restaurante', 'restaurantes.usuario_id', '=', 'u_restaurante.id')
            ->where('candidaturas.usuario_id', Auth::id())
            ->where('candidaturas.status', 'aceito')
            ->select(
                'candidaturas.vaga_id',
                'vagas.titulo_vaga',
                'vagas.valor_diaria',
                'vagas.data_hora_inicio',
                'restaurantes.nome_fantasia as restaurante',
                'u_restaurante.id as restaurante_user_id',
                'vagas.status_vaga'
            )
            ->orderBy('vagas.data_hora_inicio', 'asc')
            ->get();

        // Avaliações já feitas pelo garçom
        $avaliacoesFeitas = Avaliacao::where('avaliador_id', Auth::id())
            ->pluck('vaga_id')
            ->toArray();

        return view('vagas.agenda', compact('trabalhos', 'avaliacoesFeitas'));
    }
}
