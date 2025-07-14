<?php

class ProductosContext
{
    public static function generar(mysqli $db): string
    {
        $dashboard = new DashboardModel($db);
        $bloques = [];

        $bajoStock = $dashboard->obtenerProductosConStockBajo();
        if (!empty($bajoStock)) {
            $lista = array_map(fn($p) => "{$p['nombre']} ({$p['stock']} u)", $bajoStock);
            $bloques[] = "📦 Productos con bajo stock: " . implode(', ', $lista);
        }

        $masVendidos = $dashboard->obtenerProductoMasVendido(1);
        if (!empty($masVendidos)) {
            $p = $masVendidos[0];
            $bloques[] = "🔥 Producto más vendido: {$p['nombre']} ({$p['total_vendidos']} unidades)";
        }

        $rentables = $dashboard->obtenerProductosMasRentables(1);
        if (!empty($rentables)) {
            $r = $rentables[0];
            $bloques[] = "💰 Producto más rentable: {$r['nombre']} (S/.{$r['ingresos']})";
        }

        $valorCompra = $dashboard->obtenerValorTotalInventarioCompra();
        $valorVenta = $dashboard->obtenerValorTotalInventarioVenta();
        if ($valorCompra && $valorVenta) {
            $bloques[] = "💼 Valor total del inventario:\n- Compra: S/.{$valorCompra['valor_compra']}\n- Venta: S/.{$valorVenta['valor_venta']}";
        }

        return implode("\n", $bloques);
    }
}
