<?php
require_once __DIR__ . '/config/config.php';
spl_autoload_register(function ($clase) {
    $rutas = [
        APP_PATH . '/modelo/' . $clase . '.php',
        APP_PATH . '/helpers/' . $clase . '.php',
        APP_PATH . '/controlador/' . $clase . '.php',
        APP_PATH . '/services/' . $clase . '.php',

        APP_PATH . '/services/IAContext/' . $clase . '.php',

    ];

    foreach ($rutas as $ruta) {
        if (file_exists($ruta)) {
            require_once $ruta;
            return;
        }
    }
    throw new Exception("No se pudo cargar la clase: $clase");
});
