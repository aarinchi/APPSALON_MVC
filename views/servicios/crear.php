<?php
    $nombre;
    $servicio; //Objeto
    $alertas;
?>

<h1 class="nombre-pagina">Nuevo Servicio</h1>


<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" action="/servicios/crear" method="POST">

    <?php include_once __DIR__ . '/formulario.php' ?>

    <input type="submit" class="boton-sesion" value=" Crear Servicio">

</form>