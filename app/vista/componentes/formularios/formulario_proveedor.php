<!-- Formulario para agregar proveedor -->
        <form action="<?= URL_BASE ?>/proveedor/insertar" method="POST" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <!-- validacion 11 digitos en ruc -->
                <div class="col-md-2">
                    <input type="text" name="ruc" class="form-control" placeholder="RUC" pattern="\d{11}" maxlength="11"
                        minlength="11" title="El RUC debe tener exactamente 11 dígitos" required>
                </div>

                <!-- validacion 9 digitos en telefono -->
                <div class="col-md-2">
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono" pattern="\d{9}"
                        maxlength="9" minlength="9" title="El teléfono debe tener exactamente 9 dígitos" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="email" name="correo" class="form-control" placeholder="Correo electrónico">
                </div>
                <div class="col-auto d-grid">
                    <button type="submit" class="btn btn-success">Guardar Proveedor</button>
                </div>
            </div>
        </form>