<form action="<?= URL_BASE ?>/producto/insertar" method="POST" class="mb-4">
    <div class="row g-2">
        <div class="col-md-2">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
        </div>
        <div class="col-auto">
            <select name="id_categoria" class="form-select" required>
                <option value="">Categoria</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id_categoria'] ?>"><?= $cat['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" step="0.01" name="precio_compra" class="form-control" placeholder="Compra" required>
        </div>
        <div class="col-md-1">
            <input type="number" step="0.01" name="precio_venta" class="form-control" placeholder="Venta" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="stock" class="form-control" placeholder="Stock" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="stock_minimo" class="form-control" placeholder="Min" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success w-100">Guardar Categoria</button>
        </div>
    </div>
</form>