@extends('layouts.app')

@section('title', 'CiberEskola — Cursos de Ciberseguridad')

@section('styles')
<style>
    .hero {
        text-align: center;
        padding: 4rem 1rem 3rem;
        background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(99,102,241,0.3), transparent);
    }
    .hero h1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        background: linear-gradient(135deg, #818cf8, #6366f1, #a5b4fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
    }
    .hero p {
        font-size: 1.1rem;
        color: var(--muted);
        max-width: 600px;
        margin: 0 auto 2rem;
    }
    .curso-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: all 0.25s;
    }
    .curso-card:hover {
        border-color: var(--accent);
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(99,102,241,0.2);
    }
    .curso-icon {
        font-size: 2rem;
        width: 56px;
        height: 56px;
        background: rgba(99,102,241,0.15);
        border-radius: 12px;
        display: grid;
        place-items: center;
    }
    .curso-nombre { font-size: 1.1rem; font-weight: 700; }
    .curso-desc   { font-size: 0.875rem; color: var(--muted); flex: 1; }
    .curso-meta   { display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; }
    .curso-actions { margin-top: auto; }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--muted);
    }
    .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; }
</style>
@endsection

@section('content')
    {{-- HERO --}}
    <div class="hero">
        <h1>🛡️ CiberEskola</h1>
        <p>Centro de formación en ciberseguridad. Descubre nuestros cursos y empieza tu carrera en el mundo de la seguridad informática.</p>
        @guest
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('login') }}"    class="btn-primary" style="padding:0.75rem 2rem; border-radius:10px; text-decoration:none; font-size:1rem;">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn-outline" style="padding:0.75rem 2rem; border-radius:10px; text-decoration:none; font-size:1rem;">Registrarse</a>
            </div>
        @endguest
    </div>

    {{-- LISTA DE CURSOS --}}
    <div class="section-title">📚 Cursos disponibles</div>

    @if($cursos->isEmpty())
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>No hay cursos disponibles en este momento.<br>Contacta con la administración.</p>
        </div>
    @else
        <div class="grid grid-3">
            @foreach($cursos as $curso)
            <div class="curso-card">
                <div class="curso-icon">
                    @php
                        $icons = ['basico' => '🌱', 'intermedio' => '⚡', 'avanzado' => '🔥'];
                        echo $icons[$curso->nivel] ?? '📘';
                    @endphp
                </div>

                <div class="curso-nombre">{{ $curso->nombre }}</div>

                @if($curso->descripcion)
                    <div class="curso-desc">{{ Str::limit($curso->descripcion, 100) }}</div>
                @endif

                <div class="curso-meta">
                    @if($curso->nivel)
                        @php
                            $badgeClass = ['basico' => 'badge-green', 'intermedio' => 'badge-yellow', 'avanzado' => 'badge-red'][$curso->nivel] ?? 'badge-blue';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($curso->nivel) }}</span>
                    @endif
                    @if($curso->categoria)
                        <span class="badge badge-blue">{{ $curso->categoria }}</span>
                    @endif
                    @if($curso->duracion_horas)
                        <span style="font-size:0.8rem; color:var(--muted)">⏱ {{ $curso->duracion_horas }}h</span>
                    @endif
                </div>

                <div class="curso-actions">
                    @auth
                        @if(Auth::user()->rol === 'alumno')
                            @if(in_array($curso->id, $matriculados ?? []))
                                <span class="badge badge-green" style="padding:0.5rem 1rem;">✅ Matriculado</span>
                            @else
                                <form action="{{ route('alumno.matrikulatu', $curso->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-success" style="width:100%; padding:0.6rem;">Matricularse</button>
                                </form>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-outline" style="display:block; text-align:center; padding:0.6rem; text-decoration:none; border-radius:8px; border:1px solid var(--accent); color:var(--accent2);">
                            Inicia sesión para matricularte
                        </a>
                    @endguest
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endsection
