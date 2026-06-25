<?php

namespace App\Services\Reporting\Strategies;

use App\Services\Reporting\Contracts\ReportStrategy;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportStrategy implements ReportStrategy
{
    public function generate(array $data): string
    {
        $items = $data['items'] ?? [];
        
        // Métricas calculadas
        $totalMonto = 0;
        $conteoEstados = ['Aprobado' => 0, 'Pendiente' => 0, 'Rechazado' => 0];

        foreach ($items as $item) {
            $monto = $item['monto'] ?? 0;
            $totalMonto += $monto;
            
            $estado = $item['estado'] ?? 'Pendiente';
            if (array_key_exists($estado, $conteoEstados)) {
                $conteoEstados[$estado]++;
            }
        }

        $totalItems = count($items);
        $promedioMonto = $totalItems > 0 ? $totalMonto / $totalItems : 0;

        // Inyección de datos métricas calculadas
        $pdf = Pdf::loadView('reports.audit', [
            'items' => $items,
            'meta' => [
                'total_monto' => $totalMonto,
                'promedio_monto' => $promedioMonto,
                'total_items' => $totalItems,
                'estados' => $conteoEstados,
                'fecha_generacion' => now()->format('d/m/Y H:i:s')
            ]
        ]);

        return $pdf->output();
    }
}