<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Reestablece tu Password escribiendo Tu Email</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/olvide" method="POST">

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

    <!-- Campo de Enviar -->
    <input 
        type="submit"
        class="btn-restablecer boton"
        value="Reestablecer Contraseña"
    />

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una Cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">¿Aun no Tienes una Cuenta?</a>
</div>