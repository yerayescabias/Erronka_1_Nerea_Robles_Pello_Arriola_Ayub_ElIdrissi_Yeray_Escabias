<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'duracion_horas',
        'nivel',
        'activo',
    ];

    // ── Relaciones ──────────────────────────────────────────
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'curso_id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'matriculas', 'curso_id', 'usuario_id')
                    ->withPivot('estado', 'fecha_matricula')
                    ->withTimestamps();
    }

    // ── Métodos de acceso a BD ───────────────────────────────

    /** Devuelve todos los cursos activos */
    public static function activos()
    {
        return self::where('activo', true)->get();
    }

    /** Devuelve todos los cursos */
    public static function todos()
    {
        return self::all();
    }

    /** Busca curso por ID */
    public static function porId(int $id)
    {
        return self::findOrFail($id);
    }

    /** Devuelve cursos por categoría */
    public static function porCategoria(string $categoria)
    {
        return self::where('categoria', $categoria)->where('activo', true)->get();
    }

    /** Devuelve cursos por nivel */
    public static function porNivel(string $nivel)
    {
        return self::where('nivel', $nivel)->where('activo', true)->get();
    }

    /** Crea un nuevo curso */
    public static function crear(array $datos)
    {
        return self::create($datos);
    }

    /** Actualiza los datos del curso */
    public function actualizar(array $datos)
    {
        $this->update($datos);
        return $this;
    }

    /** Desactiva el curso (baja lógica) */
    public function desactivar()
    {
        $this->activo = false;
        $this->save();
    }

    /** Activa el curso */
    public function activar()
    {
        $this->activo = true;
        $this->save();
    }

    /** Elimina el curso */
    public function eliminar()
    {
        $this->delete();
    }

    /** Número de alumnos matriculados */
    public function totalAlumnos(): int
    {
        return $this->matriculas()->count();
    }
}
