<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('curp', 18)->unique();
            $table->string('email', 30)->nullable();
            $table->string('password', 20)->nullable();
            $table->unsignedBigInteger('Rolid');

            $table->foreign('Rolid')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
