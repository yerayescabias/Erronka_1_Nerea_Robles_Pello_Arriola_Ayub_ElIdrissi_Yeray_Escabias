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
            'nombre'        => 'Administrador',
            'email'         => 'admin@cibereskola.eus',
            'password_hash' => Hash::make('admin123'),
            'rol'           => 'admin',
            'pre_registrado'=> false,
        ]);

        // ── Alumnos pre-registrados (sin contraseña aún) ─────────
        $alumnos = [
            ['Ane Garmendia',  'ane@ikasle.eus'],
            ['Mikel Etxeberria','mikel@ikasle.eus'],
            ['Leire Azpeitia', 'leire@ikasle.eus'],
        ];
        foreach ($alumnos as [$nombre, $email]) {
            User::create([
                'nombre'        => $nombre,
                'email'         => $email,
                'password_hash' => null,
                'rol'           => 'alumno',
                'pre_registrado'=> true,
            ]);
        }

        // ── Cursos ───────────────────────────────────────────────
        $cursos = [
            ['nombre' => 'Hacking Ético y Pentesting',          'categoria' => 'Offensive Security', 'nivel' => 'intermedio', 'duracion_horas' => 60,  'descripcion' => 'Aprende las técnicas de los hackers para proteger sistemas. Metodologías de pentesting, reconocimiento, explotación y post-explotación.'],
            ['nombre' => 'Análisis Forense Digital',            'categoria' => 'Forensics',           'nivel' => 'avanzado',   'duracion_horas' => 40,  'descripcion' => 'Identificación, preservación y análisis de evidencias digitales. Cadena de custodia y elaboración de informes periciales.'],
            ['nombre' => 'Seguridad en Redes y Sistemas',       'categoria' => 'Network Security',    'nivel' => 'intermedio', 'duracion_horas' => 50,  'descripcion' => 'Cortafuegos, IDS/IPS, VPNs, segmentación de redes, DMZ y hardening de sistemas operativos.'],
            ['nombre' => 'Ciberseguridad para Principiantes',   'categoria' => 'Fundamentos',         'nivel' => 'basico',     'duracion_horas' => 30,  'descripcion' => 'Conceptos fundamentales de ciberseguridad: amenazas, vulnerabilidades, buenas prácticas y concienciación.'],
            ['nombre' => 'OSINT e Inteligencia en Fuentes Abiertas', 'categoria' => 'Reconnaissance','nivel' => 'intermedio', 'duracion_horas' => 25,  'descripcion' => 'Técnicas de recopilación de información en fuentes abiertas: Google Dorks, Shodan, Maltego y más.'],
            ['nombre' => 'Respuesta a Incidentes y Blue Team',  'categoria' => 'Defensive Security',  'nivel' => 'avanzado',   'duracion_horas' => 45,  'descripcion' => 'Detección, contención y erradicación de incidentes. SIEM, SOC y planes de continuidad de negocio.'],
        ];

        foreach ($cursos as $c) {
            Curso::create(array_merge($c, ['activo' => true]));
        }
    }
}
