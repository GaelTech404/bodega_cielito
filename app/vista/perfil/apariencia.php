<?php
require_once __DIR__ . '/../../config/config.php';

AuthHelper::verificarAcceso();

$titulo = "Apariencia";
$contenido = __DIR__ . '/apariencia_contenido.php';
require_once __DIR__ . '/../layout/layout.php';
