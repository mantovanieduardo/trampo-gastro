<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vaga_id');
            $table->foreign('vaga_id')->references('vaga_id')->on('vagas')->onDelete('cascade');
            $table->unsignedBigInteger('remetente_id');
            $table->foreign('remetente_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('destinatario_id');
            $table->foreign('destinatario_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('conteudo');
            $table->boolean('lida')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};
