<main>
    <video autoplay muted loop>
        <!-- Reemplaza 'video.mp4' con la ruta de tu video -->
        <source src="../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div id="contenedor">
        <div id="central">
            <div id="login">
                <div class="titulo">
                    Recuperar contraseña
                </div>
                <form method="POST" action="/login" id="loginform">
                    <div class="campo">
                        <label for="correo">Correo electrónico:</label>
                        <input type="text" name="correo" placeholder="Correo Electronico" required>
                    </div>
                    <input type="submit" class="formulario__submit" value="Recuperar" />
                </form>
                <div class="pie-form">
                    <a href="/login">¿Tienes Cuenta? Inicia sesión</a>
                    <a href="/register">¿No tienes Cuenta? Registrate</a>
                </div>
            </div>
            <div class="inferior">
                <a href="/">Volver</a>
            </div>
        </div>
    </div>
</main>