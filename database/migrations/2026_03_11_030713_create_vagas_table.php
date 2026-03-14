<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('vagas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo'); // Ex: Garçom para Sábado à Noite
        $table->text('descricao');
        $table->decimal('valor_pago', 8, 2); // Ex: 150.00
        $table->dateTime('data_hora_inicio');
        $table->string('status')->default('aberta'); // aberta, preenchida, finalizada
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};
