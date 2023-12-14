<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unidades_economicas_emb_ma', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UEDuenoid')->nullable();
            $table->string('RNPA', 10)->nullable();
            $table->string('Nombre', 100)->nullable();
            $table->boolean('ActivoPropio')->default(false)->nullable();
            $table->string('NombreEmbMayor', 50)->nullable();
            $table->string('Matricula', 15)->nullable();
            $table->string('PuertoBase', 50)->nullable();
            $table->unsignedBigInteger('TPActid')->nullable();
            $table->unsignedBigInteger('TPCubid')->nullable();
            $table->integer('CdPatrones')->nullable();
            $table->integer('CdMotoristas')->nullable();
            $table->integer('CdPescEspecializados')->nullable();
            $table->integer('CdPescadores')->nullable();
            $table->integer('AnioConstruccion')->nullable();
            $table->unsignedBigInteger('MtrlCascoid')->nullable();
            $table->decimal('Eslora', 10, 2)->default(0.00)->nullable();
            $table->decimal('Manga', 10, 2)->default(0.00)->nullable();
            $table->decimal('Puntal', 10, 2)->default(0.00)->nullable();
            $table->decimal('Calado', 10, 2)->default(0.00)->nullable();
            $table->decimal('ArqueoNeto', 10, 2)->default(0.00)->nullable();
            $table->string('DocAcreditacionLegalMotor', 255)->nullable();
            $table->string('DocCertificadoMatricula', 255)->nullable();
            $table->string('DocComprobanteTenenciaLegal', 255)->nullable();
            $table->string('DocCertificadoSegEmbs', 255)->nullable();

            $table->foreign('UEDuenoid')->references('id')->on('unidades_economicas_pa_fisico');
            $table->foreign('TPActid')->references('id')->on('tipos_actividad');
            $table->foreign('TPCubid')->references('id')->on('tipos_cubierta');
            $table->foreign('MtrlCascoid')->references('id')->on('materiales_casco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_economicas_emb_ma');
    }
};
