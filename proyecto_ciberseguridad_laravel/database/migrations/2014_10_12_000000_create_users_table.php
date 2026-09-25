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
            $table->string('izena', 100);
            $table->string('abizena', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('pasahitza', 255)->nullable();
            $table->date('jaiotze_data')->nullable();
            $table->foreignId('rol')->default(2)->constrained('Rol');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Usuarios');
    }
}