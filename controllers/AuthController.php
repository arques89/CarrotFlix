<?php

namespace Controllers;

use Model\User;
use MVC\Router;
use Classes\Email;

class AuthController
{
    public static function login(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user = new User($_POST);

            $alertas = $user->validateLogin();

            if (empty($alertas)) {
                // Verificar quel el usuario exista
                $user = User::where('email', $user->email);
                if (!$user || !$user->confirmed) {
                    User::setAlert('error', 'El usuario ' . $user->email . ' no existe o no esta confirmado');
                } else {
                    // El Usuario existe
                    if (password_verify($_POST['password'], $user->password)) {

                        // Iniciar la sesión
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['surname'] = $user->surname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin ?? null;

                        // Redirección
                        if ($user) {
                            header('Location: /');
                        }
                        /* if ($usuario->admin) {
                    header('Location: /');
                    } else {
                    header('Location: /');
                    } */
                    } else {
                        User::setAlert('error', 'Contraseña incorrecta');
                    }
                }
            }
        }
        $alertas = User::getAlerts();

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
    }

    public static function register(Router $router)
    {
        $alertas = [];
        $user = new User;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user->synchronizeDB($_POST);
            $alertas = $user->validateAccount();

            if (empty($alertas)) {
                $existeUsuario = User::where('email', $user->email);

                if ($existeUsuario) {
                    User::setAlert('error', 'El Usuario ya esta registrado');
                    $alertas = User::getAlerts();
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
                    $email = new Email($user->email, $user->name, $user->surname, $user->token);

                    $email->sendConfirmation();

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
