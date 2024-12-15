<div class="contenedor olvidar">
    <?php include __DIR__ . '/../template/nombre-sitio.php' ?>
    
    <div class="contenedor-sm">
        <?php include __DIR__ . '/../template/alertas.php' ?>
        <p class="descripcion-pagina">Ingresa tu email para enviarte instrucciones</p>

        <form class="formulario" method="post">
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

            <input type="submit" class="boton" value="Enviar Correo">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesion</a>
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? obtener una</a>
        </div>
    </div>
</div>