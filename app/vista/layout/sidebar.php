<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/AuthHelper.php';

AuthHelper::verificarAcceso(); // Evita acceso sin login

$usuario = $_SESSION['usuario'] ?? null;
$nombreUsuario = $usuario['nombre_usuario'];
$nombreCompleto = $usuario['nombre_completo'];
$correo = $usuario['correo'] ?? '';
$rol = $usuario['rol'] ?? '';
$iniciales = strtoupper(substr($nombreCompleto, 0, 1) . substr(strrchr($nombreCompleto, ' '), 1, 1));
?>
<aside class="sidebar-custom" id="sidebar">
    <div class="menu-btn" id="menu-btn">
        <i class="bi bi-chevron-left"></i>
    </div>

    <div class="menu-container">
        <a href="<?= URL_BASE ?>/inicio" class="d-flex align-items-center mb-4 text-decoration-none logo-link"
            style="color: inherit; font-size: 20px;" data-tooltip="Bodega Cielito">
            <div class="logo-wrapper bg-accent-content rounded p-1 me-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    fill="none" height="30" class="me-0 logo-svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
            </div>
            <span class="fw-bold texto-modulo" style="padding: 6px;">Bodega Cielito</span>
        </a>

        <span class="texto-menu texto-modulo" style="color:#a3a3a3;">Menú</span>

        <ul class="nav nav-pills flex-column mb-4" style="font-size: 18px;">

            <?php
            $paginaActual = $_GET['url'] ?? 'inicio'; // detectar la página
            ?>

            <li class="nav-item">
                <a href="<?= URL_BASE ?>/inicio"
                    class="nav-link-custom <?= $paginaActual === 'inicio' ? 'active disabled' : '' ?>"
                    data-tooltip="Inicio">
                    🏠 <span class="texto-modulo">Inicio</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= URL_BASE ?>/producto" class="nav-link-custom " data-tooltip="Productos">
                    📦 <span class="texto-modulo">Productos</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= URL_BASE ?>/categoria" class="nav-link-custom " data-tooltip="Categorias">📁
                    <span class="texto-modulo">Categorías</span></a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/proveedor" class="nav-link-custom " data-tooltip="Proveedores">🚚
                    <span class="texto-modulo">Proveedores</span></a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/compra" class="nav-link-custom " data-tooltip="Compras">🛒 <span
                        class="texto-modulo">Compras</span></a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/venta" class="nav-link-custom " data-tooltip="Ventas">💰 <span
                        class="texto-modulo">Ventas</span></a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/usuario" class="nav-link-custom " data-tooltip="Usuarios">👤 <span
                        class="texto-modulo">Usuarios</span></a>
            </li>
        </ul>
    </div>

    <!-- Perfil como ítem del menú -->
    <div class="sidebar-footer mt-auto pt-3 border-top dropdown">
        <a class="nav-link-custom  d-flex align-items-center" href="#" id="dropdownPerfil" data-bs-toggle="dropdown"
            aria-expanded="false" data-tooltip="<?= htmlspecialchars($nombreUsuario) ?>">
            <div class="avatar-circle avatar-invert fw-bold"
                style="width: 36px; height: 36px;margin: 0px 10px 0px 0px;">
                <?= $iniciales ?>
            </div>
            <span class="texto-modulo me-2"><?= htmlspecialchars($nombreUsuario) ?></span>
            <i class="texto-modulo me-2"></i>
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownPerfil">
            <div class="p-0 text-sm font-normal">
                <div class="d-flex align-items-center px-2 text-start">
                    <div class="d-flex align-items-center w-100">
                        <!-- Avatar con iniciales -->
                        <div class="avatar-circle avatar-invert fw-bold "
                            style="width: 38px; height: 38px;margin: 0px 10px 0px 0px;">
                            <?= $iniciales ?>
                        </div>

                        <!-- Datos del usuario -->
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-semibold truncar texto-modulo"
                                title="<?= htmlspecialchars($nombreCompleto) ?>">
                                <?= htmlspecialchars($nombreCompleto) ?>
                            </div>
                            <div class="fw-semibold small text-truncate texto-modulo">
                                <?= htmlspecialchars($rol) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <hr class="my-1 mx-2 border-secondary">

            <li class="nav-item">
                <a href="<?= URL_BASE ?>/perfil/apariencia" class="nav-link-custom " data-tooltip="Apariencia"> <i
                        class="bi bi-gear me-2"></i> <span class="texto-modulo">Apariencia</span></a>
            </li>

            <hr class="my-1 mx-2 border-secondary">

            <li class="nav-item">
                <a href="<?= URL_BASE ?>/login/logout" class="nav-link-custom  text-danger"
                    data-tooltip="Cerrar sesión">
                    <i class="bi bi-box-arrow-right me-2"></i> <span class="texto-modulo">Cerrar sesión</span>
                </a>
            </li>

        </ul>

    </div>
</aside>