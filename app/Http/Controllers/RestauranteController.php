<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestauranteController extends Controller
{
    public function show($id)
    {
        $restaurante = DB::table('restaurantes')->where('restaurante_id', $id)->first();
        if (!$restaurante) {
            abort(404, 'Restaurante não encontrado.');
        }

        $totalVagas = DB::table('vagas')->where('restaurante_id', $id)->count();
        $vagasAbertas = DB::table('vagas')->where('restaurante_id', $id)->where('status_vaga', 'aberta')->count();

        $garConsContratados = DB::table('candidaturas')
            ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
            ->where('vagas.restaurante_id', $id)
            ->where('candidaturas.status', 'aceito')
            ->count();

        $vagasPassadas = DB::table('vagas')
            ->where('restaurante_id', $id)
            ->where('status_vaga', 'fechada')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Avaliações recebidas pelos garçons sobre este restaurante
        $avaliacoes = Avaliacao::where('avaliado_id', $restaurante->usuario_id)
            ->where('tipo', 'garcom_avalia_restaurante')
            ->with('avaliador')
            ->orderBy('created_at', 'desc')
            ->get();

        $mediaAvaliacao = $avaliacoes->avg('nota');

        return view('restaurantes.show', compact(
            'restaurante',
            'totalVagas',
            'vagasAbertas',
            'garConsContratados',
            'vagasPassadas',
            'avaliacoes',
            'mediaAvaliacao'
        ));
    }

    public function editarPerfil(Request $request)
    {
        $request->validate([
            'descricao' => 'nullable|string|max:1000',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
        if (!$restaurante) {
            return redirect()->back()->with('error', 'Perfil de restaurante não encontrado.');
        }

        $dados = ['descricao' => $request->descricao, 'updated_at' => now()];

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotos/restaurantes', 'public');
            $dados['foto'] = $path;
        }

        DB::table('restaurantes')->where('usuario_id', Auth::id())->update($dados);

        return redirect()->back()->with('sucesso', 'Perfil do restaurante atualizado com sucesso!');
    }
}
