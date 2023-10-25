<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\PagesController;


$router = new Router();

// Area pública
$router->get('/', [PagesController::class, 'index']);

// Iniciar sesión
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);

// Registro
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);

// Recuperar
$router->get('/recuperar', [AuthController::class, 'recuperar']);

// Confirmación registro
$router->get('/message', [AuthController::class, 'message']);

// Página 404
$router->get('/404', [PagesController::class, 'error']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
