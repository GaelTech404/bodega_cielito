<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Categoría</h2>

        <form action="<?= URL_BASE ?>/categoria/actualizar" method="POST">
            <!-- Campo oculto para el ID de la categoría -->
            <input type="hidden" name="id_categoria" value="<?= htmlspecialchars($categoria['id_categoria']) ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                    value="<?= htmlspecialchars($categoria['descripcion']) ?>">
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= URL_BASE ?>/categoria/index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>

</html>