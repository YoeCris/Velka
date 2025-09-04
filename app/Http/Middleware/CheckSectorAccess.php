<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSectorAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(401, 'No autenticado.');
        }

        // Superadmin tiene acceso a todo
        if ($user->isSuperadmin()) {
            return $next($request);
        }

        // Admin sector necesita tener sector asignado
        if ($user->isAdminSector() && !$user->sector_id) {
            abort(403, 'Usuario sin sector asignado.');
        }

        // Verificar acceso a sector específico si se especifica en la ruta
        $sectorId = $request->route('sector_id') ?? $request->input('sector_id');
        
        if ($sectorId && !$user->canAccessSector($sectorId)) {
            abort(403, 'Acceso denegado al sector especificado.');
        }

        return $next($request);
    }
}
