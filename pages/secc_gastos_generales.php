<?php
/*
 * INSERT INTO `secciones` (`sc_idseccion`, `sc_idmodulo`, `sc_nombre`, `sc_url`, `sc_orden`) VALUES (NULL, '2', 'gastos generales', 'gastos_generales', '7');
 * UPDATE `secciones` SET `sc_nombre` = 'Gastos generales' WHERE `secciones`.`sc_idseccion` = 29;
 */
$infotaller=dame_gastos($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);

$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];

$haydatos=count($infotaller)==1;

$nominas=$haydatos?$infotaller[0]->nominas:0;
$seg_social=$haydatos?$infotaller[0]->seg_social:0;
$alquileres=$haydatos?$infotaller[0]->alquileres:0;
$suministros=$haydatos?$infotaller[0]->suministros:0;
$renting=$haydatos?$infotaller[0]->renting:0;
$serv_prof=$haydatos?$infotaller[0]->serv_prof:0;
$cuotas=$haydatos?$infotaller[0]->cuotas:0;
$amortizaciones=$haydatos?$infotaller[0]->amortizaciones:0;
$otros=$haydatos?$infotaller[0]->otros:0;


$porcentajes=personal_porcentaje($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);

?>
    <form action="<?=_RAIZ_?>procesando.php" method="post" class="w-100" name="edita_gastos" id="edita_gastos">
    <div class="row g-3 mt-1 w-100">
        <div class="col">
            <div class="card shadow-custom rounded-custom">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="col-12 col-sm-6">
                            <h3 class="card-title d-flex align-items-center m-0">
                                Registro de gastos generales del taller
                            </h3>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <input type="submit" style="display:none" id="edita_gastos_<?=$idtaller?>" name="edita_gastos_<?=$idtaller?>" value="Guardar" class="btn btn-sm btn-secondary"/>
                        </div>
                    </div>
                </div>
                <div class="card-body p-6 position-relative z-1">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                            <div class="col col-12 col-md-8 d-flex flex-column align-items-center justify-content-start">
                                <div id="infotaller" class="div_mostrarocultar w-100">

                                        <input type="hidden" id="idproceso" name="idproceso" value="edita_gastos" />
                                        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/gastos_generales" />
                                        <input type="hidden" id="idtaller" name="idtaller" value="<?=$idtaller?>" />
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <span class="text-danger me-1">*</span>
                                                <label for="nominas_<?=$idtaller?>">Coste personal:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="nominas_<?=$idtaller?>" name="nominas_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$nominas?>" onkeyup="comprueba_cambios('edita_gastos')" style="width: auto; text-align: right">
                                                <span class="fs_14">&euro;</span>
                                                <input type="hidden" id="nominas_<?=$idtaller?>_def" name="nominas_<?=$idtaller?>_def" value="<?=$nominas?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="seg_social_<?=$idtaller?>" class="ancho">Coste Seg. social trab.:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="seg_social_<?=$idtaller?>" name="seg_social_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$seg_social?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')">
                                                <span class="fs_14">&euro;</span>
                                                <input type="hidden" id="seg_social_<?=$idtaller?>_def" name="seg_social_<?=$idtaller?>_def" value="<?=$seg_social?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="gastos_pers_<?=$idtaller?>" class="texto_r ancho">Total gastos de personal:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="gastos_pers_<?=$idtaller?>" name="gastos_pers_<?=$idtaller?>" class="peq orig form-control form-control-sm text-bg-secondary" value="<?=moneda_punto(($nominas+$seg_social),2)?>" style="width:auto; text-align:right; " readonly>
                                                <span class="fs_14"">&euro;</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="alquileres_<?=$idtaller?>" class="ancho">Alquileres:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="alquileres_<?=$idtaller?>" name="alquileres_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$alquileres?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')">
                                                <span class="fs_14">&euro;</span>
                                                <input type="hidden" id="alquileres_<?=$idtaller?>_def" name="alquileres_<?=$idtaller?>_def" value="<?=$alquileres?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <span class="text-danger me-1">*</span>
                                                <label for="suministros_<?=$idtaller?>" class="ancho">Suministros:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="suministros_<?=$idtaller?>" name="suministros_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$suministros?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')">
                                                <span class="fs_14">&euro;</span>
                                                <input type="hidden" id="suministros_<?=$idtaller?>_def" name="suministros_<?=$idtaller?>_def" value="<?=$suministros?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="renting_<?=$idtaller?>" class="ancho">Renting de equipos:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="renting_<?=$idtaller?>" name="renting_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$renting?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14">&euro;</span>
                                                <input type="hidden" id="renting_<?=$idtaller?>_def" name="renting_<?=$idtaller?>_def" value="<?=$renting?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <span class="text-danger me-1">*</span>
                                                <label for="serv_prof_<?=$idtaller?>" class="ancho">Servicios profesionales:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="serv_prof_<?=$idtaller?>" name="serv_prof_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$serv_prof?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')">
                                                <span class="fs_14"">&euro;</span>
                                                <input type="hidden" id="serv_prof_<?=$idtaller?>_def" name="serv_prof_<?=$idtaller?>_def" value="<?=$serv_prof?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="cuotas_<?=$idtaller?>" class="ancho">Cuotas:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="cuotas_<?=$idtaller?>" name="cuotas_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$cuotas?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14">&euro;</span>
                                                <input type="hidden" id="cuotas_<?=$idtaller?>_def" name="cuotas_<?=$idtaller?>_def" value="<?=$cuotas?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="amortizaciones_<?=$idtaller?>" class="ancho">Amortizaciones:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="amortizaciones_<?=$idtaller?>" name="amortizaciones_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$amortizaciones?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')">
                                                <span class="fs_14">&euro;</span>
                                                <input type="hidden" id="amortizaciones_<?=$idtaller?>_def" name="amortizaciones_<?=$idtaller?>_def" value="<?=$amortizaciones?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="otros_<?=$idtaller?>" class="ancho">Otros gastos:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="otros_<?=$idtaller?>" name="otros_<?=$idtaller?>" class="peq orig form-control form-control-sm" value="<?=$otros?>" style="width:auto; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14">&euro;</span>
                                                <input type="hidden" id="otros_<?=$idtaller?>_def" name="otros_<?=$idtaller?>_def" value="<?=$otros?>" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                                            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                <label for="gastos_estruc_<?=$idtaller?>" class="texto_r ancho">Total gastos de estructura:</label>
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-start justify-content-sm-end w-100 ms-0 ms-sm-2">
                                                <input type="text" id="gastos_estruc_<?=$idtaller?>" name="gastos_estruc_<?=$idtaller?>" class="peq orig form-control form-control-sm text-bg-secondary" value="<?=moneda_punto(($alquileres+$suministros+$renting+$serv_prof+$cuotas+$amortizaciones+$otros),2)?>" style="width:auto; text-align:right; " disabled>
                                                <span class="fs_14">&euro;</span>
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
if (isset($_SESSION['datos_' . _ID_PAG_]['edita_gastos']['hayerrores'])) {
    $jsHayerrores = 0;
    $jsMensaje = "Guardado correctamente";
    if ($_SESSION['datos_' . _ID_PAG_]['edita_gastos']['hayerrores'] == 1) {
        $jsHayerrores = 1;
        $jsMensaje = empty($_SESSION['datos_' . _ID_PAG_]['edita_gastos']['error']) ? "No se ha podido guardar" : $_SESSION['datos_' . _ID_PAG_]['edita_gastos']['error'];
    }
    unset($_SESSION['datos_' . _ID_PAG_]['edita_gastos']);
}