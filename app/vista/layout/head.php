<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Detectar tema desde cookie (o fallback a 'light')
$tema = $_COOKIE['tema'] ?? 'light';
$claseBody = $tema === 'dark' ? 'dark bg-dark text-light' : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Bodega Cielito' ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL_BASE ?>/librerias/bootstrap/css/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/librerias/bootstrap/css/bootstrap.min.css">
    <script src="<?= URL_BASE ?>/librerias/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Estilos comunes -->
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/base.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/navbar.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/animaciones.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/sidebar.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/tema.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>