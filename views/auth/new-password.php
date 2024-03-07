<main class="auth">
    <video autoplay muted loop>
        <!-- Reemplaza 'video.mp4' con la ruta de tu video -->
        <source src="../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div class="contenedor">
        <div class="central">
            <div class="red-card">
                <?php
                    require_once __DIR__ . '/../templates/alerts.php';
                ?>
                <div class="title">
                    Restablecer contraseña
                </div>
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
                <div class="pie-form">
                    <a href="/login">¿Tienes Cuenta? Inicia sesión</a>
                    <a href="/register">¿No tienes Cuenta? Registrate</a>
                </div>
                <div class="inferior">
                    <a href="/">Volver</a>
                </div>
            </div>
        </div>
    </div>
</main>