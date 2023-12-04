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
        Schema::create('permisos_pesca', function (Blueprint $table) {
            $table->id();
            $table->string('NombrePermiso', 50)->nullable();
            $table->unsignedBigInteger('TPEspecieid');

            $table->foreign('TPEspecieid')->references('id')->on('especies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos_pesca');
    }
};
