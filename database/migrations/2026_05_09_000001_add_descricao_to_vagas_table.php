<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->text('descricao')->nullable()->after('titulo_vaga');
        });
    }

    public function down(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn('descricao');
        });
    }
};
