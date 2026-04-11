<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            // Adiciona a coluna logo depois de 'valor_diaria'
            $table->dateTime('data_hora_inicio')->nullable()->after('valor_diaria');
        });
    }

    public function down(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            // Se precisar reverter, ele apaga a coluna
            $table->dropColumn('data_hora_inicio');
        });
    }
};