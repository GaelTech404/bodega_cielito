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
        <h2 class="text-center mb-4">Gestión de Categorías</h2>

        <!-- Formulario de búsqueda -->
        <form action="<?= URL_BASE ?>/categoria/index" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por ID o nombre"
                        value="<?= htmlspecialchars($busqueda ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Formulario para agregar categoría -->
        <form action="<?= URL_BASE ?>/categoria/insertar" method="POST" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Agregar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de categorías -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
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
                        $resaltar = stripos($row['id_categoria'], $busqueda) !== false || stripos($row['nombre'], $busqueda) !== false;
                    }
                    ?>
                    <tr class="<?= $resaltar ? 'resaltado' : '' ?>">
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['descripcion']) ?></td>
                        <td>
                            <a href="<?= URL_BASE ?>/categoria/editar/<?= $row['id_categoria'] ?>"
                                class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= URL_BASE ?>/categoria/eliminar/<?= $row['id_categoria'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>