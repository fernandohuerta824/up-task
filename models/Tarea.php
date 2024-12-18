<?php

namespace Model;

class Tarea extends ActiveRecord {
    protected static string $tabla = 'tareas';

    protected static array $columnas = ['nombre', 'estado', 'proyectoId'];

    public string $nombre;
    public int $estado;
    public int $proyectoId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->proyectoId = $args['proyectoId'] ?? 0;
    }
}