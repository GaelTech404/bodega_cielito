<!-- buscador.php -->
<form method="GET" class="mb-4 row g-2 align-items-center">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="busqueda" class="form-control" placeholder="<?= $placeholder ?? 'Buscar' ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </div>
</form>