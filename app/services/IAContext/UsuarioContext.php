<?php

class UsuarioContext
{
    public static function generar(mysqli $db, array $usuario): string
    {
        $nombre = $usuario['nombre_usuario'] ?? 'Desconocido';
        $nombreCompleto = $usuario['nombre_completo'] ?? '';
        $rol = $usuario['rol'] ?? 'cajero';

        $contexto = "👤 Usuario actual: $nombre ($nombreCompleto)\n";
        $contexto .= "🧑‍💼 Rol del usuario: $rol\n";

        if ($rol === 'admin') {
            $contexto .= "🔐 Este usuario tiene acceso total como administrador.";
        } else {
            $contexto .= "🛒 Este usuario tiene permisos limitados como cajero (acceso restringido a otros módulos).";
        }

        return $contexto;
    }
}
