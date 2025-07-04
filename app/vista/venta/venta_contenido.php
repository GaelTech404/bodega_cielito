<div class="d-flex">
    <?php include_once(__DIR__ . '/../layout/sidebar.php'); ?>

    <div class="container py-4">
        <h2 class="text-center mb-4">Lista de Ventas</h2>

        <!-- Formulario de búsqueda -->
        <form class="mb-4 row g-2 align-items-center" method="GET" action="">
            <div class="col-md-3">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar venta...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>
        <hr>

        <!-- Formulario de nueva venta -->
        <form action="<?= URL_BASE ?>/venta/insertar" method="POST" class="mb-4">
            <div class="row g-2 align-items-end">
                <!-- Usuario -->
                <div class="col-auto">
                    <label class="form-label">Usuario</label>
                    <select name="id_usuario" class="form-select" required>
                        <option value="">Usuario</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nombre_completo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fecha -->
                <div class="col-auto">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha_venta" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Total -->
                <div class="col-md-1">
                    <label for="total_mostrado" class="form-label">Total (S/.)</label>
                    <input type="text" id="total_mostrado" class="form-control" value="0.00" readonly>
                </div>

                <!-- Estado -->
                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="">Estado</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="pagado">Pagado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>

                <!-- Botón Guardar -->
                <div class="col-auto d-grid">
                    <button type="submit" class="btn btn-success">Guardar venta</button>
                </div>
            </div>
            <hr>
            <!-- Productos vendidos -->
            <div id="productos-container" class="mt-3">
                <div class="producto-row mb-2 row g-2 align-items-end">
                    <div class="col-auto">
                        <select name="id_producto[]" class="form-select" required>
                            <option value="">Producto</option>
                            <?php foreach ($productos as $prod): ?>
                                <option value="<?= $prod['id_producto'] ?>"><?= $prod['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="cantidad[]" placeholder="Cantidad" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="precio_unitario[]" placeholder="Precio unitario" class="form-control"
                            step="0.01" required>
                    </div>

                    <div class="col-md-1 d-grid">
                        <button type="button" class="btn btn-danger btn-remove">X</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mt-1" id="agregar-producto">Agregar producto</button>
        </form>
        <!-- Tabla de ventas -->
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
                                stripos($usuario['nombre_usuario'], $busqueda) !== false ||
                                stripos($usuario['fecha_venta'], $busqueda) !== false;
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
                                <a href="<?= URL_BASE ?>/venta/eliminar/<?= $row['id_venta'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar esta venta?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>