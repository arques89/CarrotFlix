<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrot Flix</title>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

    <?php echo $script ?? ''; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>