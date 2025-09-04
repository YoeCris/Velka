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
        Schema::create('comuneros', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 8)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->enum('genero', ['masculino', 'femenino']);
            $table->date('fecha_nacimiento');
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->enum('estado_civil', ['soltero', 'casado', 'conviviente', 'divorciado', 'viudo']);
            $table->enum('condicion', ['calificado', 'no_calificado'])->default('no_calificado');
            $table->foreignId('sector_id')->constrained('sectores');
            $table->date('fecha_ingreso');
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->decimal('puntos_obtenidos', 8, 2)->default(0);
            $table->decimal('puntos_posibles', 8, 2)->default(0);
            $table->decimal('porcentaje_asistencia', 5, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['activo', 'sector_id']);
            $table->index(['condicion', 'activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comuneros');
    }
};
