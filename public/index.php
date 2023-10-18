<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\PaginasController;


$router = new Router();

// Iniciar sesión
$router->get('/login', [LoginController::class, 'login']);

// Página 404
$router->get('/404', [PaginasController::class, 'error']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
