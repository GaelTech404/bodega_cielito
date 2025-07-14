<?php
ob_start(); // Activa el buffer de salida (evita errores al usar header())

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/autoload.php';

// ===========================
// OPCIONAL: Activar modo debug
// ===========================
define('DEBUG_ROUTER', true);

// ===========================
// DETECCIÓN ROBUSTA DE URL
// ===========================
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = dirname($_SERVER['SCRIPT_NAME']);

// Extrae solo la parte después de la carpeta /public
$url = str_replace($scriptName, '', $requestUri);
$url = trim($url, '/');

// Quita parámetros tipo ?x=1
if (strpos($url, '?') !== false) {
    $url = explode('?', $url)[0];
}

// Ruta por defecto
if (empty($url)) {
    $url = 'login/index';
}

$url = filter_var($url, FILTER_SANITIZE_URL);
$partes = explode('/', $url);

$controlador = ucfirst($partes[0] ?? 'Login');
$accion = $partes[1] ?? 'index';
$parametros = array_slice($partes, 2);


// ===========================
// CARGA DEL CONTROLADOR
// ===========================
$archivo = APP_PATH . "/controlador/{$controlador}Controller.php";

if (file_exists($archivo)) {
    require_once $archivo;
    $clase = $controlador . "Controller";

    if (class_exists($clase)) {
        $obj = new $clase();

        if (method_exists($obj, $accion)) {
            call_user_func_array([$obj, $accion], $parametros);
        } else {
            echo "Error: Método '$accion' no encontrado en $clase.";
        }
    } else {
        echo "Error: Clase '$clase' no encontrada.";
    }
} else {
    echo "Error: Controlador '$controlador' no encontrado.";
}

ob_end_flush(); // Libera el contenido del buffer
