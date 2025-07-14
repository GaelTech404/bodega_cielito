<?php

class VentaController
{
    private $db;
    private $ventaModel;
    private $productoModel;
    private $usuarioModel;

    public function __construct()
    {
        AuthHelper::verificarAcceso();

        $this->db = Database::conectar();
        $this->ventaModel = new VentaModel($this->db);
        $this->productoModel = new ProductoModel($this->db);
        $this->usuarioModel = new UsuarioModel($this->db);
    }

    public function index()
    {
        $usuario = AuthHelper::getUsuario();
        $rol = $usuario['rol'];
        $id_usuario = $usuario['id_usuario'];
        $busqueda = $_GET['busqueda'] ?? '';

        // admin = puede ver todas las ventas
        if ($rol === 'admin') {
            $ventas = $this->ventaModel->obtenerVentasConUsuarios($busqueda);
        } else {
            $ventas = $this->ventaModel->obtenerVentasPorUsuario($id_usuario, $busqueda);
        }

        $productos = $this->productoModel->obtenerTodos();
        $usuarios = $this->usuarioModel->obtenerTodos();

        ViewHelper::render('venta/index', [
            'ventas' => $ventas,
            'productos' => $productos,
            'usuarios' => $usuarios,
            'busqueda' => $busqueda
        ]);
    }

    public function detalle($id)
    {
        require_once '../app/modelo/DetalleVentaModel.php';

        $detalleModel = new DetalleVentaModel($this->db);
        $venta = $this->ventaModel->obtenerPorId($id);

        if (!$venta) {
            echo "Venta no encontrada.";
            exit;
        }

        // Solo admin puede verla la venta o el usuario que la creó
        $usuario = AuthHelper::getUsuario();
        if ($usuario['rol'] !== 'admin' && $venta['id_usuario'] !== $usuario['id_usuario']) {
            RedirectHelper::to(URL_BASE . '/venta/index', '⛔ No tiene acceso a esta venta.');
        }

        $detalles = $detalleModel->obtenerDetallesPorVenta($id);
        require '../app/vista/venta/ver_detalle.php';
    }

    public function editar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $venta = $this->ventaModel->obtenerPorId($id);
        if (!$venta) {
            echo "Venta no encontrada";
            exit;
        }

        $usuario = AuthHelper::getUsuario();
        if ($usuario['rol'] !== 'admin' && $venta['id_usuario'] !== $usuario['id_usuario']) {
            RedirectHelper::to(URL_BASE . '/venta/index', '⛔ No puede editar esta venta.');
        }

        $detalleModel = new DetalleVentaModel($this->db);
        $usuarios = $this->usuarioModel->obtenerTodos();
        $detalleVenta = $detalleModel->obtenerDetallesPorVenta($id);

        require '../app/vista/venta/form_editar.php';
    }

    public function insertar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = AuthHelper::getUsuario();
            $id_usuario = $usuario['id_usuario'];

            $fecha_venta = $_POST['fecha_venta'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $productos = $_POST['id_producto'] ?? [];
            $cantidades = $_POST['cantidad'] ?? [];
            $precios = $_POST['precio_unitario'] ?? [];

            if ($id_usuario !== '' && $fecha_venta !== '' && count($productos) > 0) {
                try {
                    $this->ventaModel->insertarVentaCompleta(
                        $id_usuario,
                        $fecha_venta,
                        $estado,
                        $productos,
                        $cantidades,
                        $precios
                    );

                    header("Location: " . URL_BASE . "/venta/index");
                    exit;
                } catch (Exception $e) {
                    echo "Error al guardar: " . $e->getMessage();
                }
            } else {
                echo "Datos inválidos o incompletos.";
            }
        }
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_venta = $_POST['id_venta'];
            $id_usuario = $_POST['id_usuario'];
            $fecha_venta = $_POST['fecha_venta'];
            $estado = $_POST['estado'];

            $venta = $this->ventaModel->obtenerPorId($id_venta);
            if (!$venta) {
                echo "Venta no encontrada.";
                exit;
            }

            $usuario = AuthHelper::getUsuario();
            if ($usuario['rol'] !== 'admin' && $venta['id_usuario'] !== $usuario['id_usuario']) {
                RedirectHelper::to(URL_BASE . '/venta/index', '⛔ No puede actualizar esta venta.');
            }

            $detalleModel = new DetalleVentaModel($this->db);
            $total = $detalleModel->calcularTotalPorVenta($id_venta);

            $this->ventaModel->actualizar($id_venta, $id_usuario, $fecha_venta, $total, $estado);
            header("Location:  " . URL_BASE . "/venta/index");
            exit;
        }
    }

    public function eliminar($id)
    {
        if (!$id) {
            echo "ID no proporcionado";
            exit;
        }

        $venta = $this->ventaModel->obtenerPorId($id);
        if (!$venta) {
            echo "Venta no encontrada.";
            exit;
        }

        $usuario = AuthHelper::getUsuario();
        if ($usuario['rol'] !== 'admin' && $venta['id_usuario'] !== $usuario['id_usuario']) {
            RedirectHelper::to(URL_BASE . '/venta/index', '⛔ No puede eliminar esta venta.');
        }

        $this->ventaModel->eliminar($id);
        header("Location:  " . URL_BASE . "/venta/index");
    }
}
