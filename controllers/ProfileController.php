<?php

namespace Controllers;

use MVC\Router;

class ProfileController
{
    public static function profile(Router $router)
    {
        $router->render('profile/index', [
            'title' => 'Perfil de usuario'
        ]);
    }
}
