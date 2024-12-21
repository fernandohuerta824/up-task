<?php include __DIR__ . '/header.php' ?>

<div class="contenedor-sm">
    <?php include __DIR__ . '/../template/alertas.php' ?>

    <a href="/perfil" class="enlace">Volver al perfil</a>

    <form method="POST" class="formulario">
        <div class="campo">
            <label for="currentPassword">Contraseña actual: </label>
            <input 
                type="password"
                id="currentPassword"
                name="currentPassword"
                placeholder="Escribe tu contraseña actual"
            >
        </div>

        <div class="campo">
            <label for="newPassword">Contraseña nueva: </label>
            <input 
                type="password"
                id="newPassword"
                name="newPassword"
                placeholder="Escribe tu contraseña nueva"
            >
        </div>

        <div class="campo">
            <label for="newPassword2">Confirmar contraseña: </label>
            <input 
                type="password"
                id="newPassword2"
                name="newPassword2"
                placeholder="Escribe tu contraseña nueva de nuevo"
            >
        </div>

        <input type="submit" class="boton" value="Guardar Cambios">
    </form>
</div>

<?php include __DIR__ . '/footer.php' ?>