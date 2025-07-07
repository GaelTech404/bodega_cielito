<?php
AuthHelper::verificarAcceso();

$titulo = "Gestión de Productos";
$contenido = __DIR__ . '/producto_contenido.php'; 
require_once __DIR__ . '/../layout/layout.php'; 
