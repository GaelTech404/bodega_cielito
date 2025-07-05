<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $row): ?>
                <?php
                $resaltar = false;
                if (!empty($busqueda)) {
                    $resaltar =
                        stripos($row['nombre_usuario'], $busqueda) !== false ||
                        stripos($row['fecha_venta'], $busqueda) !== false;
                }

                ?>

                <tr class="text-center<?= $resaltar ? ' table-warning' : '' ?>">
                    <td><?= htmlspecialchars($row['id_venta']) ?></td>
                    <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['fecha_venta'])) ?></td>
                    <td>S/. <?= number_format($row['total'], 2) ?></td>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td class="text-center">
                        <a href="<?= URL_BASE ?>/venta/detalle/<?= $row['id_venta'] ?>" class="btn btn-info btn-sm"
                            title="Ver detalle de venta">
                            <i class="bi bi-eye"></i> Detalle
                        </a>
                        <a href="<?= URL_BASE ?>/venta/editar/<?= $row['id_venta'] ?>"
                            class="btn btn-warning btn-sm">Editar</a>
                        <a href="<?= URL_BASE ?>/venta/eliminar/<?= $row['id_venta'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar esta venta?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>