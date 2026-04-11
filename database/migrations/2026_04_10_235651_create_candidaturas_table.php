<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('candidaturas');

        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            
            // foreignId cria automaticamente um unsignedBigInteger
            // constrained() vincula à tabela 'vagas' usando a coluna 'vaga_id'
            $table->foreignId('vaga_id')->constrained('vagas', 'vaga_id')->onDelete('cascade');
            
            // Faz o mesmo para o usuário (ID padrão do Laravel é BigInt)
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            
            $table->enum('status', ['pendente', 'aceito', 'recusado'])->default('pendente');
            $table->timestamps();

            // Impede que o mesmo garçom se candidate 2x na mesma vaga
            $table->unique(['vaga_id', 'usuario_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }
};