<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Estadísticas generales para administradores
        if ($user->esAdministrador()) {
            $estadisticas = [
                'total_comuneros' => User::where('rol', 'comunero')->count(),
                'comuneros_activos' => User::activos()->where('rol', 'comunero')->count(),
                'comuneros_calificados' => User::calificados()->where('rol', 'comunero')->count(),
                'comuneros_no_calificados' => User::noCalificados()->where('rol', 'comunero')->count(),
                'por_sectores' => [
                    'sector_1' => User::delSector('sector_1')->activos()->count(),
                    'sector_2' => User::delSector('sector_2')->activos()->count(),
                    'sector_3' => User::delSector('sector_3')->activos()->count(),
                    'sector_4' => User::delSector('sector_4')->activos()->count(),
                ],
                'nuevos_este_mes' => User::where('rol', 'comunero')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];
            
            // Últimos comuneros registrados
            $ultimosComuneros = User::where('rol', 'comunero')
                ->latest()
                ->take(5)
                ->get();
            
            return view('dashboard.admin', compact('estadisticas', 'ultimosComuneros', 'user'));
        }
        
        // Dashboard para comuneros regulares
        return view('dashboard.comunero', compact('user'));
    }
    
    /**
     * Mostrar lista de comuneros (solo para administradores)
     */
    public function comuneros(Request $request)
    {
        if (!Auth::user()->esAdministrador()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        $query = User::where('rol', 'comunero');
        
        // Filtros
        if ($request->filled('sector')) {
            $query->where('sector', $request->sector);
        }
        
        if ($request->filled('condicion')) {
            $query->where('condicion', $request->condicion);
        }
        
        if ($request->filled('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }
        
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function($q) use ($busqueda) {
                $q->where('name', 'like', "%$busqueda%")
                  ->orWhere('apellido_paterno', 'like', "%$busqueda%")
                  ->orWhere('apellido_materno', 'like', "%$busqueda%")
                  ->orWhere('dni', 'like', "%$busqueda%")
                  ->orWhere('email', 'like', "%$busqueda%");
            });
        }
        
        $comuneros = $query->paginate(15);
        
        return view('dashboard.comuneros', compact('comuneros'));
    }
}
