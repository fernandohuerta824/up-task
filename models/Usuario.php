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

    public function validarEmail(): array {
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            self::$errores['error'][] = 'Ingresa un email que sea valido';
        
        return self::$errores;
    }

    public function validarPassword(): array {
        if(strlen($this->password) < 8)
            self::$errores['error'][] = 'La contraseña debe tener al menos ocho caracteres';

        if($this->password !== $this->password2) 
            self::$errores['error'][] = 'Las contraseñas no coinciden';
        
        return self::$errores;
    }

    public function validarLogin(): array {
        $credencialesValidas = true;
        if(strlen($this->password) < 8) {
            self::$errores['error'][] = 'La contraseña debe tener al menos ocho caracteres';
            $credencialesValidas = false;
        }
    
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores['error'][] = 'Ingresa un email que sea valido';
            $credencialesValidas = false;
        }

        if($credencialesValidas) {
            $usuario = $this->where('email', $this->email);
            if(!$usuario || $usuario->confirmado === 0 || !password_verify($this->password, $usuario->password))
                self::$errores['error'][] = 'Email y/o contraseña no validos, o cuenta no confirmada';
            else {
                session_start();
                $_SESSION['id'] = $usuario->id;
                $_SESSION['nombre'] = $usuario->nombre;
                $_SESSION['email'] = $usuario->email;
            }
        }

        return self::$errores;
    }

    public function validarPerfil(): array {
        $datosValidos = true;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores['error'][] = 'Ingresa un email que sea valido';
            $datosValidos = false;
        }

        if(!$this->nombre) {
            self::$errores['error'][] = 'El nombre es obligatorio';
            $datosValidos = false;
        }

        if($datosValidos) {
            $email = s($this->email);
            $usuario = Usuario::SQL("SELECT * FROM usuarios WHERE email = '$email' AND id != $this->id");

            if(count($usuario)) 
                self::$errores['error'][] = 'El correo ya existe';           
        }
        return self::$errores;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid(rand());
    }
}