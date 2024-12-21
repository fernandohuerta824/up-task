<?php include __DIR__ . '/header.php' ?>

<div class="contenedor-sm">
    <?php include __DIR__ . '/../template/alertas.php' ?>

    <a href="/cambiar-password" class="enlace">Cambiar contraseña</a>

    <form method="" class="formulario">
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

        <input type="submit" class="boton" value="Guardar Cambios">
    </form>
</div>

<?php include __DIR__ . '/footer.php' ?>