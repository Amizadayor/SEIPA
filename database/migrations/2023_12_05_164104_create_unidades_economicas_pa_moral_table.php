<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unidades_economicas_pa_moral', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UEDuenoid')->nullable();
            $table->unsignedBigInteger('Ofcid');
            $table->date('FechaRegistro')->nullable();
            $table->string('RNPA', 10);
            $table->string('RFC', 13)->nullable();
            $table->string('RazonSocial', 50)->nullable();
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
            $table->boolean('ActvAcuacultura')->default(false);
            $table->boolean('ActvPesca')->default(false);
            $table->boolean('ActivoEmbMayor')->default(false);
            $table->boolean('ActivoEmbMenor')->default(false);
            $table->string('DocRepresentanteLegal', 255)->nullable();
            $table->string('DocActaConstitutiva', 255)->nullable();
            $table->string('DocActaAsamblea', 255)->nullable();

            $table->foreign('Locid')->references('id')->on('localidades');
            $table->foreign('Ofcid')->references('id')->on('oficinas');
            $table->foreign('UEDuenoid')->references('id')->on('unidades_economicas_pa_fisico');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unidades_economicas_pa_moral');
    }
};
