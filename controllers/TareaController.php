<?php

namespace Controller;

use Model\Proyecto;
use Model\Tarea;

class TareaController {
    public static function tareas() {
        try {
            session_start();

            header('Content-Type: application/json');

            if(!$_SESSION['id']) {
                http_response_code(401);
                echo json_encode(['mensaje' => 'Fallo en auntenticarte, inicia sesion de nuevo']);
                exit;
            }

            $proyecto = Proyecto::where('url', $_GET['id'] ?? 'anything');
            if(!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                http_response_code(403);
                echo json_encode(['mensaje' => 'Proyecto no encontrado']);
                exit; 
            }

            $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
            echo json_encode(['mensaje' => 'Tareas encontradas', 'tareas' => $tareas] );
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte']);
            exit; 
        }
    }

    public static function crearTarea() {
        session_start();
        
        try {
            header('Content-Type: application/json');

            if(!$_SESSION['id']) {
                http_response_code(401);
                echo json_encode(['mensaje' => 'Fallo en auntenticarte, inicia sesion de nuevo']);
                exit;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $proyecto = Proyecto::where('url', $_POST['url'] ?? 'anything');
                if(!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                    http_response_code(403);
                    echo json_encode(['mensaje' => 'Proyecto no encontrado']);
                    exit; 
                }
                $tarea = new Tarea([
                    'nombre' => $_POST['nombre'], 
                    'estado' => 0, 
                    'proyectoId' => $proyecto->id
                ]);
                $tareaId = $tarea->guardar();
                http_response_code(201);

                $nuevaTarea = Tarea::encontrarPorID($tareaId);
                echo json_encode(['mensaje' => 'Tarea Agregada', 'datos' => $nuevaTarea]);
                exit;
            }
                
            http_response_code(400);
            echo json_encode(['mensaje' => 'Algo salio mal, intentelo de nuevo, si el probelmos persiste contacte al soporte']);
            exit; 
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(['mensaje' => 'Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte']);
            exit; 
        }
    }

    public static function actualizarTarea() {
        echo 'HOla';
    }

    public static function eliminarTarea() {
        echo 'HOla';
    }
}