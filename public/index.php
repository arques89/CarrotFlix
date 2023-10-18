<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\PaginasController;


$router = new Router();

// Iniciar sesión
$router->get('/login', [AuthController::class, 'login']);

// Registro
$router->get('/register', [AuthController::class, 'register']);

// Página 404
$router->get('/404', [PaginasController::class, 'error']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
