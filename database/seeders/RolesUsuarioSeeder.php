<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles_usuario')->insert([
            ['id' => 1, 'nombre' => 'administrador'],
            ['id' => 2, 'nombre' => 'gerente'],
            ['id' => 3, 'nombre' => 'empleado'],
        ]);
    }
}
