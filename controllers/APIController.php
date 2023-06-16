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
    public static function guardar(){
        
        // //Almacena la Cita y devuelve el Id
        // $cita = new Cita($_POST);

        // // debuguear($cita);
        
        // $resultado = $cita->guardar(); //Este resultado tiene el Id de la Cita 

        // $id = $resultado['id']; //Obtenemos el Id de la Cita 

        // //Almacena la Cita y el Servicio en la Tabla CitaServicios

        // $servicios = $_POST['servicios'];
        
        // $idServicios = explode(",", $servicios); //Separamos los servicios que nos trajimos del API que esta en String a Arreglo

        // //Almacena los Servicios Con el Id de la Cita
        // foreach($idServicios as $idServicio){ //Para no cometer un error en normalizacion creamos por cada servicio de la cita una columna nueva es decir si tiene 1,2,3 servicios son 3 columnas en la BD
        //     $args = [
        //         'citaId' => $id,
        //         'serviciosId' => $idServicio
        //     ];

        //     $citaServicio = new CitaServicio($args);
        //     $citaServicio->guardar();
        // }

        // //Retornamos una Respuesta en Nuestra API
        // $respuesta = [
        //     'resultado' => $resultado //Accedemos en el servidor al valor de los servicios 
        // ];


        $cita = new Cita($_POST);
 
        $respuesta = [
            'cita' => $cita
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