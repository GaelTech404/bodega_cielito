<?php
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: " . URL_BASE . "/login/index");
    exit;
}

$titulo = "Gestión de Usuarios";
$contenido = __DIR__ . '/usuario_contenido.php'; // Mueves el contenido del <body> aquí
require_once __DIR__ . '/../layout/layout.php'; // Este archivo renderiza head + body
