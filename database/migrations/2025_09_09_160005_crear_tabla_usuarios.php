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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('razon_social');
            $table->string('rfc')->unique();
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->text('direccion');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('codigo_postal');
            $table->string('pais')->default('México');
            $table->string('ruta_logo')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        Schema::create('tipos_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // cliente, empleado
            $table->timestamps();
        });

        Schema::create('roles_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // administrador, gerente, empleado
            $table->timestamps();
        });

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->foreignId('tipo_id')->constrained('tipos_usuario')->onDelete('restrict');
            $table->timestamp('email_verificado_en')->nullable();
            $table->string('password');
            $table->foreignId('rol_id')->nullable()->constrained('roles_usuario')->onDelete('set null');
            $table->json('permisos')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
        Schema::dropIfExists('tipos_usuario');
        Schema::dropIfExists('roles_usuario');
        Schema::dropIfExists('usuarios');
    }
};
