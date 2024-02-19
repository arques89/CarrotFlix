<main>
    <div class="container mt-5">
        <h1 class="" >Catálogo de Películas</h1>
        <div class="row">
            <?php foreach ($movies as $movie) { ?>
                <div class="card" style="width: 18rem;">
                    <a href="#">
                        <img class="card-img-top" srcset="media/<?php echo $movie->getImageURL(); ?>" alt="<?php echo $movie->getTitle(); ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
</main>