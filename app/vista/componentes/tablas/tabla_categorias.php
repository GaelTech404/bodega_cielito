<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $row): ?>
                <?php
                $resaltar = false;
                if (!empty($busqueda)) {
                    $resaltar =
                        stripos($row['nombre'], $busqueda) !== false;
                }
                ?>
                <tr class="text-center<?= $resaltar ? ' table-warning' : '' ?>">
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td>
                        <?= AuthHelper::soloAdmin($rolUsuario, '
        <a href="' . URL_BASE . '/categoria/editar/' . $row['id_categoria'] . '" class="btn btn-warning btn-sm">Editar</a>
        <a href="' . URL_BASE . '/categoria/eliminar/' . $row['id_categoria'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Eliminar esta categoría?\')">Eliminar</a>
    ') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>