<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255)->nullable();
            $table->enum('rol', ['admin', 'alumno'])->default('alumno');
            $table->boolean('pre_registrado')->default(true); // El admin da de alta primero
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Usuarios');
    }
}