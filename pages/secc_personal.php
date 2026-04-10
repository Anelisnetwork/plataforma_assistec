<?php
if (isset($_SESSION['datos_' . _ID_PAG_]['edita_empleado']['hayerrores'])) {
    if ($_SESSION['datos_' . _ID_PAG_]['edita_empleado']['hayerrores'] == 1) {
        ?>
        <script>
            alertify.error("No se ha podido guardar");
        </script>
    <?php } else {
        ?>
        <script>
            alertify.success("Guardado correctamente");
        </script>
    <?php }
}
$empleados = dame_empleados();

$porcentajes = personal_porcentaje($_SESSION['datos_' . _ID_PAG_]['datos_user']['idtaller']);

//var_dump($porcentajes);
?>
<div class="row g-3 mt-1 w-100">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title d-flex align-items-center m-0">
                            Registro de empleados
                        </h3>
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                        <span class="mostrarocultar btn btn-sm btn-secondary col-12 col-sm-auto" id="mostrarocultar_nuevoempleado">Añadir empleado</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                        <div class="col col-12 col-lg-8 d-flex flex-column align-items-center justify-content-start">
                            <div id="nuevoempleado" class="div_mostrarocultar w-100" style="display:none">
                                <div class=" flex-column align-items-start justify-content-between w-100 mb-3">
                                    <div class="linea empleado_NEW d-flex flex-column align-items-start justify-content-between w-100 p-2 p-sm-4 rounded-2 mb-3 border border-warning">
                                        <form action="<?= _RAIZ_ ?>procesando.php" method="post" class="w-100" name="nuevo_empleado" id="nuevo_empleado">
                                            <input type="hidden" id="idproceso" name="idproceso" value="edita_empleado"/>
                                            <input type="hidden" id="url_dest" name="url_dest" value="<?= _RAIZ_ ?>datos_del_taller/personal"/>
                                            <input type="hidden" id="idempleado" name="idempleado" value="NEW"/>
                                            <input type="hidden" id="idtaller" name="idtaller" value="<?= $_SESSION['datos_' . _ID_PAG_]['datos_user']['idtaller'] ?>"/>
                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start w-100">
                                                <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                    <label for="nombre_NEW" class="d-none d-sm-flex me-2">Nombre:</label>
                                                    <input type="text" placeholder="Nombre" id="nombre_NEW" name="nombre_NEW" class="form-control form-control-sm" value="">
                                                </div>
                                                <div class="d-flex flex-row align-items-center justify-content-start w-100 ms-0 ms-sm-2">
                                                    <div class="col col-8 text-end me-1">
                                                        <label for="jornada_NEW">Jornada (horas):</label>
                                                    </div>
                                                    <div class="col col-4">
                                                        <input type="text" id="jornada_NEW" name="jornada_NEW" class="form-control form-control-sm" value="8.00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1">
                                                <span class="oswald texto_r">Funciones: <span class="fs_12 ubuntu texto_n"> (Indique las funciones que desempe&ntilde;a este empleado y el porcentaje de cada una de ellas)</span></span>
                                            </div>
                                            <div class="d-flex flex-column align-items-start justify-content-center w-100 mb-1">
                                                <?php $tipos_personal = tipos_personal();
                                                for ($nf = 1; $nf <= 4; $nf++) {
                                                    ?>
                                                    <div class="funcion d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                                                        <select id="funcion_<?= $nf ?>_NEW" class="form-select form-select-sm w-75 me-0 me-sm-2" name="funcion_<?= $nf ?>_NEW">
                                                            <option value="" selected="selected" disabled="disabled">Seleccione</option>
                                                            <?php foreach ($tipos_personal as $tipo_personal) { ?>
                                                                <optgroup label="<?= $tipo_personal->tp_definicion ?>">
                                                                    <?php $cargos_personal = cargos_personal($tipo_personal->tp_idtipo);
                                                                    foreach ($cargos_personal as $cargo_personal) {
                                                                        ?>
                                                                        <option value="<?= $cargo_personal->cp_idpersonal ?>"><?= $cargo_personal->cp_nombre ?></option>
                                                                    <?php } ?>
                                                                </optgroup>
                                                            <?php } ?>
                                                        </select>
                                                        <select id="porcent_<?= $nf ?>_NEW"class="form-select form-select-sm w-25" name="porcent_<?= $nf ?>_NEW">
                                                            <?php for ($pr = 0; $pr <= 100; $pr += 25) { ?>
                                                                <option value="<?= $pr ?>"><?= $pr ?>%</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1">
                                                <textarea id="notas_NEW" name="notas_NEW" placeholder="Notas" class="form-control form-control-sm w-100" style="resize: none;"></textarea>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                                                <span class="mostrarocultar btn btn-sm btn-light col-12 col-sm-auto" id="mostrarocultar_nuevoempleado">Cancelar</span>
                                                <input type="submit" id="guardaempleado_NEW" name="guardaempleado_NEW" class="btn btn-secondary" value="Guardar"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-start justify-content-between w-100 mb-3">
                                <span class="oswald fs_16">TOTAL EMPLEADOS: <span id="empleados_total"><?= $porcentajes[0] ?></span></span>

                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                    <span style="float:left; margin-top: 0px;" class="ubuntu fs_16">Empleados directos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="empleados_directos"><?= $porcentajes[4] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<span id="empleados_dir_porc"><?= $porcentajes[2] ?></span>%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span class="fs_12 texto_r">Recomendado 70%</span>
                                </div>

                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3">
                                    <span style="float:left; margin-top: 5px;" class="ubuntu fs_16">Empleados indirectos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="empleados_indirectos"><?= $porcentajes[5] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<span id="empleados_indir_porc"><?= $porcentajes[3] ?></span>%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span class="fs_12 texto_r">Recomendado 30%</span>
                                </div>
                            </div>

                            <div id="contempleados" class="w-100">
                                <div class="d-flex flex-column align-items-start justify-content-between w-100 mb-3">
                                    <?php if (count($empleados) > 0) {
                                        foreach ($empleados as $k=>$empleado) {
                                            ?>
                                            <div class="linea empleado d-flex flex-column align-items-start justify-content-between w-100 p-2 p-sm-4 rounded-2 mb-3<?=$k%2 != 0 ? '' : ' text-bg-secondary'?>" id="it_empleado_<?= $empleado->pt_idpersonal ?>">
                                                <form action="<?= _RAIZ_ ?>procesando.php" method="post" class="w-100" name="nuevo_empleado_<?= $empleado->pt_idpersonal ?>" id="nuevo_empleado_<?= $empleado->pt_idpersonal ?>">
                                                    <input type="hidden" id="idproceso" name="idproceso" value="edita_empleado"/>
                                                    <input type="hidden" id="url_dest" name="url_dest" value="<?= _RAIZ_ ?>datos_del_taller/personal"/>
                                                    <input type="hidden" id="idempleado" name="idempleado" value="<?= $empleado->pt_idpersonal ?>"/>
                                                    <input type="hidden" id="idtaller" name="idtaller" value="<?= $_SESSION['datos_' . _ID_PAG_]['datos_user']['idtaller'] ?>"/>
                                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start w-100">
                                                        <div class="fa <?= $empleado->pt_activo == 1 ? 'fa-toggle-on text-secondary' : 'fa-toggle-off text-mute' ?> link fs_34" title="<?= $empleado->pt_activo == 1 ? 'Desactivar' : 'Activar' ?>" id="onoff_<?= $empleado->pt_idpersonal ?>" onclick="eliminar('empleado', '<?= $empleado->pt_idpersonal ?>')"></div>
                                                    </div>
                                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start w-100">
                                                        <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                            <label for="nombre_<?= $empleado->pt_idpersonal ?>" class="d-none d-sm-flex me-2">Nombre: </label>
                                                            <input type="text" placeholder="Nombre:" id="nombre_<?= $empleado->pt_idpersonal ?>" name="nombre_<?= $empleado->pt_idpersonal ?>" class="form-control form-control-sm" value="<?= u8d_($empleado->pt_nombre) ?>" onkeyup="comprueba_cambios_empleado('<?= $empleado->pt_idpersonal ?>')">
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center justify-content-start w-100 ms-0 ms-sm-2">
                                                            <div class="col col-8 text-end me-1">
                                                                <label for="jornada_<?= $empleado->pt_idpersonal ?>">Jornada <span class="fs_12">(horas)</span>:</label>
                                                            </div>
                                                            <div class="col col-4">
                                                                <input type="text" id="jornada_<?= $empleado->pt_idpersonal ?>" name="jornada_<?= $empleado->pt_idpersonal ?>" class="form-control form-control-sm"  value="<?= $empleado->pt_jornada ?>" onkeyup="comprueba_cambios_empleado('<?= $empleado->pt_idpersonal ?>')">
                                                                <input type="hidden" id="nombre_<?= $empleado->pt_idpersonal ?>_def" name="nombre<?= $empleado->pt_idpersonal ?>_def" value="<?= u8d_($empleado->pt_nombre) ?>"/>
                                                                <input type="hidden" id="jornada_<?= $empleado->pt_idpersonal ?>_def" name="jornada_<?= $empleado->pt_idpersonal ?>_def" value="<?= $empleado->pt_jornada ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1">
                                                        <span class="fs_12 ubuntu texto_n"><strong>ID:</strong> <?= en__id($empleado->pt_idpersonal) ?></span>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1">
                            <span class="oswald texto_r" style="float:left">Funciones:
                                <span
                                        class="fs_12 ubuntu texto_n"> (Indique las funciones que desempe&ntilde;a este empleado y el porcentaje de cada una de ellas)</span>
                            </span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-start justify-content-center w-100 mb-1">
                                                        <?php
                                                        $funciones = funciones_personal($empleado->pt_idpersonal);
                                                        $tipos_personal = tipos_personal();
                                                        for ($nf = 1, $clave = 0; $nf <= 4; $nf++, $clave++) {
                                                            ?>
                                                            <div class="funcion d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                                                                <input type="hidden" id="funcion_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>_def"
                                                                       name="funcion_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>_def"
                                                                       value="<?= array_key_exists($clave, $funciones) ? $funciones[$clave]->pf_idcargo : '' ?>"/>
                                                                <select id="funcion_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>" class="form-select form-select-sm w-75 me-0 me-sm-2"
                                                                        name="funcion_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>"
                                                                        onchange="comprueba_cambios_empleado('<?= $empleado->pt_idpersonal ?>')">
                                                                    <option value="0"<?= array_key_exists($clave, $funciones) ? '' : ' selected="selected"' ?>
                                                                            disabled="disabled">Seleccione
                                                                    </option>
                                                                    <?php foreach ($tipos_personal as $tipo_personal) { ?>
                                                                        <optgroup label="<?= $tipo_personal->tp_definicion ?>">
                                                                            <?php $cargos_personal = cargos_personal($tipo_personal->tp_idtipo);
                                                                            foreach ($cargos_personal as $cargo_personal) {
                                                                                ?>
                                                                                <option<?= array_key_exists($clave, $funciones) && $funciones[$clave]->pf_idcargo == $cargo_personal->cp_idpersonal ? ' selected="selected"' : '' ?>
                                                                                        value="<?= $cargo_personal->cp_idpersonal ?>"><?= $cargo_personal->cp_nombre ?></option>
                                                                            <?php } ?>
                                                                        </optgroup>
                                                                    <?php } ?>
                                                                </select>
                                                                <input type="hidden" id="porcent_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>_def"
                                                                       name="porcent_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>_def"
                                                                       value="<?= array_key_exists($clave, $funciones) ? $funciones[$clave]->pf_porcentaje : 0 ?>"/>
                                                                <select id="porcent_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>" class="form-select form-select-sm w-25"
                                                                        name="porcent_<?= $nf ?>_<?= $empleado->pt_idpersonal ?>"
                                                                        onchange="comprueba_cambios_empleado('<?= $empleado->pt_idpersonal ?>')">
                                                                    <?php for ($pr = 0; $pr <= 100; $pr += 25) { ?>
                                                                        <option<?= array_key_exists($clave, $funciones) && $funciones[$clave]->pf_porcentaje == $pr ? ' selected="selected"' : ($pr == 0 ? ' selected="selected"' : '') ?>
                                                                                value="<?= $pr ?>"><?= $pr ?>%
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1">
                            <textarea id="notas_<?= $empleado->pt_idpersonal ?>" name="notas_<?= $empleado->pt_idpersonal ?>"
                                      placeholder="Notas" class="form-control form-control-sm w-100" style="resize: none;"
                                      onkeyup="comprueba_cambios_empleado('<?= $empleado->pt_idpersonal ?>')"><?= u8d_($empleado->pt_notas) ?></textarea>
                                                        <input type="hidden" id="notas_<?= $empleado->pt_idpersonal ?>_def"
                                                               name="notas_<?= $empleado->pt_idpersonal ?>_def" value="<?= u8d_($empleado->pt_notas) ?>"/>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1">
                                                        <input type="submit" style="display:none" class="btn btn-secondary"
                                                               id="guardaempleado_<?= $empleado->pt_idpersonal ?>"
                                                               name="guardaempleado_<?= $empleado->pt_idpersonal ?>" value="Guardar"/>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php }
                                    }?>
                                </div>
                                <?php unset($_SESSION['datos_' . _ID_PAG_]['edita_empleado']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


