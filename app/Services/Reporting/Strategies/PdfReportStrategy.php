<?php

namespace App\Services\Reporting\Strategies;

use App\Services\Reporting\Contracts\ReportStrategy;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportStrategy implements ReportStrategy
{
    public function generate(array $data): string
    {
        // Más adelante lo conectar a una vista
        $html = '<h1>Reporte de Auditoría</h1>';
        $html .= '<p>Total de Transacciones: ' . count($data['items'] ?? []) . '</p>';
        
        $pdf = Pdf::loadHTML($html);

        return $pdf->output();
    }
}