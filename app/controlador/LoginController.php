<?php

class LoginController
{
    private $model;
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();

        $this->model = new LoginModel($this->db);
    }

    public function index()
    {
        ViewHelper::render('login/index');

    }
    public function recuperar()
    {
        include_once __DIR__ . '/../vista/login/recuperar.php';
    }

    public function validar()
    {
        ob_start();

        try {
            $nombre_usuario = ValidationHelper::limpiar($_POST['nombre_usuario'] ?? '');
            $clave_ingresada = ValidationHelper::limpiar($_POST['contraseña'] ?? '');

            $errores = $this->validarDatosEntrada($nombre_usuario, $clave_ingresada);
            if (!empty($errores)) {
                RedirectHelper::to(URL_BASE . '/login', implode(' ', $errores));
                return;
            }

            $usuario = $this->autenticarUsuario($nombre_usuario, $clave_ingresada);
            if (!$usuario) {
                RedirectHelper::to(URL_BASE . '/login', '⚠️ Usuario o contraseña incorrectos.');
                return;
            }

            $this->crearSesionUsuario($usuario);
            ob_end_clean();

            RedirectHelper::to(URL_BASE . '/inicio');

        } catch (Exception $e) {
            error_log("Error en validación de login: " . $e->getMessage());
            RedirectHelper::to(URL_BASE . '/login', '⚠️ Error interno. Intente nuevamente.');
        }
    }


    private function validarDatosEntrada($nombre_usuario, $clave_ingresada)
    {
        $errores = [];

        if (empty($nombre_usuario)) {
            $errores[] = '⚠️ El nombre de usuario es obligatorio.';
        } elseif (!ValidationHelper::longitudMinima($nombre_usuario, 3)) {
            $errores[] = '⚠️ El nombre de usuario es muy corto.';
        }

        if (empty($clave_ingresada)) {
            $errores[] = '⚠️ La contraseña es obligatoria.';
        } elseif (!ValidationHelper::longitudMinima($clave_ingresada, 6)) {
            $errores[] = '⚠️ La contraseña debe tener al menos 6 caracteres.';
        }

        return $errores;
    }

 
    private function autenticarUsuario($nombre_usuario, $clave_ingresada)
    {
        $usuario = $this->model->obtenerUsuarioPorNombre($nombre_usuario);

        if (!$usuario || !password_verify($clave_ingresada, $usuario['contraseña'])) {
            return false;
        }

        return $usuario;
    }

  
    private function crearSesionUsuario($usuario)
    {
        SessionHelper::set('usuario', [
            'id_usuario' => $usuario['id_usuario'],
            'nombre_usuario' => $usuario['nombre_usuario'],
            'nombre_completo' => $usuario['nombre_completo'],
            'correo' => $usuario['correo'],
            'rol' => $usuario['rol']
        ]);
    }

    public function logout()
    {
        AuthHelper::logout();
    }
}
