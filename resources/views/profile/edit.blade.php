<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Perfil') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl space-y-6">

        @if(session('status') == 'foto-atualizada')
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                Foto de perfil atualizada com sucesso!
            </div>
        @endif

        <!-- Foto de perfil -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Foto de Perfil</h3>
            <div class="flex items-center gap-6">
                @if($user->foto_perfil)
                    <img src="{{ Storage::url($user->foto_perfil) }}"
                         alt="{{ $user->name }}"
                         class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <form action="{{ route('profile.foto') }}" method="POST" enctype="multipart/form-data" class="flex-1">
                    @csrf
                    <div class="flex items-center gap-3">
                        <input type="file" name="foto_perfil" accept="image/*"
                               class="flex-1 border border-gray-200 rounded-lg text-sm px-3 py-2 focus:border-amber-400 focus:ring-amber-400"
                               required>
                        <button type="submit"
                                class="flex-shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            Salvar foto
                        </button>
                    </div>
                    @error('foto_perfil')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg rounded-xl border border-gray-200">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg rounded-xl border border-gray-200">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg rounded-xl border border-gray-200">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
