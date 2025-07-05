<?php

class ProveedorController
{
    private $model;
    private $db;
    public function __construct()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar();
        $this->model = new ProveedorModel($this->db); // ✅ Inyectar conexión
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';
        $proveedores = $this->model->obtenerTodos($busqueda);

        ViewHelper::render('proveedor/index', ['proveedores' => $proveedores, 'busqueda' => $busqueda]);
    }

    public function editar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $proveedor = $this->model->obtenerPorId($id);

        require '../app/vista/proveedor/form_editar.php';
    }

    public function insertar()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $ruc = $_POST['ruc'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $correo = $_POST['correo'] ?? '';

            if ($nombre !== '' && $ruc !== '') {
                $this->model->insertar($nombre, $ruc, $telefono, $direccion, $correo);
                header("Location:  " . URL_BASE . "/proveedor/index");
                exit;
            } else {
                echo "⚠️ Datos inválidos para crear proveedor.";
            }
        }
    }

    public function actualizar()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        $id = $_POST['id_proveedor'];
        $nombre = $_POST['nombre'];
        $ruc = $_POST['ruc'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];

        $this->model->actualizar($id, $nombre, $ruc, $telefono, $direccion, $correo);
        header("Location:  " . URL_BASE . "/proveedor/index");
    }

    public function eliminar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $proveedor = $this->model->eliminar($id);
        header("Location:  " . URL_BASE . "/proveedor/index");
    }
}
