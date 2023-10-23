<main>
    <video autoplay muted loop>
        <!-- Reemplaza 'video.mp4' con la ruta de tu video -->
        <source src="../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div id="contenedor_registro">
        <div id="central">
            <div id="registro">
                <div class="titulo">
                    Registro
                </div>
                <form method="POST" action="/login" id="loginform">
                    <div class="campo">
                        <label for="correo">Correo electrónico:</label>
                        <input type="email" name="correo" id="correo" placeholder="Correo Electronico">
                    </div>

                    <div class="campo">
                        <label for="nombre">Contraseña:</label>
                        <input type="password" placeholder="Contraseña" name="password" required>
                    </div>

                    <div class="campo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre">
                    </div>
                    <div class="campo">
                        <label for="edad">Apellido</label>
                        <input type="number" name="edad" id="edad" placeholder="Edad">
                    </div>
                    <div class="campo">
                        <label for="dni">Edad:</label>
                        <input type="text" name="dni" id="dni" placeholder="Dni">
                    </div>
                    <br>
                    <input type="submit" class="formulario__submit" value="Registrarse" />
                </form>
                <div class="pie-form">
                    <a href="/recuperar">¿Perdiste tu contraseña?</a>
                    <a href="/login">¿Tienes Cuenta? Inicia Sesión</a>
                </div>
            </div>
            <div class="inferior">
                <a href="/">Volver</a>
            </div>
        </div>
    </div>
</main>