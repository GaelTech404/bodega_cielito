<?php

class VentasContext
{
    public static function generar(mysqli $db, array $usuario): string
    {
        $rol = $usuario['rol'] ?? 'cajero';
        $idUsuario = $usuario['id_usuario'] ?? null;
        $dashboard = new DashboardModel($db);
        $texto = '';

        if ($rol === 'admin') {
            $usuarios = (new UsuarioModel($db))->obtenerTodos();
            foreach ($usuarios as $u) {
                $ventas = $dashboard->obtenerProductosVendidosPorUsuario($u['id_usuario']);
                if (!empty($ventas)) {
                    $resumen = array_map(function ($v) {
                        $cantidad = (int) $v['cantidad'];
                        $unidad = $cantidad === 1 ? 'unidad' : 'unidades';
                        $nombre = $v['nombre'];
                        $precio = number_format($v['precio_unitario'], 2);
                        $fecha = date('d/m/Y', strtotime($v['fecha_venta']));
                        $hora = date('H:i:s', strtotime($v['fecha_venta']));

                        return "$cantidad $unidad de $nombre (S/.$precio) el $fecha a las $hora";
                    }, $ventas);
                    $texto .= "🧾 Ventas de {$u['nombre_usuario']}: " . implode('; ', $resumen) . "\n";
                } else {
                    $texto .= "🧾 {$u['nombre_usuario']} no ha registrado ventas.\n";
                }
            }
        } elseif ($rol === 'cajero' && $idUsuario) {
            $ventas = $dashboard->obtenerProductosVendidosPorUsuario($idUsuario);
            if (!empty($ventas)) {
                $resumen = array_map(function ($v) {
                    $cantidad = (int) $v['cantidad'];
                    $unidad = $cantidad === 1 ? 'unidad' : 'unidades';
                    $nombre = $v['nombre'];
                    $precio = number_format($v['precio_unitario'], 2);
                    $fecha = date('d/m/Y', strtotime($v['fecha_venta']));
                    $hora = date('H:i:s', strtotime($v['fecha_venta']));

                    return "$cantidad $unidad de $nombre (S/.$precio) el $fecha a las $hora";
                }, $ventas);
                $texto .= "🧾 Tus ventas registradas: " . implode('; ', $resumen);
            } else {
                $texto .= "🧾 No has registrado ventas aún.";
            }
        }

        return $texto;
    }
}
