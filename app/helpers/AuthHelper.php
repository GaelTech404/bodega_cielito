<?php

class AuthHelper
{
    // Verifica si hay sesión activa, si no redirige al login
    public static function verificarAcceso()
    {
        SessionHelper::start();
        if (!SessionHelper::get('nombre_usuario')) {
            RedirectHelper::to(URL_BASE . '/login', 'Debe iniciar sesión para acceder.');
        }
    }

    // ✅ Verifica si el usuario tiene un rol específico (ej. admin)
    public static function verificarRol($rolRequerido)
    {
        SessionHelper::start();
        if (SessionHelper::get('rol') !== $rolRequerido) {
            RedirectHelper::to(URL_BASE . '/inicio', 'No tiene permisos para acceder a esta sección.');
        }
    }

    // Cierra sesión y redirige al login
    public static function logout()
    {
        SessionHelper::start();
        SessionHelper::destroy();
        RedirectHelper::to(URL_BASE . '/login', 'Sesión cerrada correctamente.');
    }
}
