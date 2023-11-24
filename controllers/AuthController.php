<?php

declare(strict_types=1);

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

final class AuthController
{
    public static function login(Router $router)
    {
        $alerts = [];

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $user = new User($_POST);

            $alerts = $user->validateLogin();

            if (empty($alerts)) {
                // Verificar quel el usuario exista
                $user = User::where('email', $user->getEmail());
                if (!$user || !$user->getConfirmed()) {
                    User::setAlert('error', 'El usuario no existe o no esta confirmado');
                } else {
                    // El Usuario existe
                    if (password_verify($_POST['password'], $user->getPassword())) {
                        // Iniciar la sesión
                        session_start();
                        $_SESSION['id'] = $user->getId();
                        $_SESSION['name'] = $user->getName();
                        $_SESSION['surname'] = $user->getSurname();
                        $_SESSION['email'] = $user->getEmail();
                        $_SESSION['isAdmin'] = $user->getIsAdmin() ?? null;

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
        $alerts = User::getAlerts();

        // Render a la vista
        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'alerts' => $alerts
        ]);
    }

    public static function logout()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
    }

    public static function register(Router $router)
    {
        $alerts = [];
        $user = new User();

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $user->synchronizeDB($_POST);
            $alerts = $user->validateAccount();

            if (empty($alerts)) {
                $existeUsuario = User::where('email', $user->getEmail());

                if ($existeUsuario) {
                    User::setAlert('error', 'El email utilizado ya esta está en uso.');
                    $alerts = User::getAlerts();
                } else {
                    // Hashear el password
                    $user->hashPassword();

                    // Eliminar password2
                    $password2 = $user->getPassword2();
                    unset($password2);

                    // Generar el Token
                    $user->setToken();

                    // Crear un nuevo usuario
                    $resultado = $user->save();

                    // Enviar email
                    $email = new Email($user->getEmail(), $user->getName(), $user->getSurname(), $user->getToken());

                    $email->sendConfirmation();

                    if ($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/register', [
            'title' => 'Crea tu cuenta en CarrotFlix',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function resetPassword(Router $router)
    {
        $alerts = [];

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $user = new User($_POST);
            $alerts = $user->validateEmail();

            if (empty($alerts)) {
                // Buscar el usuario
                $user = User::where('email', $user->getEmail());

                if ($user && $user->getConfirmed()) {
                    // Generar un nuevo token
                    $user->setToken();
                    $password2 = $user->getPassword2();
                    unset($password2);

                    // Actualizar el usuario
                    $user->save();

                    // Enviar el email
                    $email = new Email($user->getEmail(), $user->getName(), $user->getSurname(), $user->getToken());
                    $email->sendInstructions();

                    // Imprimir la alerta
                    // User::setAlert('exito', '¡Te hemos enviado un email con las instrucciones para restablecer tu contraseña!');

                    $alerts['exito'][] = '¡Te hemos enviado un email con las instrucciones para restablecer tu contraseña!';
                } else {
                    // User::setAlert('error', 'El Usuario no existe o no esta confirmado');

                    $alerts['error'][] = 'El Usuario no existe o no esta confirmado';
                }
            }
        }

        // Render a la vista
        $router->render('auth/reset-password', [
            'title' => '¿Olvidaste tu contraseña?',
            'alerts' => $alerts
        ]);
    }

    public static function newPassword(Router $router)
    {
        $token = s($_GET['token']);

        $valid_token = true;

        if (!$token) {
            header('Location: /');
        }

        // Identificar el usuario con este token
        $user = User::where('token', $token);

        if (empty($user)) {
            User::setAlert('error', 'Token No Válido, inténtalo de nuevo');
            $valid_token = false;
        }

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            // Añadir el nuevo password
            $user->synchronizeDB($_POST);

            // Validar el password
            $alerts = $user->validatePassword();

            if (empty($alerts)) {
                // Hashear el nuevo password
                $user->hashPassword();

                // Eliminar el Token
                $user->clearToken();

                // Guardar el usuario en la BD
                $resultado = $user->save();

                // Redireccionar
                if ($resultado) {
                    header('Location: /login');
                }
            }
        }

        $alerts = User::getAlerts();

        // Muestra la vista
        $router->render('auth/new-password', [
            'title' => 'Nueva contraseña',
            'alerts' => $alerts,
            'valid_token' => $valid_token
        ]);
    }

    public static function message(Router $router)
    {
        $router->render('auth/message', [
            'title' => 'Cuenta creada satisfactoriamente'
        ]);
    }

    public static function confirmAccount(Router $router)
    {
        $token = s($_GET['token']);

        if (!$token) {
            header('Location: /');
        }

        // Encontrar al usuario con este token
        $user = User::where('token', $token);

        if (empty($user)) {
            // No se encontró un usuario con ese token
            User::setAlert(
                'error',
                'Token no válido, su cuenta no ha sido confirmada'
            );
        } else {
            // Confirmar la cuenta
            $user->setConfirmed();
            $user->clearToken();
            $password2 = $user->getPassword2();
            unset($password2);

            // Guardar en la BD
            $user->save();

            User::setAlert('exito', 'Cuenta confirmada con éxito');
        }

        $router->render('auth/confirm', [
            'title' => 'Confirma tu cuenta',
            'alerts' => User::getAlerts()
        ]);
    }
}
