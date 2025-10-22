<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->text('client');
            $table->integer('priority');
            $table->integer('sort_order');
            $table->text('description');
            $table->text('note')->nullable();
            $table->integer('price')->default(0);
            $table->enum('payment_method', ['Cash', 'R1'])->default('Cash');
            $table->boolean('outsourced')->default(0);
            $table->boolean('design')->default(0);
            $table->boolean('ready')->default(0);
            $table->boolean('delivered')->default(0);
            $table->boolean('paid')->default(0);
            $table->integer('outsourced_price')->nullable();
            $table->boolean('printed')->default(0);
            $table->foreignId('partner_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
