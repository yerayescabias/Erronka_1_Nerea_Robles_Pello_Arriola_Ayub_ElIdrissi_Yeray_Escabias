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
        $matriculados = Matricula::porUsuario($user->id)->pluck('curso_id')->toArray();

        return view('alumno.dashboard', compact('user', 'cursos', 'matriculados'));
    }

    // Matricularse en un curso
    public function matrikulatu(Request $request, int $cursoId)
    {
        $user = Auth::user();

        if (Matricula::existe($user->id, $cursoId)) {
            return back()->with('warning', 'Ya estás matriculado en este curso.');
        }

        Matricula::matricular($user->id, $cursoId);

        return back()->with('success', 'Matrícula realizada correctamente.');
    }
}
