<?php

class CompraModel extends ModelBase
{
    public function obtenerTodas($busqueda = '')
    {
        $busqueda = mysqli_real_escape_string($this->db, $busqueda);

        $sql = "
        SELECT c.*, p.nombre AS nombre_proveedor, u.nombre_completo AS nombre_usuario
        FROM compras c
        INNER JOIN proveedores p ON c.id_proveedor = p.id_proveedor
        INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
    ";

        if (!empty($busqueda)) {
            $sql .= " WHERE 
            p.nombre LIKE '%$busqueda%' OR
            u.nombre_completo LIKE '%$busqueda%' OR
            DATE_FORMAT(c.fecha_compra, '%Y-%m-%d') LIKE '%$busqueda%'";
        }

        $query = mysqli_query($this->db, $sql);
        $compras = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $compras[] = $row;
        }

        return $compras;
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT c.*, p.nombre AS nombre_proveedor, u.nombre_completo AS nombre_usuario
            FROM compras c
            INNER JOIN proveedores p ON c.id_proveedor = p.id_proveedor
            INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_compra = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertarCompraCompleta($id_proveedor, $id_usuario, $fecha_compra, $estado, $productos, $cantidades, $precios)
    {
        $con = Database::conectar();
        $con->begin_transaction();

        try {
            // Insertar la compra con total 0
            $stmt = $con->prepare("INSERT INTO compras (id_proveedor, id_usuario, fecha_compra, total, estado) VALUES (?, ?, ?, 0, ?)");
            $stmt->bind_param("iiss", $id_proveedor, $id_usuario, $fecha_compra, $estado);
            $stmt->execute();
            $id_compra = $stmt->insert_id;

            // Insertar cada detalle de compra y actualizar stock
            $total = 0;
            for ($i = 0; $i < count($productos); $i++) {
                $id_producto = $productos[$i];
                $cantidad = $cantidades[$i];
                $precio = $precios[$i];
                $subtotal = $cantidad * $precio;

                // Insertar detalle de compra
                $stmtDetalle = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                $stmtDetalle->bind_param("iiid", $id_compra, $id_producto, $cantidad, $precio);
                $stmtDetalle->execute();

                // Actualizar stock del producto
                $stmtStock = $con->prepare("UPDATE productos SET stock = stock + ? WHERE id_producto = ?");
                $stmtStock->bind_param("ii", $cantidad, $id_producto);
                $stmtStock->execute();

                $total += $subtotal;
            }

            // Actualizar total en la compra
            $stmtTotal = $con->prepare("UPDATE compras SET total = ? WHERE id_compra = ?");
            $stmtTotal->bind_param("di", $total, $id_compra);
            $stmtTotal->execute();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    }

    public function actualizar($id, $id_proveedor, $id_usuario, $fecha_compra, $total, $estado)
    {
        $sql = "UPDATE compras SET id_proveedor = ?, id_usuario = ?, fecha_compra = ?, total = ?, estado = ? WHERE id_compra = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iisssi", $id_proveedor, $id_usuario, $fecha_compra, $total, $estado, $id);
        return $stmt->execute();
    }
    public function calcularTotal($id_compra)
    {
        $sql = "SELECT SUM(cantidad * precio_unitario) AS total FROM detalle_compra WHERE id_compra = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_compra);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM compras WHERE id_compra = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
