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
        Schema::create('elementos_factura', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('set null');
            $table->string('nombre_producto');
            $table->text('descripcion')->nullable();
            $table->decimal('cantidad', 15, 2);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('porcentaje_descuento', 5, 2)->default(0);
            $table->decimal('monto_descuento', 15, 2)->default(0);
            $table->decimal('tasa_impuesto', 5, 2)->default(16);
            $table->decimal('monto_impuesto', 15, 2)->default(0);
            $table->decimal('total_linea', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_factura');
    }
};
