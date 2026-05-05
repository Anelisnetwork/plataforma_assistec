<?php
if (isset($_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['hayerrores'])) {
    $mensaje = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['mensaje'];
    if ($_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['hayerrores'] == 1) {
        $mes = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['mes'];
        $ano = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['ano'];
        $diaslab = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['diaslab'];
        $facturadomo = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['facturadomo'];
        $facturadorec = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['facturadorec'];
        $facturadootros = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['facturadootros'];
        /*
        $cobradomo=$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['cobradomo'];
        $cobradorec=$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['cobradorec'];
        $cobradootros=$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['cobradootros'];
        */
        $pagadoprovrec = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['pagadoprovrec'];
        $pagadoprovotros = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['pagadoprovotros'];
        $costepersonal = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['costepersonal'];
        $costeestructura = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['costeestructura'];
        $horasfichadasor = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['horasfichadasor'];
        $horasasignadas = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['horasasignadas'];
        $entradastaller = $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['entradastaller'];
        ?>
        <script>
            alertify.error("<?=$mensaje?>");
            //console.log('<?=$mensaje?>');
            $(document).ready(function () {
                sumacol_datosactmes('facturado_', '<?='NEW'?>');
                //sumacol_datosactmes('cobrado_','<?='NEW'?>');
            });
        </script>
    <?php } else {
        ?>
        <script>
            alertify.success("<?=$mensaje?>");
        </script>
    <?php }
    //echo de__($_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']);//exit();
    if (isset($_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['enviamail']) && $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['enviamail'] != '0') {//Enviamos informe por correo
        ?>
        <script language="JavaScript" type="text/JavaScript">
            $(document).ready(function () {
                window.open("<?=_RAIZ_ . 'genera_informe/' . $_SESSION['datos_' . _ID_PAG_]['edita_datomensual']['enviamail'] . '/'?>", "_blank");
            });
        </script>
    <?php }
}


$iddato = 'NEW';

if (isset($_GET['mes']) && isset($_GET['anho'])) {
    $dato_mensual = datos_actividad(1, clean_get('mes'), clean_get('anho'));
    $iddato = count($dato_mensual) != 1 ? 'NEW' : $dato_mensual[0]->da_iddato;
}

$datos_guardados = datos_guardados();

if (isset($mes) && isset($ano)) {
    $proximo_mes = $mes;
    $proximo_ano = $ano;
} else {
    if (count($datos_guardados) == 0) {
        $proximo_mes = date('n');
        $proximo_ano = date('Y');
    } else {
        $proximo_mes = $datos_guardados[0]->da_mes == 12 ? 1 : $datos_guardados[0]->da_mes + 1;
        $proximo_ano = date('Y') + 1;
    }
}
$empleados_directos = dame_empleados(1);

$imp_mo = dame_impmo_actual();

$gastos_taller = dame_coste_personal($_SESSION['datos_' . _ID_PAG_]['datos_user']['idtaller']);

