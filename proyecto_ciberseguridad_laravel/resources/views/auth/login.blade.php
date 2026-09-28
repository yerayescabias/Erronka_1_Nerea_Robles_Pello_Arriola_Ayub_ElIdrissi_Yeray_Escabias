@extends('layouts.app')

@section('title', 'Iniciar sesión — CiberEskola')

@section('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 150px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    .auth-box {
        position: relative;
        width: 100%;
        max-width: 980px;
        min-height: 540px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 2px;
        padding: 4.5rem 5rem 3.5rem 48%;
        box-shadow: 18px 20px 0 rgba(6,40,90,0.08), 0 20px 45px rgba(6,40,90,0.1);
        overflow: hidden;
    }
    .auth-box::before { content: 'CIBER\A ESKOLA'; white-space: pre; position: absolute; inset: 0 auto 0 0; width: 42%; padding: 4rem 2.5rem; background: linear-gradient(150deg, #06285a, #087c73); color: #fff; font-size: clamp(2.4rem, 5vw, 4.5rem); line-height: 0.86; font-weight: 800; letter-spacing: -0.06em; }
    .auth-box::after { content: 'ACCESS / 01\A\A PROTECTED LEARNING ENVIRONMENT'; white-space: pre; position: absolute; left: 2.5rem; bottom: 2.5rem; color: var(--accent2); font: 0.68rem/1.8 'DM Mono', monospace; letter-spacing: 0.08em; }
    .auth-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .auth-logo { display: block; width: 180px; height: 54px; object-fit: contain; margin: 0 auto 1.25rem; }
    .auth-logo-dark { display: none; }
    :root:not([data-theme="light"]) .auth-logo-light { display: none; }
    :root:not([data-theme="light"]) .auth-logo-dark { display: block; object-fit: cover; }
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
    @media (max-width: 680px) { .auth-box { padding: 2rem 1.5rem; min-height: auto; } .auth-box::before, .auth-box::after { display: none; } }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-box">
        <img class="auth-logo auth-logo-light" src="{{ asset('logo-cropped.png') }}" alt="CiberEskola">
        <img class="auth-logo auth-logo-dark" src="{{ asset('logo-dark-transparent.png') }}" alt="CiberEskola">
        <div class="auth-title" data-i18n="login.title">🔐 Iniciar sesión</div>
        <div class="auth-subtitle">Accede a tu cuenta de CiberEskola</div>

        @if($errors->any())
            <div class="alert alert-error error-summary" role="alert">
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
