<?php

class InicioController
{
    private $db;

    public function index()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar();

        $dashboardModel = new DashboardModel($this->db);

        $productosRentables = $dashboardModel->obtenerProductosMasRentables();
        $productoTop = $dashboardModel->obtenerProductoMasVendido();
        $productosBajoStock = $dashboardModel->obtenerProductosConStockBajo();
        $ventasPorMes = $dashboardModel->obtenerVentasPorMes();
        $topVendedores = $dashboardModel->obtenerTopVendedores();
        $ventasPorCategoria = $dashboardModel->obtenerVentasPorCategoria();
        $comprasPorMes = $dashboardModel->obtenerComprasPorMes();
        $valorInventarioCompra = $dashboardModel->obtenerValorTotalInventarioCompra();
        $valorInventarioVenta = $dashboardModel->obtenerValorTotalInventarioVenta();

        $data = compact(
            'productosRentables',
            'productoTop',
            'productosBajoStock',
            'ventasPorMes',
            'topVendedores',
            'ventasPorCategoria',
            'comprasPorMes',
            'valorInventarioCompra',
            'valorInventarioVenta'
        );

        extract($data);

        require_once '../app/vista/inicio/index.php';
    }
}