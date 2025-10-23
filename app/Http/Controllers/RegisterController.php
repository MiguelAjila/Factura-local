<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'tipo_id' => 'required|integer|exists:tipos_usuario,id',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
        ]);

        $empresaId = 1;
        $rolId = DB::table('roles_usuario')->where('nombre', 'empleado')->value('id');

        Usuario::create([
            'empresa_id' => $empresaId,
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tipo_id' => $validated['tipo_id'],
            'rol_id' => $rolId,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'activo' => false, // Usuario inactivo por defecto
        ]);

        return redirect()->route('register')->with('success', 'Usuario registrado correctamente. Espera activación por un administrador.');
    }
}
