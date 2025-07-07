<?php
require_once __DIR__ . '/../../config/config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: " . URL_BASE . "/login/index");
    exit;
}

$usuario = $_SESSION['usuario'];
$nombreUsuario = $usuario['nombre_usuario'];
$titulo = "Inicio - Bodega Cielito";
$contenido = __DIR__ . '/inicio_contenido.php';

require_once __DIR__ . '/../layout/layout.php';
