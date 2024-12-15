<?php 

namespace Controller;

use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion'
        ]);
    }

    public static function logout(Router $router) {
        $router->render('');
    }
}