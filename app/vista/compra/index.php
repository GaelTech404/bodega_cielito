<?php
AuthHelper::verificarAcceso();

$titulo = "Gestión de Compras";
$contenido = __DIR__ . '/compra_contenido.php'; 
require_once __DIR__ . '/../layout/layout.php'; 
