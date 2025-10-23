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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade'); // Empleado que factura
            $table->foreignId('cliente_id')->constrained('usuarios')->onDelete('cascade'); // Cliente que recibe la factura
            $table->string('numero_factura')->unique();
            $table->date('fecha_factura');
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['borrador', 'enviada', 'pagada', 'vencida', 'cancelada'])->default('borrador');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('monto_impuestos', 15, 2)->default(0);
            $table->decimal('monto_descuento', 15, 2)->default(0);
            $table->decimal('monto_total', 15, 2);
            $table->decimal('monto_pagado', 15, 2)->default(0);
            $table->decimal('saldo_pendiente', 15, 2);
            $table->text('notas')->nullable();
            $table->text('terminos_condiciones')->nullable();
            $table->string('moneda', 3)->default('MXN');
            $table->json('metodos_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
