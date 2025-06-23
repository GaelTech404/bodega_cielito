<?php

class UsuarioModel extends ModelBase
{
    public function obtenerTodos($busqueda = '')
    {
        if ($busqueda !== '') {
            $busqueda = "%$busqueda%";
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario LIKE ? OR nombre_usuario LIKE ?");
            $stmt->bind_param("ss", $busqueda, $busqueda);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM usuarios");
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertar($nombre_usuario, $nombre_completo, $correo, $rol, $contrasena)
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre_usuario, nombre_completo, correo, rol, contraseña) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre_usuario, $nombre_completo, $correo, $rol, $contrasena);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre_usuario, $nombre_completo, $correo, $rol, $contrasena)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET nombre_usuario = ?, nombre_completo = ?, correo = ?, rol = ?, contraseña = ? WHERE id_usuario = ?");
        $stmt->bind_param("sssssi", $nombre_usuario, $nombre_completo, $correo, $rol, $contrasena, $id);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();

    }
}
