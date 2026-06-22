<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; }
        .header { border-bottom: 2px solid #2C3E50; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2C3E50; font-size: 22px; }
        .meta { float: right; text-align: right; font-size: 10px; color: #7F8C8D; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { bg-color: #34495E; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #BDC3C7; }
        .total-row { font-weight: bold; background-color: #ECF0F1; }
        .text-right { text-align: right; }
        footer { position: fixed; bottom: -30px; left: 0px; right: 0px; height: 30px; text-align: center; font-size: 9px; color: #95A5A6; }
    </style>
</head>
<body>

    <div class="header">
        <div class="meta">
            Emisión: {{ $meta['date'] }}<br>
            Período: {{ ucfirst($meta['month']) }} de {{ $meta['year'] }}
        </div>
        <h1>LogiCorp S.A.</h1>
        <span>Reporte Ejecutivo de Ventas Mensuales</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción del Producto</th>
                <th class="text-right">Unidades Vendidas</th>
                <th class="text-right">Ingresos Totales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $row)
            <tr>
                <td>{{ $row->product_id }}</td>
                <td>{{ $row->product_name }}</td>
                <td class="text-right">{{ $row->total_quantity }}</td>
                <td class="text-right">${{ number_format($row->total_revenue, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">TOTAL GENERAL</td>
                <td class="text-right">{{ $meta['grand_quantity'] }}</td>
                <td class="text-right">${{ number_format($meta['grand_revenue'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <footer>
        LogiCorp módulos internos — Página 1 de 1
    </footer>

</body>
</html>