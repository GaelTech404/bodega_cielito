<?php

class ProductosContext
{
    public static function generar(mysqli $db): string
    {
        $dashboard = new DashboardModel($db);
        $productoModel = new ProductoModel($db);
        $bloques = [];

        $bloques[] = ProductoFormatter::formatearStockBajo($dashboard->obtenerProductosConStockBajo());
        $bloques[] = ProductoFormatter::formatearMasVendido($dashboard->obtenerProductoMasVendido(1));
        $bloques[] = ProductoFormatter::formatearMasRentable($dashboard->obtenerProductosMasRentables(1));
        $bloques[] = ProductoFormatter::formatearValorInventario(
            $dashboard->obtenerValorTotalInventarioCompra(),
            $dashboard->obtenerValorTotalInventarioVenta()
        );
        $bloques[] = ProductoFormatter::formatearProductosActivos(
            $productoModel->obtenerProductosActivosConPrecios()
        );

        return implode("\n\n", array_filter($bloques));
    }
}

