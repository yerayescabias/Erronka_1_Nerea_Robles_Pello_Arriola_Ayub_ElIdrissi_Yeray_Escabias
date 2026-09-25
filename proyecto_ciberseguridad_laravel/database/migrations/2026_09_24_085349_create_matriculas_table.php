<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('UsuariosCursos', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('Usuarios')->onDelete('cascade');
            $table->foreignId('id_curso')->constrained('cursos')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['id_usuario', 'id_curso']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('UsuariosCursos');
    }
};
