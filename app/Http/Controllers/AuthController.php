<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesa los datos del login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Verificar si debe cambiar la contraseña
            if ($request->password === '123456' || !Auth::user()->cambio_password) {
                return redirect()->route('password.change');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña son incorrectos.',
        ])->onlyInput('email');
    }

    // MOSTRAR FORMULARIO DE CAMBIO DE CONTRASEÑA (Esto es lo que faltaba)
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // GUARDAR LA NUEVA CONTRASEÑA (Esto también faltaba)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Buscamos al usuario de forma explícita por su ID
        $user = \App\Models\User::find(Auth::id());
        
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->cambio_password = true; 
            $user->save(); 
        }

        return redirect()->route('admin.dashboard')->with('success', '¡Contraseña actualizada correctamente!');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}