<?php include __DIR__ . '/header.php' ?>

    <?php if(!count($proyectos)):  ?>
        <div class="no-proyectos">
            <p>No hay proyectos aun</p>
            <a href="/crear-proyecto" class="boton">Crea un proyecto</a>
        </div>
    <?php endif ?>

    <?php if(count($proyectos)):  ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $p) : ?>
                <li>
                    <a class="proyecto" href="/proyecto?id=<?php echo $p->url ?>">
                        <?php echo $p->nombre ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

<?php include __DIR__ . '/footer.php' ?>
