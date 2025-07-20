<?php
class ValidationHelper
{
    public static function limpiar($dato): string
    {
        return htmlspecialchars(trim(strip_tags($dato)), ENT_QUOTES, 'UTF-8');
    }

   
    public static function longitudMinima($cadena, $longitud): bool
    {
        return mb_strlen($cadena, 'UTF-8') >= $longitud;
    }

}

