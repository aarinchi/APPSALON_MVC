<?php
namespace Model;
class ActiveRecord {

    //Base de Datos
    protected static $db; //Es static solo puede ser accedido por la clase no por la instancia 
    protected static $columnasDB = []; //Hacemos referencia los datos que vamos a sanitizar a traves de la Programacion Orientada a Objetos
    protected static $tabla = ''; //Es para heredar la Clase Principal utlizar los mismos metodos e identificar por cada clase (propiedad,vendedores)
 
    //Variables
    public $id;

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }


    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    //Metodo que Sanitiza los valores del Objeto
    public function sanitizarAtributos(){ //Se va a encargar de sanitizar los atributos

        $atributos = $this->atributos();
        $sanitizado = [];


        foreach ($atributos as $llaves => $contenido) { //De esta forma recorremos un arreglo asociativo y obtenemos tanto la propiedad como su valor 
            $sanitizado[$llaves] = self::$db->escape_string($contenido);
        }

        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {

        $resultado = '';
        
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;

    }


    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
    
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
    
        // liberar la memoria
        $resultado->free();
    
        // retornar los resultados
        return $array;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }


    // Obtener Registros con cierta cantidad
    public static function get($limite) {

        $query = "SELECT * FROM " . static::$tabla . " LIMIT $limite";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    //Busca por un elemento en Concreto de la BD
    public static function find_specific($columna, $valor) {
        
        $query = "SELECT * FROM " . static::$tabla  ." WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    //Consulta Plana de SQL (Utilizar cuando los metodos del modelo no son suficientes)
    public static function SQL_Plano($query) {
 
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    // crea un nuevo registro
    public function crear() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        // return json_encode(['query' => $query]); //Retornamos el resultado de nuestra consulta para podeer Determinar Posibles Errores

        // Resultado de la consulta
        $resultado = self::$db->query($query); //Retorna True o False

        
        return [
           'query' => $query,
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    //Metodo Actualizar
    public function actualizar(){

        //Sanitizar los Datos
        $atributos = $this->sanitizarAtributos(); //Arreglo con los Datos del Objeto Sanitizados

        $valores = [];


        foreach ($atributos as $key => $valor) {
            $valores[] = "{$key}='{$valor}'";
        }

        $valores_string = join(', ', $valores);

        $query = "UPDATE " . static::$tabla  . " SET ";
        $query .=  $valores_string;
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }
    
}
