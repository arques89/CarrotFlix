<main>
    <video autoplay muted loop>
        <!-- Reemplaza 'video.mp4' con la ruta de tu video -->
        <source src="../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div id="contenedor_register">
        <div id="central">
            <div id="register">
                <?php
                require_once __DIR__ . '../../templates/alerts.php';
                ?>
                <div class="title">
                    Register
                </div>

                <form method="POST" action="/register" class="formulario">
                    <div class="formulario__campo">
                        <label for="name" class="formulario__label">Nombre</label>
                        <input type="text" class="formulario__input" placeholder="Su nombre" id="name" name="name" value="<?php echo $user->getName(); ?>">
                    </div>

                    <div class="formulario__campo">
                        <label for="surname" class="formulario__label">Apellido</label>
                        <input type="text" class="formulario__input" placeholder="Su apellido" id="surname" name="surname" value="<?php echo $user->getSurname(); ?>">
                    </div>

                    <div class="formulario__campo">
                        <label for="email" class="formulario__label">Email</label>
                        <input type="email" class="formulario__input" placeholder="Su email" id="email" name="email" value="<?php echo $user->getEmail(); ?>">
                    </div>

                    <div class="formulario__campo">
                        <label for="password" class="formulario__label">Password</label>
                        <input type="password" class="formulario__input" placeholder="Su password" id="password" name="password">
                    </div>

                    <div class="formulario__campo">
                        <label for="password2" class="formulario__label">Repetir Password</label>
                        <input type="password" class="formulario__input" placeholder="Repetir su password" id="password2" name="password2">
                    </div>

                    <input type="submit" class="formulario__submit" value="Crear cuenta" />
                </form>
                <div class="pie-form">
                    <a href="/reset-password">¿Perdiste tu contraseña?</a>
                    <a href="/login">¿Tienes Cuenta? Inicia Sesión</a>
                </div>
            </div>
            <div class="inferior">
                <a href="/">Volver</a>
            </div>
        </div>
    </div>
</main>