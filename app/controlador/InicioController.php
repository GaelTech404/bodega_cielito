<?php

class InicioController
{
    public function index()
    {
        $db = Database::conectar(); // Solo una conexión, compartida

        $ventaModel = new VentaModel($db);
        $dashboardModel = new DashboardModel($db);

        $usuarioMasVentas = $dashboardModel->obtenerUsuarioConMasVentas();
        $totalMes = $dashboardModel->obtenerTotalVentasMesActual();
        $ultimaVenta = $dashboardModel->obtenerUltimaVentaConProducto();
        $productoMasVendido = $dashboardModel->obtenerProductoMasVendido();
        $productosBajoStock = $dashboardModel->obtenerProductosConStockBajo();

        require_once '../app/vista/inicio/inicio.php';
    }


}
