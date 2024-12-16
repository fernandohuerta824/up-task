<?php

use Controller\DashboardController;
use Controller\LoginController;
use MVC\Router;

require_once '../utils/app.php';

$router = new Router;

$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/crear-cuenta', [LoginController::class, 'crearCuenta']);
$router->post('/crear-cuenta', [LoginController::class, 'crearCuenta']);

$router->get('/olvidar-password', [LoginController::class, 'olvidarPassword']);
$router->post('/olvidar-password', [LoginController::class, 'olvidarPassword']);

$router->get('/restablecer-password', [LoginController::class, 'restablecerPassword']);
$router->post('/restablecer-password', [LoginController::class, 'restablecerPassword']);

$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

$router->get('/dashboard', [DashboardController::class, 'dashboard']);

$router->comprobarRutas();