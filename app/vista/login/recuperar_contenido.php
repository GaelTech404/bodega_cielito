<h2>🔒 Recuperar contraseña</h2>
<p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
    </div>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<form action="<?= URL_BASE ?>/login/enviar_recuperacion" method="POST">
    <input type="email" name="email" class="form-control mb-2" placeholder="Correo electrónico" required autofocus>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">
    <button class="btn btn-primary w-100" type="submit">📧 Enviar enlace</button>
</form>

<p class="mt-3 text-center">
    <a href="<?= URL_BASE ?>/login">⬅️ Volver al inicio de sesión</a>
</p>
