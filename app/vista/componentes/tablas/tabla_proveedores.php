<!-- Tabla de proveedores -->
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Nombre</th>
                <th>RUC</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedores as $row): ?>
                <?php
                $resaltar = false;
                if (!empty($busqueda)) {
                    $resaltar = stripos($row['ruc'], $busqueda) !== false || stripos($row['nombre'], $busqueda) !== false;
                }
                ?>
                <tr class="text-center <?= $resaltar ? 'table-warning' : '' ?>">
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['ruc'] ?></td>
                    <td><?= $row['telefono'] ?></td>
                    <td><?= $row['direccion'] ?></td>
                    <td><?= $row['correo'] ?></td>
                    <td>
                        <?= AuthHelper::soloAdmin($rolUsuario, '
        <a href="' . URL_BASE . '/proveedor/editar/' . $row['id_proveedor'] . '" class="btn btn-warning btn-sm">Editar</a>
         <a href="' . URL_BASE . '/proveedor/eliminar/' . $row['id_proveedor'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Eliminar esta categoría?\')">Eliminar</a>
    ') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>