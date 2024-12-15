<?php foreach($errores as $key => $error) : ?>
    <?php foreach($error as $mensaje) : ?>
        <div class="alerta<?php echo ' ' . $key ?>">
            <?php echo $mensaje ?>
        </div>
    <?php endforeach ?>
<?php endforeach ?>