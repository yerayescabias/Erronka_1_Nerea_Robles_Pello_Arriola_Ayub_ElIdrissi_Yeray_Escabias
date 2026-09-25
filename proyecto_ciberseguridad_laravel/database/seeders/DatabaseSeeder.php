<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Curso;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ── Admin ────────────────────────────────────────────────
        User::create([
            'izena'         => 'Administrador',
            'email'         => 'admin@cibereskola.eus',
            'pasahitza'     => Hash::make('admin123'),
            'rol'           => 'admin',
        ]);

        // ── Alumnos pre-registrados (sin contraseña aún) ─────────
        $alumnos = [
            ['Ane Garmendia',  'ane@ikasle.eus'],
            ['Mikel Etxeberria','mikel@ikasle.eus'],
            ['Leire Azpeitia', 'leire@ikasle.eus'],
        ];
        foreach ($alumnos as [$nombre, $email]) {
            User::create([
                'izena'         => $nombre,
                'email'         => $email,
                'pasahitza'     => null,
                'rol'           => 'alumno',
            ]);
        }

        // ── Cursos ───────────────────────────────────────────────
        $cursos = [
            ['titulo' => 'Hacking Ético y Pentesting'],
            ['titulo' => 'Análisis Forense Digital'],
            ['titulo' => 'Seguridad en Redes y Sistemas'],
            ['titulo' => 'Ciberseguridad para Principiantes'],
            ['titulo' => 'OSINT e Inteligencia en Fuentes Abiertas'],
            ['titulo' => 'Respuesta a Incidentes y Blue Team'],
        ];

        foreach ($cursos as $c) {
            Curso::create($c);
        }
    }
}
