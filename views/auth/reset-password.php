<main>
    <video autoplay muted loop>
        <!-- Reemplaza 'video.mp4' con la ruta de tu video -->
        <source src="../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div id="contenedor">
        <div id="central">
            <div id="login">
                <?php
                    require_once __DIR__ . '/../templates/alerts.php';
                ?>
                <div class="title">
                    Restablecer contraseña
                </div>
                <form method="POST" action="/reset-password" id="loginform">
                    <div class="campo">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" name="email" placeholder="Correo Electronico" required>
                    </div>
                    <input type="submit" class="formulario__submit" value="Restablecer contraseña" />
                </form>
                <div class="pie-form">
                    <a href="/login">¿Tienes Cuenta? Inicia sesión</a>
                    <a href="/register">¿No tienes Cuenta? Registrate</a>
                </div>
            </div>
        </div>
    </div>
</main>