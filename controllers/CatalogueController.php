<?php

declare(strict_types=1);

namespace Controllers;

use MVC\Router;

final class CatalogueController
{
    public static function browse(Router $router)
    {
        // Render a la vista
        $router->render('catalogue/browse', [
            'title' => 'Catálogo'
        ]);
    }
}
