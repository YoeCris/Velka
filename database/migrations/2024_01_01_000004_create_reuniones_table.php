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
        Schema::create('reuniones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['ordinaria', 'extraordinaria']);
            $table->string('titulo', 255);
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('lugar', 255);
            $table->text('notas')->nullable();
            $table->enum('estado', ['programada', 'cerrada'])->default('programada');
            $table->integer('umbral_tardanza')->default(40); // minutos
            $table->timestamp('cerrada_at')->nullable();
            $table->timestamps();
            
            $table->index(['fecha', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reuniones');
    }
};
