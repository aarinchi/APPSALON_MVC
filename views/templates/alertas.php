
<?php 

    foreach ($alertas as $key => $mensajes) : //$key = [alerta_errores] $mensaje = [mensaje-de-errores]

        foreach($mensajes as $mensaje) : //Recorremos los mensajes de los errores
 
?>

        <div class="alerta <?php echo $key; ?>">
        <?php echo $mensaje; ?>
        </div>

<?php 
        endforeach;
    endforeach;
 ?>

