<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Venta</h2>

        <form action="<?= URL_BASE ?>/venta/actualizar" method="POST">
            <!-- Campo oculto para el ID de la venta -->
            <input type="hidden" name="id_venta" value="<?= htmlspecialchars($venta['id_venta']) ?>">

            <div class="mb-3">
                <label for="id_usuario" class="form-label">ID Usuario</label>
                <select name="id_usuario" class="form-select" required>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id_usuario'] ?>" <?= $venta['id_usuario'] == $usuario['id_usuario'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario['nombre_completo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="mb-3">
                <label for="fecha_venta" class="form-label">Fecha de Venta</label>
                <input type="date" name="fecha_venta" class="form-control"
                    value="<?= htmlspecialchars($venta['fecha_venta']) ?>" required>

            </div>
            <div class="mb-3">
                <label class="form-label">Total (S/.)</label>
                <input type="text" class="form-control" value="<?= number_format($venta['total'], 2) ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="Pagado" <?= $venta['estado'] === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                    <option value="Pendiente" <?= $venta['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Cancelado" <?= $venta['estado'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= URL_BASE ?>/venta/index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>

</html>