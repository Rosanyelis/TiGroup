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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('codigo')->nullable();
            $table->string('description');
            $table->decimal('price', 10, 0);
            $table->integer('quantity');
            $table->decimal('impuesto_adicional', 10, 0)->nullable();
            $table->decimal('descuento', 10, 0)->nullable();
            $table->decimal('total', 10, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
