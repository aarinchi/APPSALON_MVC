<?php 

require __DIR__ . '/../vendor/autoload.php';

//Importamos el Archivo ENV de las Variables de Entorno para Proteger las Credenciales de la BD
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //Especificamos en que direccion se encuentran nuestras Variables
$dotenv->safeLoad(); //Si el archivo .env no existe que no nos marque Error

require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);

