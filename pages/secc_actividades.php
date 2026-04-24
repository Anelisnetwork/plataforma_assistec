<?php 
$actividades=tipos_actividad();
?>
    <form action="<?=_RAIZ_?>procesando.php" method="post" class="w-100" name="edita_actividad" id="edita_actividad">
    <div class="row g-3 mt-1 w-100">
        <div class="col">
            <div class="card shadow-custom rounded-custom">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="col-12 col-sm-6">
                            <h3 class="card-title d-flex align-items-center m-0">
                                Define las actividades del taller
                            </h3>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <input type="submit" class="btn btn-sm btn-secondary" style="display: none" id="edita_actividad_<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" name="edita_actividad_<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" value="Guardar" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-6 position-relative z-1">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                            <div id="activtaller" class="div_mostrarocultar col col-12 col-lg-8 d-flex flex-column align-items-center justify-content-start">
                                
                                    <input type="hidden" id="idproceso" name="idproceso" value="edita_actividad" />
                                    <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/actividades" />
                                    <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
                                    <div class="col col-12 d-none d-sm-flex flex-row align-items-center justify-content-between subtit">
                                        <span class="col col-5 text-center"><strong>ACTIVIDAD</strong></span>
                                        <span class="col col-3 text-center"><strong>METROS</strong></span>
                                        <span class="col col-2 text-center"><strong>PUESTOS</strong></span>
                                        <span class="col col-2 text-center"><strong>ELEVADORES</strong></span>
                                    </div>
                                    <?php foreach($actividades as $key=>$actividad){
                                        $activ_taller=dame_actividad($actividad->tac_idactiv, $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);?>
                                        <div class="col col-12 d-flex flex-column flex-sm-row align-items-center justify-content-start justify-content-sm-between rounded-2 p-3 p-sm-1 mb-1<?=($key%2)!=0?' text-bg-light':''?>">
                                            <div class="col col-12 col-sm-5 d-flex flex-rom align-items-center justify-content-between">
                                                <label for="activ_<?=$actividad->tac_idactiv?>" class="ancho"><?=u8_($actividad->tac_nombre)?>:</label>
                                                <input type="checkbox"<?=$activ_taller!=''?' checked="checked"':''?> class="orig me-0 me-sm-3" id="activ_<?=$actividad->tac_idactiv?>" name="activ_<?=$actividad->tac_idactiv?>" value="1" onchange="activa_actividad('<?=$actividad->tac_idactiv?>')">
                                                <input type="hidden" id="activ_<?=$actividad->tac_idactiv?>_def" name="activ_<?=$actividad->tac_idactiv?>_def" value="<?=$activ_taller!=''?1:0?>" />
                                            </div>
                                            <div class="col col-12 col-sm-3 d-flex flex-row align-items-center justify-content-between">
                                                <label for="metros_<?=$actividad->tac_idactiv?>" class="col col-4 d-flex d-sm-none me-3"> Metros: </label>
                                                <input type="number"<?=$activ_taller!=''?'':' disabled="disabled"'?> class="peq orig w-100 form-control form-control-sm" id="metros_<?=$actividad->tac_idactiv?>" name="metros_<?=$actividad->tac_idactiv?>" value="<?=isset($activ_taller['at_metros'])?$activ_taller['at_metros']:0.00?>" min="0" step="0.01" onchange="comprueba_cambios('edita_actividad')">
                                                <input type="hidden" id="metros_<?=$actividad->tac_idactiv?>_def" name="metros_<?=$actividad->tac_idactiv?>_def" value="<?=isset($activ_taller['at_metros'])?$activ_taller['at_metros']:0.00?>" />
                                            </div>
                                            <div class="col col-12 col-sm-2 d-flex flex-row align-items-center justify-content-between">
                                                <label for="puestos_<?=$actividad->tac_idactiv?>" class="col col-4 d-flex d-sm-none me-3"> Puestos: </label>
                                                <input type="number"<?=$activ_taller!=''?'':' disabled="disabled"'?> class="peq orig w-100 form-control form-control-sm" id="puestos_<?=$actividad->tac_idactiv?>" name="puestos_<?=$actividad->tac_idactiv?>" value="<?=isset($activ_taller['at_puestos'])?$activ_taller['at_puestos']:0?>" min="0" onchange="comprueba_cambios('edita_actividad')">
                                                <input type="hidden" id="puestos_<?=$actividad->tac_idactiv?>_def" name="puestos_<?=$actividad->tac_idactiv?>_def" value="<?=isset($activ_taller['at_puestos'])?$activ_taller['at_puestos']:0?>" />
                                            </div>
                                            <div class="col col-12 col-sm-2 d-flex flex-row align-items-center justify-content-between">
                                                <label for="elevadores_<?=$actividad->tac_idactiv?>" class="col col-4 d-flex d-sm-none me-3"> Elevdores: </label>
                                                <input type="number"<?=$activ_taller!=''?'':' disabled="disabled"'?> class="peq orig w-100 form-control form-control-sm" id="elevadores_<?=$actividad->tac_idactiv?>" name="elevadores_<?=$actividad->tac_idactiv?>" value="<?=isset($activ_taller['at_elevadores'])?$activ_taller['at_elevadores']:0?>" min="0" onchange="comprueba_cambios('edita_actividad')">
                                                <input type="hidden" id="elevadores_<?=$actividad->tac_idactiv?>_def" name="elevadores_<?=$actividad->tac_idactiv?>_def" value="<?=isset($activ_taller['at_elevadores'])?$activ_taller['at_elevadores']:0?>" />
                                            </div>
                                        </div>
                                    <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>



<?php
if (isset($_SESSION['datos_' . _ID_PAG_]['edita_actividad']['hayerrores'])) {
    $jsHayerrores = 0;
    $jsMensaje = "Guardado correctamente";
    if ($_SESSION['datos_' . _ID_PAG_]['edita_actividad']['hayerrores'] == 1) {
        $jsHayerrores = 1;
        $jsMensaje = empty($_SESSION['datos_' . _ID_PAG_]['edita_actividad']['error']) ? "No se ha podido guardar" : $_SESSION['datos_' . _ID_PAG_]['edita_actividad']['error'];
    }
    unset($_SESSION['datos_' . _ID_PAG_]['edita_actividad']);
}