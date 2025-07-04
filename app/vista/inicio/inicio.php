<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: " . URL_BASE . "/login/index");
    exit;
}

$nombreUsuario = $_SESSION['nombre_usuario'];
$titulo = "Inicio - Bodega Cielito";
$contenido = __DIR__ . '/inicio_contenido.php';

require_once __DIR__ . '/../layout/layout.php';
