<aside class="sidebar">
    <h2>UpTask</h2>

    <div class="sidebar-nav">
        <a class="<?php echo $titulo === 'Dashboard' ? 'activo' : '' ?>"  href="/dashboard">Proyectos</a>
        <a class="<?php echo $titulo === 'Crear proyecto' ? 'activo' : ''  ?>"  href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo $titulo === 'Perfil' ? 'activo' : ''  ?>"  href="/perfil">Perfil</a>
    </div>

    <div class="cerra-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesion</a>
    </div>
</aside>