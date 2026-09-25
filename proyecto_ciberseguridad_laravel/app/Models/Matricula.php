<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'UsuariosCursos';
    public $incrementing = false;
    public const UPDATED_AT = null;

    protected $fillable = [
        'id_usuario',
        'id_curso',
    ];

    public function getEstadoAttribute(): string
    {
        return 'activa';
    }

    public function getFechaMatriculaAttribute()
    {
        return $this->created_at;
    }

    // ── Relaciones ──────────────────────────────────────────
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    // ── Métodos de acceso a BD ───────────────────────────────

    /** Crea una nueva matrícula */
    public static function matricular(int $usuarioId, int $cursoId): self
    {
        return self::create([
            'id_usuario' => $usuarioId,
            'id_curso'   => $cursoId,
        ]);
    }

    /** Comprueba si ya existe la matrícula */
    public static function existe(int $usuarioId, int $cursoId): bool
    {
        return self::where('id_usuario', $usuarioId)->where('id_curso', $cursoId)->exists();
    }

    /** Obtiene las matrículas de un usuario */
    public static function porUsuario(int $usuarioId)
    {
        return self::where('id_usuario', $usuarioId)->with('curso')->get();
    }

    /** Obtiene los alumnos de un curso */
    public static function porCurso(int $cursoId)
    {
        return self::where('id_curso', $cursoId)->with('usuario')->get();
    }

    /** Cancela la matrícula */
    public function cancelar()
    {
        return self::where('id_usuario', $this->id_usuario)
            ->where('id_curso', $this->id_curso)
            ->delete();
    }

    /** Marca como completada */
    public function completar()
    {
        return $this;
    }

    /** Elimina la matrícula */
    public function eliminar()
    {
        return $this->cancelar();
    }
}
