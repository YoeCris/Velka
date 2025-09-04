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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // padron, asistencia
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->json('filtros')->nullable();
            $table->integer('total_registros');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            
            $table->index(['tipo', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
