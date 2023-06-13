<?php
    $nombre;
    $servicio; //Objeto
    $alertas;
?>

<h1 class="nombre-pagina">Actualizar el Servicio</h1>


<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST">

    <?php include_once __DIR__ . '/formulario.php' ?>

    <input type="submit" class="boton-sesion" value=" Actualizar Servicio">

</form>