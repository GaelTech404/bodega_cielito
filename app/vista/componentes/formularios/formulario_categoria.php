<form action="<?= URL_BASE ?>/categoria/insertar" method="POST" class="mb-4">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success w-100">Guardar Categoria</button>
        </div>
    </div>
</form>