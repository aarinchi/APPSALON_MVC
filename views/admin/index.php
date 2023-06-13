<?php
    $nombre;
    $citas;
    $fecha;
?>

<h1 class="nombre-pagina"> Panel de Administracion</h1>


<!-- Nombre del Usuario y Btn de Cerrar Sesion -->
<?php
    include_once __DIR__ . "/../templates/barra.php";
?>

<h2>Buscar Citas</h2>

<!-- Busqueda de Citas por Fecha -->
<div class="busqueda">

    <form class="formulario">

        <div class="campo">

            <label for="fecha">Fecha: </label>

            <input
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            />

        </div>
    </form>

</div>

<?php //No se Encontro Resultados

    if(count($citas) == 0){ //Cuando no existan citas
        echo '<h2 class="sin-resultado">No se Encontraron Citas<h2/>';
    }

?>

<div id="citas-admin">

    <ul class="citas">

    <?php 

        $idCita_anterior = 0;
        $total = 0;


            foreach($citas as $key => $cita){


                if($idCita_anterior != $cita->id){ //Para que no nos imprima multiples veces la misma cita siempre y cuando sean diferentes
        ?>     
        
        <li>
                <p>ID: <span> <?php echo $cita->id; ?>  </span></p>
                <p>Hora: <span> <?php echo substr($cita->hora,0,5); ?>  </span></p>
                <p>Cliente: <span> <?php echo $cita->cliente; ?>  </span></p>
                <p>E-mail: <span> <?php echo $cita->email; ?>  </span></p>
                <p>Telefono: <span> <?php echo $cita->telefono; ?>  </span></p>

                <h3>Servicios</h3>

                <?php $idCita_anterior = $cita->id; } //FIN del IF ?>

                <p class="servicio"> <?php echo $cita->servicio . " = " . 
                "<span>" . $cita->precio . "$" . "</span>"?>  </p>

                <?php
                    $actual = $cita->id; //Traemos el ID actual de la Cita sobre la que estamos Iterando
                    $proximo = $citas[$key + 1]->id ?? 0; //Al indice sobre el que iteramos le sumamos uno en su campo ID para posicionarnos en el Ultimo Elemento

                    
                    $total = $total + $cita->precio;
                    


                    if(esUltimo($actual, $proximo) == true){ ?>
                        <p class="total"> Total a Cobrar: <span> <?php echo $total ?>$</span> </p>
                        <?php $total = 0; ?>

                        <!-- Boton Eliminar la Cita -->
                        <form action="/api/eliminar" method="POST">

                            <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar">
                            
                        </form>

                    <?php } 

                ?>
                
        
        <?php } //FIN del ForEach?>
        
    </ul>

</div>

<?php

    $script = "<script src='build/js/buscador.js'></script>";

?>