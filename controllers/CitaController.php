<?php

namespace Controllers;

use MVC\Router;


class CitaController{
    public static function index(Router $router){

        // session_start();

        isAuth(); //Si no esta definido esta funcion lo retorna a la pagina principal

        $nombre = $_SESSION['nombre'];
        $id = $_SESSION['id'];

        $router->render('cita/index',[
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
}