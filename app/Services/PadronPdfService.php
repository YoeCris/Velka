<?php

namespace App\Services;

use App\Models\Comunero;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PadronPdfService
{
    public function generarPadronPdf($comuneros, $filtros = [], $userId = null)
    {
        $fecha = Carbon::now();
        $nombreArchivo = "padron_" . $fecha->format('Y_m_d_H_i_s') . ".pdf";
        $rutaCarpeta = "reportes_jatucachi/" . $fecha->year . "/" . $fecha->format('m');
        $rutaCompleta = $rutaCarpeta . "/" . $nombreArchivo;

        // Crear directorio si no existe
        Storage::disk('public')->makeDirectory($rutaCarpeta);

        // Preparar datos para el PDF
        $data = [
            'comuneros' => $comuneros,
            'filtros' => $filtros,
            'fecha_generacion' => $fecha,
            'total_registros' => $comuneros->count(),
            'titulo' => 'Padrón Comunal - Comunidad Jatucachi'
        ];

        // Generar PDF
        $pdf = Pdf::loadView('pdfs.padron', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        // Guardar archivo
        Storage::disk('public')->put($rutaCompleta, $pdf->output());

        // Registrar en base de datos
        if ($userId) {
            Report::create([
                'tipo' => 'padron',
                'nombre_archivo' => $nombreArchivo,
                'ruta_archivo' => $rutaCompleta,
                'filtros' => $filtros,
                'total_registros' => $comuneros->count(),
                'user_id' => $userId
            ]);
        }

        return [
            'ruta' => $rutaCompleta,
            'nombre' => $nombreArchivo,
            'url_descarga' => Storage::disk('public')->url($rutaCompleta)
        ];
    }

    public function aplicarFiltros($query, $filtros)
    {
        if (!empty($filtros['buscar'])) {
            $query->buscarPorDniONombre($filtros['buscar']);
        }

        if (!empty($filtros['sector_id'])) {
            $query->where('sector_id', $filtros['sector_id']);
        }

        if (!empty($filtros['condicion'])) {
            $query->where('condicion', $filtros['condicion']);
        }

        if (isset($filtros['activo'])) {
            $query->where('activo', $filtros['activo']);
        }

        return $query;
    }
}
