<?php
$tema = $_COOKIE['tema'] ?? 'light'; // ✅ Siempre definido
$claseBody = $tema === 'dark' ? 'bg-dark text-light' : '';
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="<?= htmlspecialchars($tema) ?>">
<?php require_once 'head.php'; ?>

<body class="<?= $claseBody ?>">
    <div class="d-flex">
        <?php require_once 'sidebar.php'; ?>
        <div class="flex-grow-1 p-3">
            <?php require $contenido; ?>
        </div>
    </div>

    <?php
    $archivoContenido = basename($contenido ?? '');
    if (in_array($archivoContenido, ['compra_contenido.php', 'venta_contenido.php'])):
        ?>
        <script src="<?= URL_BASE ?>/js/venta_compra.js"></script>
    <?php endif; ?>
    <?php
    $archivoContenido = basename($contenido ?? '');
    if ($archivoContenido === 'inicio.php'): // o cualquier archivo donde se use el sidebar
        ?>
        <script src="<?= URL_BASE ?>/js/sidebar.js"></script>
    <?php endif; ?>

</body>

</html>