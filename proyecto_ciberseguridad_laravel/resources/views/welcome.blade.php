@extends('layouts.app')

@section('title', 'CiberEskola — Cursos de Ciberseguridad')

@section('styles')
<style>
    .hero {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(260px, 0.9fr);
        gap: 3rem;
        align-items: center;
        text-align: left;
        padding: 5rem 2rem 4.5rem;
        overflow: hidden;
        background: rgba(14,22,32,0.9);
        border: 1px solid var(--border);
        box-shadow: 0 18px 50px rgba(6,40,90,0.08);
    }
    :root[data-theme="light"] .hero { background: rgba(251,254,253,0.88); }
    .hero::before {
        content: 'SECURITY ACADEMY / 2026';
        position: absolute;
        top: 1.5rem;
        left: 2rem;
        color: var(--yellow);
        font: 500 0.7rem 'DM Mono', monospace;
        letter-spacing: 0.14em;
    }
    .hero::after {
        content: 'SYSTEM STATUS\A\A  ●  NETWORK   SECURE\A  ●  COURSES    06 ACTIVE\A  ●  ACCESS     VERIFIED\A\A  // learn to defend what matters';
        white-space: pre;
        justify-self: center;
        width: min(100%, 330px);
        padding: 2rem;
        border: 1px solid var(--border);
        border-left: 3px solid var(--accent);
        background: #06285a;
        box-shadow: 18px 18px 0 rgba(45,212,191,0.06);
        color: var(--accent2);
        font: 500 0.76rem/2 'DM Mono', monospace;
        letter-spacing: 0.04em;
        transform: rotate(2deg);
    }
    .hero h1 {
        grid-column: 1;
        font-size: clamp(2.6rem, 6vw, 5.2rem);
        line-height: 0.98;
        font-weight: 800;
        color: #f0f8f7;
        margin: 1rem 0 1.25rem;
    }
    :root[data-theme="light"] .hero h1 { color: #06285a; }
    .hero p {
        grid-column: 1;
        font-size: 1.1rem;
        color: var(--muted);
        max-width: 600px;
        margin: 0 0 2rem;
        max-width: 520px;
    }
    .hero > div { grid-column: 1; }
    .curso-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(145deg, #101c27, #0c141d);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: all 0.25s;
    }
    :root[data-theme="light"] .curso-card { background: #ffffff; }
    .curso-card::before {
        content: 'MODULE';
        position: absolute;
        top: 1rem;
        right: 1.2rem;
        color: var(--muted);
        font: 500 0.62rem 'DM Mono', monospace;
        letter-spacing: 0.12em;
    }
    .curso-card::after {
        content: '';
        position: absolute;
        width: 90px;
        height: 90px;
        right: -42px;
        bottom: -42px;
        border: 1px solid rgba(45,212,191,0.25);
        transform: rotate(45deg);
    }
    .curso-card:hover {
        border-color: var(--accent);
        transform: translateY(-4px);
        box-shadow: 0 12px 34px rgba(6,40,90,0.08), 0 0 0 1px rgba(0,211,154,0.08);
    }
    .curso-icon {
        font-size: 2rem;
        width: 56px;
        height: 56px;
        background: rgba(45,212,191,0.13);
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
    @media (max-width: 760px) {
        .hero { grid-template-columns: 1fr; gap: 1.5rem; padding: 4.5rem 1rem 3rem; }
        .hero::before { left: 1rem; }
        .hero::after { grid-column: 1; grid-row: 4; justify-self: start; width: 100%; transform: none; }
        .hero h1, .hero p, .hero > div { grid-column: 1; }
    }
</style>
@endsection

@section('content')
    {{-- HERO --}}
    <div class="hero">
        <h1>CiberEskola</h1>
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
