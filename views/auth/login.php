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
                    Bienvenido
                </div>
                <form method="POST" action="/login" id="loginform">
                    <input type="text" name="usuario" placeholder="Usuario" required>

                    <input type="password" placeholder="Contraseña" name="password" required>

                    <input type="submit" class="formulario__submit" value="Login" />
                </form>
                <div class="pie-form">
                    <a href="/recuperar">¿Perdiste tu contraseña?</a>
                    <a href="/register">¿No tienes Cuenta? Registrate</a>
                </div>
            </div>
            <div class="inferior">
                <a href="/">Volver</a>
            </div>
        </div>
    </div>
</main>