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

    public static function crearCuenta(Router $router) {
        $router->render('auth/crear-cuenta', [
            'titulo' => 'Crea nueva cuenta'
        ]);
    }

    public static function olvidarPassword(Router $router) {
        $router->render('auth/olvidar-password', [
            'titulo' => 'Olvidar contraseña'
        ]);
    }

}