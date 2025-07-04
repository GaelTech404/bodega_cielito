<div class="d-flex">
    <?php include_once(__DIR__ . '/../layout/sidebar.php'); ?>

    <div class="container py-4">
        <h2 class="text-center mb-4">Lista de Proveedores</h2>

        <!-- Formulario de búsqueda -->
        <form class="mb-4 row g-2 align-items-center" method="GET" action="">
            <div class="col-md-3">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar proveedor...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <hr>

        <!-- Formulario para agregar proveedor -->
        <form action="<?= URL_BASE ?>/proveedor/insertar" method="POST" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <!-- validacion 11 digitos en ruc -->
                <div class="col-md-2">
                    <input type="text" name="ruc" class="form-control" placeholder="RUC" pattern="\d{11}" maxlength="11"
                        minlength="11" title="El RUC debe tener exactamente 11 dígitos" required>
                </div>

                <!-- validacion 9 digitos en telefono -->
                <div class="col-md-2">
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono" pattern="\d{9}"
                        maxlength="9" minlength="9" title="El teléfono debe tener exactamente 9 dígitos" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="email" name="correo" class="form-control" placeholder="Correo electrónico">
                </div>
                <div class="col-auto d-grid">
                    <button type="submit" class="btn btn-success">Guardar Proveedor</button>
                </div>
            </div>
        </form>

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
                                <a href="<?= URL_BASE ?>/proveedor/editar/<?= $row['ruc'] ?>"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= URL_BASE ?>/proveedor/eliminar/<?= $row['id_proveedor'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>