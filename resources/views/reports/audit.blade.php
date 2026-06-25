<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Auditoría Financiera (DEMO)</title>
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
        }
        .kpi-card {
            width: 25%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: center;
        }
        .kpi-val {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .kpi-lbl {
            font-size: 8pt;
            color: #64748b;
            text-transform: uppercase;
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
        }
        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
        }
        .data-table td {
            padding: 10px;
            font-size: 10pt;
            border-bottom: 1px solid #e2e8f0;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 4px;
        }
        .badge-aprobado { background-color: #dcfce7; color: #15803d; }
        .badge-pendiente { background-color: #fef9c3; color: #a16207; }
        .badge-rechazado { background-color: #fee2e2; color: #b91c1c; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="brand-title">HUB</div>
                <div class="brand-subtitle">Módulo de Reportería e Integridad Financiera</div>
            </td>
            <td class="meta-text">
                <strong>Fecha Emisión:</strong> {{ $meta['fecha_generacion'] }}<br>
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
                <div class="kpi-lbl">Ticket Promedio</div>
            </td>
            <td class="kpi-card" style="border-right: none;">
                <div class="kpi-val">{{ $meta['estados']['Aprobado'] }}</div>
                <div class="kpi-lbl">Aprobadas</div>
            </td>
            <td class="kpi-card">
                <div class="kpi-val">{{ $meta['estados']['Pendiente'] }}</div>
                <div class="kpi-lbl">Pendientes</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Desglose General de Transacciones</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID Transacción</th>
                <th>Monto Procesado</th>
                <th>Estado Operativo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="font-family: monospace; font-weight: bold;">{{ $item['id'] ?? 'N/A' }}</td>
                    <td>${{ number_format($item['monto'] ?? 0, 2) }}</td>
                    <td>
                        @php $est = $item['estado'] ?? 'Pendiente'; @endphp
                        <span class="badge badge-{{ strtolower($est) }}">{{ $est }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>