<?php
$basePath = dirname(__FILE__); // Obtiene la ruta absoluta del archivo actual

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Películas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos adicionales */
        .movie-card {
            margin-bottom: 20px;
        }

        .movie-card img {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Catálogo de Películas</h1>
        <div class="row">
            <?php foreach ($movies as $movie) { ?>
                <div class="col-md-2">
                    <div class="card movie-card">
                        <img class="card-img-top" srcset="media/<?php echo $movie->getImage(); ?>" alt="<?php echo $movie->getTitle(); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>