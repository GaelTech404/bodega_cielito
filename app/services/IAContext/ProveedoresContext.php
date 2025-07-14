<?php

class ProveedoresContext
{
    public static function generar(mysqli $db): string
    {
        $dashboard = new DashboardModel($db);
        $proveedores = $dashboard->obtenerProveedores();

        if (!empty($proveedores)) {
            $resumen = array_map(function ($p) {
                return "{$p['nombre']}(📞 {$p['telefono']}) {$p['ruc']} {$p['direccion']} {$p['correo']}";
            }, $proveedores);

            return "🔗 Proveedores disponibles: " . implode(', ', $resumen);
        }

        return '';
    }
}
