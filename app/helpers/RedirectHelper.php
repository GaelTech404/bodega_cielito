<?php
class RedirectHelper
{
    public static function to($ruta, $mensaje = null)
    {
        if (!str_starts_with($ruta, 'http') && !str_starts_with($ruta, URL_BASE)) {
            $ruta = rtrim(URL_BASE, '/') . '/' . ltrim($ruta, '/');
        }

        if ($mensaje) {
            SessionHelper::flash('error', $mensaje);
        }

        if (headers_sent($archivo, $linea)) {
            echo "⚠️ Headers already sent in $archivo on line $linea<br>";
            exit;
        }

        header("Location: $ruta");
        exit();
    }
}
