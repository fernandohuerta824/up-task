<?php

namespace Controller;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    public static function dashboard(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /');

        $proyectos = Proyecto::belongsTo('usuarioId', $_SESSION['id']);


        $router->render('dashboard/dashboard', [
            'titulo' => 'Dashboard',
            'nombre' => $_SESSION['nombre'],
            'proyectos' => $proyectos
        ]);
    }

    public static function crearProyecto(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /proyecto');
        $alertas = [];

        $proyecto = new Proyecto();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto->sincronizar(['nombre' => $_POST['nombre']]);

            $alertas = $proyecto->validarProyecto();

            if(!isset($alertas['error'])) {
                try {
                    $proyecto->url = md5(uniqid(rand()));
                    $proyecto->usuarioId = $_SESSION['id'];
                    $proyecto->guardar();
                    return header('Location: /proyecto?id=' . $proyecto->url);;
                } catch (\Throwable $th) {
                    debug($th);
                   $alertas['error'][] = 'Algo salio mal, intente de nuevo si el problemas persiste contacte a soporte';
                }
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear proyecto',
            'nombre' => $_SESSION['nombre'],
            'errores' => $alertas,
            'proyecto' => $proyecto
        ]);
    }

    public static function perfil(Router $router) {
        session_start();

        $usuario = Usuario::encontrarPorID($_SESSION['id']);
        $alertas = [];
        if(!$_SESSION['id'])
            return header('Location: /');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar([
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email']
            ]);

            $alertas = $usuario->validarPerfil();

            if(!count($alertas)) {
               $usuario->guardar(); 
               $_SESSION['nombre'] = $usuario->nombre;
               $alertas['exito'][] = 'Cambios realizados correctamente';
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'nombre' => $_SESSION['nombre'],
            'usuario' => $usuario,
            'errores' => $alertas
        ]);
    }

    public static function cambiarPassword(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /');

        $alertas = [];    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $newPassword2 = $_POST['newPassword2'];


            $newPasswordUser = new Usuario(['password' => $newPassword, 'password2' => $newPassword2]);
            $alertas = $newPasswordUser->validarPassword();
            if(!count($alertas)) {
                $usuario = Usuario::where('id', $_SESSION['id']);
                $correctPassword = password_verify($currentPassword, $usuario->password);
                if(!$correctPassword) {
                    $alertas['error'][] = 'Contraseña incorrecta';
                } else {
                    $usuario->password = $newPassword;
                    $usuario->hashPassword();
                    $usuario->guardar();
                    $alertas['exito'][] = 'Contraseña cambiada correctamente';
                    
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar contraseña',
            'nombre' => $_SESSION['nombre'],
            'errores' => $alertas,
        ]);
    }

    public static function proyecto(Router $router) {
        session_start();

        if(!$_SESSION['id'])
            return header('Location: /');
        $url = s($_GET['id']);
        if(!$url) 
            return header('Location: /');

        
        $proyecto = Proyecto::where('url', $url);
        if(!$proyecto || $proyecto->usuarioId !== $_SESSION['id'])
            return header('Location: /');


        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->nombre,
            'nombre' => $_SESSION['nombre']
        ]);
    }
}