<?php

class ProveedorModel extends ModelBase
{

    public function obtenerTodos($busqueda = '')
    {
        if ($busqueda !== '') {
            $busqueda = "%$busqueda%";
            $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE id_proveedor LIKE ? OR nombre LIKE ?");
            $stmt->bind_param("ss", $busqueda, $busqueda);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM proveedores");
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        $proveedores = [];
        while ($row = $resultado->fetch_assoc()) {
            $proveedores[] = $row;
        }
        return $proveedores;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE id_proveedor = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertar($nombre, $ruc, $telefono, $direccion, $correo)
    {
        $stmt = $this->db->prepare("INSERT INTO proveedores (nombre, ruc, telefono, direccion, correo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $ruc, $telefono, $direccion, $correo);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre, $ruc, $telefono, $direccion, $correo)
    {
        $stmt = $this->db->prepare("UPDATE proveedores SET nombre = ?, ruc = ?, telefono = ?, direccion = ?, correo = ? WHERE id_proveedor = ?");
        $stmt->bind_param("sssssi", $nombre, $ruc, $telefono, $direccion, $correo, $id);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM proveedores WHERE id_proveedor = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
