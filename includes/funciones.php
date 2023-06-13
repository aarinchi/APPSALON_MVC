<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Funcion que verifica que la Cita este en el Final
function esUltimo($actual, $proximo) : bool{
    
    if($actual != $proximo){ //Estamos en el ultimo elemento
        return true;
    }else{
        return false; //No estamos aun en el ultimo Elemento
    }
}

//Funcion que Revisa que el usuario se encuentre Autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){ //Si no esta definida la Sesion significa que no tiene acceso
        header('Location: /');
    }
}

function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}