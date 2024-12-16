<div class="contenedor login">
    <?php include __DIR__ . '/../template/nombre-sitio.php' ?>
    
    <div class="contenedor-sm">
    <?php include __DIR__ . '/../template/alertas.php' ?>

        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="post">
            <div class="campo">
                <label for="email">Email: </label>
                <input 
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Escribe tu email"
                    value="<?php echo $email ?>"
                >
            </div>

            <div class="campo">
                <label for="password">Contraseña: </label>
                <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Escribe tu contraseña"
                >
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? obtener una</a>
            <a href="/olvidar-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>