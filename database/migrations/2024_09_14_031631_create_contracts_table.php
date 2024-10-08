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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('correlativo');
            $table->string('dominio')->nullable();
            $table->string('type_contract');
            $table->enum('type', ['annual', 'two years']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('subtotal', 10, 0);
            $table->decimal('iva', 10, 0);
            $table->decimal('grand_total', 10, 0);
            $table->text('note')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['Por Facturar', 'Activo', 'Vencido'])->default('Por Facturar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
