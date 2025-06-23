<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Producto</h2>

        <form action="<?= URL_BASE ?>/producto/actualizar" method="POST">
            <!-- Campo oculto para el ID del producto -->
            <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto['id_producto']) ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                    value="<?= htmlspecialchars($producto['descripcion']) ?>">
            </div>

            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select name="id_categoria" id="id_categoria" class="form-select" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $producto['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="precio_compra" class="form-label">Precio de Compra</label>
                <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control"
                    value="<?= htmlspecialchars($producto['precio_compra']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="precio_venta" class="form-label">Precio de Venta</label>
                <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control"
                    value="<?= htmlspecialchars($producto['precio_venta']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control"
                    value="<?= htmlspecialchars($producto['stock']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
                    value="<?= htmlspecialchars($producto['stock_minimo']) ?>" required>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="<?= URL_BASE ?>/producto/index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>

</body>

</html>