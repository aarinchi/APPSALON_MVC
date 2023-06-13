<?php
    $usuario;
    $alertas;
?>



<h1 class="nombre-pagina">Crear Cuenta</h1>  


<p class="descripcion-pagina">Llena el siguiente formulario para llenar una Cuenta  </p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST"  action="/crear-cuenta">

    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Ingresa Tu Nombre"
            value="<?php echo s($usuario->nombre) ?>"
        />      
    </div>

    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input 
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Ingresa Tu Apellido"
            value="<?php echo s($usuario->apellido) ?>"
        />      
    </div>

    <div class="campo">
        <label for="telefono">Telefono:</label>
        <input 
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Ingresa Tu Telefono"
            value="<?php echo s($usuario->telefono) ?>"
        />      
    </div>

    <div class="campo">
        <label for="email">E-mail:</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Ingresa Tu E-mail"
            value="<?php echo s($usuario->email) ?>"
        />      
    </div>

    <div class="campo">
        <label for="password">Password:</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Ingresa Tu Contraseña"
            value="<?php echo s($usuario->password) ?>"
        />
    </div>

    <!-- Campo de Enviar -->
    <input 
        type="submit"
        class="boton"
        value="Crear Cuenta"
    />

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Iniciar Sesion</a>
    <a href="/olvide">¿Olvidaste la contraseña?</a>
</div>