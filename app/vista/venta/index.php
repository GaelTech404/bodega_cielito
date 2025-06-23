<!DOCTYPE html>
<html lang="es">
<?php
include_once(__DIR__ . '/../layout/head.php');
?>

<body>
    <?php
    include_once(__DIR__ . '/../layout/navbar.php');
    ?>
    <div class="container mt-3">
        <h2 class="mb-4">Lista de Ventas</h2>

        <form class="mb-3 d-flex" method="GET" action="">
            <input type="text" name="busqueda" class="form-control me-2"
                placeholder="Buscar por nombre de usuario o fecha"
                value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <form action="<?= URL_BASE ?>/venta/insertar" method="POST">
            <div class="row mb-3">
                <!-- Usuario -->
                <div class="col-md-4">
                    <label for="id_usuario" class="form-label">Usuario</label>
                    <select name="id_usuario" id="id_usuario" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id_usuario'] ?>">
                                <?= $usuario['nombre_completo'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fecha -->
                <div class="col-md-4">
                    <label for="fecha_venta" class="form-label">Fecha de Venta</label>
                    <input type="date" name="fecha_venta" id="fecha_venta" class="form-control"
                        value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Estado -->
                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="">Seleccione estado</option>
                        <option value="pagado">Pagado</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
            </div>

            <hr>
            <h5 class="mt-4">Productos vendidos</h5>

            <!-- Contenedor de productos -->
            <div id="productos-container">
                <div class="producto-row row mb-3">
                    <div class="col-md-4">
                        <select name="id_producto[]" class="form-select" required>
                            <option value="">Producto</option>
                            <?php foreach ($productos as $prod): ?>
                                <option value="<?= $prod['id_producto'] ?>"><?= $prod['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio unitario"
                            step="0.01" required>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove">X</button>
                    </div>
                </div>
            </div>

            <!-- Botón para agregar más productos -->
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="agregar-producto">Agregar otro producto</button>
            </div>

            <!-- Total + Botón Guardar -->
            <div class="row align-items-end mb-3">
                <div class="col-md-3">
                    <label for="total_mostrado" class="form-label">Total (S/.)</label>
                    <input type="text" id="total_mostrado" class="form-control" value="0.00" readonly>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary mt-4">Guardar</button>
                </div>
            </div>
        </form>


        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Total (S/.)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $row): ?>
                    <?php
                    $resaltar = !empty($busqueda) && (
                        stripos($row['nombre_usuario'], $busqueda) !== false ||
                        stripos($row['fecha_venta'], $busqueda) !== false
                    );
                    ?>
                    <tr class="<?= $resaltar ? 'resaltado' : '' ?>">
                        <td><?= htmlspecialchars($row['id_venta']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['fecha_venta'])) ?></td>
                        <td>S/. <?= number_format($row['total'], 2) ?></td>
                        <td><?= htmlspecialchars($row['estado']) ?></td>
                        <td>
                            <a href="<?= URL_BASE ?>/venta/detalle/<?= $row['id_venta'] ?>"
                                class="btn btn-info btn-sm" title="Ver detalle de venta">
                                <i class="bi bi-eye"></i> Detalle
                            </a>
                            <a href="<?= URL_BASE ?>/venta/editar/<?= $row['id_venta'] ?>"
                                class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= URL_BASE ?>/venta/eliminar/<?= $row['id_venta'] ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta venta?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<script src="<?= URL_BASE ?>/js/ventas.js"></script>

</html>