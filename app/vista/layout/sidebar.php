<?php
require_once __DIR__ . '/../../config/config.php'; // Ruta desde layout/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombreUsuario = $_SESSION['nombre_usuario'] ?? 'Invitado';
$iniciales = strtoupper(substr($nombreUsuario, 0, 2));
?>



<aside class="sidebar-custom d-flex flex-column justify-content-between p-3 flex-shrink-0">
    <!-- Logo -->
    <div>
        <a href="<?= URL_BASE ?>/inicio" class="d-flex align-items-center mb-4 text-decoration-none"
            style="color: inherit; text-decoration: none;font-size: 20px;">

            <div class="logo-wrapper bg-accent-content rounded p-1 me-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    fill="none" height="30" class="me-0 logo-svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
            </div>
            <span class="fw-bold" style=" padding: 6px;">Bodega Cielito</span>
        </a>

        <span class="texto-menu" style="color:#a3a3a3;">Menú</span>

        <ul class="nav nav-pills flex-column mb-4" style="font-size: 18px;">
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/inicio" class="nav-link-custom">🏠 Inicio</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/producto" class="nav-link-custom">📦 Productos</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/categoria" class="nav-link-custom">📁 Categorías</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/proveedor" class="nav-link-custom">🚚 Proveedores</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/compra" class="nav-link-custom">🛒 Compras</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/venta" class="nav-link-custom">💰 Ventas</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL_BASE ?>/usuario" class="nav-link-custom">👤 Usuarios</a>
            </li>
        </ul>
    </div>

    <!-- Perfil con Dropdown -->
    <div class="dropdown mt-auto pt-3 border-top">
        <button class="drop btn d-flex align-items-center w-100" type="button" id="dropdownPerfil"
            data-bs-toggle="dropdown" aria-expanded="false">

            <!-- Iniciales del usuario -->
            <div class="rounded-circle avatar-invert fw-bold d-flex align-items-center justify-content-center me-2"
                style="width: 36px; height: 36px;">
                <?= $iniciales ?>
            </div>

            <!-- Nombre del usuario -->
            <span class="flex-grow-1 text-start">
                <?= htmlspecialchars($nombreUsuario) ?>
            </span>

            <!-- Icono de dropdown -->
            <i class="ms-auto bi bi-chevron-down"></i>
        </button>

        <ul class="dropdown-menu shadow w-100" aria-labelledby="dropdownPerfil">
            <div class="p-0 text-sm font-normal">

                <div class="d-flex align-items-center px-2 text-start text-sm">
                    <div class="d-flex align-items-center text-start">
                        <!-- Avatar circular con iniciales -->
                        <div class="rounded-circle avatar-invert fw-bold d-flex align-items-center justify-content-center me-2"
                            style="width: 38px; height: 38px;">
                            <?= $iniciales ?>
                        </div>

                        <!-- Info del usuario -->
                        <div class="text-start flex-grow-1">
                            <div class="fw-semibold truncate"><?= $_SESSION['nombre_completo'] ?? 'Invitado' ?>
                            </div>
                            <div class="fw-semibold truncar w-100" style=" font-size: 12px; ""
                                title="<?= htmlspecialchars($_SESSION['correo'] ?? '') ?>">
                                <?= $_SESSION['correo'] ?>
                            </div>
                            <div class="fw-semibold small text-truncate"><?= $_SESSION['rol'] ?? '' ?></div>

                        </div>
                    </div>
                </div>

            </div>
            <hr class="my-1 mx-2 border-secondary">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="<?= URL_BASE ?>/perfil/apariencia">
                    <i class="bi bi-gear me-2"></i> Apariencia
                </a>
            </li>
            <hr class="my-1 mx-2 border-secondary">
            <li>
                <a class="dropdown-item d-flex align-items-center text-danger" href="<?= URL_BASE ?>/login/logout">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                </a>
            </li>
        </ul>
    </div>


</aside>