<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $row): ?>
                <?php
                $resaltar = false;
                if (!empty($busqueda)) {
                    $resaltar = stripos($row['nombre'], $busqueda) !== false ||
                        stripos($row['categoria_nombre'] ?? '', $busqueda) !== false;
                }
                ?>

                <tr class="text-center<?= $resaltar ? ' table-warning' : '' ?>">
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= htmlspecialchars($row['categoria_nombre'] ?? 'N/A') ?></td>
                    <td>S/. <?= number_format($row['precio_compra'], 2) ?></td>
                    <td>S/. <?= number_format($row['precio_venta'], 2) ?></td>
                    <td><?= (int) $row['stock'] ?></td>
                    <td><?= (int) $row['stock_minimo'] ?></td>
                    <td>
                        <form action="<?= URL_BASE ?>/producto/cambiarEstado" method="POST">
                            <input type="hidden" name="id_producto" value="<?= $row['id_producto'] ?>">
                            <input type="checkbox" name="activo" <?= $row['activo'] ? 'checked' : '' ?>
                                <?= $rolUsuario === 'admin' ? '' : 'disabled' ?>
                                onchange="<?= $rolUsuario === 'admin' ? 'this.form.submit()' : '' ?>">
                        </form>
                    </td>


                    <td>
                        <?php if ($rolUsuario === 'admin'): ?>
                            <a href="<?= URL_BASE ?>/producto/editar/<?= $row['id_producto'] ?>"
                                class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= URL_BASE ?>/producto/eliminar/<?= $row['id_producto'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                        <?php else: ?>
                            <span class="text-muted small">Restringido</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>