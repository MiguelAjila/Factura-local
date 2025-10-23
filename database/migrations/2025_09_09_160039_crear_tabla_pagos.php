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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('numero_pago')->unique();
            $table->date('fecha_pago');
            $table->decimal('monto', 15, 2);
            $table->enum('metodo_pago', ['efectivo', 'transferencia_bancaria', 'tarjeta_credito', 'tarjeta_debito', 'cheque', 'otro']);
            $table->string('numero_referencia')->nullable();
            $table->text('notas')->nullable();
            $table->enum('estado', ['pendiente', 'completado', 'fallido', 'cancelado'])->default('completado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
