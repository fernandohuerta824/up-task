<?php

namespace Model;

use Intervention\Image\ImageManager as BaseImage;
use Intervention\Image\Drivers\Gd\Driver;

abstract class Imagen {
    protected static string $rutaParaGuardar = '';
    protected static int $tamanioMaximo = 4; // 4MB

    protected $image;
    protected string $name;
    protected string $extension;
    protected string $fullName;
    protected string $nombreFinal;
    protected string $tmpPath;
    protected int $size;

    public function __construct(array $args = []) {
        if(!isset($args['name'])) 
            throw new \Exception('El nombre de la imagen es requerido');
        
        if(!isset($args['tmp_name']) || !file_exists($args['tmp_name'])) 
                throw new \Exception('No se ha podido cargar la imagen');

        
        $this->tmpPath = $args['tmp_name'];
        
        $this->fullName = $args['name'];

        $this->name = substr($args['name'], 0, strpos($args['name'], '.'));

        $this->extension = substr($args['name'], strpos($args['name'], '.') + 1);

        $this->nombreFinal = $this->name . '-' . md5(uniqid(rand((int) 0, (int) 1000))) . '.' . $this->extension;

        $this->size = $args['size'];

        if($this->size > self::$tamanioMaximo * 1024 * 1024) 
            throw new \Exception('La imagen es demasiado grande, el tamaño máximo es de ' . self::$tamanioMaximo . 'MB');

        $manager = new BaseImage(Driver::class);

        $this->image = $manager->read($this->tmpPath);
    }

    public function save() {
        if(!is_dir(static::$rutaParaGuardar)) 
            mkdir(static::$rutaParaGuardar, 0777, true);

        $this->image->save(static::$rutaParaGuardar . $this->nombreFinal);
    }

    public function getNombreFinal(): string {
        return $this->nombreFinal;
    }

    public function getRutaParaGuardar(): string {
        return static::$rutaParaGuardar;
    }
}