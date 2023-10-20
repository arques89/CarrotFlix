<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrot Flix</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <div class="contenedor-app">
        <div class="imagen"></div>
        <div class="app">
            <?php
            include_once __DIR__ . '/templates/header.php';
            echo $contenido;
            include_once __DIR__ . '/templates/footer.php';
            ?>
        </div>
    </div>

    <?php echo $script ?? '' ?>
</body>

</html>