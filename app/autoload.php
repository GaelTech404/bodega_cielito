<?php
// app/autoload.php

require_once __DIR__ . '/config/config.php';

spl_autoload_register(function ($clase) {
    $rutas = [
        APP_PATH . '/modelo/' . $clase . '.php',
        APP_PATH . '/helpers/' . $clase . '.php',
        APP_PATH . '/controlador/' . $clase . '.php',
    ];

    foreach ($rutas as $ruta) {
        if (file_exists($ruta)) {
            require_once $ruta;
            return;
        }
    }

    echo "❌ No se pudo cargar la clase: <strong>$clase</strong><br>";
    echo "Ruta buscada: <code>" . implode('</code><br><code>', $rutas) . "</code>";
    exit;
});
