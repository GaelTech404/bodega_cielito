<?php

class InicioController
{
    private $db;

    public function index()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar();

        $compraModel = new CompraModel($this->db);
        $dashboardModel = new DashboardModel($this->db);
        $ventaModel = new VentaModel($this->db);


        $productosRentables = $dashboardModel->obtenerProductosMasRentables();
        $productoTop = $dashboardModel->obtenerProductoMasVendido();
        $productosBajoStock = $dashboardModel->obtenerProductosConStockBajo();
        $ventasPorMes = $ventaModel->obtenerVentasPorMes();
        $topVendedores = $dashboardModel->obtenerTopVendedores();
        $ventasPorCategoria = $dashboardModel->obtenerVentasPorCategoria();
        $comprasPorMes = $compraModel->obtenerComprasPorMes();
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