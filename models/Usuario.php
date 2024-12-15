<?php

namespace Model;
 
class Usuario extends ActiveRecord {
    protected static string $tabla = 'usuarios';

    protected static array $columnas = ['nombre', 'email', 'password', 'token', 'confirmado'];

    public string $nombre;
    public string $email;
    public string $password;
    public string $password2;
    public string $token;
    public int $confirmado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    public function validarNuevaCuenta(): array {
        if(strlen($this->nombre) < 5)
            self::$errores['error'][] = 'Tu nombre deber tener al menos 5 caracteres';

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            self::$errores['error'][] = 'Ingresa un email que sea valido';
        else if($this->where('email', $this->email)) 
            self::$errores['error'][] = 'El email ya esta registrado, use otro';
        
        if(strlen($this->password) < 8)
            self::$errores['error'][] = 'La contraseña debe tener al menos ocho caracteres';

        if($this->password !== $this->password2) 
            self::$errores['error'][] = 'Las contraseñas no coinciden';


        return self::$errores;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid(rand());
    }
}