<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Permitir login con correo o número de empleado
        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_no';

        if (Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password'], 'is_active' => true])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirección según rol
            if ($user->role === 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            }

            if ($user->role === 'leader') {
                return redirect()->route('production.dashboard');
            }
        }

        return back()->withErrors(['login' => 'Credenciales incorrectas o usuario inactivo.'])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
