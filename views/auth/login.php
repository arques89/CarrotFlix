<main>
    <video autoplay muted loop>
        <source src="../assets/img/movie.mp4" type="video/mp4">
    </video>
    <div class="contenedor">

        <div class="central">
            <div class="red-card">
                <div class="title">
                    Bienvenido
                </div>
                <?php
                require_once __DIR__ . '../../templates/alerts.php';
                ?>
                <form method="POST" action="/login" class="formulario">
                    <div class="formulario__campo">
                        <label for="email" class="formulario__label">Correo Electrónico</label>
                        <input type="email" class="formulario__input" placeholder="Correo Electrónico" id="email" name="email">
                    </div>

                    <div class="formulario__campo">
                        <label for="password" class="formulario__label">Contraseña</label>
                        <input type="password" class="formulario__input" placeholder="Contraseña" id="password" name="password">
                    </div>

                    <input type="submit" class="formulario__submit" value="Iniciar sesión" />
                </form>
                <div class="pie-form">
                    <a href="/reset-password">¿Perdiste tu contraseña?</a>
                    <a href="/register">¿No tienes Cuenta? Registrate</a>
                </div>
                <div class="inferior">
                    <a href="/">Volver</a>
                </div>
            </div>
        </div>
    </div>
</main>