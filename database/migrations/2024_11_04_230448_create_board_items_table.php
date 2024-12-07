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
        Schema::create('board_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained('boards')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->date('start-date'); // fecha de inicio
            $table->date('due-date'); // fecha de vencimiento
            $table->text('description');
            $table->string('priority'); // prioridad
            $table->string('badge-text');
            $table->string('badge');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_items');
    }
};
