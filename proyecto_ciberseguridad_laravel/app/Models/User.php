<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'rol',
        'pre_registrado',
    ];

    protected $hidden = ['password_hash'];

    // Laravel usa este método para verificar contraseña
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // ── Relaciones ──────────────────────────────────────────
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'usuario_id');
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'matriculas', 'usuario_id', 'curso_id')
                    ->withPivot('estado', 'fecha_matricula')
                    ->withTimestamps();
    }

    // ── Métodos de acceso a BD ───────────────────────────────

    /** Devuelve todos los usuarios */
    public static function todos()
    {
        return self::all();
    }

    /** Busca usuario por email */
    public static function porEmail(string $email)
    {
        return self::where('email', $email)->first();
    }

    /** Obtiene solo los alumnos */
    public static function alumnos()
    {
        return self::where('rol', 'alumno')->get();
    }

    /** Comprueba si el email existe (pre-registro por admin) */
    public static function estaPreRegistrado(string $email): bool
    {
        return self::where('email', $email)
                   ->where('pre_registrado', true)
                   ->whereNull('password_hash')
                   ->exists();
    }

    /** Comprueba si es admin */
    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /** Comprueba si ya está matriculado en un curso */
    public function estaMatriculadoEn(int $cursoId): bool
    {
        return $this->matriculas()->where('curso_id', $cursoId)->exists();
    }

    /** Crea un nuevo usuario (alta por admin, sin contraseña aún) */
    public static function darDeAlta(string $nombre, string $email, string $rol = 'alumno')
    {
        return self::create([
            'nombre'          => $nombre,
            'email'           => $email,
            'rol'             => $rol,
            'pre_registrado'  => true,
            'password_hash'   => null,
        ]);
    }

    /** Actualiza nombre */
    public function actualizarNombre(string $nombre)
    {
        $this->nombre = $nombre;
        $this->save();
    }

    /** Elimina el usuario */
    public function eliminar()
    {
        $this->delete();
    }
}
