<?php
$titulo = "Editar Compra";
require_once __DIR__ . '/../layout/head.php';
?>



<div class="container mt-5">
    <h2 class="mb-4">Editar Compra</h2>

    <form action="<?= URL_BASE ?>/compra/actualizar" method="POST">
        <!-- Campo oculto para el ID de la compra -->
        <input type="hidden" name="id_compra" value="<?= htmlspecialchars($compra['id_compra']) ?>">

        <div class="mb-3">
            <label for="id_proveedor" class="form-label">Proveedor</label>
            <select name="id_proveedor" id="id_proveedor" class="form-select" required>
                <?php foreach ($proveedores as $proveedor): ?>
                    <option value="<?= $proveedor['id_proveedor'] ?>" <?= $proveedor['id_proveedor'] == $compra['id_proveedor'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($proveedor['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_usuario" class="form-label">Usuario</label>
            <select name="id_usuario" id="id_usuario" class="form-select" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id_usuario'] ?>" <?= $usuario['id_usuario'] == $compra['id_usuario'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($usuario['nombre_completo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_compra" class="form-label">Fecha de Compra</label>
            <input type="datetime-local" name="fecha_compra" class="form-control"
                value="<?= htmlspecialchars($compra['fecha_compra']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="Pendiente" <?= $compra['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="Pagado" <?= $compra['estado'] === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= URL_BASE ?>/compra/index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>