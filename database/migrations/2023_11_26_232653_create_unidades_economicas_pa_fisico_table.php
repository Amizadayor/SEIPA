<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unidades_economicas_pa_fisico', function (Blueprint $table) {
            $table->id();
            $table->date('FechaRegistro')->nullable();
            $table->unsignedBigInteger('Ofcid');
            $table->string('RNPA', 10);
            $table->string('CURP', 18)->unique();
            $table->string('RFC', 13)->nullable();
            $table->string('Nombres', 50)->nullable();
            $table->string('ApPaterno', 30)->nullable();
            $table->string('ApMaterno', 30)->nullable();
            $table->date('FechaNacimiento')->nullable();
            $table->enum('Sexo', ['M', 'F'])->nullable();
            $table->string('GrupoSanguineo', 4)->nullable();
            $table->string('Email', 40)->nullable();
            $table->string('Calle', 100)->nullable();
            $table->string('NmExterior', 6)->nullable();
            $table->string('NmInterior', 6)->nullable();
            $table->string('CodigoPostal', 10)->nullable();
            $table->unsignedBigInteger('Locid');
            $table->string('NmPrincipal', 10)->nullable();
            $table->string('TpNmPrincipal', 20)->nullable();
            $table->string('NmSecundario', 10)->nullable();
            $table->string('TpNmSecundario', 20)->nullable();
            $table->date('IniOperaciones')->nullable();
            $table->boolean('ActivoEmbMayor')->default(false);
            $table->boolean('ActivoEmbMenor')->default(false);
            $table->boolean('ActvAcuacultura')->default(false);
            $table->boolean('ActvPesca')->default(false);
            $table->string('DocActaNacimiento', 255)->nullable();
            $table->string('DocComprobanteDomicilio', 255)->nullable();
            $table->string('DocCURP', 255)->nullable();
            $table->string('DocIdentificacionOfc', 255)->nullable();
            $table->string('DocRFC', 255)->nullable();
            $table->foreign('Locid')->references('id')->on('localidades');
            $table->foreign('Ofcid')->references('id')->on('oficinas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unidades_economicas_pa_fisico');
    }
};
