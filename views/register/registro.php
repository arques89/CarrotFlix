<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            color: #ec5353;
            overflow: hidden;
            margin: 0%;
        }
        
        .registro {
            width: 300px;            
            position: absolute;
            top: 50%;
            left: 85%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }
        h1 {
            text-align: center;
            margin: 20 auto;
            font-size: 40px;
        }

        .registro .campo {
            margin-bottom: 15px;
        }

        label {
            font-size: 20px;
            font-weight: bold;
        }

        .registro input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }

        video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <video autoplay muted loop>
        <source src="movie.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>
    <div class="registro">
        <h1>Registro</h1>
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