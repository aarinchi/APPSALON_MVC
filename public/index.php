<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

/****** Login del Usuario ******/
//Iniciar Sesion
$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);

//Cierre de Sesion
$router->get('/logout',[LoginController::class, 'logout']);

//Recuperar Password

$router->get('/olvide',[LoginController::class, 'olvide']);
$router->post('/olvide',[LoginController::class, 'olvide']);

//Recuperar Password | Escribir Nueva Contraseña
$router->get('/recuperar',[LoginController::class, 'recuperar']);
$router->post('/recuperar',[LoginController::class, 'recuperar']);

//Crear Cuenta 
$router->get('/crear-cuenta',[LoginController::class, 'crear']);
$router->post('/crear-cuenta',[LoginController::class, 'crear']);

//Confirmar Cuenta
if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $router->get("/confirmar-cuenta?token=$token", [LoginController::class, "confirmar"]);
    $router->post("/confirmar-cuenta?token=$token", [LoginController::class, "confirmar"]);
    }else{
    $router->get("/confirmar-cuenta", [LoginController::class, "confirmar"]);
    $router->post("/confirmar-cuenta", [LoginController::class, "confirmar"]);
}
// $router->get('/confirmar-cuenta',[LoginController::class, 'confirmar']);

$router->get('/mensaje',[LoginController::class, 'mensaje']);

/********* Area Privada *********/
$router->get('/cita',[CitaController::class, 'index']);
$router->get('/admin',[AdminController::class, 'index']);

//Api de Citas 
$router->get('/api/servicios',[APIController::class, 'index']);
$router->post('/api/citas',[APIController::class, 'guardar']);
$router->post('/api/eliminar',[APIController::class, 'eliminar']);

//CRUD de Servicios
$router->get('/servicios',[ServicioController::class, 'index']);

$router->get('/servicios/crear',[ServicioController::class,'crear']);
$router->post('/servicios/crear',[ServicioController::class,'crear']);

$router->get('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class,'actualizar']);

$router->post('/servicios/eliminar',[ServicioController::class,'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();