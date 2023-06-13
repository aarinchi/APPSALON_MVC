<?php
    $nombre;
    $servicios;
?>

<h1 class="nombre-pagina">Administración de Servicios</h1>


<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">

    
    <?php foreach($servicios as $servicio){  ?>
       
        <div class="servicio-listado">

            <li>
                <p>Nombre: <span> <?php echo $servicio->nombre ?> </span></p>
                <p>Precio: <span> <?php echo $servicio->precio ?> $ </span></p>
            </li>

            <div class="acciones">

                <a class="icono-actualizar" href="/servicios/actualizar?id=<?php echo $servicio->id ?>">
                    <img src="build/img/cohete-celeste.png" alt="">
                </a>
            
                <!-- Mandamos por POST el ID a Eliminar  -->
                <form action="/servicios/eliminar" method="POST">

                    <!-- Input envia el ID -->
                    <input type="hidden" name="id" value="<?php echo $servicio->id ?>">

                    <!-- Input para dar el Click -->
                    <button class="servicio-eliminar" type="submit">
                        <img src="build/img/borrar-icono.png">
                    </button>

                </form>
            
            </div>

        </div>
        
    <?php } ?>

</ul>