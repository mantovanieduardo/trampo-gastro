<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaga;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;

class VagaController extends Controller
{
    public function minhaAgenda()
    {
        // Garante que só garçons acessem
        if (Auth::user()->tipo !== 'garcom') {
            return redirect('/dashboard')->with('error', 'Acesso não autorizado.');
        }

        // Busca os trabalhos confirmados usando JOINs para pegar os detalhes
        $trabalhos = DB::table('candidaturas')
            ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
            ->join('restaurantes', 'vagas.restaurante_id', '=', 'restaurantes.restaurante_id')
            ->where('candidaturas.usuario_id', Auth::id())
            ->where('candidaturas.status', 'aceito')
            ->select(
                'vagas.titulo_vaga',
                'vagas.valor_diaria',
                'vagas.data_hora_inicio', // O campo que criamos na tela de nova vaga
                'restaurantes.nome_fantasia as restaurante',
                'vagas.status_vaga'
            )
            // Ordena para os trabalhos mais próximos aparecerem primeiro
            ->orderBy('vagas.data_hora_inicio', 'asc') 
            ->get();

        return view('vagas.agenda', compact('trabalhos'));
    }

    public function verCandidatos($id)
{
    // 1. Busca a vaga e garante que pertence ao restaurante logado
    $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
    $vaga = DB::table('vagas')
              ->where('vaga_id', $id)
              ->where('restaurante_id', $restaurante->restaurante_id)
              ->first();

    if (!$vaga) {
        return redirect()->route('vagas.index')->with('error', 'Vaga não encontrada ou acesso negado.');
    }

    // 2. Busca os candidatos dessa vaga fazendo um JOIN com a tabela de usuários para pegar o nome
    $candidaturas = DB::table('candidaturas')
                      ->join('users', 'candidaturas.usuario_id', '=', 'users.id')
                      ->where('candidaturas.vaga_id', $id)
                      ->select('candidaturas.*', 'users.name as nome_garcom', 'users.email')
                      ->get();

    return view('vagas.candidatos', compact('vaga', 'candidaturas'));
}

    public function aprovarCandidato($candidaturaId)
{
    // Busca a candidatura
    $candidatura = DB::table('candidaturas')->where('id', $candidaturaId)->first();

    if (!$candidatura) {
        return redirect()->back()->with('error', 'Candidatura não encontrada.');
    }

    //  Segurança Lógica: Verifica se quem está aprovando é o dono da vaga
    $vaga = DB::table('vagas')->where('vaga_id', $candidatura->vaga_id)->first();
    $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();

    if ($vaga->restaurante_id !== $restaurante->restaurante_id) {
        return redirect()->back()->with('error', 'Ação não autorizada.');
    }

    // Inicia uma Transação para garantir que ou muda tudo ou não muda nada
    DB::transaction(function () use ($candidatura, $vaga) {
        // Muda o status da candidatura
        DB::table('candidaturas')
            ->where('id', $candidatura->id)
            ->update(['status' => 'aceito']);

        // Fecha a vaga para que ninguém mais se candidate
        DB::table('vagas')
            ->where('vaga_id', $vaga->vaga_id)
            ->update(['status_vaga' => 'fechada']);
    });

    return redirect()->back()->with('sucesso', 'Garçom contratado e vaga finalizada!');
}

    public function candidatar($id)
    {
        // 1. Segurança Lógica: Verifica se quem está tentando é um garçom
        if (Auth::user()->tipo !== 'garcom') {
            return redirect()->back()->with('error', 'Apenas garçons podem se candidatar.');
        }

        // 2. Verifica se a vaga existe
        $vaga = Vaga::where('vaga_id', $id)->first();
        if (!$vaga) {
            return redirect()->back()->with('error', 'Vaga não encontrada.');
        }

        // 3. Verifica se o garçom já se candidatou para não duplicar
        $jaCandidatado = DB::table('candidaturas')
            ->where('vaga_id', $id)
            ->where('usuario_id', Auth::id())
            ->exists();

        if ($jaCandidatado) {
            return redirect()->back()->with('error', 'Você já se candidatou a esta vaga!');
        }

        // 4. Cria o vínculo na tabela de candidaturas (tabela pivô)
        DB::table('candidaturas')->insert([
            'vaga_id'    => $id,
            'usuario_id' => Auth::id(), // ID do garçom logado
            'status'     => 'pendente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('sucesso', 'Candidatura enviada com sucesso!');
    }

    // Exibe a lista de vagas
    public function index()
    {
        $vagas = Vaga::all();
        return view('vagas.index', compact('vagas'));
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
            'titulo'     => 'required|string|min:5|max:100', // Obrigatório, texto, entre 5 e 100 letras
            'valor_pago' => 'required|numeric|min:10',       // Obrigatório, número, no mínimo 10 reais
        ], [
            'titulo.required' => 'O título da vaga é obrigatório.',
            'titulo.min'      => 'O título deve ter pelo menos 5 caracteres.',
            'valor_pago.numeric' => 'O valor deve ser um número válido.',
            'valor_pago.min'  => 'O valor da diária não pode ser menor que R$ 10,00.'
        ]);

        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
        
        if (!$restaurante) {
            return redirect()->back()->with('error', 'Perfil de restaurante não encontrado.');
        }

        Vaga::create([
            'restaurante_id' => $restaurante->restaurante_id,
            'titulo_vaga'    => strip_tags($request->titulo), // Segurança Extra contra XSS
            'tipo_contrato'  => 'Freelancer',
            'valor_diaria'   => $request->valor_pago,
            'status_vaga'    => 'aberta'
        ]);

        return redirect('/vagas')->with('sucesso', 'Vaga publicada de forma segura!');
    }
}
