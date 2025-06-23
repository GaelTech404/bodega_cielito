<?php

class DetalleCompraModel extends ModelBase
{

    public function obtenerDetallesPorCompra($id_compra)
    {
        $stmt = $this->db->prepare("
        SELECT d.*, p.nombre AS nombre_producto
        FROM detalle_compra d
        INNER JOIN productos p ON d.id_producto = p.id_producto
        WHERE d.id_compra = ?
    ");
        $stmt->bind_param("i", $id_compra);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



}