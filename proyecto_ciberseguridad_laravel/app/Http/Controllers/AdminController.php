<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Curso;
use App\Models\Matricula;

class AdminController extends Controller
{
    // Panel principal de administración (administrazioa.php)
    public function dashboard()
    {
        $usuarios = User::alumnos();
        $cursos   = Curso::todos();
        $matriculas = Matricula::with(['usuario', 'curso'])->get();

        return view('admin.dashboard', compact('usuarios', 'cursos', 'matriculas'));
    }

    // Alta de nuevo alumno (pre-registro)
    public function altaAlumno(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email|unique:Usuarios,email',
            'rol'    => 'in:admin,alumno',
        ]);

        User::darDeAlta($request->nombre, $request->email, $request->rol ?? 'alumno');

        return back()->with('success', "Alumno '{$request->nombre}' dado de alta correctamente.");
    }

    // Eliminar usuario
    public function eliminarUsuario(int $id)
    {
        abort_if(Auth::id() === $id, 403, 'No puedes eliminar tu propia cuenta de administrador.');

        $user = User::findOrFail($id);
        $user->eliminar();
        return back()->with('success', 'Usuario eliminado.');
    }

    // Crear curso
    public function crearCurso(Request $request)
    {
        $request->validate([
            'nombre'         => 'required|string|max:150',
            'descripcion'    => 'nullable|string',
            'categoria'      => 'nullable|string|max:100',
            'duracion_horas' => 'nullable|integer|min:1',
            'nivel'          => 'in:basico,intermedio,avanzado',
        ]);

        Curso::crear($request->only(['nombre', 'descripcion', 'categoria', 'duracion_horas', 'nivel']));

        return back()->with('success', "Curso '{$request->nombre}' creado correctamente.");
    }

    /** Actualiza los datos editables de un curso. */
    public function actualizarCurso(Request $request, int $id)
    {
        $datos = $request->validate([
            'nombre'         => 'required|string|max:150',
            'descripcion'    => 'nullable|string',
            'categoria'      => 'nullable|string|max:100',
            'duracion_horas' => 'nullable|integer|min:1',
            'nivel'          => 'required|in:basico,intermedio,avanzado',
        ]);

        $curso = Curso::porId($id);
        $curso->actualizar($datos);

        return back()->with('success', "Curso '{$curso->nombre}' actualizado correctamente.");
    }

    /** Activa o desactiva un curso sin perder su historial de matrículas. */
    public function cambiarEstadoCurso(int $id)
    {
        $curso = Curso::porId($id);
        $curso->activo ? $curso->desactivar() : $curso->activar();

        return back()->with('success', 'Estado del curso actualizado.');
    }

    // Eliminar curso
    public function eliminarCurso(int $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->eliminar();
        return back()->with('success', 'Curso eliminado.');
    }
}
