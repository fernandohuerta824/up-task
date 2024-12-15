<div class="contenedor crear">
    <?php include __DIR__ . '/../template/nombre-sitio.php' ?>
    <?php include __DIR__ . '/../template/alertas.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <form class="formulario" method="post">
            <div class="campo">
                <label for="nombre">Nombre: </label>
                <input 
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Escribe tu nombre"
                    value="<?php echo $usuario->nombre ?>"
                >
            </div>

            <div class="campo">
                <label for="email">Email: </label>
                <input 
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Escribe tu email"
                    value="<?php echo $usuario->email ?>"
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

            <div class="campo">
                <label for="password2">Repetir Contraseña: </label>
                <input 
                    type="password"
                    id="password2"
                    name="password2"
                    placeholder="Repite tu contraseña"
                >
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesion</a>
            <a href="/olvidar-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>