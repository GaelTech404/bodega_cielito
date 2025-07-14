<?php
$titulo = "Editar Proveedor";
require_once __DIR__ . '/../layout/head.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Editar Proveedor</h2>

    <form action="<?= URL_BASE ?>/proveedor/actualizar" method="POST">
        <!-- Campo oculto para el ID del proveedor -->
        <input type="hidden" name="id_proveedor" value="<?= htmlspecialchars($proveedor['id_proveedor']) ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                value="<?= htmlspecialchars($proveedor['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="ruc" class="form-label">RUC</label>
            <input type="text" name="ruc" id="ruc" class="form-control"
                value="<?= htmlspecialchars($proveedor['ruc']) ?>">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control"
                value="<?= htmlspecialchars($proveedor['telefono']) ?>">
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control"
                value="<?= htmlspecialchars($proveedor['direccion']) ?>">
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control"
                value="<?= htmlspecialchars($proveedor['correo']) ?>">
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= URL_BASE ?>/proveedor/index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>