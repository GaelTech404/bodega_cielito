<?php

class AuthHelper
{
    public static function verificarAcceso()
    {
        if (!isset($_SESSION['usuario'])) {
            RedirectHelper::to(URL_BASE . '/login', '⚠️ Debe iniciar sesión para acceder.');
        }
    }

    public static function verificarRol($rolRequerido)
    {
        $usuario = $_SESSION['usuario'] ?? null;
        if (!$usuario || $usuario['rol'] !== $rolRequerido) {
            RedirectHelper::to(URL_BASE . '/inicio', '🚫 No tiene permisos para acceder a esta sección.');
        }
    }

    public static function logout()
    {
        SessionHelper::destroy();
        RedirectHelper::to(URL_BASE . '/login', '👋 Sesión cerrada correctamente.');
    }

    public static function soloAdmin($rolUsuario, $contenidoHtml)
    {
        if ($rolUsuario === 'admin') {
            return $contenidoHtml;
        } else {
            return '<span class="text-muted small">Restringido</span>';
        }
    }

    public static function getUsuario()
    {
        return $_SESSION['usuario'] ?? null;
    }

}

