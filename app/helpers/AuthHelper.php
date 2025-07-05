<?php

class AuthHelper
{
    // ✅ Verifica si hay sesión activa
    public static function verificarAcceso()
    {
        if (!isset($_SESSION['usuario'])) {
            RedirectHelper::to(URL_BASE . '/login', '⚠️ Debe iniciar sesión para acceder.');
        }
    }

    // ✅ Verifica si el usuario tiene el rol adecuado
    public static function verificarRol($rolRequerido)
    {
        $usuario = $_SESSION['usuario'] ?? null;
        if (!$usuario || $usuario['rol'] !== $rolRequerido) {
            RedirectHelper::to(URL_BASE . '/inicio', '🚫 No tiene permisos para acceder a esta sección.');
        }
    }

    // ✅ Cierra sesión correctamente
    public static function logout()
    {
        SessionHelper::destroy();
        RedirectHelper::to(URL_BASE . '/login', '👋 Sesión cerrada correctamente.');
    }

    // ✅ Retorna HTML solo si el usuario es admin
    public static function soloAdmin($rolUsuario, $contenidoHtml)
    {
        if ($rolUsuario === 'admin') {
            return $contenidoHtml;
        } else {
            return '<span class="text-muted small">Restringido</span>';
        }
    }

    // ✅ Obtiene el usuario actual desde la sesión
    public static function getUsuario()
    {
        return $_SESSION['usuario'] ?? null;
    }

    // ✅ Devuelve el rol directamente
    public static function getRol()
    {
        return $_SESSION['usuario']['rol'] ?? null;
    }
}

