<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compras as $row): ?>
                <?php
                $resaltar = !empty($busqueda) && (
                    stripos($row['nombre_proveedor'], $busqueda) !== false ||
                    stripos($row['nombre_usuario'], $busqueda) !== false ||
                    stripos($row['fecha_compra'], $busqueda) !== false
                );
                ?>

                <tr class="text-center<?= $resaltar ? 'table-warning' : '' ?>">
                    <td><?= htmlspecialchars($row['id_compra']) ?></td>
                    <td><?= htmlspecialchars($row['nombre_proveedor']) ?></td>
                    <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['fecha_compra'])) ?></td>
                    <td>S/. <?= number_format($row['total'], 2) ?></td>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td class="text-center">
                        <?= AuthHelper::soloAdmin($rolUsuario, '
       <a href="' . URL_BASE . '/compra/detalle/' . $row['id_compra'] . '" class="btn btn-info btn-sm">Ver detalle</a>
       <a href="' . URL_BASE . '/compra/editar/' . $row['id_compra'] . '" class="btn btn-warning btn-sm">Editar</a>
        <a href="' . URL_BASE . '/compra/eliminar/' . $row['id_compra'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Eliminar esta categoría?\')">Eliminar</a>
    ') ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>