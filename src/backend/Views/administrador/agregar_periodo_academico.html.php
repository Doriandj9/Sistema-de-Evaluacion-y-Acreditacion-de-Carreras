<div class="centrado-linea contenedor-x75 margin-arriba-2">
    <h2 class="text-center">Ingreso de Periodo Académico</h2>
    <div class="descripcion text-justificado">
        En esta seccion se debera ingresar el periodo academico vigente con las siguientes restrinciones:
    </div>
    <ol>
    <li class="text-justificado"> El identificador debe ser el año del periodo académico por ejemplo 2022-2022 sin ningún tipo de espacios entre el guion el año 2022 - 2022 es invalido por el espacio antes y después del guion </li>
    <li class="text-justificado">
        La fecha inicial corresponde al dia en que inicia el periodo académico 
    </li>
    <li class="text-justificado">
        La fecha final corresponde al dia en que finaliza el periodo académico 
    </li>
    </ol>
    <form>
        <table class="tabla tabla-vertical contenedor-x75 margin-arriba-2 centrado-linea">
            <thead>
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
                        <button class="boton boton-enviar is-hover-boton-enviar">Agregar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>