<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumnoController;
use App\Models\Curso;

// ─────────────────────────────────────────────────────────────────
// PÁGINA PRINCIPAL (index) — Lista de cursos + menú login/registro
// ─────────────────────────────────────────────────────────────────
Route::get('/', function () {
    $cursos = Curso::activos();
    return view('welcome', compact('cursos'));
})->name('inicio');

// ─────────────────────────────────────────────────────────────────
// AUTENTICACIÓN (solo para invitados)
// ─────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─────────────────────────────────────────────────────────────────
// PANEL ADMINISTRADOR → /administrazioa
// ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('administrazioa')->name('admin.')->group(function () {
    Route::get('/',                         [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestión de alumnos
    Route::post('/alta-alumno',             [AdminController::class, 'altaAlumno'])->name('alta-alumno');
    Route::delete('/usuario/{id}',          [AdminController::class, 'eliminarUsuario'])->name('eliminar-usuario');

    // Gestión de cursos
    Route::post('/crear-curso',             [AdminController::class, 'crearCurso'])->name('crear-curso');
    Route::put('/curso/{id}',               [AdminController::class, 'actualizarCurso'])->name('actualizar-curso');
    Route::patch('/curso/{id}/estado',      [AdminController::class, 'cambiarEstadoCurso'])->name('cambiar-estado-curso');
    Route::delete('/curso/{id}',            [AdminController::class, 'eliminarCurso'])->name('eliminar-curso');
});

// ─────────────────────────────────────────────────────────────────
// PANEL ALUMNO → /ikaslea
// ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:alumno'])->prefix('ikaslea')->name('alumno.')->group(function () {
    Route::get('/dashboard',               [AlumnoController::class, 'dashboard'])->name('dashboard');
    Route::post('/matrikulatu/{cursoId}',  [AlumnoController::class, 'matrikulatu'])->name('matrikulatu');
    Route::delete('/matrikula/{cursoId}',  [AlumnoController::class, 'bajaMatricula'])->name('baja-matricula');
});
