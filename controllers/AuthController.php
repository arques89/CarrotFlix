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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alertas = $user->validateEmail();

            if (empty($alertas)) {
                // Buscar el usuario
                $user = User::where('email', $user->email);

                if ($user && $user->confirmed) {

                    // Generar un nuevo token
                    $user->createToken();
                    unset($user->password2);

                    // Actualizar el usuario
                    $user->save();

                    // Enviar el email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();

                    // Imprimir la alerta
                    // User::setAlert('exito', 'Hemos enviado las instrucciones a tu email');

                    $alertas['exito'][] = 'Hemos enviado las instrucciones a tu email';
                } else {

                    // User::setAlert('error', 'El Usuario no existe o no esta confirmado');

                    $alertas['error'][] = 'El Usuario no existe o no esta confirmado';
                }
            }
        }

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

    public static function confirm(Router $router)
    {

        $token = s($_GET['token']);

        if (!$token) {
            header('Location: /');
        }

        // Encontrar al usuario con este token
        $user = User::where('token', $token);

        if (empty($user)) {
            // No se encontró un usuario con ese token
            User::setAlert('error', 'Token no válido, su cuenta no ha sido confirmada');
        } else {
            // Confirmar la cuenta
            $user->confirmed = 1;
            $user->token = '';
            unset($user->password2);

            // Guardar en la BD
            $user->save();

            User::setAlert('exito', 'Cuenta confirmada con éxito');
        }

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta',
            'alertas' => User::getAlerts()
        ]);
    }
}
