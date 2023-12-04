<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telefonos_pa_fisico', function (Blueprint $table) {
            $table->id();
            $table->string('Numero', 10)->nullable();
            $table->boolean('Principal')->default(false);
            $table->string('Tipo', 20)->nullable();
            $table->unsignedBigInteger('UEPAFid');

            $table->foreign('UEPAFid')->references('id')->on('unidades_economicas_pa_fisico');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telefonos_pa_fisico');
    }
};
