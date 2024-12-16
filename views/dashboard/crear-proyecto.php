<?php include __DIR__ . '/header.php' ?>

    <div class="contenedor-sm">
        <?php include __DIR__ . '/../template/alertas.php' ?>

        <form class="formulario" method="post">
            <?php include __DIR__ . '/formulario-proyecto.php' ?>
            <input type="submit" class="boton" value="Crear Proyecto">
        </form>
    </div>

<?php include __DIR__ . '/footer.php' ?>