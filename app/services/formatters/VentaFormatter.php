<?php
class VentaFormatter
{
    public static function formatearResumenVentasMensual(array $ventasMes): string
    {
        $nombresMeses = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];

        $resumen = [];
        foreach ($ventasMes as $mes => $total) {
            $nombre = ucfirst($nombresMeses[$mes] ?? "Mes $mes");
            $resumen[] = "$nombre: S/. " . number_format($total, 2);
        }

        $mesActual = (int) date('n');
        $nombreMesActual = ucfirst($nombresMeses[$mesActual] ?? "mes $mesActual");

        $texto = "📊 Ventas por mes:\n- " . implode("\n- ", $resumen);

        if (isset($ventasMes[$mesActual])) {
            $monto = number_format($ventasMes[$mesActual], 2);
            $texto .= "\n📆 Total en $nombreMesActual: S/. $monto";
        } else {
            $texto .= "\n📆 No hay ventas en $nombreMesActual.";
        }

        return $texto . "\n";
    }

    public static function formatearVentas(array $ventas, string $nombre): string
    {
        if (empty($ventas)) {
            return $nombre === 'tus'
                ? "🧾 No has registrado ventas aún.\n"
                : "🧾 {$nombre} no ha registrado ventas.\n";
        }

        $resumen = array_map(function ($v) {
            $cantidad = (int) $v['cantidad'];
            $unidad = $cantidad === 1 ? 'unidad' : 'unidades';
            $nombre = $v['nombre'];
            $precio = number_format($v['precio_unitario'], 2);
            $fecha = date('d/m/Y', strtotime($v['fecha_venta']));
            $hora = date('H:i:s', strtotime($v['fecha_venta']));

            return "$cantidad $unidad de $nombre (S/.$precio) el $fecha a las $hora";
        }, $ventas);

        $etiqueta = $nombre === 'tus' ? "Tus ventas registradas" : "Ventas de $nombre";
        return "🧾 $etiqueta: " . implode('; ', $resumen) . "\n";
    }
}