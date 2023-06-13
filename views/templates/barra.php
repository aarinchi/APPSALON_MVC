<?php
    $nombre;
?>
<!-- MOSTRAMOS EL NOMBRE DEL USUARIO BARRA-->

<div class="barra">
    <p class="descripcion-usuario"> <span>Hola:</span> <?php echo $nombre ?? ''?></p>

    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>


<?php if(isset($_SESSION['admin'])){ ?>

        <div class="barra-servicios">

            <a class="boton" href="/admin">Ver Citas</a>
            <a class="boton" href="/servicios">Ver Servicios</a>
            <a class="boton" href="/servicios/crear">Nuevo Servicio</a>

        </div>

<?php } ?>