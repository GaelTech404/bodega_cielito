<?php ob_start(); ?>
<h2 class="text-center mb-4">Lista de Ventas</h2>

<?php $placeholder = 'Buscar por nombre'; ?>
<?php include __DIR__ . '/../componentes/buscador.php'; ?>
<hr>

    <?php include __DIR__ . '/../componentes/formularios/formulario_venta.php'; ?>


<?php include __DIR__ . '/../componentes/tablas/tabla_ventas.php'; ?>

<?php $contenidoModulo = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout/contenedor_general.php'; ?>