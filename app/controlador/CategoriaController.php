<?php

class CategoriaController
{
    private $model;

    public function __construct()
    {
        $db = Database::conectar(); // ✅ Conexión única
        $this->model = new CategoriaModel($db); // ✅ Inyectar conexión
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';
        $categorias = $this->model->obtenerTodas($busqueda);
        require '../app/vista/categoria/index.php';
    }

    public function editar($id)
    {
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
        $id = $_POST['id_categoria'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $this->model->actualizar($id, $nombre, $descripcion);
        header("Location:  " . URL_BASE . "/categoria/index");
    }

    public function eliminar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $categoria = $this->model->eliminar($id);
        header("Location:  " . URL_BASE . "/categoria/index");
    }
}
