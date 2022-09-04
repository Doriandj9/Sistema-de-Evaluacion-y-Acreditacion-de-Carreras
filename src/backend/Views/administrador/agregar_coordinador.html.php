<div class="centrado-linea">
    <h2 class="text-center">Seleción de Coordinador</h2>

    <form>
        <table class="tabla tabla-vertical contenedor-x100 margin-arriba-2 centrado-linea">
            <thead>
                <tr>
                    <th>Carreras</th>
                    <th>Coordinador</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Finalización</th>
                    <th>Guardar</th>
                </tr>
            </thead>
            <tbody>
                <tr class="p-relativo">
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                        <label for="carreras"><span class="material-icons">&#xe152;</span></label> 
                            <select name="carreras" id="carreras">
                                <option value="none" >Presione aquí ...</option>
                               <?php foreach($carreras as $carrera): ?>
                                    <option value="<?= $carrera->id; ?>"> <?= $carrera->nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <label for="coordinador"><span class="material-icons">&#xe03b;</span></label> 
                            <select name="coordinador" id="coordinador">
                            <option value="none">Presione aquí ...</option>

                            </select>
                        </div>
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