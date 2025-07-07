<?php
AuthHelper::verificarAcceso();


$titulo = "Gestión de Proveedores";
$contenido = __DIR__ . '/proveedor_contenido.php'; 
require_once __DIR__ . '/../layout/layout.php'; 
