<?php

class VentasContext
{
    public static function generar(mysqli $db, array $usuario): string
    {
        $rol = $usuario['rol'] ?? 'cajero';
        $idUsuario = $usuario['id_usuario'] ?? null;

        $dashboardModel = new DashboardModel($db);
        $usuarioModel = new UsuarioModel($db);
        $ventaModel = new VentaModel($db);

        $texto = '';

        if ($rol === 'admin') {
            $usuarios = $usuarioModel->obtenerTodos();
            foreach ($usuarios as $u) {
                $ventas = $dashboardModel->obtenerProductosVendidosPorUsuario($u['id_usuario']);
                $texto .= VentaFormatter::formatearVentas($ventas, $u['nombre_usuario']);
            }
        } elseif ($rol === 'cajero' && $idUsuario) {
            $ventas = $dashboardModel->obtenerProductosVendidosPorUsuario($idUsuario);
            $texto .= VentaFormatter::formatearVentas($ventas, 'tus');
        }

        $ventasMensuales = $ventaModel->obtenerVentasPorMes();
        $texto .= "\n" . VentaFormatter::formatearResumenVentasMensual($ventasMensuales);

        return $texto ?: "🧾 No hay ventas registradas.";
    }
}
