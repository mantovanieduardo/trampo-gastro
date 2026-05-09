<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('garcons', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('telefone');
            $table->string('experiencia')->nullable()->after('bio'); // Ex: "3 anos"
        });
    }

    public function down(): void
    {
        Schema::table('garcons', function (Blueprint $table) {
            $table->dropColumn(['bio', 'experiencia']);
        });
    }
};
