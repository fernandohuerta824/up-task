<?php 

namespace Controller;

use Model\Usuario;
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
        $usuario = new Usuario();
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar([
                'email' => $_POST['email'], 
                'nombre' => $_POST['nombre'],
                'password' => $_POST['password'],
                'password2' => $_POST['password2'],
            ]);

            $errores = $usuario->validarNuevaCuenta();
            
            if(!isset($errores['error'])) {
                $usuario->hashPassword();
                $usuario->crearToken();
                try {
                    $resultado = $usuario->guardar();
                    if($resultado)
                        return header('Location: /mensaje');
                    
                    $errores['error'][] = 'Algo salio mal, intentelo de nuevo, si el problema persiste contacte a soporte';
                } catch (\Throwable $th) {
                    $errores['error'][] = 'Algo salio mal, intentelo de nuevo, si el problema persiste contacte a soporte';
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'titulo' => 'Crea nueva cuenta',
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }

    public static function olvidarPassword(Router $router) {
        $router->render('auth/olvidar-password', [
            'titulo' => 'Olvidar contraseña'
        ]);
    }

    public static function restablecerPassword(Router $router) {
        $router->render('auth/restablecer-password', [
            'titulo' => 'Restablecer contraseña'
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada'
        ]);
    }

    public static function confirmar(Router $router) {
        $router->render('auth/confirmar', [
            'titulo' => 'Cuenta confirmada'
        ]);
    }

}