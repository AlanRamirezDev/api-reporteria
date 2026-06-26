<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11pt;
            line-height: 1.5;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .brand-title {
            font-size: 20pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            font-size: 9pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }
        .meta-text {
            text-align: right;
            font-size: 9pt;
            color: #64748b;
        }
        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
            table-layout: fixed;
        }
        .kpi-card {
            width: 20%; 
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 8px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }
        .kpi-val {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .kpi-lbl {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 6px;
            margin-bottom: 15px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
            letter-spacing: 0.5px;
        }
        .data-table td {
            padding: 10px;
            font-size: 9.5pt;
            border-bottom: 1px solid #e2e8f0;
            word-wrap: break-word; 
            vertical-align: top;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 7.5pt;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
            word-wrap: break-word;
            max-width: 100%;
            line-height: 1.2;
        }
        .badge-aprobado { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-pendiente { background-color: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .badge-rechazado { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .badge-default { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; } 
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="brand-title">Reporte Financiero</div>
                <div class="brand-subtitle">Visualización de Movimientos Transaccionales</div>
            </td>
            <td class="meta-text">
                <strong>Fecha Emisión:</strong> {{ now()->timezone(request()->input('timezone', 'UTC'))->format('d/m/Y H:i:s') }}<br>
                <strong>ID Reporte:</strong> RPT-{{ time() }}<br>
                <strong>Estado:</strong> Consolidado
            </td>
        </tr>
    </table>

    <div class="section-title">Indicadores Clave de Rendimiento (KPIs)</div>
    
    <table class="kpi-table">
        <tr>
            <td class="kpi-card" style="border-right: none;">
                <div class="kpi-val">${{ number_format($meta['total_monto'], 2) }}</div>
                <div class="kpi-lbl">Volumen Total</div>
            </td>
            <td class="kpi-card" style="border-right: none;">
                <div class="kpi-val">${{ number_format($meta['promedio_monto'], 2) }}</div>
                <div class="kpi-lbl">Ticket Prom.</div>
            </td>
            <td class="kpi-card" style="border-right: none;">
                <div class="kpi-val">{{ $meta['estados']['Aprobado'] ?? 0 }}</div>
                <div class="kpi-lbl">Aprobadas</div>
            </td>
            <td class="kpi-card" style="border-right: none;">
                <div class="kpi-val">{{ $meta['estados']['Pendiente'] ?? 0 }}</div>
                <div class="kpi-lbl">Pendientes</div>
            </td>
            <td class="kpi-card">
                <div class="kpi-val">{{ $meta['estados']['Rechazado'] ?? 0 }}</div>
                <div class="kpi-lbl">Rechazadas</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Desglose General de Transacciones</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">ID</th>
                <th style="width: 45%;">Detalle Operativo</th>
                <th style="width: 18%;">Monto</th>
                <th style="width: 22%; text-align: center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="font-family: monospace; font-weight: bold; color: #475569;">{{ $item['id'] ?? 'N/A' }}</td>
                    <td>{{ $item['detalle'] ?? 'Sin detalle registrado' }}</td>
                    <td style="font-family: monospace;">${{ number_format($item['monto'] ?? 0, 2) }}</td>
                    <td style="text-align: center;">
                        @php 
                            $rawEst = $item['estado'] ?? ''; 
                            $estNormalizado = strtolower(trim($rawEst));
                            
                            // Si el estado no es válido, se sobrescribe.
                            if (in_array($estNormalizado, ['aprobado', 'pendiente', 'rechazado'])) {
                                $estFinal = ucfirst($estNormalizado);
                                $claseBadge = $estNormalizado;
                            } else {
                                $estFinal = 'No clasificado';
                                $claseBadge = 'default';
                            }
                        @endphp
                        <span class="badge badge-{{ $claseBadge }}">{{ $estFinal }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>