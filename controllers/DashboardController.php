<?php

namespace Controller;

use MVC\Router;

class DashboardController {
    public static function dashboard(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /');

        $router->render('dashboard/dashboard', [
            'titulo' => 'Dashboard',
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function crearProyecto(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /');
        $alertas = [];
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear proyecto',
            'nombre' => $_SESSION['nombre'],
            'errores' => $alertas
        ]);
    }

    public static function perfil(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /');

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'nombre' => $_SESSION['nombre']
        ]);
    }
}