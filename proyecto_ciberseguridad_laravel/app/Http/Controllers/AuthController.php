<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ── Login ──────────────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Formato de correo no válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'Mínimo 6 caracteres.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        return $this->redirectByRole();
    }

    // ── Registro (solo si el admin lo pre-registró) ────────
    public function showRegister()
    {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Comprobar que el admin ya lo dio de alta sin contraseña
        if (!User::estaPreRegistrado($request->email)) {
            return back()->withErrors([
                'email' => 'Tu correo no está registrado por el centro. Contacta con la administración.'
            ])->withInput();
        }

        // Activar la cuenta con la contraseña elegida
        $user = User::where('email', $request->email)->first();
        $user->password_hash = Hash::make($request->password);
        $user->pre_registrado = false;
        $user->save();

        Auth::login($user);
        return redirect()->route('alumno.dashboard');
    }

    // ── Logout ─────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('inicio');
    }

    // ── Redirección por rol ────────────────────────────────
    private function redirectByRole()
    {
        return Auth::user()->rol === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('alumno.dashboard');
    }
}
