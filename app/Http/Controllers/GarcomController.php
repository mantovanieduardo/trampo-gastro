<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GarcomController extends Controller
{
    public function show($id)
    {
        // Busca o garçom
        $garcom = User::where('id', $id)->where('tipo', 'garcom')->firstOrFail();

        // Perfil extra (tabela garcons)
        $perfil = DB::table('garcons')->where('usuario_id', $id)->first();

        // Média e total de avaliações recebidas
        $avaliacoes = Avaliacao::where('avaliado_id', $id)
            ->where('tipo', 'restaurante_avalia_garcom')
            ->orderBy('created_at', 'desc')
            ->get();

        $mediaAvaliacao = $avaliacoes->avg('nota');
        $totalAvaliacao = $avaliacoes->count();

        // Histórico de trabalhos confirmados
        $historico = DB::table('candidaturas')
            ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
            ->join('restaurantes', 'vagas.restaurante_id', '=', 'restaurantes.restaurante_id')
            ->where('candidaturas.usuario_id', $id)
            ->where('candidaturas.status', 'aceito')
            ->select(
                'vagas.titulo_vaga',
                'vagas.data_hora_inicio',
                'vagas.valor_diaria',
                'restaurantes.nome_fantasia as restaurante'
            )
            ->orderBy('vagas.data_hora_inicio', 'desc')
            ->limit(10)
            ->get();

        return view('garcons.show', compact(
            'garcom',
            'perfil',
            'avaliacoes',
            'mediaAvaliacao',
            'totalAvaliacao',
            'historico'
        ));
    }

    public function editarPerfil(Request $request)
    {
        $request->validate([
            'bio'         => 'nullable|string|max:500',
            'experiencia' => 'nullable|string|max:100',
            'telefone'    => 'nullable|string|max:20',
        ]);

        $perfil = DB::table('garcons')->where('usuario_id', Auth::id())->first();

        if ($perfil) {
            DB::table('garcons')->where('usuario_id', Auth::id())->update([
                'bio'         => $request->bio,
                'experiencia' => $request->experiencia,
                'telefone'    => $request->telefone,
                'updated_at'  => now(),
            ]);
        } else {
            DB::table('garcons')->insert([
                'usuario_id'  => Auth::id(),
                'bio'         => $request->bio,
                'experiencia' => $request->experiencia,
                'telefone'    => $request->telefone,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        return redirect()->back()->with('sucesso', 'Perfil atualizado com sucesso!');
    }
}
