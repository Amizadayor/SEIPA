<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_permisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Rolid');
            $table->unsignedBigInteger('Permid');
            $table->boolean('Permitido')->nullable();

            $table->foreign('Rolid')->references('id')->on('roles');
            $table->foreign('Permid')->references('id')->on('permisos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_permisos');
    }
};
