<?php

class CompraController
{
    private $db;
    private $model;
    private $usuarioModel;
    private $proveedorModel;
    private $productoModel;
    private $detalleModel;
    public function __construct()
    {
        $this->db = Database::conectar();
        $this->model = new CompraModel($this->db);
        $this->usuarioModel = new UsuarioModel($this->db);
        $this->proveedorModel = new ProveedorModel($this->db);
        $this->productoModel = new ProductoModel($this->db);
        $this->detalleModel = new DetalleCompraModel($this->db);
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';

        $productos = $this->productoModel->obtenerTodos();
        $compras = $this->model->obtenerTodas($busqueda);
        $usuarios = $this->usuarioModel->obtenerTodos();
        $proveedores = $this->proveedorModel->obtenerTodos();

        require '../app/vista/compra/index.php';
    }

    public function detalle($id)
    {
        $compra = $this->model->obtenerPorId($id);
        $detalles = $this->detalleModel->obtenerDetallesPorCompra($id);

        if (!$compra) {
            echo "Compra no encontrada.";
            exit;
        }

        require '../app/vista/compra/ver_detalle.php';
    }

    public function editar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $compra = $this->model->obtenerPorId($id);
        if (!$compra) {
            echo "Compra no encontrada";
            exit;
        }

        $usuarios = $this->usuarioModel->obtenerTodos();
        $proveedores = $this->proveedorModel->obtenerTodos();

        require '../app/vista/compra/form_editar.php';
    }

    public function insertar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_proveedor = $_POST['id_proveedor'] ?? '';
            $id_usuario = $_POST['id_usuario'] ?? '';
            $fecha_compra = $_POST['fecha_compra'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $productos = $_POST['id_producto'] ?? [];
            $cantidades = $_POST['cantidad'] ?? [];
            $precios = $_POST['precio_unitario'] ?? [];

            if ($id_proveedor && $id_usuario && $fecha_compra && count($productos)) {
                try {
                    $this->model->insertarCompraCompleta(
                        $id_proveedor,
                        $id_usuario,
                        $fecha_compra,
                        $estado,
                        $productos,
                        $cantidades,
                        $precios
                    );
                    header("Location:  " . URL_BASE . "/compra/index");
                    exit;
                } catch (Exception $e) {
                    echo "❌ Error al guardar: " . $e->getMessage();
                }
            } else {
                echo "⚠️ Faltan datos obligatorios.";
            }
        }
    }

    public function actualizar()
    {
        $id = $_POST['id_compra'] ?? '';
        $id_proveedor = $_POST['id_proveedor'] ?? '';
        $id_usuario = $_POST['id_usuario'] ?? '';
        $fecha_compra = $_POST['fecha_compra'] ?? '';
        $estado = $_POST['estado'] ?? '';

        if ($id && $id_proveedor && $id_usuario && $fecha_compra && $estado !== '') {
            $total = $this->model->calcularTotal($id);
            $this->model->actualizar($id, $id_proveedor, $id_usuario, $fecha_compra, $total, $estado);
            header("Location:  " . URL_BASE . "/compra/index");
        } else {
            echo "⚠️ Faltan datos para actualizar la compra.";
        }
    }

    public function eliminar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $this->model->eliminar($id);
        header("Location:  " . URL_BASE . "/compra/index");
    }
}