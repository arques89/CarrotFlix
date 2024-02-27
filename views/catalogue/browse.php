<main>
    <div class="container mt-5">
        <h1>Catálogo de Películas</h1>
        <div class="row gap-4">
            <?php foreach ($movies as $movie) { ?>
                <div class="card mt-5" style="width: 18rem;">
                    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $movie->getId(); ?>">
                        <img class="card-img-top mt-2" srcset="media/<?php echo $movie->getImageURL(); ?>" alt="<?php echo $movie->getTitle(); ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                    </div>

                    <!-- Ventana modal -->
                    <div class="modal fade" id="myModal<?php echo $movie->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $movie->getTitle(); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span class="text-uppercase fs-5">Director: </span> <?php echo $movie->getDirector(); ?></p>
                                            <p><span class="text-uppercase fs-5">Sinopsis: </span> <?php echo $movie->getSynopsis(); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span class="text-uppercase fs-5">Género: </span> <?php echo $movie->getGenre(); ?></p>
                                            <p><span class="text-uppercase fs-5">Idioma: </span> <?php echo $movie->getLanguage(); ?></p>
                                            <p><span class="text-uppercase fs-5">Reparto: </span> <?php echo $movie->getCast(); ?></p>
                                            <p><span class="text-uppercase fs-5">Año: </span> <?php echo $movie->getYear(); ?></p>
                                            <p><span class="text-uppercase fs-5">Valoración: </span> <?php echo $movie->getRating(); ?></p>
                                        </div>
                                    </div>

                                    <!-- Mini reproductor de YouTube -->
                                    <div>
                                        <span class="text-uppercase fs-5">Trailer: </span>
                                    </div>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <?php
                                        // Obtener el código de inserción del enlace del video
                                        $videoUrl = $movie->getTrailer();
                                        $videoId = getYouTubeVideoId($videoUrl);
                                        $embedCode = "https://www.youtube.com/embed/$videoId";
                                        ?>
                                        <iframe class="embed-responsive-item" src="<?php echo $embedCode; ?>" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<?php
// Función para extraer el ID del video de YouTube desde la URL
function getYouTubeVideoId($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    return isset($params['v']) ? $params['v'] : '';
}
?>