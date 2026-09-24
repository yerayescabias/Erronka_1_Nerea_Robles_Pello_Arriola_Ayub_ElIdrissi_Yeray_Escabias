<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('Usuarios')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'activa', 'completada', 'cancelada'])->default('activa');
            $table->timestamp('fecha_matricula')->useCurrent();
            $table->timestamps();
            $table->unique(['usuario_id', 'curso_id']); // No duplicar matrículas
        });
    }

    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
};
