<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_actividad']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_actividad']['hayerrores']==1){?>
    <script>
	alertify.error("Han ocurrido errores al guardar");
	</script>
	<?php }
	else{?>
    <script>
	alertify.success("Guardado correctamente");
	</script>
	<?php }
}
$actividades=tipos_actividad();
?>
<div id="activtaller" class="div_mostrarocultar" style="float:left;">	
	<form action="<?=_RAIZ_?>procesando.php" method="post" name="edita_actividad" id="edita_actividad">
        <input type="hidden" id="idproceso" name="idproceso" value="edita_actividad" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/actividades" />
        <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
        <div class="linea">
            <span class="subtit" style="padding:5px 60px"><strong>ACTIVIDAD</strong></span>
            <span class="subtit"><strong>METROS</strong></span>
            <span class="subtit"><strong>PUESTOS</strong></span>
            <span class="subtit"><strong>ELEVADORES</strong></span>
        </div>
        <?php foreach($actividades as $key=>$actividad){
			$activ_taller=dame_actividad($actividad->tac_idactiv, $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);?>
        <div class="linea">
            <label for="activ_<?=$actividad->tac_idactiv?>" class="ancho"><?=u8_($actividad->tac_nombre)?>:</label>
            <input type="checkbox"<?=$activ_taller!=''?' checked="checked"':''?> class="orig" id="activ_<?=$actividad->tac_idactiv?>" name="activ_<?=$actividad->tac_idactiv?>" value="1" onchange="activa_actividad('<?=$actividad->tac_idactiv?>')">
            <input type="hidden" id="activ_<?=$actividad->tac_idactiv?>_def" name="activ_<?=$actividad->tac_idactiv?>_def" value="<?=$activ_taller!=''?1:0?>" />
            <input type="number"<?=$activ_taller!=''?'':' disabled="disabled"'?> class="peq orig" id="metros_<?=$actividad->tac_idactiv?>" name="metros_<?=$actividad->tac_idactiv?>" value="<?=isset($activ_taller['at_metros'])?$activ_taller['at_metros']:0.00?>" min="0" step="0.01" onchange="comprueba_cambios('edita_actividad')">
            <input type="hidden" id="metros_<?=$actividad->tac_idactiv?>_def" name="metros_<?=$actividad->tac_idactiv?>_def" value="<?=isset($activ_taller['at_metros'])?$activ_taller['at_metros']:0.00?>" />
            <input type="number"<?=$activ_taller!=''?'':' disabled="disabled"'?> class="peq orig" id="puestos_<?=$actividad->tac_idactiv?>" name="puestos_<?=$actividad->tac_idactiv?>" value="<?=isset($activ_taller['at_puestos'])?$activ_taller['at_puestos']:0?>" min="0" onchange="comprueba_cambios('edita_actividad')">
            <input type="hidden" id="puestos_<?=$actividad->tac_idactiv?>_def" name="puestos_<?=$actividad->tac_idactiv?>_def" value="<?=isset($activ_taller['at_puestos'])?$activ_taller['at_puestos']:0?>" />
            <input type="number"<?=$activ_taller!=''?'':' disabled="disabled"'?> class="peq orig" id="elevadores_<?=$actividad->tac_idactiv?>" name="elevadores_<?=$actividad->tac_idactiv?>" value="<?=isset($activ_taller['at_elevadores'])?$activ_taller['at_elevadores']:0?>" min="0" onchange="comprueba_cambios('edita_actividad')">
            <input type="hidden" id="elevadores_<?=$actividad->tac_idactiv?>_def" name="elevadores_<?=$actividad->tac_idactiv?>_def" value="<?=isset($activ_taller['at_elevadores'])?$activ_taller['at_elevadores']:0?>" />
        </div>
        <?php }?>
        <input type="submit" style="display:none" id="edita_actividad_<?=$infotaller[0]->it_idtaller?>" name="edita_actividad_<?=$infotaller[0]->it_idtaller?>" value="Guardar" />
</div>
<?php unset($_SESSION['datos_'._ID_PAG_]['edita_actividad']);?>