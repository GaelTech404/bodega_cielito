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
    public function recuperar()
    {
        include_once __DIR__ . '/../vista/login/recuperar.php';
    }
    public function enviar_recuperacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            SessionHelper::start();

            // CSRF Token
            if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
                $_SESSION['flash_message'] = 'Petición inválida. Vuelve a intentarlo.';
                header('Location: ' . URL_BASE . '/login/recuperar');
                exit;
            }

            // Validación de correo
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash_message'] = 'Correo no válido.';
                header('Location: ' . URL_BASE . '/login/recuperar');
                exit;
            }

            // Aquí podrías buscar el email en la base de datos, y si existe, generar y guardar token
            // Simulación segura:
            $_SESSION['flash_message'] = 'Si el correo está registrado, recibirás instrucciones para restablecer tu contraseña.';

            // 🔐 (Opcional) log interno:
            error_log("Intento de recuperación para: $email desde IP: " . $_SERVER['REMOTE_ADDR']);

            header('Location: ' . URL_BASE . '/login/recuperar');
            exit;
        }
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
            SessionHelper::set('correo', $usuario['correo']); // ✅ Agrega esta línea
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
