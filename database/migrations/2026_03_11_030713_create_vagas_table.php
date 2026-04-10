<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('vagas')) {
            Schema::create('vagas', function (Blueprint $table) {
                $table->id('vaga_id');
                $table->unsignedBigInteger('restaurante_id');
                $table->string('titulo_vaga');
                $table->string('tipo_contrato');
                $table->decimal('valor_diaria', 8, 2);
                $table->string('status_vaga')->default('aberta');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};