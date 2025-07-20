<?php

class ComprasContext
{
    public static function generar(mysqli $db, array $usuario): string
    {
        $rol = $usuario['rol'] ?? 'cajero';
        $idUsuario = $usuario['id_usuario'] ?? null;

        $compraModel = new CompraModel($db);
        $texto = '';

        if ($rol === 'admin') {
            $comprasPorMes = $compraModel->obtenerComprasPorMes();
            $texto .= self::formatearResumenComprasMensual($comprasPorMes);
        }

        if ($idUsuario) {
            $compras = $compraModel->obtenerComprasPorUsuario($idUsuario);
            $texto .= self::formatearComprasUsuario($compras);
        }

        return $texto ?: "🛒 No hay compras registradas.";
    }

    private static function formatearResumenComprasMensual(array $comprasMes): string
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
        foreach ($comprasMes as $mes => $total) {
            $nombre = $nombresMeses[$mes] ?? "Mes $mes";
            $resumen[] = "$nombre: S/. " . number_format($total, 2);
        }

        $mesActual = (int) date('n');
        $nombreMesActual = $nombresMeses[$mesActual] ?? "mes $mesActual";

        $texto = "🗓 Compras por mes:\n- " . implode("\n- ", $resumen);
        if (isset($comprasMes[$mesActual])) {
            $monto = number_format($comprasMes[$mesActual], 2);
            $texto .= "\n📆 Gasto en $nombreMesActual: S/. $monto\n";
        } else {
            $texto .= "\n📆 No hay compras en $nombreMesActual.\n";
        }

        return $texto . "\n";
    }

    private static function formatearComprasUsuario(array $compras): string
    {
        if (empty($compras)) {
            return "📦 Aún no has registrado compras.\n";
        }

        $lineas = array_map(function ($c) {
            $fecha = date('d/m/Y', strtotime($c['fecha_compra']));
            $hora = date('H:i:s', strtotime($c['fecha_compra']));
            $proveedor = $c['proveedor'] ?? 'Proveedor desconocido';
            $total = number_format($c['total'], 2);
            return "Compra de S/.{$total} a {$proveedor} el $fecha a las $hora";
        }, $compras);

        return "📦 Tus compras registradas:\n- " . implode("\n- ", $lineas) . "\n";
    }
}
