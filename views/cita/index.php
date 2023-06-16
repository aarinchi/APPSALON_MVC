<?php
    $nombre;
    $id;
?>

<h1 class="nombre-pagina">Crear Nueva Cita</h1>

<?php
    include_once __DIR__ . "/../templates/barra.php";
?>

<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>



<div id="app">

    <nav class="tabs">

        <button  type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion de la Cita</button>
        <button type="button" data-paso="3">Resumen</button>

    </nav>

    <!-- PASO 1 (SERVICIOS) -->
    <div id="paso-1" class="seccion">

        <h2>Servicios</h2>
        <p class="text-center">Elige tus Servicios a Continuación</p>

        <!-- Listado de los Servicios -->
        <div id="servicios" class="Listado-Servicios"></div>

    </div>

    <!-- PASO 2 (AGENDAR CITA) -->
    <div id="paso-2" class="seccion">

        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y la fecha de tu cita: </p>

        <!-- Este formulario no Lleva ni action ni method ya que lo controlaremos desde JavaScript -->
        <form class="formulario">

            <div class="campo">

                <label for="nombre">Nombre </label>
                <input 
                    type="text" 
                    name="nombre" 
                    id="nombre"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>

            <div class="campo">

                <label for="nombre">Fecha </label>
                <input 
                    type="date" 
                    name="fecha" 
                    id="fecha"
                    min = <?php echo date('Y-m-d'); ?>
                    max = <?php echo date('Y-12-31');?> 
                />
            </div>    

            <div class="campo">

                <label for="hora">Hora </label>
                <input 
                    type="time" 
                    name="hora" 
                    id="hora"
                />
            </div>
            
            <input type="hidden" id="id" value="<?php echo $id ?>">

            
        </form>

    </div>


    <!-- PASO 3  (RESUMEN CITA)-->
    <div id="paso-3" class="seccion contenido-resumen">

        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta </p>

    </div>

    <!-- PAGINACION ADELANTE-ANTERIOR  -->
    <div class="paginacion">

        <!-- Boton Anterior -->
        <button class="boton" id="anterior" >&laquo; Anterior </button> <!-- La entidad &laquo; pone dos flechas a la izquierda << haciendo referencia a un paso Anterior -->

        <!-- Boton Siguiente -->
        <button class="boton" id="siguiente">Siguiente &raquo; </button>

    </div>
    

</div>

<!-- IMPORTAMOS EL SCRIPT A TODO NUESTRO DOCUMENTO  -->
<?php

    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";

?>