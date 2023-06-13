<?php

namespace Model;

class Usuario extends ActiveRecord{

    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'password', 'email', 'telefono', 'admin', 'confirmado', 'token']; //Sirve para crear el Arreglo Asociativo

    //Para crear la Plantilla del Objeto
    public $id;
    public $nombre;
    public $apellido;
    public $password;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';       
    }

    /**** Mensajes de validacion para la Creacion de una cuenta ****/

    public function Validar_Nueva_Cuenta(){

        //Se crea dentro de un arreglo de error porque va haber 2 Tipos de Alertas (Una de Errores y Otras de Alertas Exitosas)

        /** Alerta-Nombre ***/
        if(!$this->nombre){ //Si no existe un Nombre entonces
           self::$alertas['error'][] = 'Ingresar su Nombre es Obligatorio'; //El arreglo asociativo se llama error y lo agregamos al final
        }

        /** Alerta-Apellido ***/
        if(!$this->apellido){ 
            self::$alertas['error'][] = 'Ingresar su Apellido es Obligatorio'; 
        }
        
        /** Alerta-Telefono ***/
        if(!$this->telefono){ 
            self::$alertas['error'][] = 'Ingresar su Teléfono es Obligatorio'; 
        }else if(!preg_match('/^[0-9]{10}$/', $this->telefono)){  // El simbolo ^$ significa que debe cumplir en toda la longitud de la cadena
            self::$alertas['error'][] = 'La longitud de su Telefono debe ser de 10 Numeros'; 
        } 

        /** Alerta-E-mail ***/
        if(!$this->email){ 
            self::$alertas['error'][] = 'Ingresar su E-mail es Obligatorio'; 
        }

        /** Alerta-Password ***/
        if(!$this->password){ 
            self::$alertas['error'][] = 'Ingresar su Contraseña es Obligatoria'; 
        }else if(strlen($this->password) < 6){  //Si la longitud de la Contraseña es menor a 6 entonces
            self::$alertas['error'][] = 'Su contraseña es demasiado Corta intente de Nuevo';
        }else if(!preg_match('/.*[A-Z].*/',$this->password)){ 
            self::$alertas['error'][] = 'Su contraseña Debe contener almenos una Letra Mayuscula';
        }
        
        return self::$alertas;
    }

    /**** Mensajes de validacion para el Login de una cuenta ****/

    public function validar_login(){
        if(!$this->email){
            self::$alertas['error'][] = 'Ingresar su E-mail es Obligatorio'; 
        }

        if(!$this->password){ 
            self::$alertas['error'][] = 'Ingresar su Contraseña es Obligatoria'; 
        }

        return self::$alertas;
    }

    /**** Mensajes de validacion para la Recuperacion de una cuenta ****/

    public function validar_email(){

        if(!$this->email){
            self::$alertas['error'][] = 'Ingresar su E-mail es Obligatorio'; 
        }

        return self::$alertas;
    }

    /**** Mensajes de validacion para Validar la Nueva Contraseña ****/

    public function validar_password(){
        /** Alerta-Password ***/
        if(!$this->password){ 
            self::$alertas['error'][] = 'Ingresar su Contraseña es Obligatoria'; 
        }else if(strlen($this->password) < 6){  //Si la longitud de la Contraseña es menor a 6 entonces
            self::$alertas['error'][] = 'Su contraseña es demasiado Corta intente de Nuevo';
        }else if(!preg_match('/.*[A-Z].*/',$this->password)){ 
            self::$alertas['error'][] = 'Su contraseña Debe contener almenos una Letra Mayuscula';
        }

        return self::$alertas;
    }

    
    /**** Revisa si el Usuario Existe ****/

    public function Existe_Usuario(){

        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email ."' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){ //Si existe un resultado es decir es correta la sentencia SQL entonces
            self::$alertas['error'][] = "Este Usuario Ya Existe en Nuestra Base de Datos";
        }

        return $resultado;
    }

    /**** Hashear la contraseña del Usuario ****/

    public function Hash_Password(){
        
        $pass_old= $this->password;

        $this->password = password_hash($pass_old, PASSWORD_BCRYPT); //Sobreescribimos la Contraseña antigua por la Nueva pero Hasheada
    }

    /**** Generar un Nuevo Token (Seguridad Email) ****/

    public function Generar_Token(){

        $this->token = uniqid();
        
    }

    /**** Comprobar Password y Verificacion por E-mail es decir que Este Confirmado ****/

    public function Comprobar_Password_Verificacion_Email($password_user){


        $resultado_password = password_verify($password_user,$this->password);

        // debuguear($this);

        if(($resultado_password == false) || (!$this->confirmado)){ //Significa que el Password es Incorrecto o Aun no verifica su Cuenta
           return false;
        }else{ //Significa que el Password y la Verificacion es Correcta
            return true;
        }
    }

}