<?php

namespace App\Services\Reporting\Strategies;

use App\Services\Reporting\Contracts\ReportStrategy;

class CsvReportStrategy implements ReportStrategy
{
    public function generate(array $data): string
    {
        $handle = fopen('php://temp', 'r+');

        // Encabezados
        fputcsv($handle, ['ID Ref', 'Detalle Operativo', 'Monto', 'Estado']);

        $total = 0;

        // Iteración de datos
        foreach ($data['items'] ?? [] as $item) {
            $monto = $item['monto'] ?? 0;
            $total += $monto;

            $rawEst = $item['estado'] ?? '';
            $estNormalizado = strtolower(trim($rawEst));
            
            $estFinal = in_array($estNormalizado, ['aprobado', 'pendiente', 'rechazado']) 
                ? ucfirst($estNormalizado) 
                : 'No clasificado';

            fputcsv($handle, [
                $item['id'] ?? 'N/A',
                $item['detalle'] ?? 'Sin detalle registrado',
                $monto,
                $estFinal
            ]);
        }

        // Inyección de los totales exactos
        fputcsv($handle, ['-', 'Total Acumulado', $total, '-']);

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return $csvContent;
    }
}