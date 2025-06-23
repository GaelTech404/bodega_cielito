<?php
class ViewHelper
{
    public static function render(string $rutaVista, array $data = []): void
    {
        // Incluir variables globales
        $data['nombreUsuario'] = $_SESSION['nombre_usuario'] ?? 'Invitado';
        $data['rolUsuario'] = $_SESSION['rol'] ?? '';
        $data['nombreCompleto'] = $_SESSION['nombre_completo'] ?? '';
        $data['URL_BASE'] = defined('URL_BASE') ? URL_BASE : '';

        extract($data, EXTR_SKIP);

        $rutaAbsoluta = APP_PATH . "/vista/{$rutaVista}.php";

        if (file_exists($rutaAbsoluta)) {
            require $rutaAbsoluta;
        } else {
            echo "⚠️ Vista no encontrada: $rutaVista";
        }
    }
}



