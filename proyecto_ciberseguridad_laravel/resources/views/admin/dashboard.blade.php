@extends('layouts.app')

@section('title', 'Panel de Administración — CiberEskola')

@section('styles')
<style>
    .admin-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .admin-title { font-size: 1.75rem; font-weight: 800; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2.5rem; }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.25rem;
        text-align: center;
    }
    .stat-number { font-size: 2rem; font-weight: 800; color: var(--accent2); }
    .stat-label  { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
    .section { margin-bottom: 3rem; }
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .collapsible-form {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: none;
    }
    .collapsible-form.open { display: block; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media(max-width:600px) { .form-row { grid-template-columns: 1fr; } }
    .table-wrapper { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
</style>
@endsection

@section('content')
<div class="admin-header">
    <div class="admin-title">⚙️ Panel de Administración</div>
    <span style="color:var(--muted); font-size:0.9rem;">Bienvenido, {{ Auth::user()->nombre }}</span>
</div>

{{-- ESTADÍSTICAS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $usuarios->count() }}</div>
        <div class="stat-label">👨‍🎓 Alumnos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $cursos->count() }}</div>
        <div class="stat-label">📚 Cursos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $matriculas->count() }}</div>
        <div class="stat-label">📋 Matrículas</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $cursos->where('activo', true)->count() }}</div>
        <div class="stat-label">✅ Cursos activos</div>
    </div>
</div>

