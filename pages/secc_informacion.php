<?php 
$infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];
$hay_datos=count($infotaller)>0;
?>
    <form action="<?=_RAIZ_?>procesando.php" method="post" class="w-100" name="edita_info" id="edita_info">
    <div class="w-100 g-3 mt-1">
        <div class="col">
            <div class="card shadow-custom rounded-custom">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="col-12 col-sm-6">
                            <h3 class="card-title d-flex align-items-center m-0">
                                Establece los datos generales del taller
                            </h3>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <input type="submit" style="display:none" class="btn btn-sm btn-secondary" form="edita_info" id="edita_info_<?=$idtaller?>" name="edita_info_<?=$idtaller?>" value="Guardar" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-6 position-relative z-1">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                            <div id="infotaller" class="div_mostrarocultar  col col-12 d-flex flex-column align-items-center justify-content-start" >

                                    <input type="hidden" id="idproceso" name="idproceso" value="edita_info" />
                                    <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/informacion" />
                                    <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="pvpmo_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row"><span class="text-danger me-1">*</span>Importe de la MO:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="pvpmo_<?=$idtaller?>" name="pvpmo_<?=$idtaller?>" required class="peq orig form-control form-control-sm border-danger" value="<?=$hay_datos?$infotaller[0]->it_impmo:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <span class="fs_14"">&euro;/H. jornada</span>
                                            <input type="hidden" id="pvpmo_<?=$idtaller?>_def" name="pvpmo_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_impmo:0?>" />
                                        </div>

                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="hconvenio_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row"><span class="text-danger me-1">*</span>Horas convenio anuales:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="hconvenio_<?=$idtaller?>" name="hconvenio_<?=$idtaller?>" required class="peq orig form-control form-control-sm border-danger" value="<?=$hay_datos?$infotaller[0]->hconvenio:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="hconvenio_<?=$idtaller?>_def" name="hconvenio_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->hconvenio:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="vstock_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row">Valor stock actual:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="vstock_<?=$idtaller?>" name="vstock_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_valorstock:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                                            <input type="hidden" id="vstock_<?=$idtaller?>_def" name="vstock_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_valorstock:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="parking_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row">Puestos aparcamiento:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="parking_<?=$idtaller?>" name="parking_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_parking:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="parking_<?=$idtaller?>_def" name="parking_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_parking:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="sustit_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row">Veh&iacute;culos de sustituci&oacute;n:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="sustit_<?=$idtaller?>" name="sustit_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_vehicsus:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="sustit_<?=$idtaller?>_def" name="sustit_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_vehicsus:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="clitot_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row">Clientes totales en BBDD:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="clitot_<?=$idtaller?>" name="clitot_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_totalclientes:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="clitot_<?=$idtaller?>_def" name="clitot_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_totalclientes:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="clivisit_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row">Clientes con visitas el &uacute;ltimo a&ntilde;o:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="clivisit_<?=$idtaller?>" name="clivisit_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_clivisitas:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="clivisit_<?=$idtaller?>_def" name="clivisit_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_clivisitas:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <label for="clinuevos_<?=$idtaller?>" class="col col-12 col-sm-6 d-flex flex-row">Clientes nuevos el &uacute;ltimo a&ntilde;o:</label>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" id="clinuevos_<?=$idtaller?>" name="clinuevos_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_clinuevos:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="clinuevos_<?=$idtaller?>_def" name="clinuevos_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_clinuevos:0?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="dms_<?=$idtaller?>" class="col col-10 d-flex flex-row flex-nowrap align-items-center justify-content-start">DMS<i class="fa fa-info-circle fs_14 text-secondary mx-1" title="Programa de gestión"></i>:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-end justify-content-sm-center">
                                                <input type="checkbox" class="orig" id="dms_<?=$idtaller?>" name="dms_<?=$idtaller?>" value="1"<?=$hay_datos&&$infotaller[0]->it_tienedms==1?' checked="checked"':''?> onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="dms_<?=$idtaller?>_def" name="dms_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_tienedms:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" placeholder="Proveedor" id="dmsprov_<?=$idtaller?>" name="dmsprov_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?u8d_($infotaller[0]->it_provdms):''?>">
                                            <input type="hidden" id="dmsprov_<?=$idtaller?>_def" name="dmsprov_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_provdms):''?>" onkeyup="comprueba_cambios('edita_info')" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="fichan_<?=$idtaller?>" class="col col-10 d-flex flex-row">Operarios fichan:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-end justify-content-sm-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_fichan==1?' checked="checked"':''?> class="orig" id="fichan_<?=$idtaller?>" name="fichan_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="fichan_<?=$idtaller?>_def" name="fichan_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_fichan:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" placeholder="Cómo" id="fichancomo_<?=$idtaller?>" name="fichancomo_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?u8d_($infotaller[0]->it_comofichan):''?>" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="fichancomo_<?=$idtaller?>_def" name="fichancomo_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_comofichan):''?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="distrip_<?=$idtaller?>" class="col col-10 d-flex flex-row">Distribuidor piezas principal:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-end justify-content-sm-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_distrip==1?' checked="checked"':''?> class="orig" id="distrip_<?=$idtaller?>" name="distrip_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="distrip_<?=$idtaller?>_def" name="distrip_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_distrip:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" placeholder="Nombre" id="ndistrip_<?=$idtaller?>" name="ndistrip_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomdistri):''?>" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="ndistrip_<?=$idtaller?>_def" name="ndistrip_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomdistri):''?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="asist_<?=$idtaller?>" class="col col-10 d-flex flex-row">Asistencia t&eacute;cnica:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-end justify-content-sm-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_asistec==1?' checked="checked"':''?> class="orig" id="asist_<?=$idtaller?>" name="asist_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="asist_<?=$idtaller?>_def" name="asist_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_asistec:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" placeholder="Nombre" id="nasist_<?=$idtaller?>" name="nasist_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomasist):''?>" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="nasist_<?=$idtaller?>_def" name="nasist_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomasist):''?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="ecom_<?=$idtaller?>" class="col col-10 d-flex flex-row">Comercio electr&oacute;nico:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-end justify-content-sm-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_comelec==1?' checked="checked"':''?> class="orig" id="ecom_<?=$idtaller?>" name="ecom_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="ecom_<?=$idtaller?>_def" name="ecom_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_comelec:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <input type="text" placeholder="Nombre" id="necom_<?=$idtaller?>" name="necom_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomcomelec):''?>" onkeyup="comprueba_cambios('edita_info')">
                                            <input type="hidden" id="necom_<?=$idtaller?>_def" name="necom_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomcomelec):''?>" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="espera_<?=$idtaller?>" class="col col-10 d-flex flex-row">Zona de espera:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_zonaespera==1?' checked="checked"':''?> class="orig" id="espera_<?=$idtaller?>" name="espera_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="espera_<?=$idtaller?>_def" name="espera_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_zonaespera:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <label for="citas_<?=$idtaller?>" class="col col-10 d-flex flex-row">Pantalla de citas:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_pantcitas==1?' checked="checked"':''?> class="orig" id="citas_<?=$idtaller?>" name="citas_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="citas_<?=$idtaller?>_def" name="citas_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_pantcitas:0?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="cafe_<?=$idtaller?>" class="col col-10 d-flex flex-row">M&aacute;quinas de bebidas y caf&eacute;:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_maqcafe==1?' checked="checked"':''?> class="orig" id="cafe_<?=$idtaller?>" name="cafe_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="cafe_<?=$idtaller?>_def" name="cafe_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_maqcafe:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-start justify-content-sm-end">
                                            <label for="ofertas_<?=$idtaller?>" class="col col-10 d-flex flex-row ">Ofertas comerciales en recepci&oacute;n:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_ofrecep==1?' checked="checked"':''?> class="orig" id="ofertas_<?=$idtaller?>" name="ofertas_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="ofertas_<?=$idtaller?>_def" name="ofertas_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_ofrecep:0?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100 px-2 py-1">
                                        <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-between">
                                            <label for="tlfase_<?=$idtaller?>" class="col col-10 d-flex flex-row">Tel&eacute;fonos inal&aacute;mbricos asesores:</label>
                                            <div class="col col-2 d-flex flex-row align-items-center justify-content-center">
                                                <input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_telinal==1?' checked="checked"':''?> class="orig" id="tlfase_<?=$idtaller?>" name="tlfase_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="tlfase_<?=$idtaller?>_def" name="tlfase_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_telinal:0?>" />
                                            </div>
                                        </div>
                                        <div class="col col-12 col-sm-6 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between">
                                            <label for="porcita_<?=$idtaller?>" class="col col-12 col-sm-10 d-flex flex-row">% de entradas al taller con cita previa:</label>
                                            <div class="col col-12 col-sm-2 d-flex flex-row align-items-center justify-content-start justify-content-sm-center">
                                                <input type="text" id="porcita_<?=$idtaller?>" name="porcita_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$hay_datos?$infotaller[0]->it_porcentr:0?>" style="text-align:right" onkeyup="comprueba_cambios('edita_info')">
                                                <input type="hidden" id="porcita_<?=$idtaller?>_def" name="porcita_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_porcentr:0?>" />
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>

<?php
if (isset($_SESSION['datos_' . _ID_PAG_]['edita_info']['hayerrores'])) {
    $jsHayerrores = 0;
    $jsMensaje = "Guardado correctamente";
    if ($_SESSION['datos_' . _ID_PAG_]['edita_info']['hayerrores'] == 1) {
        $jsHayerrores = 1;
        $jsMensaje = empty($_SESSION['datos_' . _ID_PAG_]['edita_info']['error']) ? "No se ha podido guardar" : $_SESSION['datos_' . _ID_PAG_]['edita_info']['error'];
    }
    unset($_SESSION['datos_' . _ID_PAG_]['edita_info']);
}