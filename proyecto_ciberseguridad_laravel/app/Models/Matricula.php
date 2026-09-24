<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';

    protected $fillable = [
        'usuario_id',
        'curso_id',
        'estado',
    ];

    // ── Relaciones ──────────────────────────────────────────
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    // ── Métodos de acceso a BD ───────────────────────────────

    /** Crea una nueva matrícula */
    public static function matricular(int $usuarioId, int $cursoId): self
    {
        return self::create([
            'usuario_id' => $usuarioId,
            'curso_id'   => $cursoId,
            'estado'     => 'activa',
        ]);
    }

    /** Comprueba si ya existe la matrícula */
    public static function existe(int $usuarioId, int $cursoId): bool
    {
        return self::where('usuario_id', $usuarioId)
                   ->where('curso_id', $cursoId)
                   ->exists();
    }

    /** Obtiene las matrículas de un usuario */
    public static function porUsuario(int $usuarioId)
    {
        return self::where('usuario_id', $usuarioId)->with('curso')->get();
    }

    /** Obtiene los alumnos de un curso */
    public static function porCurso(int $cursoId)
    {
        return self::where('curso_id', $cursoId)->with('usuario')->get();
    }

    /** Cancela la matrícula */
    public function cancelar()
    {
        $this->estado = 'cancelada';
        $this->save();
    }

    /** Marca como completada */
    public function completar()
    {
        $this->estado = 'completada';
        $this->save();
    }

    /** Elimina la matrícula */
    public function eliminar()
    {
        $this->delete();
    }
}
