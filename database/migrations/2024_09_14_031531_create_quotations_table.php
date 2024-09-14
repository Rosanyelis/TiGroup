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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('correlativo');
            $table->string('customer_name');
            $table->decimal('subtotal', 10, 0);
            $table->decimal('iva', 10, 0);
            $table->decimal('grand_total', 10, 0);
            $table->text('file_propuesta')->nullable();
            $table->text('note')->nullable();
            $table->date('closing_date');
            $table->string('closing_percentage');
            $table->string('invoice_number')->nullable();
            $table->enum('status', ['Cotizado', 'Facturado', 'Pagado'])->default('Cotizado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
