<?php
class ProductoFormatter
{
    public static function formatearStockBajo(array $productos): string
    {
        if (empty($productos))
            return '';
        $lista = array_map(fn($p) => "{$p['nombre']} ({$p['stock']} u)", $productos);
        return "📦 Productos con bajo stock: " . implode(', ', $lista);
    }

    public static function formatearMasVendido(array $productos): string
    {
        if (empty($productos))
            return '';
        $p = $productos[0];
        return "🔥 Producto más vendido: {$p['nombre']} ({$p['total_vendidos']} unidades)";
    }

    public static function formatearMasRentable(array $productos): string
    {
        if (empty($productos))
            return '';
        $p = $productos[0];
        return "💰 Producto más rentable: {$p['nombre']} (S/.{$p['ingresos']})";
    }

    public static function formatearValorInventario(array $compra, array $venta): string
    {
        if (!$compra || !$venta)
            return '';
        return "💼 Valor total del inventario:\n- Compra: S/.{$compra['valor_compra']}\n- Venta: S/.{$venta['valor_venta']}";
    }

    public static function formatearProductosActivos(array $productos): string
    {
        if (empty($productos))
            return '';
        $lineas = array_map(function ($p) {
            return "- {$p['nombre']}: Compra S/.{$p['precio_compra']}, Venta S/.{$p['precio_venta']}, Stock: {$p['stock']}";
        }, $productos);
        return "📋 Productos activos con precios y stock:\n" . implode("\n", $lineas);
    }
}