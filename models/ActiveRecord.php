<?php 

namespace Model;

use Model\Imagen as Imagen;
use mysqli;

abstract class ActiveRecord {
    protected static mysqli $db;

    protected static string $tabla = '';

    protected static array $columnas = [];

    protected static array $errores = [];

    protected int $id;
    protected Imagen $imagen;

    public function __construct(array $args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key)) {
                if(gettype($this->$key) === 'number') 
                    $this->$key = intval($value);
                else
                    $this->$key = $value ?? null;
            }
        }
    }

    public static function setDB(mysqli $db) {
        self::$db = $db;
    }
    
    public function guardar(): mysqli|bool {
        if(!empty(static::$errores)) 
            return false;
        $atributos = $this->sanitizarAtributos();

        $columnas = join(', ', array_keys($atributos));

        $valores = join("', '", array_values($atributos));

        if($this->id) {
            $registro = self::encontrarPorID($this->id);

            if(!$registro) 
                return false;

            $query = "UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', array_map(fn($key) => "$key = '$atributos[$key]'", array_keys($atributos)));
            $query .= " WHERE id = " . $this->id;
        } else {
            $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ('$valores')";
        }

        return self::$db->query($query);
    }

    private function sanitizarAtributos(): array {
        $atributos = $this->atributos();

        foreach($atributos as $key => $value) {
            // if($key === 'imagen') {
            //     $atributos[$key] = $value->getNombreFinal();
            //     continue;
            // }

            if($key === 'id') 
                continue;

            $atributos[$key] = self::$db->real_escape_string($value);
        }

        return $atributos;
    }

    private function atributos(): array {
        $atributos = [];
        foreach(static::$columnas as $columna) 
            $atributos[$columna] = $this->$columna;

        return $atributos;
    }

    public static function encontrarPorID(int|string $id): ActiveRecord {
        $id = intval($id);
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        return self::consultar($query)[0];
    }

    protected static function consultar(string $query): array {
        $resultado = self::$db->query($query);

        if(!$resultado) 
            return [];
        $columnas = [];
        $array = [];

        while ($registro = $resultado->fetch_assoc()) {
            $columnas = $registro;
    
            
            $instancia = new static($columnas);
    
            
            if (isset($registro['imagen'])) {
                $imagenValores = [
                    'name' => $registro['imagen'],
                    'size' => 1,
                    'tmp_name' => $instancia->imagen->getRutaParaGuardar() . $registro['imagen']
                ];
                $instancia->imagen = $imagenValores; 
            }
    
            $array[] = $instancia;
        }

        $resultado->free();

        return $array;
    }

    public static function getErrores(): array {
        return static::$errores;
    }   

    public function todos(): array {
        $query = "SELECT * FROM " . static::$tabla;

        return self::consultar($query);
    }

    public function obtener(int $cantidad, int $saltar): array {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT $cantidad OFFSET $saltar";

        return self::consultar($query);
    }

    public function where(string $columna, string $valor): array {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";

        return self::consultar($query);
    }

    public function borrar(): mysqli|bool {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . $this->id;

        return self::$db->query($query);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getImagen(): Imagen {
        return $this->imagen;
    }
}