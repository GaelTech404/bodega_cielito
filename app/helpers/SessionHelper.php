<?php
class SessionHelper
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        self::start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function flash($key, $value = null)
    {
        self::start();

        // Guardar
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return;
        }

        // Mostrar y borrar
        if (isset($_SESSION['_flash'][$key])) {
            $mensaje = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $mensaje;
        }

        return null;
    }
}
