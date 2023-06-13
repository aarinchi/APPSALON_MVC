<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController{

    //Index Servicios (Mostrar Servicios)
    public static function index(Router $router){ // "/servicios"

        isadmin();

        $nombre = $_SESSION['nombre'];

        $servicios = Servicio::all();


        $router->render('servicios/index',[
            'nombre' => $nombre,
            'servicios' => $servicios
        ]);

    }

    //Crear Servicios
    public static function crear(Router $router){ // "/servicios/crear"

        isadmin();

        $nombre = $_SESSION['nombre'];
        $servicio = new Servicio();
        $alertas = [];
        

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $servicio->sincronizar($_POST);
            
            $alertas = $servicio->validar(); //Retorna Alertas de los Errores

            if(empty($alertas)){ //Si alertas esta vacio significa que no hay errores
                //Guardamos el Servicio
                $servicio->guardar();
                header('Location: /servicios');
            }     

        }


        $router->render('servicios/crear',[
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);

    }

    //Actualizar Servicios
    public static function actualizar(Router $router){ // "/servicios/actualizar"

        isadmin();

        $nombre = $_SESSION['nombre'];
        $alertas = [];
        $id = $_GET['id']; //Debe Haber unicamente numeros en la URL

        if(!is_numeric($id) || !$id){ //Si el ID en la URL no esta definido lo retornamos 
            header('Location: /servicios');
        }

        $servicio = Servicio::find($id);

        if(!$servicio){ //Si no Encuentra al Servicio entonces lo retorna
            header('Location: /servicios');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }

            
    
        }

        $router->render('/servicios/actualizar',[
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    //Eliminar Servicios
    public static function eliminar(){

        isadmin();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $id = $_POST['id'];
            
            $servicio = Servicio::find($id);

            if($servicio){
                $servicio->eliminar();
                header('Location: /servicios');
            }
     
        }

    }


}