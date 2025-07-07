<?php

class CategoriaController
{
    private $model;
    private $db;
    public function __construct()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar(); 

        $this->model = new CategoriaModel($this->db); 
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';
        $categorias = $this->model->obtenerTodas($busqueda);

        ViewHelper::render('categoria/index', ['categorias' => $categorias, 'busqueda' => $busqueda]);
    }

    public function editar($id)
    {
        AuthHelper::verificarRol('admin'); 

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $categoria = $this->model->obtenerPorId($id);

        if (!$categoria) {
            echo "Categoría no encontrada";
            exit;
        }

        require '../app/vista/categoria/form_editar.php';
    }

    public function insertar()
    {
        AuthHelper::verificarRol('admin'); 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            if ($nombre !== '') {
                $this->model->insertar($nombre, $descripcion);
                header("Location:  " . URL_BASE . "/categoria/index");
                exit;
            } else {
                echo "⚠️ El nombre de la categoría es obligatorio.";
            }
        }
    }

    public function actualizar()
    {
        AuthHelper::verificarRol('admin'); 

        $id = $_POST['id_categoria'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $this->model->actualizar($id, $nombre, $descripcion);
        header("Location:  " . URL_BASE . "/categoria/index");
    }

    public function eliminar($id)
    {
        AuthHelper::verificarRol('admin');

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $categoria = $this->model->eliminar($id);
        header("Location:  " . URL_BASE . "/categoria/index");
    }
}
