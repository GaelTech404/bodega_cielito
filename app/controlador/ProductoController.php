<?php

class ProductoController
{
    private $productoModel;
    private $categoriaModel;
    private $db;
    public function __construct()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar(); // ✅ solo una vez

        $this->productoModel = new ProductoModel($this->db);
        $this->categoriaModel = new CategoriaModel($this->db);

    }

    public function index()
    {

        $busqueda = $_GET['busqueda'] ?? '';

        $productos = $this->productoModel->obtenerTodos($busqueda);
        $categorias = $this->categoriaModel->obtenerTodas();
        ViewHelper::render('producto/index', ['productos' => $productos, 'busqueda' => $busqueda]);
    }

    public function editar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        // Obtener el producto desde ProductoModel
        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            echo "Producto no encontrado.";
            exit;
        }

        // Instanciar CategoriaModel y obtener categorías
        $categoriaModel = new CategoriaModel($this->db); // ✅ inyección de dependencia
        $categorias = $categoriaModel->obtenerTodas();

        // Cargar la vista
        require '../app/vista/producto/form_editar.php';
    }

    public function insertar()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

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
                $this->productoModel->insertar($nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo, $activo);
                header("Location:  " . URL_BASE . "/producto/index");
                exit;
            } else {
                echo "⚠️ Datos inválidos para crear producto.";
            }
        }
    }

    public function cambiarEstado()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_producto'];
            $activo = isset($_POST['activo']) ? 1 : 0;

            $this->productoModel->cambiarEstado($id, $activo);
            header("Location:  " . URL_BASE . "/producto/index");
            exit;
        }
    }

    public function actualizar()
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

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

            $this->productoModel->actualizar($id, $nombre, $descripcion, $id_categoria, $precio_compra, $precio_venta, $stock, $stock_minimo);
            header("Location:  " . URL_BASE . "/producto/index");
        }
    }

    public function eliminar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }
        $producto = $this->productoModel->eliminar($id);
        header("Location:  " . URL_BASE . "/producto/index");
    }
}
