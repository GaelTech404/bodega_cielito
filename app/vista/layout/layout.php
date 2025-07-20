<?php
$tema = $_COOKIE['tema'] ?? 'system';

switch ($tema) {
    case 'light':
        $dataTheme = 'light';
        break;
    case 'dark':
        $dataTheme = 'dark';
        break;
    case 'system':
    default:
        $dataTheme = (isset($_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME']) && $_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'] === 'dark')
            ? 'dark' : 'light';
        break;
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="<?= $dataTheme ?>">
<?php require_once 'head.php'; ?>


<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <?php require_once 'sidebar.php'; ?>
        <main class="contenido-principal flex-grow-1 p-3">
            <?php require $contenido; ?>

        </main>
    </div>
    <?php include_once 'footer.php'; ?>

    <?php
    $archivoContenido = basename($contenido ?? '');
    if (in_array($archivoContenido, ['compra_contenido.php', 'venta_contenido.php'])):
        ?>
        <script src="<?= URL_BASE ?>/js/venta_compra.js"></script>
    <?php endif; ?>
    <script src="<?= URL_BASE ?>/js/menu_desplegable.js"></script>
    <?php
    $archivoContenido = basename($contenido ?? '');

    if ($archivoContenido === 'inicio_contenido.php'): ?>
        <script>
            window.dashboardData = {
                productosMasRentables: {
                    labels: <?= json_encode(array_column($productosRentables, 'nombre')) ?>,
                    data: <?= json_encode(array_map('floatval', array_column($productosRentables, 'ingresos'))) ?>
                },
                productosMasVendidos: {
                    labels: <?= json_encode(array_column($productoTop, 'nombre')) ?>,
                    data: <?= json_encode(array_column($productoTop, 'total_vendidos')) ?>
                },
                ventasPorMes: {
                    labels: <?= json_encode(['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']) ?>,
                    data: <?= json_encode(array_values($ventasPorMes)) ?>
                },
                topVendedores: {
                    labels: <?= json_encode(array_column($topVendedores, 'nombre_usuario')) ?>,
                    data: <?= json_encode(array_column($topVendedores, 'total_ventas')) ?>
                },
                ventasPorCategoria: {
                    labels: <?= json_encode(array_column($ventasPorCategoria, 'categoria')) ?>,
                    data: <?= json_encode(array_column($ventasPorCategoria, 'total_vendidos')) ?>
                },
                comprasPorMes: {
                    labels: <?= json_encode(["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]) ?>,
                
                    data: <?= json_encode(array_values($comprasPorMes)) ?>
                },
                productosStockBajo: <?= json_encode($productosBajoStock) ?>,
                valorInventarioCompra: <?= $valorInventarioCompra['valor_compra'] ?? 0 ?>,
                valorInventarioVenta: <?= $valorInventarioVenta['valor_venta'] ?? 0 ?>
            };
        </script>
        <script src="<?= URL_BASE ?>/js/dashboard.js"></script>
        <script src="<?= URL_BASE ?>/js/saludo.js"></script>
    <?php endif; ?>

</body>

</html>