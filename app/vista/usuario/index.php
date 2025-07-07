<?php
AuthHelper::verificarAcceso();


$titulo = "Gestión de Usuarios";
$contenido = __DIR__ . '/usuario_contenido.php'; 
require_once __DIR__ . '/../layout/layout.php'; 
