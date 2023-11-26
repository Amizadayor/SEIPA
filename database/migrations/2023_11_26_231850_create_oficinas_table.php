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
            $table->string('NombreOficina', 50)->notnull();
            $table->string('Ubicacion', 100)->notnull();
            $table->string('Telefono', 10)->notnull();
            $table->string('Email', 40)->notnull();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
