<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('socios_detalles_pa_moral', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UEPAMid');
            $table->string('CURP', 18)->nullable();
            $table->boolean('ActvPesca')->default(false);
            $table->boolean('ActvAcuacultura')->default(false);
            $table->string('DocActaNacimiento', 255)->nullable();
            $table->string('DocComprobanteDomicilio', 255)->nullable();
            $table->string('DocCURP', 255)->nullable();
            $table->string('DocIdentificacionOfc', 255)->nullable();
            $table->string('DocRFC', 255)->nullable();

            $table->foreign('UEPAMid')->references('id')->on('unidades_economicas_pa_moral');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socios_detalles_pa_moral');
    }
};
