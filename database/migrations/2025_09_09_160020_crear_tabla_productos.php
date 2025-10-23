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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('codigo_producto')->unique();
            $table->decimal('precio', 15, 2);
            $table->decimal('costo', 15, 2)->default(0);
            $table->integer('cantidad_stock')->default(0);
            $table->integer('nivel_minimo_stock')->default(0);
            $table->string('unidad')->default('pza');
            $table->decimal('tasa_impuesto', 5, 2)->default(16);
            $table->string('categoria')->nullable();
            $table->boolean('activo')->default(true);
            $table->json('imagenes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
