<div class="d-flex">
    <?php include_once(__DIR__ . '/../layout/sidebar.php'); ?>

    <div class="container py-4">
        <h2 class="text-center mb-4">Lista de Usuarios</h2>

        <!-- Formulario de búsqueda -->
        <form class="mb-4 row g-2 align-items-center" method="GET" action="">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar usuario...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>
        <hr>
        <!-- Formulario para agregar usuario -->
        <form action="<?= URL_BASE ?>/usuario/insertar" method="POST" class="mb-4">
            <div class="row g-2">
                <div class="col-md-2">
                    <input type="text" name="nombre_usuario" class="form-control" placeholder="Usuario" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre completo"
                        required>
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
                    <button type="submit" class="btn btn-success w-100">Agregar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de usuarios -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <?php
                        $resaltar = false;
                        if (!empty($busqueda)) {
                            $resaltar = stripos($usuario['id_usuario'], $busqueda) !== false ||
                                stripos($usuario['nombre_usuario'], $busqueda) !== false;
                        }
                        ?>
                        <tr class="text-center<?= $resaltar ? ' table-warning' : '' ?>">
                            <td><?= htmlspecialchars($usuario['nombre_usuario']) ?></td>
                            <td><?= htmlspecialchars($usuario['nombre_completo']) ?></td>
                            <td><?= htmlspecialchars($usuario['correo']) ?></td>
                            <td><?= htmlspecialchars($usuario['rol']) ?></td>
                            <td>
                                <a href="<?= URL_BASE ?>/usuario/editar/<?= $usuario['id_usuario'] ?>"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= URL_BASE ?>/usuario/eliminar/<?= $usuario['id_usuario'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>