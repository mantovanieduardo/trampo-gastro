<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($outroUsuario->foto_perfil)
                    <img src="{{ Storage::url($outroUsuario->foto_perfil) }}" alt="{{ $outroUsuario->name }}"
                         class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($outroUsuario->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="text-base font-semibold text-gray-800 leading-tight">{{ $outroUsuario->name }}</h2>
                    <p class="text-xs text-gray-400">Conversa sobre: {{ $vaga->titulo_vaga }}</p>
                </div>
            </div>
            <a href="javascript:history.back()" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                &larr; Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl"
         x-data="chat()"
         x-init="scrollToBottom()">

        <!-- Mensagens -->
        <div id="chat-container"
             class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-4">
            <div id="messages-list" class="p-4 space-y-3 max-h-[60vh] overflow-y-auto">
                @forelse($mensagens as $msg)
                    <div class="flex {{ $msg->remetente_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">
                            <div class="{{ $msg->remetente_id == Auth::id()
                                ? 'bg-amber-500 text-white rounded-2xl rounded-tr-sm'
                                : 'bg-gray-100 text-gray-800 rounded-2xl rounded-tl-sm' }} px-4 py-2.5 text-sm">
                                {{ $msg->conteudo }}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1 {{ $msg->remetente_id == Auth::id() ? 'text-right' : 'text-left' }}">
                                {{ $msg->created_at->format('H:i') }}
                                @if($msg->remetente_id != Auth::id())
                                    &mdash; {{ $msg->remetente->name }}
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-gray-400 text-sm">Nenhuma mensagem ainda. Inicie a conversa!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Form de envio -->
        <form action="{{ route('mensagens.store') }}" method="POST"
              class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            @csrf
            <input type="hidden" name="vaga_id" value="{{ $vaga->vaga_id }}">
            <input type="hidden" name="destinatario_id" value="{{ $outroUsuario->id }}">

            <div class="flex gap-3">
                <textarea name="conteudo" rows="2"
                          class="flex-1 border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400 resize-none"
                          placeholder="Digite sua mensagem..."
                          required maxlength="2000"></textarea>
                <button type="submit"
                        class="flex-shrink-0 self-end px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Enviar
                </button>
            </div>

            @if ($errors->any())
                <p class="text-xs text-red-500 mt-2">{{ $errors->first('conteudo') }}</p>
            @endif
        </form>
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
        // Auto scroll on page load
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('messages-list');
            if (el) el.scrollTop = el.scrollHeight;
        });
    </script>
</x-app-layout>
