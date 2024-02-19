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

        if (!$_SESSION['id']) {
            header('Location: /');
        }

        // Render a la vista
        $router->render('catalogue/browse', [
            'title' => 'Catálogo',
            'movies' => $movies,
            'alerts' => $alerts
        ]);
    }
}
