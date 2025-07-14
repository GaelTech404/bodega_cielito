<?php
$titulo = "Editar Usuario";
require_once __DIR__ . '/../layout/head.php';
?>



<div class="container mt-5">
    <h2 class="mb-4">Editar Usuario</h2>

    <form action="<?= URL_BASE ?>/usuario/actualizar" method="POST">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

        <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control"
                value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre Completo</label>
            <input type="text" name="nombre_completo" id="nombre_completo" class="form-control"
                value="<?= htmlspecialchars($usuario['nombre_completo']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control"
                value="<?= htmlspecialchars($usuario['correo']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>
                    Administrador</option>
                <option value="cajero" <?= $usuario['rol'] === 'cajero' ? 'selected' : '' ?>>Cajero</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control"
                value="<?= htmlspecialchars($usuario['contraseña']) ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= URL_BASE ?>/usuario/index" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>