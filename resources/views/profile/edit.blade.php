<x-app-layout>
    <x-slot name="header">
        <h2 class="text-base font-semibold text-slate-700 leading-tight">Meu Perfil</h2>
    </x-slot>

    <div class="max-w-3xl space-y-5">

        @if(session('status') == 'foto-atualizada')
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                Foto de perfil atualizada com sucesso!
            </div>
        @endif

        <!-- Foto de perfil -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-5">Foto de Perfil</h3>

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                <!-- Avatar com botão de editar sobreposto -->
                <div class="relative flex-shrink-0">
                    @if($user->foto_perfil)
                        <img src="{{ Storage::url($user->foto_perfil) }}"
                             alt="{{ $user->name }}"
                             class="w-20 h-20 rounded-2xl object-cover">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-orange-500 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-slate-900 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </div>
                </div>

                <form action="{{ route('profile.foto') }}" method="POST" enctype="multipart/form-data" class="flex-1 w-full">
                    @csrf
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alterar foto</label>
                    <div class="flex flex-col sm:flex-row items-stretch gap-3">
                        <input type="file" name="foto_perfil" accept="image/*"
                               class="flex-1 border border-slate-200 rounded-xl text-sm px-3 py-2.5 focus:border-orange-400 focus:ring-orange-400"
                               required>
                        <button type="submit"
                                class="flex-shrink-0 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95 min-h-[44px]">
                            Salvar foto
                        </button>
                    </div>
                    @error('foto_perfil')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

        <!-- Informações do perfil -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Informações Pessoais</h3>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Senha -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Alterar Senha</h3>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Zona de perigo -->
        <div class="bg-white rounded-2xl border border-rose-100 shadow-sm">
            <div class="px-6 py-4 border-b border-rose-100">
                <h3 class="text-sm font-semibold text-rose-700">Zona de Perigo</h3>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
