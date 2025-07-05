<?php
session_start(); // ✅ Obligatorio aquí

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/autoload.php';

$url = filter_var($_GET['url'] ?? 'login/index', FILTER_SANITIZE_URL);
$partes = explode('/', trim($url, '/'));

$controlador = ucfirst($partes[0] ?? 'Login');
$accion = $partes[1] ?? 'index';
$parametros = array_slice($partes, 2);

$archivo = APP_PATH . "/controlador/{$controlador}Controller.php";

if (file_exists($archivo)) {
    require_once $archivo;
    $clase = $controlador . "Controller";

    if (class_exists($clase)) {
        $obj = new $clase();

        if (method_exists($obj, $accion)) {
            call_user_func_array([$obj, $accion], $parametros);
        } else {
            echo "❌ Método '$accion' no encontrado en $clase.";
        }
    } else {
        echo "❌ Clase '$clase' no encontrada.";
    }
} else {
    echo "❌ Controlador '$controlador' no encontrado.";
}
