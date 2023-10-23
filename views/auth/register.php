<main>
    <video autoplay muted loop>
        <!-- Reemplaza 'video.mp4' con la ruta de tu video -->
        <source src="../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div class="registro">
        <form action="/registrar" method="post">
            <div class="campo">
                <label for="correo">Correo electrónico:</label>
                <input type="email" name="correo" id="correo">
            </div>
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            <div class="campo">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido">
            </div>
            <div class="campo">
                <label for="edad">Edad:</label>
                <input type="number" name="edad" id="edad">
            </div>
            <div class="campo">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni">
            </div>
            <button type="submit">Registrar</button>
            <div class="inferior">
                <a href="/login">Volver</a>
            </div>
        </form>
    </div>
</main>