
<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/">
    
    <!-- Campo de Email -->
    <div class="campo">
        <label for="email">Email:</label>

        <input 
            type="email"
            id="email"
            placeholder="Ingresa Tu Email"
            name="email"
        />
    </div>

    <!-- Campo de Password -->
    <div class="campo">
        <label for="password">Password:</label>

        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Ingresa Tu Contraseña"
        />
    </div>

    <!-- Campo de Enviar -->
    <input 
        type="submit"
        class="boton boton-sesion"
        value="Iniciar Sesión"
    />
    
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear una Nueva Cuenta</a>
    <a href="/olvide">¿Olvidaste la contraseña?</a>
</div>