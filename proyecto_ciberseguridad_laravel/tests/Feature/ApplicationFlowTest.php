<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\Matricula;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApplicationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_an_encrypted_password(): void
    {
        $user = User::create([
            'nombre' => 'Ane',
            'email' => 'ane@example.test',
            'password_hash' => Hash::make('secret123'),
            'rol' => 'alumno',
            'pre_registrado' => false,
        ]);

        $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'secret123',
        ])->assertRedirect(route('alumno.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_roles_protect_the_administration_panel(): void
    {
        $alumno = User::create([
            'nombre' => 'Mikel',
            'email' => 'mikel@example.test',
            'password_hash' => Hash::make('secret123'),
            'rol' => 'alumno',
            'pre_registrado' => false,
        ]);

        $this->actingAs($alumno)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_student_can_enroll_and_cancel_their_own_course(): void
    {
        $alumno = User::create([
            'nombre' => 'Leire',
            'email' => 'leire@example.test',
            'password_hash' => Hash::make('secret123'),
            'rol' => 'alumno',
            'pre_registrado' => false,
        ]);
        $curso = Curso::create([
            'nombre' => 'Fundamentos',
            'nivel' => 'basico',
            'activo' => true,
        ]);

        $this->actingAs($alumno)
            ->post(route('alumno.matrikulatu', $curso->id))
            ->assertSessionHas('success');

        $matricula = Matricula::firstOrFail();
        $this->assertSame((int) $curso->id, (int) $matricula->id_curso);

        $this->actingAs($alumno)
            ->delete(route('alumno.baja-matricula', $matricula->id_curso))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('UsuariosCursos', [
            'id_usuario' => $alumno->id,
            'id_curso' => $curso->id,
        ]);
    }
}
