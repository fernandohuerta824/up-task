<?php

namespace Controller;

use Model\Proyecto;
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

        if(!$_SESSION['id'])
            return header('Location: /');

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'nombre' => $_SESSION['nombre']
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