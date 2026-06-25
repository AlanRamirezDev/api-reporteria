<?php

namespace App\Services\Reporting\Strategies;

use App\Services\Reporting\Contracts\ReportStrategy;

class CsvReportStrategy implements ReportStrategy
{
    public function generate(array $data): string
    {
        $handle = fopen('php://temp', 'r+');

        // Encabezados
        fputcsv($handle, ['ID', 'Monto', 'Estado']);

        $total = 0;

        // Iteración de datos
        foreach ($data['items'] ?? [] as $item) {
            $monto = $item['monto'] ?? 0;
            $total += $monto;

            fputcsv($handle, [
                $item['id'] ?? 'N/A',
                $monto,
                $item['estado'] ?? 'N/A'
            ]);
        }

        // Inyección de los totales exactos
        fputcsv($handle, ['-', 'Total', $total]);

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return $csvContent;
    }
}