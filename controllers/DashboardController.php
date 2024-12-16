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
}