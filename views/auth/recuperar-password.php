<?php
    $alertas;
    $error;
?>
<h1 class="nombre-pagina"> Recuperar Password</h1>

<p class="descripcion-pagina">Coloca tu nuevo password a Continuación</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php 

    if($error == false){  //El Formulario se Mostrara Unicamente cuando el Token sea Valido ?>
    
        <form class="formulario" method="POST">

            <!-- Campo de Email -->
            <div class="campo">
                <label for="password">Password:</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Ingresa Tu Nueva Contraseña"
                    name="password"
                />
            </div>

        <input type="submit" class="boton" value="Guardar Nueva Contraseña">

    </form>
<?php    } ?>




<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">¿Aun no Tienes una Cuenta?</a>
</div>