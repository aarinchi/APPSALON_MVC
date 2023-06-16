<?php

namespace Model;

class CitaServicio extends ActiveRecord{
        
    //Base de Datos     
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'citaId', 'servicioId'];

    public $id;
    public $citaId;
    public $serviciosId;

    public function __construct($args = []){
        $this->id = $args['id']  ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->serviciosId = $args['servicioId'] ?? '';
    }

}