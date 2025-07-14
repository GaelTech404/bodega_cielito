<?php $usuario = AuthHelper::getUsuario(); ?>

<form action="<?= URL_BASE ?>/venta/insertar" method="POST" class="mb-4">
    <div class="row g-2 align-items-end">

        <!-- Usuario -->
        <div class="col-auto">
            <label class="form-label">Usuario</label>
            <?php if ($usuario): ?>
                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['nombre_completo']) ?>"
                    readonly>
            <?php else: ?>
                <input type="text" class="form-control text-danger" value="⚠️ Usuario no autenticado" readonly>
            <?php endif; ?>

        </div>
        <!-- Fecha -->
        <div class="col-auto">
            <label class="form-label">Fecha</label>
            <input type="datetime-local" name="fecha_venta" class="form-control" value="<?= date('Y-m-d\TH:i') ?>"
                required>
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