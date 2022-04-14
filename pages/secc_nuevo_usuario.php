<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']==1){
		$mensaje='No se ha podido guardar';
		if(isset($_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['mensaje'])){
			$mensaje=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['mensaje'];
		}?>
    <script>
	alertify.error("<?=$mensaje?>");
	</script>
	<?php }
	else{
		$mensaje='Guardado correctamente';?>
    <script>
	alertify.success("<?=$mensaje?>");
	</script>
	<?php }
}
?>
<div class="linea usuario_NEW">
    <form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_usuario" id="nuevo_usuario">
        <input type="hidden" id="idproceso" name="idproceso" value="nuevo_usuario" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>usuarios/nuevo_usuario" />
        <input type="hidden" id="idusuario" name="idusuario" value="NEW" />
        <div class="linea">
            <label for="rango_NEW">Tipo usuario:</label>
            <select id="rango_NEW" name="rango_NEW" onchange="cambiarango(this.value)" >
			<?php foreach($l_rangos as $rango){?>
                <option value="<?=$rango->ru_idrango?>"<?=$rango->ru_idrango==1||$rango->ru_idrango==4?' disabled="disabled"':($rango->ru_idrango==3?' selected="selected"':'')?>><?=$rango->ru_nombre?></option>
            <?php }?>
            </select>
            <input type="submit" id="guardadatos_NEW" name="guardadatos_NEW" value="Guardar" style="margin:0px" />
        </div>
        <div class="linea" id="parataller">
            <label for="taller_NEW">Para el taller:</label>
            <select id="taller_NEW" name="taller_NEW">
            	<option value="0" disabled="disabled" selected="selected">Seleccione:</option>
            	<?php foreach($l_talleres as $taller){?>
                <option value="<?=$taller->ta_idtaller?>" title="<?=u8d_($taller->ta_nombre)?>"><?=u8d_($taller->uf_nomcom)?></option>
                <?php }?>
            </select>
        </div>
        <div class="linea" id="parared" style="display:none">
            <label for="red_NEW">Para la red:</label>
            <select id="red_NEW" name="red_NEW">
            	<option value="0" disabled="disabled" selected="selected">Seleccione:</option>
            	<?php foreach($l_redes as $red){?>
                <option value="<?=$red->ta_idtaller?>"><?=$red->ta_nombre?></option>
                <?php }?>
            </select>
        </div>
        <div class="linea">
            <label for="estado_NEW">Estado:</label>
            <select id="estado_NEW" name="estado_NEW" >
            	<?php foreach($l_estados as $estado){?>
                <option<?=$estado->eu_idestado==2?' disabled="disabled"':''?> value="<?=$estado->eu_idestado?>"><?=$estado->eu_nombre?></option>
                <?php }?>
            </select>
        </div>
        
        <div class="linea">
            <label for="nick_NEW">Nick / Alias:</label>
            <input type="text" id="nick_NEW" name="nick_NEW" value="" onkeyup="comprueba_sino(this.value, 'nick')">
            <input type="hidden" id="nick_val" name="nick_val" value="1">
            <div id="nick_sino"></div>
        </div>
        <div class="linea">
            <label for="correo_NEW">Correo acceso:</label>
            <input type="text" id="correo_NEW" name="correo_NEW" value="" onkeyup="comprueba_sino(this.value, 'correo')" required="required">
            <input type="hidden" id="correo_val" name="correo_val" value="0">
            <div id="correo_sino"><img class="sino" title="No es válido" src="<?=_RAIZ_?>imagenes/no.png" /></div>
        </div>
        <div class="linea">
            <label for="pass_NEW">Contrase&ntilde;a acceso:</label>
            <input type="password" id="pass_NEW" name="pass_NEW" value="" placeholder="Si la deja en blanco se asignará una contraseña aleatoria" onkeyup="comprueba_sino(this.value, 'pass')">
            <input type="hidden" id="pass_val" name="pass_val" value="1">
            <div id="pass_sino"></div>
        </div>
    </form>
</div>
<?php 
unset($_SESSION['datos_'._ID_PAG_]['nuevo_usuario']);
?>