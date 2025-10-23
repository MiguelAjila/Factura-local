<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('empresas')->insert([
            'id' => 1,
            'nombre' => 'Importadora LV',
            'razon_social' => 'Grupo Info S.A',
            'rfc' => 'XAXX010101000',
            'email' => 'contacto@importadoralv.com',
            'telefono' => '5551234567',
            'direccion' => 'Av. Principal 123, Col. Centro',
            'ciudad' => 'Ciudad de México',
            'estado' => 'CDMX',
            'codigo_postal' => '06000',
            'pais' => 'México',
            'ruta_logo' => null,
            'activa' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
