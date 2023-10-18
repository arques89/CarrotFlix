<?php

namespace Controllers;

use MVC\Router;

class PaginasController
{

    public static function error(Router $router)
    {

        $router->render('paginas/error404', [
            'titulo' => 'ERROR 404: Página no encontrada'
        ]);
    }
}
