<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->text('descripcion')->nullable();
            $table->string('categoria', 100)->nullable();
            $table->unsignedInteger('duracion_horas')->nullable();
            $table->string('nivel', 20)->nullable();
            $table->boolean('activo')->default(true);
        });
    }

    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn([
                'descripcion',
                'categoria',
                'duracion_horas',
                'nivel',
                'activo',
            ]);
        });
    }
};