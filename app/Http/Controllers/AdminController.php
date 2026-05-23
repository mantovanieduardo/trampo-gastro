<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalGarcons = User::where('tipo', 'garcom')->count();
        $totalRestaurantes = User::where('tipo', 'restaurante')->count();
        $totalVagas = Vaga::count();
        $vagasAbertas = Vaga::where('status_vaga', 'aberta')->count();
        $totalCandidaturas = DB::table('candidaturas')->count();
        $candidaturasAceitas = DB::table('candidaturas')->where('status', 'aceito')->count();
        $receitaTotal = DB::table('candidaturas')
            ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
            ->where('candidaturas.status', 'aceito')
            ->sum('vagas.valor_diaria');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalGarcons',
            'totalRestaurantes',
            'totalVagas',
            'vagasAbertas',
            'totalCandidaturas',
            'candidaturasAceitas',
            'receitaTotal'
        ));
    }

    public function usuarios()
    {
        $usuarios = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.usuarios', compact('usuarios'));
    }

    public function vagas()
    {
        $vagas = DB::table('vagas')
            ->join('restaurantes', 'vagas.restaurante_id', '=', 'restaurantes.restaurante_id')
            ->select('vagas.*', 'restaurantes.nome_fantasia as restaurante')
            ->orderBy('vagas.created_at', 'desc')
            ->paginate(20);

        return view('admin.vagas', compact('vagas'));
    }

    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);

        // Não remover admin de si mesmo
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Você não pode alterar seu próprio status de admin.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $acao = $user->is_admin ? 'promovido a admin' : 'removido do admin';
        return redirect()->back()->with('sucesso', "Usuário {$user->name} foi {$acao}.");
    }
}
