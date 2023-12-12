<?php

declare(strict_types=1);

namespace Controllers;

use MVC\Router;

final class CatalogueController
{
    public static function browse(Router $router)
    {

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
