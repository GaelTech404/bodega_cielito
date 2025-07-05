 <!-- Formulario de nueva compra -->
        <form action="<?= URL_BASE ?>/compra/insertar" method="POST" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label">Proveedor</label>
                    <select name="id_proveedor" class="form-select" required>
                        <option value="">Proveedor</option>
                        <?php foreach ($proveedores as $p): ?>
                            <option value="<?= $p['id_proveedor'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

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

                <div class="col-auto">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha_compra" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-md-1">
                    <label for="total_mostrado" class="form-label">Total (S/.)</label>
                    <input type="text" id="total_mostrado" class="form-control" value="0.00" readonly>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="pagado">Pagado</option>
                    </select>
                </div>

                <div class="col-auto d-grid">
                    <button type="submit" class="btn btn-success">Guardar compra</button>
                </div>
            </div>
            <hr>
            <!-- Productos -->
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