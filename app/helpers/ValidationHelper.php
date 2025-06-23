<?php
class ValidationHelper
{
    // Elimina espacios, etiquetas y convierte caracteres especiales
    public static function limpiar($dato): string
    {
        return htmlspecialchars(trim(strip_tags($dato)), ENT_QUOTES, 'UTF-8');
    }

    public static function validarEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function longitudMinima($cadena, $longitud): bool
    {
        return mb_strlen($cadena, 'UTF-8') >= $longitud;
    }

    public static function soloNumeros($valor): bool
    {
        return preg_match('/^\d+$/', $valor) === 1;
    }

    public static function maxLength($cadena, $max): bool
    {
        return mb_strlen($cadena, 'UTF-8') <= $max;
    }
}

