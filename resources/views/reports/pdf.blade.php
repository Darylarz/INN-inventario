<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 0; }
        .filters { margin: 8px 0 12px; }
        .filters span { margin-right: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .small { font-size: 11px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventario de Tecnología - INN</h1>
        <div class="small">Reporte de Inventario</div>
    </div>

    <div class="filters small">
        <span><strong>Estado:</strong>
            @php
                $statusLabel = [
                    'all' => 'Todos',
                    'enabled' => 'Activos',
                    'disabled' => 'Desincorporados',
                ][$status ?? 'all'] ?? 'Todos';
            @endphp
            {{ $statusLabel }}
        </span>
        <span><strong>Tipo:</strong> {{ $itemType ?: 'Todos' }}</span>
        <span><strong>Desde:</strong> {{ $from ?: '-' }}</span>
        <span><strong>Hasta:</strong> {{ $to ?: '-' }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Bien Nal.</th>
                <th>Estado</th>
                <th>F. Desinc.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $it)
                <tr>
                    <td class="text-right">{{ $it->id }}</td>
                    <td>{{ $it->item_type }}</td>
                    <td>{{ $it->brand }}</td>
                    <td>{{ $it->model }}</td>
                    <td>{{ $it->serial_number }}</td>
                    <td>{{ $it->national_asset_tag }}</td>
                    <td>{{ $it->is_disabled ? 'Desincorporado' : 'Activo' }}</td>
                    <td>{{ optional($it->disabled_at)->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-right small">Sin resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="small" style="margin-top: 10px;">Generado: {{ ($generatedAt ?? now())->format('Y-m-d H:i') }}</p>
</body>
</html>
