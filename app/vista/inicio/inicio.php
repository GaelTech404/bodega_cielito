<?php
require_once __DIR__ . '/../../config/config.php'; // Ajusta la ruta según tu estructura

session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: " . URL_BASE . "/login/index");
    exit;
}


$nombreUsuario = $_SESSION['nombre_usuario'];

function card($url, $img, $alt, $titulo, $descripcion)
{
    $base = URL_BASE;
    return "
    <div class='card' onclick=\"location.href='{$base}/{$url}'\">
        <div class='face front'>
            <img src='{$base}/img/{$img}' alt='{$alt}'>
            <h3>{$titulo}</h3>
        </div>
        <div class='face back'>
            <p>{$descripcion}</p>
        </div>
    </div>";
}

?>

<!DOCTYPE html>
<html lang="es">
<!-- PROBANDO CAMBIOS EN RAMAS DEV -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inicio - Bodega Cielito</title>

    <!-- Librerías CSS -->
    <link rel="stylesheet" href="<?= URL_BASE ?>/librerias/bootstrap/css/bootstrap.min.css">

    <!-- estilos locales -->
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/base.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/navbar.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/animaciones.css">

</head>

<body>
    <div class="d-flex">
        <!-- PANEL IZQUIERDO -->
        <div class="dashboard-wrapper">

            <!-- Sidebar -->
            <aside class="sidebar">
                <img src="<?= URL_BASE ?>/img/logo.png" class="sidebar-logo">

                <!-- Producto más vendido -->
                <?php if (!empty($productoMasVendido)): ?>
                    <div class="text-center text-muted mb-3">
                        🏆 Producto más vendido: <strong><?= htmlspecialchars($productoMasVendido['nombre']) ?></strong>
                        (<?= $productoMasVendido['total_vendidos'] ?> unidades)
                    </div>
                <?php endif; ?>

                <!-- Producto con stock bajo -->
                <?php if (!empty($productosBajoStock)): ?>
                    <div class="text-center text-danger mb-3">
                        ⚠️ <strong>Productos con bajo stock:</strong>
                        <?php foreach ($productosBajoStock as $index => $producto): ?>
                            <?= htmlspecialchars($producto['nombre']) ?>
                            (<?= $producto['stock'] ?>/<?= $producto['stock_minimo'] ?>)
                            <?= $index < count($productosBajoStock) - 1 ? ' • ' : '' ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Usuario con mas ventas -->
                <?php if (!empty($usuarioMasVentas)): ?>
                    <div class="text-center text-success mb-3">
                        👤 Usuario con más ventas:
                        <strong><?= htmlspecialchars($usuarioMasVentas['nombre_completo']) ?></strong>
                        (<?= $usuarioMasVentas['total_ventas'] ?> ventas)
                    </div>
                <?php endif; ?>
                <!-- Total ventas del mes -->
                <?php if (!empty($totalMes)): ?>
                    <div class="text-center text-primary mb-3">
                        💳 Total ventas del mes: <strong>S/. <?= number_format($totalMes['total_mes'], 2) ?></strong>
                    </div>
                <?php endif; ?>
                <!-- Última venta -->
                <?php if (!empty($ultimaVenta)): ?>
                    <div class="text-center text-muted mb-3">
                        🕒 Última venta: <strong><?= htmlspecialchars($ultimaVenta['producto']) ?></strong>
                        vendida por <strong><?= htmlspecialchars($ultimaVenta['usuario']) ?></strong>
                        el <strong><?= date('d/m/Y', strtotime($ultimaVenta['fecha_venta'])) ?></strong>
                    </div>
                <?php endif; ?>

                <a href="<?= URL_BASE ?>/login/logout" class="btn btn-outline-danger w-100 mt-4">
                    Cerrar sesión
                </a>
            </aside>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-grow-1 p-4">
            <!-- SALUDO -->
            <div class="mb-4">
                <h5 class="text-muted" id="saludo"></h5>
            </div>

            <div class="dashboard-cards">
                <?= card('producto', 'productos.jpg', 'Productos', 'Productos', 'Gestionar productos') ?>
                <?= card('categoria', 'categoria.jpg', 'Categorías', 'Categorías', 'Gestionar categorías') ?>
                <?= card('proveedor', 'proveedor.jpg', 'Proveedores', 'Proveedores', 'Gestionar proveedores') ?>
                <?= card('compra', 'compras.jpg', 'Compras', 'Compras', 'Gestionar compras') ?>
                <?= card('venta', 'ventas.jpg', 'Ventas', 'Ventas', 'Gestionar ventas') ?>
                <?= card('usuario', 'usuarios.jpg', 'Usuarios', 'Usuarios', 'Gestionar usuarios') ?>
            </div>
            <?php include_once(__DIR__ . '/../layout/footer.php'); ?>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const saludo = document.getElementById("saludo");
        const fecha = new Date();
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const nombreUsuario = "<?= htmlspecialchars($nombreUsuario) ?>";
        saludo.innerHTML = `Bienvenido <strong>${nombreUsuario}</strong>. Hoy es ${fecha.toLocaleDateString('es-ES', opciones)}`;
    });
</script>

</html>