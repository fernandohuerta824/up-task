<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y administra tus proyecto</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="post">
            <div class="campo">
                <label for="email">Email: </label>
                <input 
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Escribe tu email"
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

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? obtener una</a>
            <a href="/olvidar-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>