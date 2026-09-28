@extends('layouts.app')

@section('title', 'Mis Cursos — CiberEskola')

@section('styles')
<style>
    .alumno-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .welcome-msg { font-size: 1.5rem; font-weight: 700; }
    .curso-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        transition: all 0.25s;
    }
    .curso-card:hover { border-color: var(--accent); transform: translateY(-3px); box-shadow: 0 6px 24px rgba(99,102,241,0.15); }
    .curso-card.matriculado { border-color: rgba(16,185,129,0.4); }
    .curso-nombre { font-size: 1.05rem; font-weight: 700; }
    .curso-desc   { font-size: 0.875rem; color: var(--muted); flex: 1; }
    .curso-meta   { display: flex; gap: 0.5rem; flex-wrap: wrap; }
</style>
@endsection

@section('content')
<div class="alumno-header">
    <div class="welcome-msg">👋 Hola, {{ $user->nombre }}</div>
    <span class="badge badge-blue">Alumno</span>
</div>

<div class="section-title" data-i18n="student.courses">📚 Mis cursos</div>

@if($cursos->isEmpty())
    <div class="empty-state" style="text-align:center; padding:4rem;">
        <div style="font-size:3rem; margin-bottom:1rem;">📭</div>
        <p>Aún no tienes cursos matriculados.</p>
    </div>
@else
    <div class="grid grid-3">
        @foreach($cursos as $curso)
        @php $yaMatriculado = in_array($curso->id, $matriculados); @endphp
        <div class="curso-card {{ $yaMatriculado ? 'matriculado' : '' }}">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div style="font-size:1.75rem;">
                    {{ ['basico'=>'🌱','intermedio'=>'⚡','avanzado'=>'🔥'][$curso->nivel] ?? '📘' }}
                </div>
                @if($yaMatriculado)
                    <span class="badge badge-green" data-i18n="student.enrolled">✅ Matriculado</span>
                @endif
            </div>

            <div class="curso-nombre">{{ $curso->nombre }}</div>

            @if($curso->descripcion)
                <div class="curso-desc">{{ Str::limit($curso->descripcion, 120) }}</div>
            @endif

            <div class="curso-meta">
                @php $nc = ['basico'=>'badge-green','intermedio'=>'badge-yellow','avanzado'=>'badge-red']; @endphp
                <span class="badge {{ $nc[$curso->nivel] ?? 'badge-blue' }}">{{ ucfirst($curso->nivel) }}</span>
                @if($curso->categoria)
                    <span class="badge badge-blue">{{ $curso->categoria }}</span>
                @endif
                @if($curso->duracion_horas)
                    <span style="font-size:0.8rem; color:var(--muted)">⏱ {{ $curso->duracion_horas }}h</span>
                @endif
            </div>

            @if(!$yaMatriculado)
                <form action="{{ route('alumno.matrikulatu', $curso->id) }}" method="POST" style="margin-top:auto;">
                    @csrf
                    <button type="submit" class="btn-success" style="width:100%; padding:0.6rem; border:none; border-radius:8px; cursor:pointer; font-family:inherit;">
                        Matricularse
                    </button>
                </form>
            @else
                <div style="text-align:center; padding:0.6rem; color:var(--green); font-size:0.9rem; font-weight:600;">
                    <span data-i18n="student.already_enrolled">Ya estás inscrito en este curso</span>
                </div>
            @endif
        </div>
        @endforeach
    </div>
@endif

<div class="section-title" style="margin-top:3rem;" data-i18n="student.enrollments">📋 Mis matrículas</div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>Curso</th><th>Estado</th><th>Fecha</th><th>Acción</th></tr></thead>
        <tbody>
            @forelse($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula->curso->nombre ?? 'Curso eliminado' }}</td>
                    <td><span class="badge {{ $matricula->estado === 'cancelada' ? 'badge-red' : 'badge-green' }}">{{ ucfirst($matricula->estado) }}</span></td>
                    <td>{{ $matricula->fecha_matricula }}</td>
                    <td>
                        @if($matricula->estado !== 'cancelada')
                            <form action="{{ route('alumno.baja-matricula', $matricula->id_curso) }}" method="POST" onsubmit="return confirm('¿Cancelar esta matrícula?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:0.3rem 0.75rem; border:0; border-radius:6px; cursor:pointer; font-family:inherit;">Cancelar</button>
                            </form>
                        @else
                            <span style="color:var(--muted);">Sin acciones</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center; color:var(--muted); padding:2rem;">Todavía no tienes matrículas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
