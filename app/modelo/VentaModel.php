<?php

class VentaModel extends ModelBase
{
    public function obtenerVentasConUsuarios($busqueda = '')
    {
        if ($busqueda !== '') {
            $busqueda = '%' . $busqueda . '%';
            $stmt = $this->db->prepare("
            SELECT v.*, u.nombre_completo AS nombre_usuario
            FROM ventas v
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
            WHERE u.nombre_completo LIKE ? 
               OR v.fecha_venta LIKE ?
               OR v.estado LIKE ?
               OR CAST(v.total AS CHAR) LIKE ?
        ");
            $stmt->bind_param("ssss", $busqueda, $busqueda, $busqueda, $busqueda);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $stmt = $this->db->prepare("
            SELECT v.*, u.nombre_completo AS nombre_usuario
            FROM ventas v
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
        ");
            $stmt->execute();
            $result = $stmt->get_result();
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerPorId($id)
    {
        $con = $this->db;
        $sql = "SELECT v.*, u.nombre_completo 
            FROM ventas v
            INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
            WHERE v.id_venta = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerVentasPorUsuario($id_usuario, $busqueda = '')
    {
        if (!empty($busqueda)) {
            $busqueda = "%$busqueda%";
            $sql = "SELECT v.*, u.nombre_completo AS nombre_usuario 
                FROM ventas v
                INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
                WHERE v.id_usuario = ? AND (
                    u.nombre_completo LIKE ? OR
                    v.fecha_venta LIKE ?
                )";

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("iss", $id_usuario, $busqueda, $busqueda);
        } else {
            $sql = "SELECT v.*, u.nombre_completo AS nombre_usuario 
                FROM ventas v
                INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
                WHERE v.id_usuario = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function insertarVentaCompleta($id_usuario, $fecha_venta, $estado, $productos, $cantidades, $precios)
    {
        $con = Database::conectar();
        $con->begin_transaction();

        try {
            // Insertar la venta con total 0
            $stmt = $con->prepare("INSERT INTO ventas (id_usuario, fecha_venta, total, estado) VALUES (?, ?, 0, ?)");
            $stmt->bind_param("iss", $id_usuario, $fecha_venta, $estado);
            $stmt->execute();
            $id_venta = $stmt->insert_id;

            $total = 0;

            // Insertar cada detalle de venta y actualizar stock
            for ($i = 0; $i < count($productos); $i++) {
                $id_producto = $productos[$i];
                $cantidad = $cantidades[$i];
                $precio = $precios[$i];
                $subtotal = $cantidad * $precio;

                // Validar que haya stock suficiente
                $stmtStockActual = $con->prepare("SELECT stock FROM productos WHERE id_producto = ?");
                $stmtStockActual->bind_param("i", $id_producto);
                $stmtStockActual->execute();
                $result = $stmtStockActual->get_result();
                $stockActual = $result->fetch_assoc()['stock'];

                if ($stockActual < $cantidad) {
                    throw new Exception("Stock insuficiente para el producto con ID $id_producto.");
                }

                // Insertar detalle de venta
                $stmtDetalle = $con->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                $stmtDetalle->bind_param("iiid", $id_venta, $id_producto, $cantidad, $precio);
                $stmtDetalle->execute();

                // Actualizar stock del producto (restar)
                $stmtStock = $con->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
                $stmtStock->bind_param("ii", $cantidad, $id_producto);
                $stmtStock->execute();

                $total += $subtotal;
            }

            // Actualizar total de la venta
            $stmtTotal = $con->prepare("UPDATE ventas SET total = ? WHERE id_venta = ?");
            $stmtTotal->bind_param("di", $total, $id_venta);
            $stmtTotal->execute();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    }

    public function actualizar($id, $id_usuario, $fecha_venta, $total, $estado)
    {
        $con = $this->db;
        $sql = "UPDATE ventas SET id_usuario = ?, fecha_venta = ?, total = ?, estado = ? WHERE id_venta = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isdsi", $id_usuario, $fecha_venta, $total, $estado, $id);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $con = $this->db;
        $stmt = $con->prepare("DELETE FROM ventas WHERE id_venta = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
