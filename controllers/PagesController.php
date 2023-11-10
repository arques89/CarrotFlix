<?php

namespace Controllers;

use MVC\Router;

class PagesController
{
    public static function index(Router $router)
    {
        $router->render('pages/index', [
            'titulo' => 'Inicio',
        ]);
    }

    public static function error(Router $router)
    {
        $router->render('pages/error404', [
            'titulo' => 'ERROR 404: Página no encontrada',
        ]);
    }
}
