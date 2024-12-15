<?php 

namespace Controller;

use Class\Email;
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
                    if($resultado) {
                        $email = new Email([
                            'email' => $usuario->email,
                            'nombre' => $usuario->nombre,
                            'token' => $usuario->token
                        ]);

                        $email->enviarConfirmacion();
                        return header('Location: /mensaje');
                    }
                    
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
        $alertas = [];
        $usuario = new Usuario();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario(['email' => $_POST['email']]);

            $alertas = $usuario->validarEmail();;
            if(!isset($alertas['error'])) {
                $usuarioExistente = Usuario::where('email', $usuario->email);

                if($usuarioExistente && $usuarioExistente->confirmado === 1) {
                    $usuarioExistente->crearToken();
                    $usuarioExistente->guardar();
                    $email = new Email([
                        'nombre' => $usuarioExistente->nombre,
                        'email' => $usuarioExistente->email,
                        'token' => $usuarioExistente->token
                    ]);
                    $email->enviarRestablecerPassword();
                }
                $usuario->resetar();
                $alertas['exito'][] = 'Si el correo esta registrado y tu cuenta esta confirmada te enviaremos un email';
            }
        }

        $router->render('auth/olvidar-password', [
            'titulo' => 'Olvidar contraseña',
            'errores' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function restablecerPassword(Router $router) {
        $token = s($_GET['token']);

        if(!$token) return header('Location: /');
        $mostrarFormulario = true;
        $usuario = Usuario::where('token', $token);
        $alertas = [];
        if(!$usuario || $usuario->confirmado === 0) {
            $alertas['error'][] = 'Enlace no valido para restablecer tu contraseña, si no has confirmado tu cuenta, confirmala primero';
            $mostrarFormulario = false;
        } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->password = $_POST['password'];
            $usuario->password2 = $_POST['password2'];
            
            $alertas = $usuario->validarPassword();

            if(!isset($alertas['error'])) {
                $usuario->hashPassword();
                $usuario->token = '';
                $usuario->guardar();
                return header('Location: /');
            }
        }

        $router->render('auth/restablecer-password', [
            'titulo' => 'Restablecer contraseña',
            'errores' => $alertas,
            'mostrarFormulario' => $mostrarFormulario
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada'
        ]);
    }

    public static function confirmar(Router $router) {
        $token = S($_GET['token']);
        if(!$token) return header('Location: /');

        $alertas = [];
        try {
            $usuario = Usuario::where('token', $token);
            if(!$usuario || $usuario->confirmado === 1) 
                $alertas['error'][] = 'Enlace no valido para confirmar tu cuenta, si creaste una cuenta hace mas de 3 meses y no la confirmaste, tu cuenta fue borrada, registrate de nuevo';
            else {
                $usuario->token = '';
                $usuario->confirmado = 1;
                $usuario->guardar();
                $alertas['exito'][] = 'Cuenta confirmada, Ya puedes iniciar sesion';
            }
        } catch (\Throwable $th) {
            $alertas['error'][] = 'Algo salio mal, intentelo de nuevo, si el problema persiste contacte a soporte';
        }

        $router->render('auth/confirmar', [
            'titulo' => 'Cuenta confirmada',
            'errores' => $alertas
        ]);
    }

}