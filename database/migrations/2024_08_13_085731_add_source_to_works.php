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
        Schema::table('works', function (Blueprint $table) {
            $table->enum('source', ['Walk in', 'E-mail', 'WhatsApp', 'Signal'])->default('Walk in')->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->enum('source', ['Walk in', 'E-mail', 'WhatsApp', 'Signal'])->default('Walk in')>after('priority');
        });
    }
};
