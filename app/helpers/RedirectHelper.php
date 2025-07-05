<?php
class RedirectHelper
{
    public static function to($ruta, $mensaje = null)
    {
        // Asegura que URL_BASE no tenga doble barra al unir con $ruta
        if (!str_starts_with($ruta, 'http') && !str_starts_with($ruta, URL_BASE)) {
            $ruta = rtrim(URL_BASE, '/') . '/' . ltrim($ruta, '/');
        }

        if ($mensaje) {
            $_SESSION['flash_message'] = $mensaje;
        }

        header("Location: $ruta");
        exit();
    }
}

