<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="flex-shrink-0 p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                @if($outroUsuario->foto_perfil)
                    <img src="{{ Storage::url($outroUsuario->foto_perfil) }}" alt="{{ $outroUsuario->name }}"
                         class="w-9 h-9 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-9 h-9 rounded-full bg-orange-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($outroUsuario->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="text-sm font-semibold text-slate-900 leading-tight">{{ $outroUsuario->name }}</h2>
                    <p class="text-xs text-slate-400 truncate max-w-[200px]">{{ $vaga->titulo_vaga }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl flex flex-col"
         style="height: calc(100vh - 180px);"
         x-data="chat()"
         x-init="scrollToBottom()">

        <!-- Área de mensagens -->
        <div id="messages-list"
             class="flex-1 overflow-y-auto bg-white rounded-2xl border border-slate-100 shadow-sm p-4 space-y-3 mb-3">
            @forelse($mensagens as $msg)
                <div class="flex {{ $msg->remetente_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[80%]">
                        <div class="{{ $msg->remetente_id == Auth::id()
                            ? 'bg-orange-500 text-white rounded-2xl rounded-tr-sm'
                            : 'bg-slate-100 text-slate-800 rounded-2xl rounded-tl-sm' }} px-4 py-2.5 text-sm leading-relaxed">
                            {{ $msg->conteudo }}
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1 {{ $msg->remetente_id == Auth::id() ? 'text-right' : 'text-left' }}">
                            {{ $msg->created_at->format('H:i') }}
                            @if($msg->remetente_id != Auth::id())
                                &mdash; {{ $msg->remetente->name }}
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-32">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                        </div>
                        <p class="text-slate-400 text-sm">Nenhuma mensagem ainda.</p>
                        <p class="text-slate-400 text-xs mt-1">Inicie a conversa!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Formulário de envio fixo -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex-shrink-0">
            <form action="{{ route('mensagens.store') }}" method="POST">
                @csrf
                <input type="hidden" name="vaga_id" value="{{ $vaga->vaga_id }}">
                <input type="hidden" name="destinatario_id" value="{{ $outroUsuario->id }}">

                <div class="flex gap-3 items-end">
                    <textarea name="conteudo" rows="2"
                              class="flex-1 border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400 resize-none"
                              placeholder="Digite sua mensagem..."
                              required maxlength="2000"></textarea>
                    <button type="submit"
                            class="flex-shrink-0 w-11 h-11 bg-orange-500 hover:bg-orange-600 text-white rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </button>
                </div>

                @if ($errors->any())
                    <p class="text-xs text-rose-500 mt-2">{{ $errors->first('conteudo') }}</p>
                @endif
            </form>
        </div>
    </div>

    <script>
        function chat() {
            return {
                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('messages-list');
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('messages-list');
            if (el) el.scrollTop = el.scrollHeight;
        });
    </script>
</x-app-layout>
