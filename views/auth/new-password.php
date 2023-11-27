<main class="auth">
    <h2 class="auth__heading"><?php echo $title; ?></h2>
    <p class="auth__texto">Establece tu nueva contraseña</p>

    <?php
    require_once __DIR__ . '../../templates/alerts.php';
    ?>

    <?php if ($valid_token) { ?>
        <form method="POST" class="formulario">
            <div class="formulario__campo">
                <label for="password" class="formulario__label">Nueva contraseña</label>
                <input type="password" class="formulario__input" placeholder="Su nueva contraseña" id="password" name="password">
                <label for="password2" class="formulario__label">Repita contraseña</label>
                <input type="password" class="formulario__input" placeholder="Repita su nueva contraseña" id="password2" name="password2">
            </div>

            <input type="submit" class="formulario__submit" value="Guardar contraseña" />
        </form>
    <?php } ?>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar sesión!</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Regístrate!</a>
    </div>
</main>