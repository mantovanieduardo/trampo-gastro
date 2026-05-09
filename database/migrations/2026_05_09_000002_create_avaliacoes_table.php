<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained('vagas', 'vaga_id')->onDelete('cascade');
            $table->foreignId('avaliador_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('avaliado_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('nota'); // 1 a 5 estrelas
            $table->text('comentario')->nullable();
            $table->enum('tipo', ['restaurante_avalia_garcom', 'garcom_avalia_restaurante']);
            $table->timestamps();

            // Cada usuário só pode avaliar uma vez por vaga
            $table->unique(['vaga_id', 'avaliador_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
