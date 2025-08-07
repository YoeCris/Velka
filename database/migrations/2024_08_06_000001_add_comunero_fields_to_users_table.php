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
        Schema::table('users', function (Blueprint $table) {
            // Información básica del comunero
            $table->string('dni', 8)->nullable()->unique()->after('email');
            $table->string('apellido_paterno')->after('name');
            $table->string('apellido_materno')->after('apellido_paterno');
            $table->date('fecha_nacimiento')->nullable()->after('apellido_materno');
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable()->after('fecha_nacimiento');
            $table->string('telefono', 15)->nullable()->after('genero');
            
            // Información específica de la comunidad
            $table->enum('condicion', ['calificado', 'no_calificado'])->default('no_calificado')->after('telefono');
            $table->enum('sector', ['sector_1', 'sector_2', 'sector_3', 'sector_4'])->after('condicion');
            $table->date('fecha_ingreso_comunidad')->nullable()->after('sector');
            $table->text('observaciones')->nullable()->after('fecha_ingreso_comunidad');
            
            // Roles y permisos
            $table->enum('rol', ['administrador', 'comunero'])->default('comunero')->after('observaciones');
            $table->boolean('activo')->default(true)->after('rol');
            
            // Información adicional
            $table->string('direccion')->nullable()->after('activo');
            $table->string('ocupacion')->nullable()->after('direccion');
            $table->string('estado_civil')->nullable()->after('ocupacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'dni',
                'apellido_paterno',
                'apellido_materno',
                'fecha_nacimiento',
                'genero',
                'telefono',
                'condicion',
                'sector',
                'fecha_ingreso_comunidad',
                'observaciones',
                'rol',
                'activo',
                'direccion',
                'ocupacion',
                'estado_civil'
            ]);
        });
    }
};
