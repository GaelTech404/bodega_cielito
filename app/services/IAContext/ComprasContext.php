<?php
class ComprasContext
{
    public static function generar(mysqli $db): string
    {
        $dashboard = new DashboardModel($db);
        $comprasMes = $dashboard->obtenerComprasPorMes(); // Debe devolver [mes => total]

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

        $mesActual = (int) date('n');
        $nombreMesActual = $nombresMeses[$mesActual] ?? "mes $mesActual";

        $resumen = [];
        foreach ($comprasMes as $mes => $total) {
            $nombre = $nombresMeses[(int) $mes] ?? "Mes $mes";
            $resumen[] = "$nombre: S/. " . number_format($total, 2);
        }

        $texto = "🛒 Compras por mes:\n- " . implode("\n- ", $resumen);

        if (isset($comprasMes[$mesActual])) {
            $monto = number_format($comprasMes[$mesActual], 2);
            $texto .= "\n📆 Gasto en compras durante el mes de $nombreMesActual: S/. $monto";
        } else {
            $texto .= "\n📆 No hay compras registradas durante el mes de $nombreMesActual.";
        }

        return $texto;
    }
}

