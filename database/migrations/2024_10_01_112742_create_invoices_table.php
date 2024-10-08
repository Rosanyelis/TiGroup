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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('n_factura');
            $table->decimal('monto_neto', 10, 0);
            $table->decimal('iva', 10, 0);
            $table->decimal('impuesto_adicional', 10, 0);
            $table->decimal('total', 10, 0);
            $table->string('factura_pdf')->nullable();
            $table->date('fecha_factura');
            $table->enum('forma_pago', ['Contado', 'Credito', 'Transferencia', 'Cheque'])->default('Contado');
            $table->enum('status', ['Por Facturar', 'Activo', 'Vencido', 'Pagado'])->default('Por Facturar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
