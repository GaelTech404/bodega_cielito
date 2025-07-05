<?php

class UsuarioController
{
    private $model;
    private $db;

    public function __construct()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar(); // ✅ solo una vez

        $this->model = new UsuarioModel($this->db);
    }

    public function index()
    {

        $busqueda = $_GET['busqueda'] ?? '';
        $usuarios = $this->model->obtenerTodos($busqueda);

        ViewHelper::render('usuario/index', ['usuarios' => $usuarios, 'busqueda' => $busqueda]);
    }

    public function editar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $usuario = $this->model->obtenerPorId($id);
        require '../app/vista/usuario/form_editar.php';
    }

    public function actualizar()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        $id = $_POST['id_usuario'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $nombre_completo = $_POST['nombre_completo'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];
        $contrasena = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

        $this->model->actualizar($id, $nombre_usuario, $nombre_completo, $correo, $rol, $contrasena);

        header("Location:  " . URL_BASE . "/usuario/index");
    }

    public function eliminar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $this->model->eliminar($id);

        header("Location:  " . URL_BASE . "/Usuario/index");
        exit;
    }

    public function insertar()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'] ?? '';
            $nombre_completo = $_POST['nombre_completo'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $rol = $_POST['rol'] ?? '';
            $contrasena = $_POST['contraseña'] ?? '';

            if ($nombre_usuario && $nombre_completo && $correo && $rol && $contrasena) {
                $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
                $this->model->insertar($nombre_usuario, $nombre_completo, $correo, $rol, $contrasena_hash);
                header("Location:  " . URL_BASE . "/usuario/index");
            } else {
                echo "⚠️ Por favor, completa todos los campos.";
            }
        }
    }

}
