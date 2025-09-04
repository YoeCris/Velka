<?php

use App\Livewire\Dashboard;
use App\Livewire\Comuneros\Index as ComunerosIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Comuneros (Padrón)
    Route::get('/comuneros', ComunerosIndex::class)
        ->name('comuneros.index');
    
    // Reuniones (placeholder por ahora)
    Route::get('/reuniones', function() {
        return view('placeholder', ['title' => 'Reuniones', 'message' => 'Módulo de reuniones en desarrollo']);
    })->name('reuniones.index');
    
    // Reportes (placeholder por ahora)
    Route::get('/reportes/padron', function() {
        return view('placeholder', ['title' => 'Reportes de Padrón', 'message' => 'Módulo de reportes en desarrollo']);
    })->name('reportes.padron');
    
    Route::get('/reportes/asistencia', function() {
        return view('placeholder', ['title' => 'Reportes de Asistencia', 'message' => 'Módulo de reportes en desarrollo']);
    })->name('reportes.asistencia');
    
    // Actualización masiva de condición (placeholder por ahora)
    Route::get('/condicion-masiva', function() {
        return view('placeholder', ['title' => 'Condición Masiva', 'message' => 'Módulo de condición masiva en desarrollo']);
    })->name('condicion-masiva');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('profile/edit', 'profile')
    ->middleware(['auth'])
    ->name('profile.edit');

require __DIR__.'/auth.php';
