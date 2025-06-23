<!DOCTYPE html>
<html lang="es">
<?php
include_once(__DIR__ . '/../layout/head.php');
?>

<body>
    <?php
    include_once(__DIR__ . '/../layout/navbar.php');
    ?>
    <div class="container py-4">
        <h2 class="mb-4">Lista de Compras</h2>

        <!-- Formulario de búsqueda -->
        <form class="mb-4 row g-2 align-items-center" method="GET" action="">
            <div class="col-md-4">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar compra..."
                    value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <hr>
        <!-- Formulario de nueva compra -->
        <form action="<?= URL_BASE ?>/compra/insertar" method="POST" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Proveedor</label>
                    <select name="id_proveedor" class="form-select" required>
                        <option value="">Proveedor</option>
                        <?php foreach ($proveedores as $p): ?>
                            <option value="<?= $p['id_proveedor'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Usuario</label>
                    <select name="id_usuario" class="form-select" required>
                        <option value="">Usuario</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nombre_completo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha_compra" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Total (S/.)</label>
                    <input type="text" id="total-mostrado" class="form-control" value="0.00" readonly>
                    <input type="hidden" name="total" id="total-hidden">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="pagado">Pagado</option>
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </div>
            <hr>
            <!-- Productos -->
            <div id="productos-container" class="mt-3">
                <div class="producto-row mb-2 row g-2 align-items-end">
                    <div class="col-md-4">
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

                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn btn-danger btn-remove">X</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mt-2" id="agregar-producto">Agregar producto</button>
        </form>

        <!-- Tabla de compras -->
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

                        <tr class="<?= $resaltar ? 'table-warning' : '' ?>">
                            <td><?= htmlspecialchars($row['id_compra']) ?></td>
                            <td><?= htmlspecialchars($row['nombre_proveedor']) ?></td>
                            <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['fecha_compra'])) ?></td>
                            <td>S/. <?= number_format($row['total'], 2) ?></td>
                            <td><?= htmlspecialchars($row['estado']) ?></td>
                            <td class="text-center">
                                <a href="<?= URL_BASE ?>/compra/detalle/<?= $row['id_compra'] ?>"
                                    class="btn btn-info btn-sm" title="Ver detalle">
                                    <i class="bi bi-eye"></i> Detalle
                                </a>
                                <a href="<?= URL_BASE ?>/compra/editar/<?= $row['id_compra'] ?>"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= URL_BASE ?>/compra/eliminar/<?= $row['id_compra'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar esta compra?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
<script src="<?= URL_BASE ?>/js/compras.js"></script>

</html>