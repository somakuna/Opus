<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('circular_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circular_id');
            $table->date('due_date');
            $table->date('charged_at')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['circular_id', 'due_date']);

            $table->foreign('circular_id')
                ->references('id')
                ->on('circulars')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('circular_charges');
    }
};
