<?php

namespace Controllers;

use MVC\Router;

class AuthController
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            debuguear($_POST);
        }

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

    public static function recuperar(Router $router)
    {
        $alertas = [];

        // Render a la vista
        $router->render('auth/recuperar', [
            'titulo' => '¿Olvidaste tu contraseña?',
            'alertas' => $alertas
        ]);
    }
}
