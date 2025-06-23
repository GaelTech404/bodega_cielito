<!DOCTYPE html>
<html lang="es">

<?php
include_once(__DIR__ . '/../layout/head.php');
?>

<body>
    <?php
    include_once(__DIR__ . '/../layout/navbar.php');
    ?>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Gestión de Proveedores</h2>

        <!-- Formulario de búsqueda -->
        <form action="<?= URL_BASE ?>/proveedor/index" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por ID o nombre"
                        value="<?= htmlspecialchars($busqueda ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Formulario para agregar proveedor -->
        <form action="<?= URL_BASE ?>/proveedor/insertar" method="POST" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="ruc" class="form-control" placeholder="RUC">
                </div>
                <div class="col-md-2">
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                </div>
                <div class="col-md-3">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="email" name="correo" class="form-control" placeholder="Correo electrónico">
                </div>
                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-success w-100">Agregar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de proveedores -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>RUC</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $row): ?>
                    <?php
                    $resaltar = false;
                    if (!empty($busqueda)) {
                        $resaltar = stripos($row['id_proveedor'], $busqueda) !== false || stripos($row['nombre'], $busqueda) !== false;
                    }
                    ?>
                    <tr class="<?= $resaltar ? 'resaltado' : '' ?>">
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['ruc'] ?></td>
                        <td><?= $row['telefono'] ?></td>
                        <td><?= $row['direccion'] ?></td>
                        <td><?= $row['correo'] ?></td>
                        <td>
                            <a href="<?= URL_BASE ?>/proveedor/editar/<?= $row['id_proveedor'] ?>"
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
</body>

</html>