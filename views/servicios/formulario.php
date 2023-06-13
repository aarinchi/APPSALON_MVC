
<div class="campo">

    <label for="nombre">Nombre:</label>
    <input
        type="text"
        id="nombre"
        name="nombre"
        value="<?php echo $servicio->nombre ?>"
        placeholder="Nombre Servicio"
    />

</div>

<div class="campo">

    <label for="precio">Precio:</label>
    <input
        type="number"
        value="<?php echo $servicio->precio ?>"
        step="0.01"
        min = "0"
        max = "99"
        id="precio"
        name="precio"
        placeholder="Precio Servicio"
    />

</div>