<form action="<?= URL_BASE ?>/usuario/insertar" method="POST" class="mb-4">
    <div class="row g-2">
        <div class="col-md-2">
            <input type="text" name="nombre_usuario" class="form-control" placeholder="Usuario" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre completo" required>
        </div>
        <div class="col-md-3">
            <input type="email" name="correo" class="form-control" placeholder="Correo" required>
        </div>
        <div class="col-auto">
            <select name="rol" class="form-select" required>
                <option value="">Seleccionar rol</option>
                <option value="admin">Administrador</option>
                <option value="cajero">Vendedor</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-success">Agregar</button>
        </div>
    </div>
</form>