<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores']==1){?>
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
$empleados=dame_empleados();

$porcentajes=personal_porcentaje($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);

//var_dump($porcentajes);
?>
<div class="linea">
    <span style="float:left; margin-top: 7px" class="oswald fs_16">A&Ntilde;ADIR EMPLEADO</span><div class="link mostrarocultar" id="mostrarocultar_nuevoempleado" style="margin-top: 11px"></div>

    <span style="float:left; margin-top: 7px; margin-left: 50px" class="oswald fs_16">TOTAL EMPLEADOS: <span id="empleados_total"><?=$porcentajes[0]?></span></span>

    <div style="float: right">
        <span style="float:left; margin-top: 0px;" class="ubuntu fs_16">Empleados directos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="empleados_directos"><?=$porcentajes[4]?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<span id="empleados_dir_porc"><?=$porcentajes[2]?></span>%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fs_12 texto_r">Recomendado 70%</span></span>
    </div>

    <div style="float: right">
        <span style="float:left; margin-top: 5px;" class="ubuntu fs_16">Empleados indirectos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="empleados_indirectos"><?=$porcentajes[5]?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<span id="empleados_indir_porc"><?=$porcentajes[3]?></span>%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fs_12 texto_r">Recomendado 30%</span></span>
    </div>
</div>

<br clear="all"><br clear="all"><br clear="all">

<div id="nuevoempleado" class="div_mostrarocultar" style="display:none">
	<div class="linea empleado_NEW">
        <form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_empleado" id="nuevo_empleado">
            <input type="hidden" id="idproceso" name="idproceso" value="edita_empleado" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/personal" />
            <input type="hidden" id="idempleado" name="idempleado" value="NEW" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
            <div class="izq">
                <div class="linea">
                    <label for="nombre_NEW" style="width:70px">Nombre:</label><input type="text" id="nombre_NEW" name="nombre_NEW" style="width:250px" value="">
                    <label for="jornada_NEW" style="width:120px; margin-left:15px">Jornada (horas):</label><input type="text" id="jornada_NEW" name="jornada_NEW" style="width:40px" value="8.00">
                    <input type="submit" id="guardaempleado_NEW" name="guardaempleado_NEW" value="Guardar" />
                </div>
                <div class="linea" style="margin-top:15px">
                    <span class="oswald texto_r">Funciones: <span class="fs_12 ubuntu texto_n"> (Indique las funciones que desempe&ntilde;a este empleado y el porcentaje de cada una de ellas)</span></span>
                </div>
                <div class="linea">
                <?php $tipos_personal=tipos_personal();
                for($nf=1; $nf<=4; $nf++){?>
                    <div class="funcion">
                        <select id="funcion_<?=$nf?>_NEW" name="funcion_<?=$nf?>_NEW">
                            <option value="" selected="selected" disabled="disabled">Seleccione</option>
                            <?php foreach($tipos_personal as $tipo_personal){?>
                            <optgroup label="<?=$tipo_personal->tp_definicion?>">
                            <?php $cargos_personal=cargos_personal($tipo_personal->tp_idtipo);
                            foreach($cargos_personal as $cargo_personal){?>
                            <option value="<?=$cargo_personal->cp_idpersonal?>"><?=$cargo_personal->cp_nombre?></option>
                            <?php }?>
                            </optgroup>
                            <?php }?>
                        </select>
                        <br clear="all" />
                        <select id="porcent_<?=$nf?>_NEW" name="porcent_<?=$nf?>_NEW">
                            <?php for($pr=0; $pr<=100; $pr+=25){?>
                            <option value="<?=$pr?>"><?=$pr?>%</option>
                            <?php }?>
                        </select>
                    </div>
                <?php }?>
                </div>
            </div>
            <textarea id="notas_NEW" name="notas_NEW" placeholder="Notas" class="der"></textarea>
    </form>
    </div>
