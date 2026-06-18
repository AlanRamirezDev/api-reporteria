<?php

namespace App\Services\Reporting\Contracts;

interface ReportStrategy
{
    /**
     * Genera el reporte en el formato correspondiente.
     *
     * @param array
     * @return string
     */
    public function generate(array $data): string;
}