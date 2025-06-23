<?php

class CategoriaModel extends ModelBase
{
    public function obtenerTodas($busqueda = '')
    {
        if ($busqueda !== '') {
            $busqueda = '%' . $busqueda . '%';
            $stmt = $this->db->prepare("SELECT * FROM categorias WHERE nombre LIKE ?");
            $stmt->bind_param("s", $busqueda);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM categorias");
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        $categorias = [];
        while ($row = $resultado->fetch_assoc()) {
            $categorias[] = $row;
        }

        return $categorias;
    }


    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM categorias WHERE id_categoria = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function insertar($nombre, $descripcion)
    {
        $sql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $nombre, $descripcion);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre, $descripcion)
    {
        $sql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id_categoria = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $descripcion, $id);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM categorias WHERE id_categoria = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
