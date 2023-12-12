<?php

declare(strict_types=1);

namespace Controllers;

use Model\Movie;
use MVC\Router;

final class CatalogueController
{
    public static function browse(Router $router)
    {

        $movie = new Movie();
        debug($movie->all());
        $alerts = [];

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $alerts = [];
        }
        // Render a la vista
        $router->render('catalogue/browse', [
            'title' => 'Catálogo',
            'alerts' => $alerts
        ]);
    }
}
