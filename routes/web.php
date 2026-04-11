<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VagaController; // Importante importar seu controller de vagas
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard comum para todos os logados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- ROTAS PROTEGIDAS POR AUTENTICAÇÃO ---
Route::middleware('auth')->group(function () {
    
    // Perfil (Padrão do Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ESTA ROTA FICA AQUI (Fora dos grupos específicos)
    // Agora tanto Garçom quanto Restaurante podem "Ver todas as vagas"
    Route::get('/vagas', [VagaController::class, 'index'])->name('vagas.index');

    // --- SÓ RESTAURANTE ---
    Route::middleware('checkTipo:restaurante')->group(function () {
        Route::get('/vagas/create', [VagaController::class, 'create'])->name('vagas.create');
        Route::post('/vagas', [VagaController::class, 'store'])->name('vagas.store');
        Route::get('/vagas/{id}/candidatos', [VagaController::class, 'verCandidatos'])->name('vagas.candidatos');
    });

    // Rota para aprovar Vaga
    Route::post('/candidaturas/{id}/aprovar', [VagaController::class, 'aprovarCandidato'])
            ->name('candidaturas.aprovar');

    // --- SÓ GARÇOM ---
    Route::middleware('checkTipo:garcom')->group(function () {
        Route::post('/vagas/{vaga}/candidatar', [VagaController::class, 'candidatar'])->name('vagas.candidatar');

        Route::get('/minha-agenda', [VagaController::class, 'minhaAgenda'])->name('agenda.index');
    });

});

require __DIR__.'/auth.php';