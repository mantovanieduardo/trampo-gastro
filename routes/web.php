<?php

use App\Http\Controllers\VagaController;
use Illuminate\Support\Facades\Route;

// Página inicial de listagem
Route::get('/vagas', [VagaController::class, 'index'])->name('vagas.index');

// Página do formulário de cadastro
Route::get('/vagas/criar', [VagaController::class, 'create'])->name('vagas.create');

// Rota que recebe os dados do formulário e salva no banco
Route::post('/vagas', [VagaController::class, 'store'])->name('vagas.store');