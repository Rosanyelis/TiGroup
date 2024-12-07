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
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('cascade');
            $table->foreignId('contract_renewed_id')->nullable()->constrained('contracts')->onDelete('cascade');
            $table->foreignId('quotation_id')->nullable()->constrained('quotations')->onDelete('cascade');
            $table->enum('type', ['Contract', 'Contract Renewed', 'Quotation', 'Invoice External'])->default('Invoice External');
            $table->text('n_invoice_exist')->nullable();
            $table->string('correlativo');
            $table->text('motive');
            $table->decimal('net_amount', 10, 0);
            $table->decimal('iva', 10, 0);
            $table->decimal('additional_tax', 10, 0)->nullable();
            $table->decimal('total', 10, 0);
            $table->string('factura_pdf')->nullable();
            $table->string('n_factura')->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->enum('payment_form', ['Sin Definir','Efectivo', 'Credito', 'Transferencia', 'Cheque', 'WebPay'])->default('Sin Definir');
            $table->enum('status', ['Por Facturar', 'Facturado', 'Vencido', 'Pagado', 'Anulado'])->default('Por Facturar');
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
