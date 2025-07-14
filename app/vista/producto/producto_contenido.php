<?php ob_start(); ?>
<h2 class="text-center mb-4">Lista de Productos</h2>

<?php $placeholder = 'Buscar por nombre o categoría'; ?>
<?php include __DIR__ . '/../componentes/buscador.php'; ?>
<hr>

<?php if ($rolUsuario === 'admin'): ?>
    <?php include __DIR__ . '/../componentes/formularios/formulario_producto.php'; ?>
<?php else: ?>
    <?php include __DIR__ . '/../componentes/alerta_restringido.php'; ?>
<?php endif; ?>

<?php include __DIR__ . '/../componentes/tablas/tabla_productos.php'; ?>

<?php $contenidoModulo = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout/contenedor_general.php'; ?>