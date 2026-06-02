<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pagos de proyectos proximos a vencer</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827;">
    <h1 style="font-size: 20px;">Pagos de proyectos proximos a vencer</h1>
    <p>Se detectaron {{ $charges->count() }} cargos con saldo pendiente que vencen dentro de los proximos {{ $days }} dias.</p>

    <table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr>
                <th align="left">Proyecto</th>
                <th align="left">Cliente</th>
                <th align="left">Folio</th>
                <th align="right">Monto</th>
                <th align="right">Saldo</th>
                <th align="left">Vencimiento</th>
                <th align="right">Dias</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($charges as $charge)
                <tr>
                    <td>{{ $charge->proyecto?->nombre ?? '-' }}</td>
                    <td>{{ $charge->cliente?->nombre ?? $charge->cliente?->razon_social ?? '-' }}</td>
                    <td>{{ $charge->folio }}</td>
                    <td align="right">{{ number_format((float) $charge->monto, 2) }} {{ $charge->moneda }}</td>
                    <td align="right">{{ number_format((float) $charge->saldo, 2) }} {{ $charge->moneda }}</td>
                    <td>{{ $charge->fecha_vencimiento?->format('d/m/Y') }}</td>
                    <td align="right">{{ now()->startOfDay()->diffInDays($charge->fecha_vencimiento, false) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 18px;">
        <a href="{{ $actionUrl }}">Abrir modulo de cobranza</a>
    </p>
</body>
</html>
