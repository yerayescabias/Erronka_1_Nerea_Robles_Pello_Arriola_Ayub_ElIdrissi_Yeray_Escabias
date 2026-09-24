@extends('layouts.app')

@section('title', 'Iniciar sesión — CiberEskola')

@section('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-box {
        width: 100%;
        max-width: 420px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2.5rem;
    }
    .auth-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .auth-subtitle {
        color: var(--muted);
        font-size: 0.9rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.875rem;
        color: var(--muted);
    }
    .auth-footer a { color: var(--accent2); text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-box">
        <div class="auth-title">🔐 Iniciar sesión</div>
        <div class="auth-subtitle">Accede a tu cuenta de CiberEskola</div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}" placeholder="tu@correo.com" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:0.5rem;">
                <input type="checkbox" id="remember" name="remember" style="accent-color:var(--accent);">
                <label for="remember" style="margin:0; color:var(--muted); font-size:0.875rem;">Recordarme</label>
            </div>
            <button type="submit" class="btn-primary" style="width:100%; padding:0.75rem; font-size:1rem; border-radius:10px; border:none; cursor:pointer; font-family:inherit; margin-top:0.5rem;">
                Entrar
            </button>
        </form>

        <div class="auth-footer">
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a><br>
            <a href="{{ route('inicio') }}" style="color:var(--muted); font-size:0.8rem;">← Volver al inicio</a>
        </div>
    </div>
</div>
@endsection
