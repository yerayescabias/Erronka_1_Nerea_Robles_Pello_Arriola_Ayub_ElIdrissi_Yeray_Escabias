<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';
    public $timestamps = false;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'titulo',
        'hasiera_data',
        'bukaera_data',
        'nombre',
        'descripcion',
        'categoria',
        'duracion_horas',
        'nivel',
        'activo',
    ];
    public function setNombreAttribute($value): void { $this->attributes['titulo'] = $value; }
    
    protected $casts = [
        'activo' => 'boolean',
    ];


    // ── Relaciones ──────────────────────────────────────────
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'id_curso');
    }

    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'UsuariosCursos', 'id_curso', 'id_usuario')
                ->withPivot('created_at');
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
        if (isset($datos['nombre'])) { $datos['titulo'] = $datos['nombre']; unset($datos['nombre']); }
        $datos = array_intersect_key($datos, array_flip([
            'titulo',
            'descripcion',
            'categoria',
            'duracion_horas',
            'nivel',
            'hasiera_data',
            'bukaera_data',
        ]));
        return self::create($datos);
    }

    /** Actualiza los datos del curso */
    public function actualizar(array $datos)
    {
        if (isset($datos['nombre'])) { $datos['titulo'] = $datos['nombre']; unset($datos['nombre']); }
        $datos = array_intersect_key($datos, array_flip([
            'titulo',
            'descripcion',
            'categoria',
            'duracion_horas',
            'nivel',
            'hasiera_data',
            'bukaera_data',
        ]));
        $this->update($datos);
        return $this;
    }

    /** Desactiva el curso (baja lógica) */
    public function desactivar()
    {
        $this->update(['activo' => false]);
        return $this;
    }

    /** Activa el curso */
    public function activar()
    {
        $this->update(['activo' => true]);
        return $this;
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
