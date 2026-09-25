<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Rol', function (Blueprint $table) {
            $table->id();
            $table->string('rol', 50)->unique();
        });

        DB::table('Rol')->insert([
            ['rol' => 'admin'],
            ['rol' => 'alumno'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('Rol');
    }
};