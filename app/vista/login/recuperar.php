<?php
if (session_status() === PHP_SESSION_NONE)
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="<?= URL_BASE ?>/css/login.css">
</head>

<body>
    <div class="login-container">

        <form class="login-form" action="<?= URL_BASE ?>/login/enviar_recuperacion" method="POST">
                  <img src="<?= URL_BASE ?>/img/logo.png" alt="Logo" style="max-width: 200px; height: auto;">

            <h2>🔒 Recuperar contraseña</h2>
            <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>

            <!-- Mensaje de estado (similar a session flash) -->
            <?php if (!empty($_SESSION['flash_message'])): ?>
                <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                    <?= htmlspecialchars($_SESSION['flash_message']) ?>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <input type="email" name="email" placeholder="Correo electrónico" required autofocus>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <button type="submit">📧 Enviar enlace de recuperación</button>

            <p style="margin-top: 10px;">
                <a href="<?= URL_BASE ?>/login">⬅️ Volver al inicio de sesión</a>
            </p>
        </form>
    </div>
</body>

</html>