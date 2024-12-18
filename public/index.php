<?php

use Controller\DashboardController;
use Controller\LoginController;
use Controller\TareaController;
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
$router->get('/crear-proyecto', [DashboardController::class, 'crearProyecto']);
$router->post('/crear-proyecto', [DashboardController::class, 'crearProyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);

$router->get('/api/tareas', [TareaController::class, 'tareas']);
$router->post('/api/tarea', [TareaController::class, 'crearTarea']);
$router->post('/api/tarea/actualizar', [TareaController::class, 'actualizarTarea']);
$router->post('/api/tarea/eliminar', [TareaController::class, 'eliminarTarea']);



$router->comprobarRutas();