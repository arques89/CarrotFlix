<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../../assets/css/recuperar.css">
    <style>

    </style>
</head>

<body>
    <video autoplay muted loop>
        <source src="../../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>
    <div class="recuperar">
        <h1>Recuperar</h1>
        <form action="/registrar" method="post">
            <div class="campo">
                <label for="correo">Correo electrónico:</label>
                <input type="email" name="correo" id="correo">
            </div>
            <button type="submit">Enviar email</button>
            <div class="inferior">
            <a href="/login">Volver</a>
        </div>
        </form>
    </div>
</body>

</html>