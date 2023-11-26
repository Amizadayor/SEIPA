<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficinas', function (Blueprint $table) {
            $table->id();
            $table->string('NombreOficina', 50)->nullable();
            $table->string('Ubicacion', 100)->nullable();
            $table->string('Telefono', 10)->nullable();
            $table->string('Email', 40)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
