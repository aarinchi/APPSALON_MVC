<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{

    public static function index(Router $router){
        
        isAdmin();

        date_default_timezone_set('America/Mexico_City');
        //Fecha Seleccionada por el Usuario
        $fecha = $_GET['fecha'] ?? date('Y-m-d');


        $fecha = explode('-', $fecha); //Con explode separamos en php por el -

        if(!checkdate($fecha[1] , $fecha[2] , $fecha[0])){ //Si es false entonces la fecha es incorrecta tiene un formato incorrecto
            header('Location: /404');
        }
        
        $fecha = implode('-', $fecha); //Ya verificada la Fecha correcta lo cambiamos nuevamente a String

        $nombre = $_SESSION['nombre'];

        //Consultar a la BD //Union de Todas las Tablas que Necesitamos Y Campos que Necesitamos con LEFT JOIN
        $consulta =  "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId = usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId = citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id = citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        //Realiza la Consulta a la BD y nos trae el Resultado (Todas las Citas que Tenemos en la BD)
        $citas = AdminCita::SQL_Plano($consulta); //Consulta Plana


        $router->render('admin/index', [
            'nombre' => $nombre,
            'citas' => $citas,
            'fecha' => $fecha

        ]);
    }
}
