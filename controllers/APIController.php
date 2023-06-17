<?php

namespace Controllers;

//Modelos
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;


class APIController{
    
    //Mostramos todos los Servicios mediante API
    public static function index(){

        $servicios = Servicio::all();

        echo json_encode($servicios, JSON_UNESCAPED_UNICODE); //Mostramos en la URL /api/servicios los servicios como archivo .json
    }


    //Guardamos los Datos del Usuario de JavaScript a PHP mediante API http://127.0.0.1:3000/api/citas
    public static function guardar() {

        // Almacena la cita y devuelve el id
        $cita = new Cita($_POST);

        $resultado = $cita->guardar();

        
        $id = $resultado['id'];

        // Almacen la cita y el servicio

        $idServicios = explode(",", $_POST['servicios']);

        

        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => intval($idServicio) 
            ];
            
            
            $citaServicio = new CitaServicio($args);
            debuguear($citaServicio);

            $citaServicio->guardar();
        }
        // Retornamos una respuesta
        $respuesta = [
            'servicios' => $resultado
        ];
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    
    // "api/eliminar"
    public static function eliminar(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Obtenemos el ID del POST (Cita Seleccionada)
            $id_cita = $_POST['id'];

            //Encontramos con el ID la Cita a buscar en la BD
            $cita = Cita::find($id_cita);

            //Eliminamos dicha Cita encontrada
            $cita->eliminar();

            //Redirigimos al usuario a la Pagina de donde vino
            header('Location:' . $_SERVER['HTTP_REFERER']);


        }


    }


}