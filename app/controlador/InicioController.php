<?php

class InicioController
{
    public function index()
    {
        $db = Database::conectar();

        $ventaModel = new VentaModel($db);
        $dashboardModel = new DashboardModel($db);

        $usuarioTop = $dashboardModel->obtenerUsuarioConMasVentas();
        $ventasMes = $dashboardModel->obtenerTotalVentasMesActual();
        $ultimaVenta = $dashboardModel->obtenerUltimaVentaConProducto();
        $productoTop = $dashboardModel->obtenerProductoMasVendido();
        $productosBajoStock = $dashboardModel->obtenerProductosConStockBajo();
        $ventasPorMes = $dashboardModel->obtenerVentasPorMes();
        $topVendedores = $dashboardModel->obtenerTopVendedores();
        $ventasPorCategoria = $dashboardModel->obtenerVentasPorCategoria();
        $comprasPorMes = $dashboardModel->obtenerComprasPorMes();

        // Pasamos todos los datos a la vista
        $data = compact(
            'usuarioTop',
            'ventasMes',
            'ultimaVenta',
            'productoTop',
            'productosBajoStock',
            'ventasPorMes',
            'topVendedores',
            'ventasPorCategoria',
            'comprasPorMes'
        );

        extract($data); // convierte claves del array en variables para la vista

        require_once '../app/vista/inicio/inicio.php';
    }
}