<?php

namespace Controllers;

use MVC\Router;

class AuthController
{
    public static function login(Router $router)
    {
        $alertas = '';
        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function register(Router $router)
    {
        $alertas = [];

        // Render a la vista
        $router->render('auth/register', [
            'titulo' => 'Crea tu cuenta en CarrotFlix',
            'alertas' => $alertas
        ]);
    }
}
