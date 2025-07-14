<?php
class ProductoModel extends ModelBase
{
    public function obtenerTodos(string $busqueda = ''): array
    {
        if (!$this->db) {
            throw new Exception("Error: Sin conexión a la base de datos.");
        }

        $sqlBase = "
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
    ";

        if ($busqueda !== '') {
            $sql = $sqlBase . " WHERE p.nombre LIKE ? OR c.nombre LIKE ?";
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }

            $like = '%' . $busqueda . '%';
            $stmt->bind_param("ss", $like, $like);
        } else {
            $stmt = $this->db->prepare($sqlBase);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->db->error);
            }
        }

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function insertar($nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo, $activo)
    {
        $stmt = $this->db->prepare("INSERT INTO productos 
        (nombre, descripcion, id_categoria, precio_compra, precio_venta, stock, stock_minimo, fecha_registro, activo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
        $stmt->bind_param("ssiddiii", $nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo, $activo);
        return $stmt->execute();
    }
    public function actualizar($id, $nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo)
    {
        $stmt = $this->db->prepare("UPDATE productos 
        SET nombre = ?, descripcion = ?, id_categoria = ?, precio_compra = ?, precio_venta = ?, stock = ?, stock_minimo = ?
        WHERE id_producto = ?");

        $stmt->bind_param("ssiddiii", $nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo, $id);

        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function cambiarEstado($id, $activo)
    {
        $stmt = $this->db->prepare("UPDATE productos SET activo = ? WHERE id_producto = ?");
        $stmt->bind_param("ii", $activo, $id);
        return $stmt->execute();
    }

}
