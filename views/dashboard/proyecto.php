<?php include __DIR__ . '/header.php' ?>

    <div class="contenedor-sm">
        <div class="contenedor-nueva-tarea">
            <button type="button" class="agregar-tarea" id="agregar-tarea">
               <span>&#43;</span>  Nueva Tarea
            </button>
        </div>

        <ul id="listado-tareas">
            
        </ul>
    </div>

<?php include __DIR__ . '/footer.php' ?>

<?php $script = '<script src="build/js/tareas.js"></script>' ?>