(function(){
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');

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

        } catch(error) {
            mostrarAlerta('Algo salio mal, intentelo de nuevo, si el problema persiste contacte al soporte', 'error', document.querySelector('.contenido .contenedor-nueva-tarea'), 6)
        }
    }

    nuevaTareaBtn.addEventListener('click', e => {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML =` 
            <form class="formulario nueva-tarea">
                <legend>Añande una nueva tarea</legend>
                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input
                        type="text"
                        name="tarea"
                        id="tarea"
                        placeholder="Nueva tarea al proyecto"
                    />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir tarea"/>
                    <button type="button" class="cerrar-modal" value="Añadir tarea">Cancelar</button>

                </div>
            </form>
        `;

        document.querySelector('.dashboard').appendChild(modal);
        const form = document.querySelector('.formulario');
        const tareaInput = document.querySelector('#tarea');
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
                agregarTarea(tarea);
                form.classList.remove('animar')
                setTimeout(() => modal.remove(), 300);
            }
        })
    })
})()