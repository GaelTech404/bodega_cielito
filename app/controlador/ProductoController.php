<?php

class ProductoController
{
    private $model;
    private $categoriaModel;
    private $db;
    public function __construct()
    {
        $this->db = Database::conectar(); // ✅ solo una vez
        $this->model = new ProductoModel($this->db);
        $this->categoriaModel = new CategoriaModel($this->db);

    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';

        $productos = $this->model->obtenerTodos($busqueda);
        $categorias = $this->categoriaModel->obtenerTodas();
        require '../app/vista/producto/index.php';
    }

    public function editar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        // Obtener el producto desde ProductoModel
        $producto = $this->model->obtenerPorId($id);
        if (!$producto) {
            echo "Producto no encontrado.";
            exit;
        }

        // Instanciar CategoriaModel y obtener categorías
        $db = Database::conectar(); // ✅ usa la misma conexión
        $categoriaModel = new CategoriaModel($db); // ✅ inyección de dependencia
        $categorias = $categoriaModel->obtenerTodas();

        // Cargar la vista
        require '../app/vista/producto/form_editar.php';
    }

    public function insertar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $id_categoria = $_POST['id_categoria'] ?? 0;
            $precio_compra = $_POST['precio_compra'] ?? 0;
            $precio_venta = $_POST['precio_venta'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $stock_minimo = $_POST['stock_minimo'] ?? 0;
            $activo = isset($_POST['activo']) ? 1 : 0;

            if ($nombre !== '' && $precio_venta > 0 && $precio_compra >= 0 && $stock >= 0 && $stock_minimo >= 0) {
                $this->model->insertar($nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo, $activo);
                header("Location:  " . URL_BASE . "/producto/index");
                exit;
            } else {
                echo "⚠️ Datos inválidos para crear producto.";
            }
        }
    }

    public function cambiarEstado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_producto'];
            $activo = isset($_POST['activo']) ? 1 : 0;

            $this->model->cambiarEstado($id, $activo);
            header("Location:  " . URL_BASE . "/producto/index");
            exit;
        }
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_producto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['id_categoria'];
            $precio_compra = $_POST['precio_compra'];
            $precio_venta = $_POST['precio_venta'];
            $stock = $_POST['stock'];
            $stock_minimo = $_POST['stock_minimo'];
            $activo = isset($_POST['activo']) ? 1 : 0;

            $this->model->actualizar($id, $nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo);
            header("Location:  " . URL_BASE . "/producto/index");
        }
    }

    public function eliminar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $producto = $this->model->eliminar($id);
        header("Location:  " . URL_BASE . "/producto/index");
    }
}
