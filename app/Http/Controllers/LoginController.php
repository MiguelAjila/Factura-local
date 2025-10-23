<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('bienvenida');
        }
        return back()->with('error', 'Credenciales incorrectas');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear browser cache and prevent caching
        $response = redirect()->route('login');
        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', '0');
    }

    public function bienvenida()
    {
        return view('bienvenida');
    }

    public function updateUserSettings(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Actualizar datos básicos
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            
            // Actualizar contraseña si se proporcionó
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Manejar la carga de la imagen de perfil
            if ($request->hasFile('avatar')) {
                // Eliminar la imagen anterior si existe
                if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                    Storage::delete('public/' . $user->avatar);
                }
                
                // Guardar la nueva imagen
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Configuración actualizada correctamente',
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }
}
