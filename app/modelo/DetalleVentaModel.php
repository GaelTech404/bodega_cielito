<?php

class DetalleVentaModel extends ModelBase
{

    public function calcularTotalPorVenta($id_venta)
    {
        $stmt = $this->db->prepare("
        SELECT SUM(cantidad * precio_unitario) AS total 
        FROM detalle_venta 
        WHERE id_venta = ?
    ");
        $stmt->bind_param("i", $id_venta);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function obtenerDetallesPorVenta($id_venta)
    {
        $stmt = $this->db->prepare("
        SELECT dv.*, p.nombre AS nombre_producto
        FROM detalle_venta dv
        INNER JOIN productos p ON dv.id_producto = p.id_producto
        WHERE dv.id_venta = ?
    ");
        $stmt->bind_param("i", $id_venta);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}