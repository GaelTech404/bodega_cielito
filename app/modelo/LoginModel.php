<?php

class LoginModel extends ModelBase
{

    public function obtenerUsuarioPorNombre($nombre_usuario)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc(); 
    }
}
