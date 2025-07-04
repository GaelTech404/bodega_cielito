<div class="d-flex">
    <?php include_once(__DIR__ . '/../layout/sidebar.php'); ?>

    <div class="container py-4">
        <h2 class="text-center mb-4">Gestión de Categorías</h2>

        <!-- Formulario de búsqueda -->
        <form class="mb-4 row g-2 align-items-center" method="GET" action="">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar categoria...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>
        <hr>
        <!-- Formulario para agregar categoría -->
        <form action="<?= URL_BASE ?>/categoria/insertar" method="POST" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success w-100">Guardar Categoria</button>
                </div>
            </div>
        </form>

        <!-- Tabla de categorías -->
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
    </div>
</div>