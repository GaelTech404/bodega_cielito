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
                        <?php if ($rolUsuario === 'admin'): ?>
                            <a href="<?= URL_BASE ?>/usuario/editar/<?= $usuario['id_usuario'] ?>"
                                class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= URL_BASE ?>/usuario/eliminar/<?= $usuario['id_usuario'] ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                        <?php else: ?>
                            <span class="text-muted small">Solo el administrador puede editar o eliminar</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>