<?php
$tema = $_COOKIE['tema'] ?? 'light'; 
$claseBody = $tema === 'dark' ? 'bg-dark text-light' : '';
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="<?= htmlspecialchars($tema) ?>">
<?php require_once 'head.php'; ?>

<body class="<?= $claseBody ?>">
    <div class="d-flex">
        <?php require_once 'sidebar.php'; ?>
        <div class="contenido-principal flex-grow-1 p-3">
            <?php require $contenido; ?>
        </div>
    </div>

    <?php
    $archivoContenido = basename($contenido ?? '');
    if (in_array($archivoContenido, ['compra_contenido.php', 'venta_contenido.php'])):
        ?>
        <script src="<?= URL_BASE ?>/js/venta_compra.js"></script>
    <?php endif; ?>
    <script src="<?= URL_BASE ?>/js/menu_desplegable.js"></script>


</body>

</html>