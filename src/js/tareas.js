(function(){
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    const estados = {
        0: 'Pendiente',
        1: 'Completa'
    }

    /**
     * 
     * @param {{id: int|string, nombre: string}} tarea 
     */
    const editarTarea = async tarea => {
        try {
            const body = new FormData();
            body.append('id', tarea.id);
            body.append('nombre', tarea.nombre);
            body.append('proyectoId', obtenerIdProyecto());

            const resultado = await fetch('/api/tarea/nombre', {
                method: 'POST',
                body
            })
            const datos = await resultado.json();
            
            if(resultado.status !== 200)
                return mostrarAlerta(datos.mensaje, 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)

            const p = document.querySelector(`.tarea[data-id="${tarea.id}"] p`)

            p.textContent = tarea.nombre;
        } catch (error) {
            console.log(error)
            return mostrarAlerta('Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte', 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)
            
        }
        
    }

    /**
     * @param {{id: int|string, nombre: string}} tareaEditar 
     * @param {boolean} editar 
     */
    const mostrarFormulario = (editar = false, tareaEditar = null) => {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML =` 
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Edita el nombre de la tarea' :  'Añande una nueva tarea'}</legend>
                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input
                        type="text"
                        name="tarea"
                        id="tarea"
                        placeholder="${editar ? 'Nuevo nombre' : 'Nueva tarea al proyecto'}"
                        value="${editar ? tareaEditar.nombre : ''}"
                    />
                </div>
                <div class="opciones">
                    <button type="button" class="submit-nueva-tarea">${editar ? 'Editar nombre': 'Añadir tarea'}</button>
                    <button type="button" class="cerrar-modal" value="Añadir tarea">Cancelar</button>

                </div>
            </form>
        `;

        document.querySelector('.dashboard').appendChild(modal);
        const tareaInput = document.querySelector('#tarea');
        const form = document.querySelector('.formulario');
        setTimeout(() => {
            form.classList.add('animar');
        }, 0);

        modal.addEventListener('click', async e  => {
            e.preventDefault();
            if(e.target.classList.contains('modal') || e.target.classList.contains('cerrar-modal')) {
                form.classList.remove('animar')
                setTimeout(() => modal.remove(), 300);
            }

            if(e.target.classList.contains('submit-nueva-tarea')) {
                const tarea = tareaInput.value.trim();
                if(!tarea) {
                    mostrarAlerta('El nombre es obligatorio', 'error', form.querySelector('.campo'));
                    return;
                }
                if(editar)
                    editarTarea({id: tareaEditar.id, nombre: tarea})
                else 
                    agregarTarea(tarea);
                
                form.classList.remove('animar')
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        })
    }

    /**
        * @param {string} mensaje
        * @param {string} tipo 
        * @param {HTMLElement|Element} ref 
        * @param {int} segundos 
        * 
    */
    const mostrarAlerta = (mensaje, tipo, ref, segundos = 3000) => {
        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        ref.insertAdjacentElement('beforebegin',alerta);
        setTimeout(() => alerta.remove(), segundos * 1000);
    }
    
    /**
     * 
     * @returns {string}
     */
    const obtenerIdProyecto = () => {
        const proyectoParams = new URLSearchParams(window.location.search);
        const { id } = Object.fromEntries(proyectoParams.entries())
        return id;
    }

    /**
     * 
     * @param {{id: int, nombre: string, estado: int, proyectoId: int}} tarea 
     * @returns {Promise<int|null>}
     *  
     */
    const cambiarTarea = async tarea => {
        const body = new FormData();
        body.append('nombre', tarea.nombre);
        body.append('id', tarea.id);
        body.append('proyectoId', tarea.proyectoId);


        try {
            const resultado = await fetch('/api/tarea/actualizar', {
                method: 'POST',
                body,
            })

            const datos = await resultado.json();
            
            if(resultado.status !== 200) {
                mostrarAlerta(datos.mensaje, 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)
                return null;
            }

            return datos.estado;
        } catch(error) {
            mostrarAlerta('Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte', 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)
            return null;
        }
    }

    /**
     * 
     * @param {{id: int, nombre: string, estado: int, proyectoId: int}} tarea 
     * @returns {boolean}
     */
    const confirmarEliminarTarea = tarea => {
        Swal.fire({
            title: "¿Eliminar tarea?",
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: 'No',
            width: '350px'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire("Tarea Eliminada", "", "success");
                eliminarTarea(tarea);
            } 
          }); 
    }

    /**
     * 
     * @param {{id: int, nombre: string, estado: int, proyectoId: int}} tarea 
     * 
     */
    const eliminarTarea = async tarea => {
        try {
            const body = new FormData();
            body.append('id', tarea.id);
            body.append('proyectoId', tarea.proyectoId);
    
            const resultado = await fetch('/api/tarea/eliminar', {
                method: 'POST',
                body,
            })
    
            
            const datos = await resultado.json();
            if(resultado.status !== 200) 
                return mostrarAlerta(datos.mensaje, 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)

            const tareaDiv = document.querySelector(`.tarea[data-id="${tarea.id}"]`);
            tareaDiv.remove();
            console.log(datos);
        } catch(error) {
            console.log(error);
            mostrarAlerta('Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte', 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)
        }

    }

    /**
     * 
     * @param {{id: int, nombre: string, estado: int, proyectoId: int}} tarea 
     * @param {HTMLElement|Element} ref 
     */
    const mostrarTarea = (tarea, ref) => {
        const tareaLI = document.createElement('LI');
        tareaLI.dataset.id = tarea.id;
        tareaLI.classList.add('tarea');

        const nombreTarea = document.createElement('P');
        nombreTarea.textContent = tarea.nombre;
        nombreTarea.addEventListener('dblclick', async e => {
            mostrarFormulario(true, {id: tarea.id, nombre: tarea.nombre});
            const url = '/api/tareas?id=' + obtenerIdProyecto();

            const resultado = await fetch(url);

            const datos = await resultado.json();

            if(resultado.status !== 200)
                return;

            const { tareas } = datos;

            mostrarTareas(tareas);
        })

        const opciones = document.createElement('DIV');
        opciones.classList.add('opciones');

        const btnEstado = document.createElement('BUTTON');
        btnEstado.classList.add('estado-tarea', `${estados[tarea.estado].toLowerCase()}`)
        btnEstado.dataset.estado = tarea.estado;
        btnEstado.dataset.id = tarea.id;
        btnEstado.textContent = estados[tarea.estado];
        
        btnEstado.addEventListener('dblclick', async e => {
            const estado = await cambiarTarea(tarea);
            if(estado === null) return
            const oldEstado = estado === 0 ? 1 : 0;
            btnEstado.classList.remove(`${estados[oldEstado].toLowerCase()}`)
            btnEstado.classList.add(`${estados[estado].toLowerCase()}`)
            btnEstado.textContent = estados[estado];
        })

        const btnEliminar = document.createElement('BUTTON');
        btnEliminar.classList.add('eliminar-tarea');
        btnEliminar.dataset.id = tarea.id;
        btnEliminar.textContent = 'Eliminar';
        btnEliminar.addEventListener('click',  e => {
            confirmarEliminarTarea(tarea)
        })


        opciones.append(btnEstado, btnEliminar)
        tareaLI.append(nombreTarea, opciones);
        ref.append(tareaLI);
    }
    
    /**
     * 
     * @param {[{
     * id : int, 
     * estado: int, 
     * nombre: string, 
     * proyectoId: int}
     * ]} tareas 
     */
    const mostrarTareas = tareas => {
        const listadoTareas = document.querySelector('#listado-tareas');
        if(tareas.length === 0) {
            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No hay tareas';
            textoNoTareas.classList.add('no-tareas');
            listadoTareas.append(textoNoTareas);
            return;
        }

        listadoTareas.innerHTML = '';
        tareas.forEach(t => {
            mostrarTarea(t, listadoTareas);
        })
        
    }

    (async function(){
        try {
            const url = '/api/tareas?id=' + obtenerIdProyecto();

            const resultado = await fetch(url);

            const datos = await resultado.json();

            if(resultado.status !== 200)
                return;

            const { tareas } = datos;

            mostrarTareas(tareas);
        } catch(error) {
        }
    })()

    /**
     * 
     * @param {string} tarea 
     */
    const agregarTarea = async tarea => {
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('url', obtenerIdProyecto());

        try {
            const res = await fetch('/api/tarea', {
                method: 'POST',
                body: datos
            })
            const data = await res.json();
            if(res.status !== 201)
                return mostrarAlerta(data.mensaje, 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)

            const { datos: tareaObj } = data;
            mostrarTarea(tareaObj, document.querySelector('#listado-tareas'));

        } catch(error) {
            mostrarAlerta('Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte', 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)
        }
    }

    nuevaTareaBtn.addEventListener('click', e => {
        mostrarFormulario();
    })
})()