<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\GarcomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard com estatísticas
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- ROTAS PROTEGIDAS POR AUTENTICAÇÃO ---
Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vagas (acessível a todos logados)
    Route::get('/vagas', [VagaController::class, 'index'])->name('vagas.index');
    Route::get('/vagas/{id}', [VagaController::class, 'show'])->name('vagas.show');

    // Avaliações
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');

    // --- SÓ RESTAURANTE ---
    Route::middleware('checkTipo:restaurante')->group(function () {
        Route::get('/vagas/create', [VagaController::class, 'create'])->name('vagas.create');
        Route::post('/vagas', [VagaController::class, 'store'])->name('vagas.store');
        Route::get('/vagas/{id}/candidatos', [VagaController::class, 'verCandidatos'])->name('vagas.candidatos');
        Route::patch('/vagas/{id}/fechar', [VagaController::class, 'fechar'])->name('vagas.fechar');
        Route::patch('/vagas/{id}/reabrir', [VagaController::class, 'reabrir'])->name('vagas.reabrir');
    });

    // Aprovar candidato (restaurante)
    Route::post('/candidaturas/{id}/aprovar', [VagaController::class, 'aprovarCandidato'])
        ->name('candidaturas.aprovar');

    // --- SÓ GARÇOM ---
    Route::middleware('checkTipo:garcom')->group(function () {
        Route::post('/vagas/{vaga}/candidatar', [VagaController::class, 'candidatar'])->name('vagas.candidatar');
        Route::get('/minha-agenda', [VagaController::class, 'minhaAgenda'])->name('agenda.index');
        Route::patch('/garcom/perfil', [GarcomController::class, 'editarPerfil'])->name('garcom.perfil.update');
    });

    // Perfil público do garçom (restaurante visualiza)
    Route::get('/garcons/{id}', [GarcomController::class, 'show'])->name('garcons.show');

});

require __DIR__.'/auth.php';
