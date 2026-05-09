<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];

        if ($user->tipo === 'restaurante') {
            $restaurante = DB::table('restaurantes')->where('usuario_id', $user->id)->first();

            if ($restaurante) {
                $stats['total_vagas'] = DB::table('vagas')
                    ->where('restaurante_id', $restaurante->restaurante_id)
                    ->count();

                $stats['vagas_abertas'] = DB::table('vagas')
                    ->where('restaurante_id', $restaurante->restaurante_id)
                    ->where('status_vaga', 'aberta')
                    ->count();

                $stats['candidaturas_pendentes'] = DB::table('candidaturas')
                    ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
                    ->where('vagas.restaurante_id', $restaurante->restaurante_id)
                    ->where('candidaturas.status', 'pendente')
                    ->count();

                $stats['contratados'] = DB::table('candidaturas')
                    ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
                    ->where('vagas.restaurante_id', $restaurante->restaurante_id)
                    ->where('candidaturas.status', 'aceito')
                    ->count();
            }
        } else {
            $stats['candidaturas_enviadas'] = DB::table('candidaturas')
                ->where('usuario_id', $user->id)
                ->count();

            $stats['trabalhos_confirmados'] = DB::table('candidaturas')
                ->where('usuario_id', $user->id)
                ->where('status', 'aceito')
                ->count();

            $stats['pendentes'] = DB::table('candidaturas')
                ->where('usuario_id', $user->id)
                ->where('status', 'pendente')
                ->count();

            $stats['proximo_trabalho'] = DB::table('candidaturas')
                ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.vaga_id')
                ->where('candidaturas.usuario_id', $user->id)
                ->where('candidaturas.status', 'aceito')
                ->where('vagas.data_hora_inicio', '>=', now())
                ->orderBy('vagas.data_hora_inicio', 'asc')
                ->select('vagas.titulo_vaga', 'vagas.data_hora_inicio')
                ->first();
        }

        return view('dashboard', compact('stats'));
    }
}
