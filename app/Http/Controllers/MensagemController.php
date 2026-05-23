<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MensagemController extends Controller
{
    public function show($vagaId, $userId)
    {
        $vaga = DB::table('vagas')->where('vaga_id', $vagaId)->firstOrFail();
        $outroUsuario = DB::table('users')->where('id', $userId)->firstOrFail();

        // Verificar que o usuário logado tem acesso a essa conversa (é um dos dois lados)
        $meId = Auth::id();
        if ($meId != $userId) {
            // Verificar se existe candidatura entre os dois nessa vaga
            $temAcesso = DB::table('candidaturas')
                ->where('vaga_id', $vagaId)
                ->where(function ($q) use ($meId, $userId) {
                    $q->where('usuario_id', $meId)->orWhere('usuario_id', $userId);
                })
                ->exists();

            // Ou se é o dono do restaurante
            $restaurante = DB::table('restaurantes')->where('usuario_id', $meId)->first();
            if ($restaurante) {
                $temAcesso = DB::table('vagas')
                    ->where('vaga_id', $vagaId)
                    ->where('restaurante_id', $restaurante->restaurante_id)
                    ->exists();
            }

            if (!$temAcesso) {
                abort(403, 'Acesso negado.');
            }
        }

        // Buscar mensagens da conversa
        $mensagens = Mensagem::where('vaga_id', $vagaId)
            ->where(function ($q) use ($meId, $userId) {
                $q->where(function ($inner) use ($meId, $userId) {
                    $inner->where('remetente_id', $meId)->where('destinatario_id', $userId);
                })->orWhere(function ($inner) use ($meId, $userId) {
                    $inner->where('remetente_id', $userId)->where('destinatario_id', $meId);
                });
            })
            ->with('remetente')
            ->orderBy('created_at', 'asc')
            ->get();

        // Marcar como lidas as mensagens recebidas
        Mensagem::where('vaga_id', $vagaId)
            ->where('remetente_id', $userId)
            ->where('destinatario_id', $meId)
            ->where('lida', false)
            ->update(['lida' => true]);

        return view('mensagens.show', compact('vaga', 'outroUsuario', 'mensagens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vaga_id'          => 'required|integer',
            'destinatario_id'  => 'required|integer|exists:users,id',
            'conteudo'         => 'required|string|max:2000',
        ]);

        $mensagem = Mensagem::create([
            'vaga_id'         => $request->vaga_id,
            'remetente_id'    => Auth::id(),
            'destinatario_id' => $request->destinatario_id,
            'conteudo'        => $request->conteudo,
        ]);

        // Criar notificação para o destinatário
        $remetente = Auth::user();
        $vaga = DB::table('vagas')->where('vaga_id', $request->vaga_id)->first();
        Notificacao::create([
            'user_id'  => $request->destinatario_id,
            'titulo'   => 'Nova mensagem de ' . $remetente->name,
            'mensagem' => 'Você recebeu uma mensagem sobre a vaga "' . ($vaga->titulo_vaga ?? '') . '".',
            'link'     => route('mensagens.show', [$request->vaga_id, Auth::id()]),
        ]);

        return redirect()->route('mensagens.show', [$request->vaga_id, $request->destinatario_id]);
    }
}
