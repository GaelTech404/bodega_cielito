<!-- Saludo -->
<div class="mb-4">
    <?php $usuario = AuthHelper::getUsuario(); ?>
    <h5 id="saludo">Bienvenido <?= htmlspecialchars($usuario['nombre_completo'] ?? 'Usuario') ?>. Hoy es <span
            id="fecha"></span></h5>
</div>

<!-- Carrusel -->
<div class="carousel" mask>
    <!-- Gráfico de ventas por usuario -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6>
                        <i class="bi bi-currency-exchange text-warning"></i> Productos con más ingresos
                    </h6>
                    <canvas id="chartProductosRentables"></canvas>
                </div>
            </div>
        </div>
    </article>

    <!-- Gráfico de ventas mensuales -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6><i class="bi bi-graph-up-arrow text-secondary me-2"></i> Ventas mensuales</h6>
                    <canvas id="chartVentasMes"></canvas>
                </div>
            </div>
        </div>
    </article>

    <!-- Compras mensuales -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6><i class="bi bi-cart-check-fill text-success me-2"></i> Compras mensuales</h6>
                    <canvas id="chartComprasMes"></canvas>
                </div>
            </div>
        </div>
    </article>

    <!-- Top vendedores -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6><i class="bi bi-award-fill text-warning me-2"></i> Top vendedores</h6>
                    <canvas id="chartTopVendedores"></canvas>
                </div>
            </div>
        </div>
    </article>

    <!-- Ventas por categoría -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6><i class="bi bi-pie-chart-fill text-info me-2"></i> Ventas por categoría</h6>
                    <canvas id="chartVentasCategoria"></canvas>
                </div>
            </div>
        </div>
    </article>
    <!-- Productos más vendidos -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6><i class="bi bi-bar-chart-fill text-primary me-2"></i> Productos más vendidos</h6>
                    <canvas id="chartProductosMasVendidos"></canvas>
                </div>
            </div>
        </div>
    </article>

    <!-- Stock bajo -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6>
                        Productos con bajo stock<i class="bi bi-exclamation-triangle-fill text-danger ms-2"></i>
                    </h6>
                    <canvas id="chartStockBajo"></canvas>
                </div>
            </div>
        </div>
    </article>

    <!-- Stock bajo -->
    <article>
        <div class="mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6>
                        Valor de inventario<i class="bi bi-cash ms-2"></i>
                    </h6>
                    <canvas id="chartValorInventario"></canvas>
                </div>
            </div>
        </div>
    </article>


</div> <?php include_once(__DIR__ . '/../layout/footer.php'); ?></div>

<?php include_once(__DIR__ . '/../layout/footer.php'); ?>

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
            data: <?= json_encode($comprasPorMes) ?>
        },
        productosStockBajo: <?= json_encode($productosBajoStock) ?>,
        valorInventarioCompra: <?= $valorInventarioCompra['valor_compra'] ?? 0 ?>,
        valorInventarioVenta: <?= $valorInventarioVenta['valor_venta'] ?? 0 ?>

    };
</script>

<script src="<?= URL_BASE ?>/js/dashboard.js"></script>
<script src="<?= URL_BASE ?>/js/saludo.js"></script>