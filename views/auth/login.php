<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/registro.css">
    <style>

    </style>
</head>

<body>
    <video autoplay muted loop>
        <source src="../../assets/img/movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>
    <div class="registro">
        <h1>Registro</h1>
        <h1>* Cambiar este template por el template de LOGIN</h1>

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
        </form>
    </div>
</body>

</html>