<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores']==1){?>
    <script>
	alertify.error("No se ha podido guardar");
	</script>
	<?php }
	else{?>
    <script>
	alertify.success("Guardado correctamente");
	</script>
	<?php }
}

$tipos_equipamiento=tipos_equipamiento();

$equipamientos=dame_equipamiento($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);?>

<div class="row g-3 mt-1 w-100">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title d-flex align-items-center m-0">
                            Registro de equipamiento
                        </h3>
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                        <span class="oswald mostrarocultar btn btn-sm btn-secondary col-12 col-sm-auto" id="mostrarocultar_nuevoequipo">Añadir equipamiento</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                        <div class="col col-12 col-md-8 col-xl-6 d-flex flex-column align-items-center justify-content-start">
                            <div id="nuevoequipo" class="div_mostrarocultar w-100" style="display:none">
                                <div class=" flex-column align-items-start justify-content-between w-100 mb-3">
                                    <div class="linea equipo_NEW d-flex flex-column align-items-start justify-content-between w-100 p-2 p-sm-4 rounded-2 mb-3 border border-warning">
                                        <form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_equipamiento" id="nuevo_equipamiento" class="w-100">
                                            <input type="hidden" id="idproceso" name="idproceso" value="edita_equipamiento" />
                                            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/equipamiento" />
                                            <input type="hidden" id="idequipo" name="idequipo" value="NEW" />
                                            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
                                            <div class="d-flex flex-row align-items-start align-items-sm-center justify-content-start w-100 mb-2">
                                                <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                    <label for="tipo_NEW" class="d-none d-sm-flex me-2">Seleccione:</label>
                                                    <select id="tipo_NEW" name="tipo_NEW" class="form-select form-select-sm" style="width:auto">
                                                        <?php foreach($tipos_equipamiento as $tipo_equipamiento){?>
                                                            <option value="<?=$tipo_equipamiento->te_idequip?>"><?=$tipo_equipamiento->te_nombre?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="d-flex flex-row align-items-center justify-content-end w-100 ms-0 ms-sm-2">
                                                    <label for="cantidad_NEW" style="width:auto; margin:0px 5px">X</label>
                                                    <input type="number" id="cantidad_NEW" name="cantidad_NEW" value="1" min="0" max="100" step="1" class="form-control form-control-sm" style="width:50px;">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start w-100 mb-1">
                                                <input type="text" id="notas_NEW" class="form-control form-control-sm col-12 col-sm auto mb-2 mb-sm-0" name="notas_NEW" value="<?=isset($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['notas_NEW'])?$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['notas_NEW']:''?>" placeholder="Notas">
                                            </div>
                                            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                                                <span class="mostrarocultar btn btn-sm btn-light col-12 col-sm-auto" id="mostrarocultar_nuevoequipo">Cancelar</span>
                                                <input type="submit" id="guardaequipo_NEW" name="guardaequipo_NEW" value="Guardar" class="btn btn-sm btn-secondary ms-0 ms-sm-2 col-12 col-sm-auto" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="contequipos" class=" flex-column align-items-start justify-content-between w-100 mb-3">
                                <?php if(count($equipamientos)>0){
                                    foreach($equipamientos as $k=>$equipamiento){?>
                                        <div class="linea equipo d-flex flex-column align-items-start justify-content-between w-100 p-2 p-sm-4 rounded-2 mb-3<?=$k%2 != 0 ? '' : ' text-bg-secondary'?>" id="it_equipamiento_<?=$equipamiento->et_idequip?>">
                                            <form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_equipamiento" id="nuevo_equipamiento" class="w-100">
                                                <input type="hidden" id="idproceso" name="idproceso" value="edita_equipamiento" />
                                                <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/equipamiento" />
                                                <input type="hidden" id="idequipo" name="idequipo" value="<?=$equipamiento->et_idequip?>" />
                                                <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
                                                <div class="d-flex flex-row align-items-end align-items-sm-center justify-content-end w-100 mb-2">
                                                    <div class=" fa fa-xmark fs_20 text-danger" style="cursor: pointer" title="Eliminar" onclick="eliminar('equipamiento', '<?=$equipamiento->et_idequip?>')"></div>
                                                </div>
                                                <div class="d-flex flex-row align-items-start align-items-sm-center justify-content-start w-100 mb-2">
                                                    <div class="d-flex flex-row align-items-center justify-content-start w-100">
                                                        <label for="tipo_<?=$equipamiento->et_idequip?>" class="d-none d-sm-flex me-2">Equipamiento:</label>
                                                        <select id="tipo_<?=$equipamiento->et_idequip?>" name="tipo_<?=$equipamiento->et_idequip?>" class="form-select form-select-sm" style="width:auto">
                                                            <?php foreach($tipos_equipamiento as $tipo_equipamiento){?>
                                                                <option value="<?=$tipo_equipamiento->te_idequip?>"<?=$tipo_equipamiento->te_idequip==$equipamiento->et_idtipo?' selected="selected"':''?>><?=$tipo_equipamiento->te_nombre?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center justify-content-end w-100 ms-0 ms-sm-2">
                                                        <input type="hidden" id="tipo_<?=$equipamiento->et_idequip?>_def" name="tipo_<?=$equipamiento->et_idequip?>_def" value="<?=$equipamiento->et_idtipo?>" />
                                                        <label for="cantidad_<?=$equipamiento->et_idequip?>" style="width:auto; margin:0px 5px">X</label>
                                                        <input type="number" id="cantidad_<?=$equipamiento->et_idequip?>" name="cantidad_<?=$equipamiento->et_idequip?>" value="<?=$equipamiento->et_cantidad?>" min="0" max="100" step="1" class="form-control form-control-sm" style="width:50px;" onchange="comprueba_cambios_equipo('<?=$equipamiento->et_idequip?>')" onkeyup="comprueba_cambios_equipo('<?=$equipamiento->et_idequip?>')">
                                                        <input type="hidden" id="cantidad_<?=$equipamiento->et_idequip?>_def" name="cantidad_<?=$equipamiento->et_idequip?>_def" value="<?=$equipamiento->et_cantidad?>" />
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start w-100">
                                                    <input type="text" id="notas_<?=$equipamiento->et_idequip?>" name="notas_<?=$equipamiento->et_idequip?>" class="form-control form-control-sm col-12 col-sm auto mb-2 mb-sm-0" value="<?=u8d_($equipamiento->et_notas)?>" placeholder="Notas" onkeyup="comprueba_cambios_equipo('<?=$equipamiento->et_idequip?>')">
                                                    <input type="hidden" id="notas_<?=$equipamiento->et_idequip?>_def" name="notas_<?=$equipamiento->et_idequip?>_def" value="<?=u8d_($equipamiento->et_notas)?>" />
                                                    <input type="submit" id="guardaequipo_<?=$equipamiento->et_idequip?>" name="guardaequipo_<?=$equipamiento->et_idequip?>" class="btn btn-sm btn-secondary ms-0 ms-sm-2 col-12 col-sm-auto" value="Guardar" style="display:none" />
                                                </div>
                                            </form>
                                        </div>
                                    <?php }
                                }?>
                                <?php unset($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