</div>
<div id="contempleados" class="div_mostrarocultar">
<?php if(count($empleados)>0){
	foreach($empleados as $empleado){?>
    <div class="linea empleado" id="it_empleado_<?=$empleado->pt_idpersonal?>">
    	<form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_empleado_<?=$empleado->pt_idpersonal?>" id="nuevo_empleado_<?=$empleado->pt_idpersonal?>">
            <input type="hidden" id="idproceso" name="idproceso" value="edita_empleado" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/personal" />
            <input type="hidden" id="idempleado" name="idempleado" value="<?=$empleado->pt_idpersonal?>" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
            <div class="izq">
                <div class="linea">
                    <label for="nombre_<?=$empleado->pt_idpersonal?>" style="width:70px">Nombre:</label><input type="text" id="nombre_<?=$empleado->pt_idpersonal?>" name="nombre_<?=$empleado->pt_idpersonal?>" style="width:250px" value="<?=u8d_($empleado->pt_nombre)?>" onkeyup="comprueba_cambios_empleado('<?=$empleado->pt_idpersonal?>')">
                    <label for="jornada_<?=$empleado->pt_idpersonal?>" style="margin-left:15px; width:120px">Jornada (horas):</label><input type="text" id="jornada_<?=$empleado->pt_idpersonal?>" name="jornada_<?=$empleado->pt_idpersonal?>" style="width:40px; text-align:right" value="<?=$empleado->pt_jornada?>" onkeyup="comprueba_cambios_empleado('<?=$empleado->pt_idpersonal?>')">
                    <input type="submit" style="display:none" id="guardaempleado_<?=$empleado->pt_idpersonal?>" name="guardaempleado_<?=$empleado->pt_idpersonal?>" value="Guardar" />
                    <input type="hidden" id="nombre_<?=$empleado->pt_idpersonal?>_def" name="nombre<?=$empleado->pt_idpersonal?>_def" value="<?=u8d_($empleado->pt_nombre)?>" />
                    <input type="hidden" id="jornada_<?=$empleado->pt_idpersonal?>_def" name="jornada_<?=$empleado->pt_idpersonal?>_def" value="<?=$empleado->pt_jornada?>" />
                </div>
                <div class="linea">
                    <span class="fs_12 ubuntu texto_n"><strong>ID:</strong> <?=en__id($empleado->pt_idpersonal)?></span>
                </div>
                <div class="linea" style="margin-top:15px">
                    <span class="oswald texto_r" style="float:left">Funciones: <span class="fs_12 ubuntu texto_n"> (Indique las funciones que desempe&ntilde;a este empleado y el porcentaje de cada una de ellas)</span></span>
                    <div class="onoff link" title="<?=$empleado->pt_activo==1?'Desactivar':'Activar'?>" id="onoff_<?=$empleado->pt_idpersonal?>" style="background-position:<?=$empleado->pt_activo==1?'top':'bottom'?>" onclick="eliminar('empleado', '<?=$empleado->pt_idpersonal?>')"></div>
                </div>
                <div class="linea">
                <?php 
                $funciones=funciones_personal($empleado->pt_idpersonal);
                $tipos_personal=tipos_personal();
                for($nf=1,$clave=0; $nf<=4; $nf++,$clave++){?>
                    <div class="funcion">
                        <input type="hidden" id="funcion_<?=$nf?>_<?=$empleado->pt_idpersonal?>_def" name="funcion_<?=$nf?>_<?=$empleado->pt_idpersonal?>_def" value="<?=array_key_exists($clave, $funciones)?$funciones[$clave]->pf_idcargo:''?>" />
                        <select id="funcion_<?=$nf?>_<?=$empleado->pt_idpersonal?>" name="funcion_<?=$nf?>_<?=$empleado->pt_idpersonal?>" onchange="comprueba_cambios_empleado('<?=$empleado->pt_idpersonal?>')">
                            <option value="0"<?=array_key_exists($clave, $funciones)?'':' selected="selected"'?> disabled="disabled">Seleccione</option>
                            <?php foreach($tipos_personal as $tipo_personal){?>
                            <optgroup label="<?=$tipo_personal->tp_definicion?>">
                            <?php $cargos_personal=cargos_personal($tipo_personal->tp_idtipo);
                            foreach($cargos_personal as $cargo_personal){?>
                            <option<?=array_key_exists($clave, $funciones)&&$funciones[$clave]->pf_idcargo==$cargo_personal->cp_idpersonal?' selected="selected"':''?> value="<?=$cargo_personal->cp_idpersonal?>"><?=$cargo_personal->cp_nombre?></option>
                            <?php }?>
                            </optgroup>
                            <?php }?>
                        </select>
                        <br clear="all" />
                        <input type="hidden" id="porcent_<?=$nf?>_<?=$empleado->pt_idpersonal?>_def" name="porcent_<?=$nf?>_<?=$empleado->pt_idpersonal?>_def" value="<?=array_key_exists($clave, $funciones)?$funciones[$clave]->pf_porcentaje:0?>" />
                        <select id="porcent_<?=$nf?>_<?=$empleado->pt_idpersonal?>" name="porcent_<?=$nf?>_<?=$empleado->pt_idpersonal?>" onchange="comprueba_cambios_empleado('<?=$empleado->pt_idpersonal?>')">
                            <?php for($pr=0; $pr<=100; $pr+=25){?>
                            <option<?=array_key_exists($clave, $funciones)&&$funciones[$clave]->pf_porcentaje==$pr?' selected="selected"':($pr==0?' selected="selected"':'')?> value="<?=$pr?>"><?=$pr?>%</option>
                            <?php }?>
                        </select>
                    </div>
                <?php }?>
                </div>
            </div>
            <textarea id="notas_<?=$empleado->pt_idpersonal?>" name="notas_<?=$empleado->pt_idpersonal?>" placeholder="Notas" class="der" onkeyup="comprueba_cambios_empleado('<?=$empleado->pt_idpersonal?>')"><?=u8d_($empleado->pt_notas)?></textarea>
            <input type="hidden" id="notas_<?=$empleado->pt_idpersonal?>_def" name="notas_<?=$empleado->pt_idpersonal?>_def" value="<?=u8d_($empleado->pt_notas)?>" />
        </form>
    </div>
<?php }
}
unset($_SESSION['datos_'._ID_PAG_]['edita_empleado']);?>
</div>