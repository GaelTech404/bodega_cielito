<?php
class ViewHelper
{
    public static function render(string $rutaVista, array $data = []): void
    {
        $usuario = $_SESSION['usuario'] ?? null;

        $data['usuario'] = $usuario;
        $data['nombreUsuario'] = $usuario['nombre_usuario'] ?? 'Invitado';
        $data['rolUsuario'] = $usuario['rol'] ?? '';
        $data['nombreCompleto'] = $usuario['nombre_completo'] ?? '';
        $data['correoUsuario'] = $usuario['correo'] ?? '';
        $data['URL_BASE'] = defined('URL_BASE') ? URL_BASE : '';
        $data['tema'] = $_SESSION['tema'] ?? 'light';


        extract($data, EXTR_SKIP);

        $rutaAbsoluta = APP_PATH . "/vista/{$rutaVista}.php";

        if (file_exists($rutaAbsoluta)) {
            require $rutaAbsoluta;
        } else {
            echo "⚠️ Vista no encontrada: $rutaVista";
        }
    }
}