$muestra_empleados = false;
if(isset($tipopresencia) && $tipopresencia == 1){
    $muestra_empleados = true;
}
else if(isset($dato_mensual[0]->da_tipopresencia) && $dato_mensual[0]->da_tipopresencia == 1){
    $muestra_empleados = true;
}
?>
    <div class="row g-3 mt-1">
        <div class="col">
            <div class="card shadow-custom rounded-custom">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="col-12 col-sm-6 d-flex flex-column flex-md-row justify-content-start align-items-center mb-4 mb-sm-0">
                                <?php if($iddato === 'NEW'){?>
                                    <span class="card-title d-flex align-items-center m-0 h3">Datos nuevos de: </span>
                                    <div class="d-flex flex-row flex-nowrap align-items-center justify-content-start">
                                        <select name="mesdato_<?= $iddato ?>" id="mesdato_<?= $iddato ?>" class="form-select form-select-sm ms-2" style="width:auto">
                                            <?php for ($m = 1; $m <= 12; $m++) { ?>
                                                <option<?= $proximo_mes == $m ? ' selected="selected"' : '' ?>
                                                        value="<?= $m ?>"><?= nom_mes($m) ?></option>
                                            <?php } ?>
                                        </select>
                                        <select name="anodato_<?= $iddato ?>" id="anodato_<?= $iddato ?>" class="form-select form-select-sm" style="width:auto; margin-left:15px">
                                            <?php for ($a = date('Y') - 2; $a <= $proximo_ano + 1; $a++) { ?>
                                                <option<?= $proximo_ano == $a ? ' selected="selected"' : '' ?>
                                                        value="<?= $a ?>"><?= $a ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php }
                                else{?>
                                    <span class="me-4">Datos de <b><?= nom_mes($dato_mensual[0]->da_mes) ?></b> de <b><?=$dato_mensual[0]->da_ano?></b></span>
                                    <a href="<?= _RAIZ_ ?>datos_del_mes/" class="btn btn-sm btn-secondary" >Registrar datos nuevos</a>
                                <?php }?>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <span class="fs_12 me-2 text-nowrap">Ver datos de</span>
                            <select class="form-select form-select-sm w-auto d-inline-block" onchange="window.location.href ='<?= _RAIZ_ ?>datos_del_mes/'+this.value+'/'">
                                <option value="NEW"<?= $iddato === 'NEW' ? ' selected' : '' ?> disabled>Seleccione...</option>
                                <?php foreach ($datos_guardados as $dato_guardado) { ?>
                                    <option value="<?= $dato_guardado->da_mes . '/' . $dato_guardado->da_ano ?>"<?= isset($dato_mensual[0]) && (nom_mes($dato_mensual[0]->da_mes) . ' ' . $dato_mensual[0]->da_ano) == (nom_mes($dato_guardado->da_mes) . ' ' . $dato_guardado->da_ano) ? ' selected' : '' ?>><?= nom_mes($dato_guardado->da_mes) . ' ' . $dato_guardado->da_ano ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-6 position-relative z-1">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                            <form action="<?= _RAIZ_ ?>procesando.php" method="post" name="edita_datomensual" id="edita_datomensual">
                                <input type="hidden" id="idproceso" name="idproceso" value="edita_datomensual"/>
                                <input type="hidden" id="url_dest" name="url_dest" value="<?= _RAIZ_ ?>datos_del_mes"/>
                                <input type="hidden" id="idtaller" name="idtaller"
                                       value="<?= $_SESSION['datos_' . _ID_PAG_]['datos_user']['idtaller'] ?>"/>
                                <input type="hidden" id="iddatoact" name="iddatoact" value="<?= $iddato ?>"/>
                                <input type="hidden" id="importemo_<?= $iddato ?>" name="importemo_<?= $iddato ?>"
                                       value="<?= $iddato == 'NEW' ? $imp_mo : $dato_mensual[0]->da_impmo ?>"/>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho">N&ordm; de d&iacute;as laborables:</label>
                                    <input type="text" id="diaslab_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="diaslab_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= $iddato == 'NEW' ? (isset($diaslab) ? $diaslab : 0) : $dato_mensual[0]->da_diaslaborables ?>"
                                           onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="diaslab_<?= $iddato ?>_def" name="diaslab_<?= $iddato ?>_def"
                                           value="<?= $iddato == 'NEW' ? (isset($diaslab) ? $diaslab : 0) : $dato_mensual[0]->da_diaslaborables ?>"/>
                                </div>

                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq">N&ordm; horas presencia:</label>
                                    <input type="text" id="horaspresencia_<?= $iddato ?>"
                                           style="text-align:right;width: auto"
                                           name="horaspresencia_<?= $iddato ?>" class="peq orig form-control form-control-sm<?= ($iddato === 'NEW' && isset($tipopresencia) && $tipopresencia == 1) || (isset($dato_mensual[0]) && $dato_mensual[0]->da_tipopresencia == 1 ? ' text-bg-secondary' : '') ?>"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horaspresencia) ? $horaspresencia : 0) : $dato_mensual[0]->da_horaspresencia, 2) ?>"
                                           onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')"<?= $iddato == 'NEW' ? (isset($tipopresencia) ? ($tipopresencia == 1 ? ' readonly="readonly"' : '') : '') : ($dato_mensual[0]->da_tipopresencia == 1 ? ' readonly="readonly"' : '') ?>>
                                    <input type="hidden" id="horaspresencia_<?= $iddato ?>_def" name="horaspresencia_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horaspresencia) ? $horaspresencia : 0) : $dato_mensual[0]->da_horaspresencia, 2) ?>"/>
                                </div>

                                <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                                    <div class="tit_mes oswald_l <?=$muestra_empleados?' active':''?>" id="showempleados">Indicar presencia por empleado</div>
                                    <input type="checkbox" name="presenciaxemp" id="presenciaxemp" style="float:left; margin-top:9px" value="1"<?= $iddato == 'NEW' ? (isset($tipopresencia) ? ($tipopresencia == 1 ? ' checked="checked"' : '') : '') : ($dato_mensual[0]->da_tipopresencia == 1 ? ' checked="checked"' : '') ?> onclick="muestra_empleados('<?= $iddato ?>')"/>
                                </div>

                                <div id="empleados" style="<?= !$muestra_empleados ? 'display:none' : ''?>">
                                    <!--PARA CADA EMPLEADO DIRECTO-->
                                    <?php foreach ($empleados_directos as $empleado_directo) {
                                        $presencia_empleado = dame_presencia($iddato == 'NEW' ? 0 : $iddato, $empleado_directo->pt_idpersonal);
                                        $jornada_emp = dame_jornadas(1, $empleado_directo->pt_idpersonal); ?>
                                        <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                                            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 px-3">
                                                <div class="d-flex flex-row align-items-center justify-content-start">
                                                    <span class="texto_r"><?= u8d_($empleado_directo->pt_nombre) ?></span>
                                                    <input type="hidden" name="jornada_<?= $empleado_directo->pt_idpersonal ?>"
                                                           id="jornada_<?= $empleado_directo->pt_idpersonal ?>" value="<?= $jornada_emp[2] ?>"/>
                                                </div>
                                                <input type="checkbox" class="pres_emp orig"
                                                       name="activaemp_<?= $empleado_directo->pt_idpersonal ?>"
                                                       id="activaemp_<?= $empleado_directo->pt_idpersonal ?>"
                                                       value="<?= $empleado_directo->pt_idpersonal ?>"<?= $presencia_empleado != '' ? ' checked="checked"' : '' ?>
                                                       onclick="muestra_datosemp(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')"/>

                                            </div>
                                            <span class="tit_mes ubuntu fs_12 col-3 col-sm-4 d-flex flex-row align-items-center justify-content-end" style="white-space: nowrap" >(<?= $jornada_emp[0] ?> h. al <?= $jornada_emp[1] ?>%)</span>
                                            <input type="hidden" name="activaemp_<?= $empleado_directo->pt_idpersonal ?>_def"
                                                   id="activaemp_<?= $empleado_directo->pt_idpersonal ?>_def"
                                                   value="<?= $presencia_empleado != '' ? $empleado_directo->pt_idpersonal : '0' ?>"/>
                                        </div>
                                        <div id="empleado_<?= $empleado_directo->pt_idpersonal ?>"<?= $presencia_empleado != '' ? '' : ' style="display:none"' ?>>
                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                                <label class="ancho">Horas extras pagadas:</label>
                                                <input type="text"
                                                       id="extraspagadas_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       style="text-align:right;width: auto"
                                                       name="extraspagadas_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       class="peq orig form-control form-control-sm"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_extraspagadas']), 2) ?>"
                                                       onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                                <input type="hidden"
                                                       id="extraspagadas_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       name="extraspagadas_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_extraspagadas']), 2) ?>"/>
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                                <label class="ancho">D&iacute;as de vacaciones:</label>
                                                <input type="text"
                                                       id="diasvacaciones_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       style="text-align:right;width: auto"
                                                       name="diasvacaciones_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       class="peq orig form-control form-control-sm"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diasvacaciones']), 2) ?>"
                                                       onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                                <input type="hidden"
                                                       id="diasvacaciones_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       name="diasvacaciones_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diasvacaciones']), 2) ?>"/>
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                                <label class="ancho">D&iacute;as de baja:</label>
                                                <input type="text" id="diasbaja_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       style="text-align:right;width: auto"
                                                       name="diasbaja_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       class="peq orig form-control form-control-sm"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diasbaja']), 2) ?>"
                                                       onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                                <input type="hidden"
                                                       id="diasbaja_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       name="diasbaja_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diasbaja']), 2) ?>"/>
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                                <label class="ancho">Horas de permiso:</label>
                                                <input type="text"
                                                       id="diaspermiso_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       style="text-align:right;width: auto"
                                                       name="diaspermiso_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       class="peq orig form-control form-control-sm"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diaspermiso']), 2) ?>"
                                                       onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                                <input type="hidden"
                                                       id="diaspermiso_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       name="diaspermiso_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diaspermiso']), 2) ?>"/>
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                                <label class="ancho">D&iacute;as de formaci&oacute;n:</label>
                                                <input type="text"
                                                       id="diasformacion_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       style="text-align:right;width: auto"
                                                       name="diasformacion_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>"
                                                       class="peq orig form-control form-control-sm"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diasformacion']), 2) ?>"
                                                       onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                                <input type="hidden"
                                                       id="diasformacion_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       name="diasformacion_<?= $empleado_directo->pt_idpersonal ?>_<?= $iddato ?>_def"
                                                       value="<?= moneda_punto($iddato == 'NEW' ? 0 : ($presencia_empleado == '' ? '0' : $presencia_empleado['pp_diasformacion']), 2) ?>"/>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!--PARA CADA EMPLEADO DIRECTO-->
                                </div>

                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <span class="tit_mes oswald fs_22">Datos econ&oacute;micos</span>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq" title="Introducir el importe de facturación de la mano de obra">Importe
                                        facturado de MO:</label>
                                    <input type="text" id="facturadomo_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="facturadomo_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($facturadomo) ? $facturadomo : 0) : $dato_mensual[0]->da_facturadomo, 2) ?>"
                                           onkeyup="comprueba_num(this.id); datos_presencia('<?= $iddato ?>'); sumacol_datosactmes('facturado_','<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="facturadomo_<?= $iddato ?>_def" name="facturadomo_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($facturadomo) ? $facturadomo : 0) : $dato_mensual[0]->da_facturadomo, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq"
                                           title="Introducir el importe de facturación del recambio (piezas y pintura)">Importe
                                        facturado de REC:</label>
                                    <input type="text" id="facturadorec_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="facturadorec_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($facturadorec) ? $facturadorec : 0) : $dato_mensual[0]->da_facturadorec, 2) ?>"
                                           onkeyup="comprueba_num(this.id); sumacol_datosactmes('facturado_','<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="facturadorec_<?= $iddato ?>_def" name="facturadorec_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($facturadorec) ? $facturadorec : 0) : $dato_mensual[0]->da_facturadorec, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq" title="Importe facturados como material limpieza o gestión residuos">Importe
                                        varios facturado:</label>
                                    <input type="text" id="facturadootros_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="facturadootros_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($facturadootros) ? $facturadootros : 0) : $dato_mensual[0]->da_facturadootros, 2) ?>"
                                           onkeyup="comprueba_num(this.id); sumacol_datosactmes('facturado_','<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="facturadootros_<?= $iddato ?>_def" name="facturadootros_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($facturadootros) ? $facturadootros : 0) : $dato_mensual[0]->da_facturadootros, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho">Total importes facturados:</label>
                                    <input type="text" id="facturado_<?= $iddato ?>" style="text-align:right; width: auto"
                                           name="facturado_<?= $iddato ?>" class="peq form-control form-control-sm text-bg-secondary"
                                           value="<?= moneda_punto($iddato == 'NEW' ? 0 : $dato_mensual[0]->da_facturadomo + $dato_mensual[0]->da_facturadorec + $dato_mensual[0]->da_facturadootros, 2) ?>"
                                           disabled="disabled">
                                </div>
                                <?php if (1 == 0) { ?>
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                        <label class="ancho">Importe cobrado de MO:</label>
                                        <input type="text" id="cobradomo_<?= $iddato ?>" style="text-align:right;width: auto"
                                               name="cobradomo_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                               value="<?= moneda_punto($iddato == 'NEW' ? (isset($cobradomo) ? $cobradomo : 0) : $dato_mensual[0]->da_cobradomo, 2) ?>"
                                               onkeyup="comprueba_num(this.id); sumacol_datosactmes('cobrado_','<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                        <input type="hidden" id="cobradomo_<?= $iddato ?>_def" name="cobradomo_<?= $iddato ?>_def"
                                               value="<?= moneda_punto($iddato == 'NEW' ? (isset($cobradomo) ? $cobradomo : 0) : $dato_mensual[0]->da_cobradomo, 2) ?>"/>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                        <label class="ancho">Importe cobrado de REC:</label>
                                        <input type="text" id="cobradorec_<?= $iddato ?>" style="text-align:right;width: auto"
                                               name="cobradorec_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                               value="<?= moneda_punto($iddato == 'NEW' ? (isset($cobradorec) ? $cobradorec : 0) : $dato_mensual[0]->da_cobradorec, 2) ?>"
                                               onkeyup="comprueba_num(this.id); sumacol_datosactmes('cobrado_','<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                        <input type="hidden" id="cobradorec_<?= $iddato ?>_def" name="cobradorec_<?= $iddato ?>_def"
                                               value="<?= moneda_punto($iddato == 'NEW' ? (isset($cobradorec) ? $cobradorec : 0) : $dato_mensual[0]->da_cobradorec, 2) ?>"/>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                        <label class="ancho">Importe varios cobrado:</label>
                                        <input type="text" id="cobradootros_<?= $iddato ?>" style="text-align:right;width: auto"
                                               name="cobradootros_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                               value="<?= moneda_punto($iddato == 'NEW' ? (isset($cobradootros) ? $cobradootros : 0) : $dato_mensual[0]->da_cobradootros, 2) ?>"
                                               onkeyup="comprueba_num(this.id); sumacol_datosactmes('cobrado_','<?= $iddato ?>'); comprueba_cambios('edita_datomensual')">
                                        <input type="hidden" id="cobradootros_<?= $iddato ?>_def" name="cobradootros_<?= $iddato ?>_def"
                                               value="<?= moneda_punto($iddato == 'NEW' ? (isset($cobradootros) ? $cobradootros : 0) : $dato_mensual[0]->da_cobradootros, 2) ?>"/>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                        <label class="ancho">Total importes cobrado:</label>
                                        <input type="text" id="cobrado_<?= $iddato ?>"
                                               style="text-align:right;width: auto; " name="cobrado_<?= $iddato ?>"
                                               class="peq form-control form-control-sm text-bg-secondary"
                                               value="<?= moneda_punto($iddato == 'NEW' ? 0 : $dato_mensual[0]->da_cobradomo + $dato_mensual[0]->da_cobradorec + $dato_mensual[0]->da_cobradootros, 2) ?>"
                                               disabled="disabled">
                                    </div>
                                <?php } ?>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq doslineas"
                                           title="Anotar el importe de los albaranes o facturas de proveedores de piezas de recambios / pintura del mes">Importe
                                        pagado proveedores REC:</label>
                                    <input type="text" id="pagadoprovrec_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="pagadoprovrec_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($pagadoprovrec) ? $pagadoprovrec : 0) : $dato_mensual[0]->da_pagadoprovrec, 2) ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="pagadoprovrec_<?= $iddato ?>_def" name="pagadoprovrec_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($pagadoprovrec) ? $pagadoprovrec : 0) : $dato_mensual[0]->da_pagadoprovrec, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq doslineas"
                                           title="Indicar cifra de importes pagados a proveedores de taller (protecciones, pequeño material, consumibles…)">Importe
                                        pagado otros proveedores:</label>
                                    <input type="text" id="pagadoprovotros_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="pagadoprovotros_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($pagadoprovotros) ? $pagadoprovotros : 0) : $dato_mensual[0]->da_pagadoprovotros, 2) ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="pagadoprovotros_<?= $iddato ?>_def"
                                           name="pagadoprovotros_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($pagadoprovotros) ? $pagadoprovotros : 0) : $dato_mensual[0]->da_pagadoprovotros, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq"
                                           title="Nóminas + Seguridad Social<br><br>Puedes establecer este valor por defecto en 'Datos del taller -> Gastos generales'">Coste
                                        de personal:</label>
                                    <input type="text" id="costepersonal_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="costepersonal_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($costepersonal) ? $costepersonal : $gastos_taller['PERSONAL']) / 12 : $dato_mensual[0]->da_costepersonal, 2) ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="costepersonal_<?= $iddato ?>_def" name="costepersonal_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($costepersonal) ? $costepersonal : 0) : $dato_mensual[0]->da_costepersonal, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq"
                                           title="Anotar gastos de alquiler, seguros, acreedores de servicio, suministros, etc…<br><br>Puedes establecer este valor por defecto en 'Datos del taller -> Gastos generales'">Coste
                                        estructura:</label>
                                    <input type="text" id="costeestructura_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="costeestructura_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($costeestructura) ? $costeestructura : $gastos_taller['ESTRUCTURA']) / 12 : $dato_mensual[0]->da_costeestructura, 2) ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="costeestructura_<?= $iddato ?>_def"
                                           name="costeestructura_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($costeestructura) ? $costeestructura : 0) : $dato_mensual[0]->da_costeestructura, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <span class="tit_mes oswald fs_22">Ratios de gesti&oacute;n</span>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq" title="Horas fichadas en OR de vehículos">N&ordm; horas fichadas en
                                        OR:</label>
                                    <input type="text" id="horasfichadasor_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="horasfichadasor_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horasfichadasor) ? $horasfichadasor : 0) : $dato_mensual[0]->da_horasfichadasor, 2) ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="horasfichadasor_<?= $iddato ?>_def"
                                           name="horasfichadasor_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horasfichadasor) ? $horasfichadasor : 0) : $dato_mensual[0]->da_horasfichadasor, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq"
                                           title="Horas asignadas en las OR (Los tiempos que se asignan según los temparios del fabricante para las reparaciones)<br>En caso de no disponer de este dato, indicar el número de horas fichadas en OR.">N&ordm;
                                        horas asignadas:</label>
                                    <input type="text" id="horasasignadas_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="horasasignadas_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horasasignadas) ? $horasasignadas : 0) : $dato_mensual[0]->da_horasasignadas, 2) ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="horasasignadas_<?= $iddato ?>_def" name="horasasignadas_<?= $iddato ?>_def"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horasasignadas) ? $horasasignadas : 0) : $dato_mensual[0]->da_horasasignadas, 2) ?>"/>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho">N&ordm; horas facturadas:</label>
                                    <input type="text" id="horasfac_<?= $iddato ?>" style="text-align:right;width: auto; "
                                           name="horasfac_<?= $iddato ?>" class="peq form-control form-control-sm text-bg-secondary"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horasfac) ? $horasfac : 0) : $dato_mensual[0]->da_horasfac, 2) ?>"
                                           readonly="readonly">
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq"
                                           title="Horas que se podían haber facturado en base al objetivo de eficacia">Horas
                                        perdidas:</label>
                                    <input type="text" id="horasimproductivas_<?= $iddato ?>"
                                           style="text-align:right;width: auto; " name="horasimproductivas_<?= $iddato ?>"
                                           class="peq form-control form-control-sm text-bg-secondary"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($horasimproductivas) ? $horasimproductivas : 0) : $dato_mensual[0]->da_horasimproductivas, 2) ?>"
                                           readonly="readonly">
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq" title="Cálculo del importe no facturado en base al objetivo de eficacia">Importe
                                        no facturado:</label>
                                    <input type="text" id="nofacturado_<?= $iddato ?>"
                                           style="text-align:right;width: auto; " name="nofacturado_<?= $iddato ?>"
                                           class="peq form-control form-control-sm text-bg-secondary"
                                           value="<?= moneda_punto($iddato == 'NEW' ? (isset($nofacturado) ? $nofacturado : 0) : $dato_mensual[0]->da_nofacturado, 2) ?>"
                                           readonly="readonly">
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between w-100 mb-1">
                                    <label class="ancho faq" title="Número de órdenes de repación abiertas en el mes">Entradas al
                                        taller:</label>
                                    <input type="text" id="entradastaller_<?= $iddato ?>" style="text-align:right;width: auto"
                                           name="entradastaller_<?= $iddato ?>" class="peq orig form-control form-control-sm"
                                           value="<?= $iddato == 'NEW' ? (isset($entradastaller) ? $entradastaller : 0) : $dato_mensual[0]->da_entradastaller ?>"
                                           onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datomensual')">
                                    <input type="hidden" id="entradastaller_<?= $iddato ?>_def" name="entradastaller_<?= $iddato ?>_def"
                                           value="<?= $iddato == 'NEW' ? (isset($entradastaller) ? $entradastaller : 0) : $dato_mensual[0]->da_entradastaller ?>"/>
                                </div>
                                <div class="d-flex flex-row align-items-center justify-content-end w-100 mb-1 mt-2">
                                    <input type="submit" style="display:none" class="btn btn-secondary" id="edita_datoactividad" name="edita_datoactividad" value="Guardar"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php unset($_SESSION['datos_' . _ID_PAG_]['edita_datomensual']); ?>