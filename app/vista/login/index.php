<!DOCTYPE html>
<?php
if (session_status() === PHP_SESSION_NONE) {
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Login - Bodega Cielito</title>
  <link rel="stylesheet" href="<?= URL_BASE ?>/css/login.css">
  <link rel="stylesheet" href="<?= URL_BASE ?>/css/animaciones.css">
</head>

<body>
  <div class="login-container">
    <form class="login-form" action="<?= URL_BASE ?>/login/validar" method="POST">
      <h2>Ingreso al sistema</h2>
      <img src="<?= URL_BASE ?>/img/logo.png" alt="Logo" style="max-width: 200px; height: auto;">

      <!-- ✅ MENSAJE DE ERROR FLASH -->
      <?php if (!empty($_SESSION['flash_message'])): ?>
        <div class="mensaje-error" style="color: red; margin-bottom: 10px;">
          <?= htmlspecialchars($_SESSION['flash_message']) ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
      <?php endif; ?>

      <input type="text" name="nombre_usuario" placeholder="Usuario" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <p style="margin-top: 10px;">
        <a href="<?= URL_BASE ?>/login/recuperar">¿Olvidaste tu contraseña?</a>
      </p>
      <button type="submit">Iniciar sesión</button>
    </form>
  </div>
</body>

</html>