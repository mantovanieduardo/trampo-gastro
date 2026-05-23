<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\GarcomController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AdminController;
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
    Route::post('/profile/foto', [ProfileController::class, 'updateFoto'])->name('profile.foto');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vagas (acessível a todos logados)
    Route::get('/vagas', [VagaController::class, 'index'])->name('vagas.index');

    // Avaliações
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');

    // Notificações
    Route::get('/notificacoes', [NotificacaoController::class, 'index'])->name('notificacoes.index');
    Route::post('/notificacoes/{id}/lida', [NotificacaoController::class, 'marcarLida'])->name('notificacoes.lida');
    Route::post('/notificacoes/todas-lidas', [NotificacaoController::class, 'marcarTodas'])->name('notificacoes.todas');

    // Mensagens
    Route::get('/mensagens/{vagaId}/{userId}', [MensagemController::class, 'show'])->name('mensagens.show');
    Route::post('/mensagens', [MensagemController::class, 'store'])->name('mensagens.store');

    // Perfil público do restaurante
    Route::get('/restaurantes/{id}', [RestauranteController::class, 'show'])->name('restaurantes.show');

    // --- SÓ RESTAURANTE ---
    // IMPORTANTE: create deve vir ANTES de {id} para não ser capturado como parâmetro
    Route::middleware('checkTipo:restaurante')->group(function () {
        Route::get('/vagas/create', [VagaController::class, 'create'])->name('vagas.create');
        Route::post('/vagas', [VagaController::class, 'store'])->name('vagas.store');
        Route::get('/vagas/{id}/candidatos', [VagaController::class, 'verCandidatos'])->name('vagas.candidatos');
        Route::patch('/vagas/{id}/fechar', [VagaController::class, 'fechar'])->name('vagas.fechar');
        Route::patch('/vagas/{id}/reabrir', [VagaController::class, 'reabrir'])->name('vagas.reabrir');
        Route::post('/candidaturas/{id}/recusar', [VagaController::class, 'recusarCandidato'])->name('candidaturas.recusar');
        Route::patch('/restaurante/perfil', [RestauranteController::class, 'editarPerfil'])->name('restaurante.perfil.update');
    });

    // Rota de detalhes DEPOIS do create para não capturar /vagas/create como {id}
    Route::get('/vagas/{id}', [VagaController::class, 'show'])->name('vagas.show');

    // Aprovar candidato (restaurante)
    Route::post('/candidaturas/{id}/aprovar', [VagaController::class, 'aprovarCandidato'])
        ->name('candidaturas.aprovar');

    // --- SÓ GARÇOM ---
    Route::middleware('checkTipo:garcom')->group(function () {
        Route::post('/vagas/{vaga}/candidatar', [VagaController::class, 'candidatar'])->name('vagas.candidatar');
        Route::get('/minha-agenda', [VagaController::class, 'minhaAgenda'])->name('agenda.index');
        Route::patch('/garcom/perfil', [GarcomController::class, 'editarPerfil'])->name('garcom.perfil.update');
        Route::delete('/candidaturas/{id}/cancelar', [VagaController::class, 'cancelarCandidatura'])->name('candidaturas.cancelar');
    });

    // Perfil público do garçom (restaurante visualiza)
    Route::get('/garcons/{id}', [GarcomController::class, 'show'])->name('garcons.show');

    // --- ADMIN ---
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
        Route::get('/vagas', [AdminController::class, 'vagas'])->name('admin.vagas');
        Route::patch('/usuarios/{id}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.toggle-admin');
    });

});

require __DIR__.'/auth.php';
