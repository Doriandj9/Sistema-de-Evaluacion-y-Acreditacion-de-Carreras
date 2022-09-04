<div class="centrado-linea">
<table class="tabla tabla-vertical contenedor-x100 margin-arriba-2 centrado-linea">
            <thead>
                <tr class="titulo-tablas">
                    <th colspan="4">
                        <div>
                        <span class="material-icons">&#xe241;</span>
                        <strong>Lista de Periodos Académicos</strong>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>Periodo Académico</th>
                    <th>Fecha de Incio</th>
                    <th>Fecha de Finalización</th>
                    <th> Opción </th>
                </tr>
            </thead>
            <tbody>
                <tr class="p-relativo">
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <span class="material-icons">&#xe8b5;</span>
                            <input type="text" name="periodo" id="ciclo-academico" placeholder="Periodo Académico">
                        </div>
                        <p class="mensaje-error mensaje-error-flotante p-absoluta oculto">
                            Error la entrada no es valida
                        </p>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <label for="f_i"><span class="material-icons">&#xebcc;</span></label> 
                            <input type="date" id="f_i" name="fecha_inicial">
                        </div>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                           <label for="f_f"><span class="material-icons">&#xe916;</span></label> 
                            <input type="date" id="f_f" name="fecha_final">
                        </div>
                    </td>
                    <td>
                        <button class="boton boton-enviar is-hover-boton-enviar block centrado-linea boton-iconos">
                        <span class="material-icons text-blanco">&#xe3c9;</span>
                        Editar 
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

    <form class="margin-arriba-3">
        <table class="tabla tabla-vertical contenedor-x100 margin-arriba-2 centrado-linea">
            <thead>
                <tr class="titulo-tablas">
                    <th colspan="4">
                        <div>
                        <span class="material-icons">&#xea5d;</span>
                        <strong>Agregar un Periodo Académico</strong>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>Periodo Académico</th>
                    <th>Fecha de Incio</th>
                    <th>Fecha de Finalización</th>
                    <th>Agregar</th>
                </tr>
            </thead>
            <tbody>
                <tr class="p-relativo">
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <span class="material-icons">&#xe8b5;</span>
                            <input type="text" name="periodo" id="ciclo-academico" placeholder="Periodo Académico">
                        </div>
                        <p class="mensaje-error mensaje-error-flotante p-absoluta oculto">
                            Error la entrada no es valida
                        </p>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <label for="f_i"><span class="material-icons">&#xebcc;</span></label> 
                            <input type="date" id="f_i" name="fecha_inicial">
                        </div>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                           <label for="f_f"><span class="material-icons">&#xe916;</span></label> 
                            <input type="date" id="f_f" name="fecha_final">
                        </div>
                    </td>
                    <td>
                        <button class="boton boton-enviar is-hover-boton-enviar block centrado-linea">Agregar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>