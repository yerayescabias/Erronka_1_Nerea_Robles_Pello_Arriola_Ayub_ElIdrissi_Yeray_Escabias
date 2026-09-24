<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Matricula;

class AlumnoController extends Controller
{
    public function dashboard()
    {
        $user   = Auth::user();
        $cursos = Curso::activos();

        // Marcar en cuáles ya está matriculado
        $matriculas = Matricula::porUsuario($user->id);
        $matriculados = $matriculas->where('estado', '!=', 'cancelada')->pluck('curso_id')->toArray();

        return view('alumno.dashboard', compact('user', 'cursos', 'matriculados', 'matriculas'));
    }

    // Matricularse en un curso
    public function matrikulatu(int $cursoId)
    {
        $user = Auth::user();
        $curso = Curso::porId($cursoId);

        if (!$curso->activo) {
            return back()->with('warning', 'Este curso ya no está disponible.');
        }

        if (Matricula::existe($user->id, $cursoId)) {
            return back()->with('warning', 'Ya estás matriculado en este curso.');
        }

        Matricula::matricular($user->id, $cursoId);

        return back()->with('success', 'Matrícula realizada correctamente.');
    }

    /** Permite al alumno cancelar únicamente una matrícula propia. */
    public function bajaMatricula(int $id)
    {
        $matricula = Matricula::whereKey($id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $matricula->cancelar();

        return back()->with('success', 'Matrícula cancelada correctamente.');
    }
}
