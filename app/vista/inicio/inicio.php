<?php
require_once __DIR__ . '/../../config/config.php';

// ✅ Verificar si el usuario está autenticado usando el array 'usuario'
if (!isset($_SESSION['usuario'])) {
    header("Location: " . URL_BASE . "/login/index");
    exit;
}

// ✅ Obtener datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$nombreUsuario = $usuario['nombre_usuario'];
$titulo = "Inicio - Bodega Cielito";
$contenido = __DIR__ . '/inicio_contenido.php';

require_once __DIR__ . '/../layout/layout.php';
