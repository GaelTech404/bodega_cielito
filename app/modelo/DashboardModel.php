<?php

class DashboardModel extends ModelBase
{
    public function obtenerProductosMasRentables($limite = 5)
    {
        $sql = "SELECT p.nombre, SUM(dv.cantidad * dv.precio_unitario) AS ingresos
            FROM detalle_venta dv
            INNER JOIN productos p ON dv.id_producto = p.id_producto
            GROUP BY dv.id_producto
            ORDER BY ingresos DESC
            LIMIT " . intval($limite);

        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTopVendedores($limite = 5)
    {
        $sql = "SELECT u.nombre_usuario, COUNT(v.id_venta) AS total_ventas
            FROM ventas v
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
            WHERE u.nombre_usuario IS NOT NULL
            GROUP BY u.id_usuario
            ORDER BY total_ventas DESC
            LIMIT " . intval($limite);

        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerProductoMasVendido($limite = 5)
    {
        $sql = "SELECT p.nombre, SUM(dv.cantidad) AS total_vendidos
            FROM detalle_venta dv
            INNER JOIN productos p ON dv.id_producto = p.id_producto
            GROUP BY dv.id_producto
            ORDER BY total_vendidos DESC
            LIMIT " . intval($limite);

        $resultado = $this->db->query($sql);

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerProductosVendidosPorUsuario($id_usuario)
    {
        $sql = "SELECT p.nombre, dv.cantidad, dv.precio_unitario, v.fecha_venta
            FROM ventas v
            INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
            INNER JOIN productos p ON dv.id_producto = p.id_producto
            WHERE v.id_usuario = ?
            ORDER BY v.fecha_venta DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function obtenerProveedores()
    {
        $sql = "SELECT nombre, ruc, telefono, direccion, correo FROM proveedores";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerProductosConStockBajo()
    {
        $sql = "SELECT * FROM productos WHERE stock <= stock_minimo AND activo = 1";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
  

    public function obtenerVentasPorCategoria()
    {
        $sql = "SELECT c.nombre AS categoria, SUM(dv.cantidad) AS total_vendidos
            FROM detalle_venta dv
            INNER JOIN productos p ON dv.id_producto = p.id_producto
            INNER JOIN categorias c ON p.id_categoria = c.id_categoria
            GROUP BY c.id_categoria
            ORDER BY total_vendidos DESC";

        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

  
    public function obtenerValorTotalInventarioCompra()
    {
        $sql = "SELECT SUM(stock * precio_compra) AS valor_compra
            FROM productos
            WHERE activo = 1";

        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }
    public function obtenerValorTotalInventarioVenta()
    {
        $sql = "SELECT SUM(stock * precio_venta) AS valor_venta
            FROM productos
            WHERE activo = 1";

        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

}