<?php
include_once(__DIR__ . '/../layout/head.php');
?>

<div class="container mt-5">
    <h3>Detalle de Compra #<?= htmlspecialchars($compra['id_compra']) ?></h3>
    <p><strong>Proveedor:</strong> <?= htmlspecialchars($compra['nombre_proveedor']) ?></p>
    <p><strong>Usuario:</strong> <?= htmlspecialchars($compra['nombre_usuario']) ?></p>
    <p><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($compra['fecha_compra'])) ?></p>
    <p><strong>Total:</strong> S/. <?= number_format($compra['total'], 2) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($compra['estado']) ?></p>

    <hr>
    <h5>Productos comprados:</h5>
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
                    <td><?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= URL_BASE ?>/compra/index" class="btn btn-secondary">Volver</a>
</div>