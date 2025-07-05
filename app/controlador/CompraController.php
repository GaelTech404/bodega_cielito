<?php

class CompraController
{

    private $compraModel;
    private $usuarioModel;
    private $proveedorModel;
    private $productoModel;
    private $detalleModel;
    private $db;
    public function __construct()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar();
        $this->compraModel = new CompraModel($this->db);
        $this->usuarioModel = new UsuarioModel($this->db);
        $this->proveedorModel = new ProveedorModel($this->db);
        $this->productoModel = new ProductoModel($this->db);
        $this->detalleModel = new DetalleCompraModel($this->db);
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';

        $productos = $this->productoModel->obtenerTodos();
        $compras = $this->compraModel->obtenerTodas($busqueda);
        $usuarios = $this->usuarioModel->obtenerTodos();
        $proveedores = $this->proveedorModel->obtenerTodos();

        ViewHelper::render('compra/index', [
            'compras' => $compras,
            'productos' => $productos,
            'usuarios' => $usuarios,
            'proveedores' => $proveedores,
            'busqueda' => $busqueda
        ]);
    }

    public function detalle($id)
    {
        AuthHelper::verificarAcceso();

        $compra = $this->compraModel->obtenerPorId($id);
        $detalles = $this->detalleModel->obtenerDetallesPorCompra($id);

        if (!$compra) {
            echo "Compra no encontrada.";
            exit;
        }

        require '../app/vista/compra/ver_detalle.php';
    }

    public function editar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $compra = $this->compraModel->obtenerPorId($id);
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
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

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
                    $this->compraModel->insertarCompraCompleta(
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
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        $id = $_POST['id_compra'] ?? '';
        $id_proveedor = $_POST['id_proveedor'] ?? '';
        $id_usuario = $_POST['id_usuario'] ?? '';
        $fecha_compra = $_POST['fecha_compra'] ?? '';
        $estado = $_POST['estado'] ?? '';

        if ($id && $id_proveedor && $id_usuario && $fecha_compra && $estado !== '') {
            $total = $this->compraModel->calcularTotal($id);
            $this->compraModel->actualizar($id, $id_proveedor, $id_usuario, $fecha_compra, $total, $estado);
            header("Location:  " . URL_BASE . "/compra/index");
        } else {
            echo "⚠️ Faltan datos para actualizar la compra.";
        }
    }

    public function eliminar($id)
    {
        AuthHelper::verificarRol('admin'); // ✅ Solo admin

        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $this->compraModel->eliminar($id);
        header("Location:  " . URL_BASE . "/compra/index");
    }
}