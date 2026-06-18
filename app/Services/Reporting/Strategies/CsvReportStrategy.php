<?php

namespace App\Services\Reporting\Strategies;

use App\Services\Reporting\Contracts\ReportStrategy;

class CsvReportStrategy implements ReportStrategy
{
    public function generate(array $data): string
    {
        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, ['ID', 'Monto', 'Estado']);

        foreach ($data['items'] ?? [] as $item) {
            fputcsv($handle, [
                $item['id'] ?? 'N/A',
                $item['monto'] ?? 0,
                $item['estado'] ?? 'N/A'
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return $csvContent;
    }
}