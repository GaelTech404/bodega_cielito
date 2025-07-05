<?php
AuthHelper::verificarAcceso();


$titulo = "Gestión de Productos";
$contenido = __DIR__ . '/producto_contenido.php'; // Mueves el contenido del <body> aquí
require_once __DIR__ . '/../layout/layout.php'; // Este archivo renderiza head + body
