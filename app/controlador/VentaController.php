<?php

class VentaController
{
    private $db;
    private $ventaModel;
    private $productoModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->db = Database::conectar();
        $this->ventaModel = new VentaModel($this->db);
        $this->productoModel = new ProductoModel($this->db);
        $this->usuarioModel = new UsuarioModel($this->db);
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';

        $ventas = $this->ventaModel->obtenerVentasConUsuarios($busqueda); // Puedes añadirle $busqueda si lo implementas
        $productos = $this->productoModel->obtenerTodos();
        $usuarios = $this->usuarioModel->obtenerTodos();

        require '../app/vista/venta/index.php';
    }

    public function detalle($id)
    {
        require_once '../app/modelo/DetalleVentaModel.php';

        $detalleModel = new DetalleVentaModel(Database::conectar());

        $venta = $this->ventaModel->obtenerPorId($id);
        $detalles = $detalleModel->obtenerDetallesPorVenta($id);
        require '../app/vista/venta/ver_detalle.php';
    }

    // Mostrar formulario de edición
    public function editar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $db = Database::conectar(); // ✅ una sola vez

        $usuarioModel = new UsuarioModel($db);
        $detalleModel = new DetalleVentaModel($db);
        $ventaModel = new VentaModel($db); // si no lo estás inyectando desde el constructor

        // Obtener la venta
        $venta = $ventaModel->obtenerPorId($id);
        if (!$venta) {
            echo "Venta no encontrada";
            exit;
        }

        $usuarios = $usuarioModel->obtenerTodos();
        $detalleVenta = $detalleModel->obtenerDetallesPorVenta($id);

        require '../app/vista/venta/form_editar.php';
    }


    // Insertar nueva venta
    public function insertar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_POST['id_usuario'] ?? '';
            $fecha_venta = $_POST['fecha_venta'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $productos = $_POST['id_producto'] ?? [];
            $cantidades = $_POST['cantidad'] ?? [];
            $precios = $_POST['precio_unitario'] ?? [];

            if ($id_usuario !== '' && $fecha_venta !== '' && count($productos) > 0) {
                try {
                    $this->ventaModel->insertarVentaCompleta($id_usuario, $fecha_venta, $estado, $productos, $cantidades, $precios);
                    header("Location:  " . URL_BASE . "/venta/index");
                    exit;
                } catch (Exception $e) {
                    echo "Error al guardar: " . $e->getMessage();
                }
            } else {
                echo "⚠️ Datos inválidos o incompletos.";
            }
        }
    }

    // Actualizar venta
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_venta = $_POST['id_venta'];
            $id_usuario = $_POST['id_usuario'];
            $fecha_venta = $_POST['fecha_venta'];
            $estado = $_POST['estado'];

            // Calcular el total desde detalle_venta
            $detalleModel = new DetalleVentaModel($this->db);
            $total = $detalleModel->calcularTotalPorVenta($id_venta);

            // Actualizar la venta con el total real calculado
            $this->ventaModel->actualizar($id_venta, $id_usuario, $fecha_venta, $total, $estado);

            header("Location:  " . URL_BASE . "/venta/index");
            exit;
        }
    }

    // Eliminar venta
    public function eliminar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $this->ventaModel->eliminar($id);

        header("Location:  " . URL_BASE . "/venta/index");
    }
}
