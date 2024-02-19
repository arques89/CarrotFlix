<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\PagesController;
use Controllers\ProfileController;
use Controllers\CatalogueController;

$router = new Router();

// Area pública
$router->get('/', [PagesController::class, 'index']);

// Iniciar / Cerrar sesión
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Register
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);

// Reset-password
$router->get('/reset-password', [AuthController::class, 'resetPassword']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);

// Set a new password
$router->get('/new-password', [AuthController::class, 'newPassword']);
$router->post('/new-password', [AuthController::class, 'newPassword']);

// Confirmación register
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm-account', [AuthController::class, 'confirmAccount']);

// Profile
$router->get('/profile', [ProfileController::class, 'profile']);
$router->post('/procesaCSV', [ProfileController::class, 'procesaCSV']);

// Catalogue
$router->get('/browse', [CatalogueController::class, 'browse']);
$router->post('/browse', [CatalogueController::class, 'browse']);

// Página 404
$router->get('/404', [PagesController::class, 'error']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
