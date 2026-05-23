<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function index()
    {
        $notificacoes = Notificacao::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Marcar as visíveis como lidas após listar
        Notificacao::where('user_id', Auth::id())
            ->where('lida', false)
            ->update(['lida' => true]);

        return view('notificacoes.index', compact('notificacoes'));
    }

    public function marcarLida($id)
    {
        $notificacao = Notificacao::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notificacao->update(['lida' => true]);

        return redirect()->back();
    }

    public function marcarTodas()
    {
        Notificacao::where('user_id', Auth::id())
            ->where('lida', false)
            ->update(['lida' => true]);

        return redirect()->back()->with('sucesso', 'Todas as notificações foram marcadas como lidas.');
    }
}
