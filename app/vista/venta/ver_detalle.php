<?php
include_once(__DIR__ . '/../layout/head.php');
?>

<div class="container mt-5">

    <h3>Detalle de Venta #<?= htmlspecialchars($venta['id_venta']) ?></h3>
    <p><strong>Usuario:</strong> <?= htmlspecialchars($venta['nombre_completo']) ?></p>
    <p><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($venta['fecha_venta'])) ?></p>
    <p><strong>Total:</strong> S/. <?= number_format($venta['total'], 2) ?></p>

    <hr>
    <h5>Productos vendidos:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario (S/.)</th>
                <th>Subtotal (S/.)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td><?= number_format($item['precio_unitario'], 2) ?></td>
                    <td><?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= URL_BASE ?>/venta/index" class="btn btn-secondary">Volver</a>
</div>