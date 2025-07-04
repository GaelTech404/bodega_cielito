<div class="d-flex">
    <?php include_once(__DIR__ . '/../layout/sidebar.php'); ?>

    <div class="container py-4">
        <h2 class="text-center mb-4">Gestión de Productos</h2>

        <!-- Formulario de búsqueda -->
        <form class="mb-4 row g-2 align-items-center" method="GET" action="">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>
        <!-- Formulario para agregar producto -->
        <form action="<?= URL_BASE ?>/producto/insertar" method="POST" class="mb-4">
            <div class="row g-2">
                <div class="col-md-2">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                </div>
                <div class="col-auto">
                    <select name="id_categoria" class="form-select" required>
                        <option value="">Categoria</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id_categoria'] ?>"><?= $cat['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="number" step="0.01" name="precio_compra" class="form-control" placeholder="Compra"
                        required>
                </div>
                <div class="col-md-1">
                    <input type="number" step="0.01" name="precio_venta" class="form-control" placeholder="Venta"
                        required>
                </div>
                <div class="col-md-1">
                    <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                </div>
                <div class="col-md-1">
                    <input type="number" name="stock_minimo" class="form-control" placeholder="Min" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success w-100">Guardar Categoria</button>
                </div>
            </div>
        </form>

        <!-- Tabla de productos -->
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
                                    <input type="checkbox" name="activo" onchange="this.form.submit()" <?= $row['activo'] ? 'checked' : '' ?>>
                                </form>
                            </td>
                            <td>
                                <a href="<?= URL_BASE ?>/producto/editar/<?= $row['id_producto'] ?>"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= URL_BASE ?>/producto/eliminar/<?= $row['id_producto'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>