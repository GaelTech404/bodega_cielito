<?php

class DashboardModel extends ModelBase
{

    public function obtenerUsuarioConMasVentas()
    {
        $sql = "SELECT u.id_usuario, u.nombre_completo, COUNT(v.id_venta) AS total_ventas
            FROM ventas v
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
            GROUP BY u.id_usuario
            ORDER BY total_ventas DESC
            LIMIT 1";

        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }
    public function obtenerTotalVentasMesActual()
    {
        $sql = "SELECT SUM(total) AS total_mes
            FROM ventas
            WHERE MONTH(fecha_venta) = MONTH(CURDATE()) 
              AND YEAR(fecha_venta) = YEAR(CURDATE())";

        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }
    public function obtenerUltimaVentaConProducto()
    {
        $sql = "SELECT v.fecha_venta, u.nombre_completo AS usuario, p.nombre AS producto
            FROM ventas v
            INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
            INNER JOIN productos p ON dv.id_producto = p.id_producto
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
            ORDER BY v.fecha_venta DESC
            LIMIT 1";

        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function obtenerProductoMasVendido()
    {
        $sql = "SELECT p.nombre, SUM(dv.cantidad) AS total_vendidos
        FROM detalle_venta dv
        INNER JOIN productos p ON dv.id_producto = p.id_producto
        GROUP BY dv.id_producto
        ORDER BY total_vendidos DESC
        LIMIT 1";

        $resultado = $this->db->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_assoc(); // ← aquí se devuelve el producto más vendido
        }

        return null;
    }

    public function obtenerProductosConStockBajo()
    {
        $sql = "SELECT * FROM productos WHERE stock <= stock_minimo AND activo = 1";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}