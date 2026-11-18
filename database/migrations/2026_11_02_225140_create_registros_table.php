<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 50);
            $table->enum('tipo', ['ENTRADA', 'SALIDA']);
            $table->timestamp('fecha_hora')->useCurrent();

            // Clave foránea que referencia al UID de la tabla usuarios
            $table->foreign('uid')->references('uid')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};