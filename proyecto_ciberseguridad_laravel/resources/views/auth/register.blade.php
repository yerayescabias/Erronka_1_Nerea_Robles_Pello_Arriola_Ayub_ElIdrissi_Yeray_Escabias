@extends('layouts.app')

@section('title', 'Registrarse — CiberEskola')

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
    .auth-title   { font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; text-align: center; }
    .auth-subtitle { color: var(--muted); font-size: 0.9rem; text-align: center; margin-bottom: 2rem; }
    .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--muted); }
    .auth-footer a { color: var(--accent2); text-decoration: none; }
    .info-box {
        background: rgba(99,102,241,0.1);
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        color: var(--accent2);
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-box">
        <div class="auth-title">📋 Registrarse</div>
        <div class="auth-subtitle">Activa tu cuenta de alumno</div>

        <div class="info-box">
            ℹ️ Para registrarte, el centro debe haber dado de alta tu correo previamente. Contacta con la administración si tienes problemas.
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Correo electrónico (dado de alta por el centro)</label>
                <input type="email" id="email" name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}" placeholder="tu@correo.com" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Elige una contraseña</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirma la contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repite la contraseña" required>
            </div>
            <button type="submit" class="btn-primary" style="width:100%; padding:0.75rem; font-size:1rem; border-radius:10px; border:none; cursor:pointer; font-family:inherit; margin-top:0.5rem;">
                Activar cuenta
            </button>
        </form>

        <div class="auth-footer">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a><br>
            <a href="{{ route('inicio') }}" style="color:var(--muted); font-size:0.8rem;">← Volver al inicio</a>
        </div>
    </div>
</div>
@endsection
