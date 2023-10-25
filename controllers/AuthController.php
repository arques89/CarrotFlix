<?php

namespace Controllers;

use Model\User;
use MVC\Router;

class AuthController
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* debuguear($_POST); */
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
        $user = new User;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user->sincronizar($_POST);

            $alertas = $user->validateAccount();

            if (empty($alertas)) {
                $existeUsuario = User::where('email', $user->email);

                if ($existeUsuario) {
                    User::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = User::getAlertas();
                } else {
                    // Hashear el password
                    $user->hashPassword();

                    // Eliminar password2
                    unset($user->password2);

                    // Generar el Token
                    $user->createToken();

                    // Crear un nuevo usuario
                    $resultado = $user->save();

                    // Enviar email
                    /*  $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion(); */

                    if ($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }


        // Render a la vista
        $router->render('auth/register', [
            'titulo' => 'Crea tu cuenta en CarrotFlix',
            'user' => $user,
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

    public static function message(Router $router)
    {

        $router->render('auth/message', [
            'titulo' => 'Cuenta creada satisfactoriamente'
        ]);
    }
}
