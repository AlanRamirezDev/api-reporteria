<?php

uses(Tests\TestCase::class);

it('audita matemáticamente que el reporte csv incluya los totales exactos', function () {
    // Preparación de datos de prueba
    $payload = [
        'formato' => 'csv',
        'data' => [
            'items' => [
                ['id' => 'TXN-001', 'monto' => 150.50, 'estado' => 'Aprobado'],
                ['id' => 'TXN-002', 'monto' => 200.25, 'estado' => 'Aprobado'],
                ['id' => 'TXN-003', 'monto' => 50.00,  'estado' => 'Pendiente'],
            ]
        ]
    ];

    // Ejecución de la petición HTTP al endpoint
    $response = $this->postJson('/api/reportes/generar', $payload);

    // Obtención del contenido devuelto
    $csvOutput = $response->getContent();

    // Impresión del contenido en la consola
    dump("--- SALIDA ACTUAL DEL CSV ---");
    dump($csvOutput);
    dump("--- FIN DE SALIDA ---");
    dump("EXPECTATIVA MATEMÁTICA: La suma total debe ser 400.75");

    // Validación del endpoint
    $response->assertStatus(200);

    // Validación del CSV ()'Total' y cálculo exacto)
    expect($csvOutput)->toContain('Total');
    expect($csvOutput)->toContain('400.75');
});