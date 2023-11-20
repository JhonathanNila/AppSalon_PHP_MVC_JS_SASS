<h1 class="nombre-pagina">Recupera tu Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>
<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
            <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu nuevo Password"
            />
    </div>
    <input type="submit" value="Guardar Nuevo Password" class="boton">
</form>
<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/crear-cuenta">Obtener una cuenta</a>
</div>