{{-- GESTIÓN DE ALUMNOS --}}
<div class="section">
    <div class="section-header">
        <div class="section-title" style="margin:0;">👨‍🎓 Gestión de alumnos</div>
        <button onclick="toggleForm('form-alumno')" class="btn-primary" style="padding:0.5rem 1.25rem; border:none; border-radius:8px; cursor:pointer; font-family:inherit;">
            + Dar de alta alumno
        </button>
    </div>

    {{-- Formulario alta alumno --}}
    <div id="form-alumno" class="collapsible-form">
        <form action="{{ route('admin.alta-alumno') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nombre completo</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre Apellido" required>
                </div>
                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="alumno@email.com" required>
                </div>
            </div>
            <div class="form-group" style="max-width:200px;">
                <label>Rol</label>
                <select name="rol" class="form-control">
                    <option value="alumno">Alumno</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-success" style="padding:0.6rem 1.5rem; border:none; border-radius:8px; cursor:pointer; font-family:inherit;">
                Dar de alta
            </button>
        </form>
    </div>

    {{-- Tabla de alumnos --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado cuenta</th>
                    <th>Matrículas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $alumno)
                <tr>
                    <td style="color:var(--muted)">{{ $alumno->id }}</td>
                    <td><strong>{{ $alumno->nombre }}</strong></td>
                    <td style="color:var(--muted)">{{ $alumno->email }}</td>
                    <td>
                        @if($alumno->password_hash)
                            <span class="badge badge-green">Activada</span>
                        @else
                            <span class="badge badge-yellow">Pendiente registro</span>
                        @endif
                    </td>
                    <td>{{ $alumno->matriculas->count() }}</td>
                    <td>
                        <form action="{{ route('admin.eliminar-usuario', $alumno->id) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar al alumno {{ $alumno->nombre }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding:0.3rem 0.75rem; border:none; border-radius:6px; cursor:pointer; font-family:inherit; font-size:0.8rem;">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; color:var(--muted); padding:2rem;">No hay alumnos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- GESTIÓN DE CURSOS --}}
<div class="section">
    <div class="section-header">
        <div class="section-title" style="margin:0;">📚 Gestión de cursos</div>
        <button onclick="toggleForm('form-curso')" class="btn-primary" style="padding:0.5rem 1.25rem; border:none; border-radius:8px; cursor:pointer; font-family:inherit;">
            + Nuevo curso
        </button>
    </div>

    {{-- Formulario nuevo curso --}}
    <div id="form-curso" class="collapsible-form">
        <form action="{{ route('admin.crear-curso') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nombre del curso</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Hacking Ético" required>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <input type="text" name="categoria" class="form-control" placeholder="Ej: Offensive Security">
                </div>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción del curso..."></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nivel</label>
                    <select name="nivel" class="form-control">
                        <option value="basico">Básico</option>
                        <option value="intermedio">Intermedio</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Duración (horas)</label>
                    <input type="number" name="duracion_horas" class="form-control" placeholder="40" min="1">
                </div>
            </div>
            <button type="submit" class="btn-success" style="padding:0.6rem 1.5rem; border:none; border-radius:8px; cursor:pointer; font-family:inherit;">
                Crear curso
            </button>
        </form>
    </div>

    {{-- Tabla de cursos --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Nivel</th>
                    <th>Duración</th>
                    <th>Alumnos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cursos as $curso)
                <tr>
                    <td style="color:var(--muted)">{{ $curso->id }}</td>
                    <td><strong>{{ $curso->nombre }}</strong></td>
                    <td style="color:var(--muted)">{{ $curso->categoria ?? '—' }}</td>
                    <td>
                        @php $nc = ['basico'=>'badge-green','intermedio'=>'badge-yellow','avanzado'=>'badge-red']; @endphp
                        <span class="badge {{ $nc[$curso->nivel] ?? 'badge-blue' }}">{{ ucfirst($curso->nivel) }}</span>
                    </td>
                    <td>{{ $curso->duracion_horas ? $curso->duracion_horas.'h' : '—' }}</td>
                    <td>{{ $curso->matriculas->count() }}</td>
                    <td>
                        <span class="badge {{ $curso->activo ? 'badge-green' : 'badge-red' }}">
                            {{ $curso->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <details>
                            <summary style="cursor:pointer; color:var(--accent2);">Editar</summary>
                            <form action="{{ route('admin.actualizar-curso', $curso->id) }}" method="POST" style="min-width:260px; padding-top:0.75rem;">
                                @csrf
                                @method('PUT')
                                <input class="form-control" name="nombre" value="{{ $curso->nombre }}" required>
                                <input class="form-control" name="categoria" value="{{ $curso->categoria }}" placeholder="Categoría" style="margin-top:0.4rem;">
                                <select class="form-control" name="nivel" style="margin-top:0.4rem;">
                                    @foreach(['basico' => 'Básico', 'intermedio' => 'Intermedio', 'avanzado' => 'Avanzado'] as $valor => $etiqueta)
                                        <option value="{{ $valor }}" @selected($curso->nivel === $valor)>{{ $etiqueta }}</option>
                                    @endforeach
                                </select>
                                <input class="form-control" type="number" name="duracion_horas" value="{{ $curso->duracion_horas }}" min="1" placeholder="Horas" style="margin-top:0.4rem;">
                                <textarea class="form-control" name="descripcion" rows="2" placeholder="Descripción" style="margin-top:0.4rem;">{{ $curso->descripcion }}</textarea>
                                <button type="submit" class="btn-primary" style="margin-top:0.4rem; padding:0.3rem 0.75rem; border:0; border-radius:6px; cursor:pointer;">Guardar</button>
                            </form>
                        </details>
                        <form action="{{ route('admin.cambiar-estado-curso', $curso->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-outline" style="padding:0.3rem 0.75rem; border-radius:6px; cursor:pointer; font-family:inherit; font-size:0.8rem;">
                                {{ $curso->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.eliminar-curso', $curso->id) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar el curso {{ $curso->nombre }}?')" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding:0.3rem 0.75rem; border:none; border-radius:6px; cursor:pointer; font-family:inherit; font-size:0.8rem;">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center; color:var(--muted); padding:2rem;">No hay cursos creados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MATRÍCULAS --}}
<div class="section">
    <div class="section-title">📋 Matrículas recientes</div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>Alumno</th><th>Curso</th><th>Estado</th><th>Fecha</th></tr>
            </thead>
            <tbody>
                @forelse($matriculas->take(20) as $mat)
                <tr>
                    <td>{{ $mat->usuario->nombre ?? '—' }}</td>
                    <td>{{ $mat->curso->nombre ?? '—' }}</td>
                    <td>
                        @php $ms = ['activa'=>'badge-green','pendiente'=>'badge-yellow','completada'=>'badge-blue','cancelada'=>'badge-red']; @endphp
                        <span class="badge {{ $ms[$mat->estado] ?? 'badge-blue' }}">{{ ucfirst($mat->estado) }}</span>
                    </td>
                    <td style="color:var(--muted); font-size:0.85rem;">{{ $mat->fecha_matricula }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; color:var(--muted); padding:2rem;">No hay matrículas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleForm(id) {
        document.getElementById(id).classList.toggle('open');
    }
</script>
@endsection
