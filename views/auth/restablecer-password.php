<div class="contenedor restablecer">
    <?php include __DIR__ . '/../template/nombre-sitio.php' ?>

    <div class="contenedor-sm">
    <?php include __DIR__ . '/../template/alertas.php' ?>
    <?php if($mostrarFormulario) : ?>
        <p class="descripcion-pagina">Coloca tu nueva contraseña</p>

        <form class="formulario" method="post">
            <div class="campo">
                <label for="password">Contraseña: </label>
                <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Escribe tu contraseña"
                >
            </div>

            <div class="campo">
                <label for="password2">Repetir Contraseña: </label>
                <input 
                    type="password"
                    id="password2"
                    name="password2"
                    placeholder="Repite tu contraseña"
                >
            </div>

            <input type="submit" class="boton" value="Restablecer Contraseña">
        </form>
        <?php endif ?>
    </div>
</div>