<?php

namespace Model;

class Proyecto extends ActiveRecord{
    protected static string $tabla = 'proyectos';

    protected static array $columnas = ['nombre', 'url', 'usuarioId'];

    public string $nombre;
    public string $url;
    public int $usuarioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->url = $args['url'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? 0;
    }

    public function validarProyecto(): array {
        if(!$this->nombre) 
            self::$errores['error'][] = 'El nombre es obligatorio';
           
        return self::$errores;
    }

}