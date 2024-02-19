<?php

declare(strict_types=1);

namespace Controllers;

use Model\Movie;
use MVC\Router;

final class CatalogueController
{
    public static function browse(Router $router)
    {
        $movieObj = new Movie();
        $movies = $movieObj->all();
        $alerts = [];

        // TODO : Proteger ruta
        // Render a la vista
        $router->render('catalogue/browse', [
            'title' => 'Catálogo',
            'movies' => $movies,
            'alerts' => $alerts
        ]);
    }
}
