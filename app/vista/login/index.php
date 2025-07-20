<?php require_once __DIR__ . '/../../config/config.php'; ?>

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

      <?php if ($msg = SessionHelper::flash('error')): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>


      <input type="text" name="nombre_usuario" placeholder="Usuario" required autocomplete="username">
      <input type="password" name="contraseña" placeholder="Contraseña" required autocomplete="current-password">
      <p style="margin-top: 10px;">
        <a href="<?= URL_BASE ?>/login/recuperar">¿Olvidaste tu contraseña?</a>
      </p>
      <button type="submit">Iniciar sesión</button>
    </form>
  </div>
</body>

</html>