<?php
AuthHelper::verificarAcceso();

$titulo = "Gestión de Categorias";
$contenido = __DIR__ . '/categoria_contenido.php'; 
require_once __DIR__ . '/../layout/layout.php'; 
