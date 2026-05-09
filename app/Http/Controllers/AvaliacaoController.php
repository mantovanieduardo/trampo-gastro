<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vaga_id'     => 'required|integer',
            'avaliado_id' => 'required|integer',
            'nota'        => 'required|integer|min:1|max:5',
            'comentario'  => 'nullable|string|max:500',
            'tipo'        => 'required|in:restaurante_avalia_garcom,garcom_avalia_restaurante',
        ]);

        // Verifica se já avaliou
        $jaAvaliou = Avaliacao::where('vaga_id', $request->vaga_id)
            ->where('avaliador_id', Auth::id())
            ->exists();

        if ($jaAvaliou) {
            return redirect()->back()->with('error', 'Você já avaliou esta vaga.');
        }

        // Verifica se tem vínculo com a vaga
        $temVinculo = false;

        if ($request->tipo === 'restaurante_avalia_garcom') {
            $restaurante = DB::table('restaurantes')->where('usuario_id', Auth::id())->first();
            if ($restaurante) {
                $temVinculo = DB::table('vagas')
                    ->where('vaga_id', $request->vaga_id)
                    ->where('restaurante_id', $restaurante->restaurante_id)
                    ->exists();
            }
        } else {
            $temVinculo = DB::table('candidaturas')
                ->where('vaga_id', $request->vaga_id)
                ->where('usuario_id', Auth::id())
                ->where('status', 'aceito')
                ->exists();
        }

        if (!$temVinculo) {
            return redirect()->back()->with('error', 'Você não tem permissão para avaliar esta vaga.');
        }

        Avaliacao::create([
            'vaga_id'     => $request->vaga_id,
            'avaliador_id' => Auth::id(),
            'avaliado_id' => $request->avaliado_id,
            'nota'        => $request->nota,
            'comentario'  => $request->comentario,
            'tipo'        => $request->tipo,
        ]);

        return redirect()->back()->with('sucesso', 'Avaliação enviada com sucesso!');
    }
}
