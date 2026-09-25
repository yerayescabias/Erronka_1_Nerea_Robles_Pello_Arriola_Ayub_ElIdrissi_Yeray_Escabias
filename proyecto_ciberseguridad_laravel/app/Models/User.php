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
        'izena',
        'abizena',
        'email',
        'pasahitza',
        'rol',
        'jaiotze_data',
        'nombre',
        'name',
        'password_hash',
        'password',
        'pre_registrado',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = ['pasahitza'];

    public function getNombreAttribute(): string { return $this->izena; }
    public function getPasswordHashAttribute(): ?string { return $this->pasahitza; }
    public function getPreRegistradoAttribute(): bool { return $this->pasahitza === null; }
    public function setNombreAttribute($value): void { $this->attributes['izena'] = $value; }
    public function setNameAttribute($value): void { $this->attributes['izena'] = $value; }
    public function setPasswordHashAttribute($value): void { $this->attributes['pasahitza'] = $value; }
    public function setPasswordAttribute($value): void { $this->attributes['pasahitza'] = $value; }
    public function setPreRegistradoAttribute($value): void {}
    public function setEmailVerifiedAtAttribute($value): void {}
    public function setRememberTokenAttribute($value): void {}
    public function setRolAttribute($value): void { $this->attributes['rol'] = is_numeric($value) ? $value : ($value === 'admin' ? 1 : 2); }
    public function getRolAttribute($value): string { return (int) $value === 1 ? 'admin' : 'alumno'; }

    // Laravel usa este método para verificar contraseña
    public function getAuthPassword()
    {
        return $this->pasahitza;
    }

    // ── Relaciones ──────────────────────────────────────────
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'id_usuario');
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'UsuariosCursos', 'id_usuario', 'id_curso')
                ->withPivot('created_at');
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
        return self::where('rol', 2)->get();
    }

    /** Comprueba si el email existe (pre-registro por admin) */
    public static function estaPreRegistrado(string $email): bool
    {
        return self::where('email', $email)
                   ->whereNull('pasahitza')
                   ->exists();
    }

    /** Comprueba si es admin */
    public function esAdmin(): bool
    {
        return (int) $this->getRawOriginal('rol') === 1;
    }

    /** Comprueba si ya está matriculado en un curso */
    public function estaMatriculadoEn(int $cursoId): bool
    {
        return $this->matriculas()->where('id_curso', $cursoId)->exists();
    }

    /** Crea un nuevo usuario (alta por admin, sin contraseña aún) */
    public static function darDeAlta(string $nombre, string $email, string $rol = 'alumno')
    {
        return self::create([
            'izena'           => $nombre,
            'email'           => $email,
            'rol'             => $rol,
            'pasahitza'       => null,
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
