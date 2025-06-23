<?php

class LoginController
{
    private $model;

    public function __construct()
    {
        $this->model = new LoginModel(Database::conectar());
    }

    public function index()
    {
        ViewHelper::render('login/index');

    }

    public function validar()
    {

        SessionHelper::start();

        $nombre_usuario = ValidationHelper::limpiar($_POST['nombre_usuario'] ?? '');
        $clave_ingresada = ValidationHelper::limpiar($_POST['contraseña'] ?? '');

        // Validaciones adicionales
        if (!ValidationHelper::longitudMinima($nombre_usuario, 3)) {

            RedirectHelper::to(URL_BASE . '/login', '⚠️ El nombre de usuario es muy corto.');

        }

        if (!ValidationHelper::longitudMinima($clave_ingresada, 6)) {
            RedirectHelper::to(URL_BASE . '/login', '⚠️ La contraseña debe tener al menos 6 caracteres.');
        }

        $usuario = $this->model->obtenerUsuarioPorNombre($nombre_usuario);

        if ($usuario && password_verify($clave_ingresada, $usuario['contraseña'])) {
            SessionHelper::set('nombre_usuario', $usuario['nombre_usuario']);
            SessionHelper::set('nombre_completo', $usuario['nombre_completo']);
            SessionHelper::set('rol', $usuario['rol']);


            RedirectHelper::to(URL_BASE . '/inicio');
            return;
        } else {

            RedirectHelper::to(URL_BASE . '/login', '❌ Usuario o contraseña incorrectos.');
        }

    }

    public function logout()
    {
        AuthHelper::logout(); // destruye la sesión y redirige al login
    }
}
