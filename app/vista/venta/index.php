<?php
AuthHelper::verificarAcceso();

$titulo = "Gestión de Ventas";
$contenido = __DIR__ . '/venta_contenido.php'; 
require_once __DIR__ . '/../layout/layout.php'; 
