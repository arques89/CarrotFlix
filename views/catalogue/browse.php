<?php
$basePath = dirname(__FILE__); // Obtiene la ruta absoluta del archivo actual

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>Catálogo de Películas</h1>
        <div class="row">
            <?php foreach ($movies as $movie) {?>

                <div class="card" style="width: 18rem;">
                    <a href="#">
                        <img class="card-img-top" srcset="media/<?php echo $movie->getImage(); ?>" alt="<?php echo $movie->getTitle(); ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                    </div>

                </div>

            <?php }?>
        </div>
    </div>
</body>

</html>