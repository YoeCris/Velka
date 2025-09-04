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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_id')->constrained('reuniones');
            $table->foreignId('comunero_id')->constrained('comuneros');
            $table->timestamp('marca_entrada')->nullable();
            $table->timestamp('marca_salida')->nullable();
            $table->decimal('puntos_entrada', 3, 2)->default(0);
            $table->decimal('puntos_salida', 3, 2)->default(0);
            $table->decimal('puntos_total', 3, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['reunion_id', 'comunero_id']);
            $table->index(['comunero_id', 'reunion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
