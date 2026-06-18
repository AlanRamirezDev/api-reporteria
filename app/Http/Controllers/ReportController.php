<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Reporting\Strategies\PdfReportStrategy;
use App\Services\Reporting\Strategies\CsvReportStrategy;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        // Validar de la petición del Hub
        $validated = $request->validate([
            'formato' => 'required|string|in:pdf,csv',
            'data'    => 'required|array',
            'data.items' => 'nullable|array',
        ]);

        // Seleccionar la estrategia
        $strategy = match ($validated['formato']) {
            'pdf' => new PdfReportStrategy(),
            'csv' => new CsvReportStrategy(),
        };

        // Ejecutar el motor
        $content = $strategy->generate($validated['data']);

        // Preparar cabeceras HTTP para descarga
        $contentType = $validated['formato'] === 'pdf' ? 'application/pdf' : 'text/csv';
        $fileName = 'artefacto_' . now()->format('Ymd_His') . '.' . $validated['formato'];

        // Retornar respuesta (200 OK) directamente al Hub 
        return response($content)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}