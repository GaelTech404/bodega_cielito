<?php ob_start(); ?>

<!-- Saludo -->
<div class="mb-4">
    <?php $usuario = AuthHelper::getUsuario(); ?>
    <h5 id="saludo">
        Bienvenido <?= htmlspecialchars($usuario['nombre_completo'] ?? 'Usuario') ?>. Hoy es <span id="fecha"></span>
    </h5>
</div>

<!-- Carrusel -->
<div class="carousel" mask>
    <?php
    $graficos = [
        ['id' => 'chartProductosRentables', 'titulo' => 'Productos con más ingresos', 'icono' => 'currency-exchange text-warning'],
        ['id' => 'chartVentasMes', 'titulo' => 'Ventas mensuales', 'icono' => 'graph-up-arrow text-secondary'],
        ['id' => 'chartComprasMes', 'titulo' => 'Compras mensuales', 'icono' => 'cart-check-fill text-success'],
        ['id' => 'chartTopVendedores', 'titulo' => 'Top vendedores', 'icono' => 'award-fill text-warning'],
        ['id' => 'chartVentasCategoria', 'titulo' => 'Ventas por categoría', 'icono' => 'pie-chart-fill text-info'],
        ['id' => 'chartProductosMasVendidos', 'titulo' => 'Productos más vendidos', 'icono' => 'bar-chart-fill text-primary'],
        ['id' => 'chartStockBajo', 'titulo' => 'Productos con bajo stock', 'icono' => 'exclamation-triangle-fill text-danger'],
        ['id' => 'chartValorInventario', 'titulo' => 'Valor de inventario', 'icono' => 'cash']
    ];
    ?>

    <?php foreach ($graficos as $grafico): ?>
        <article>
            <div class="mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h6>
                            <i class="bi bi-<?= $grafico['icono'] ?> me-2"></i> <?= $grafico['titulo'] ?>
                        </h6>
                        <canvas id="<?= $grafico['id'] ?>"></canvas>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php $contenidoModulo = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout/contenedor_general.php'; ?>