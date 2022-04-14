<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_usuario']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_usuario']['hayerrores']==1){
		$mensaje='No se ha podido guardar';
		if(isset($_SESSION['datos_'._ID_PAG_]['edita_usuario']['mensaje'])){
			$mensaje=$_SESSION['datos_'._ID_PAG_]['edita_usuario']['mensaje'];
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

if($d_user==''||$d_user==NULL||$d_user['us_rango']==1){?>
<div class="linea">
	<span class="oswald fs_16 texto_r">NO HAY DATOS</span>
</div>
<?php }
else{?>
<div class="linea usuario_<?=$d_user['us_idusuario']?>">
    <form action="<?=_RAIZ_?>procesando.php" method="post" name="edita_usuario" id="edita_usuario">
        <input type="hidden" id="idproceso" name="idproceso" value="edita_usuario" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>usuarios/editar_usuario/<?=$d_user['us_idusuario']?>" />
        <input type="hidden" id="idusuario" name="idusuario" value="<?=$d_user['us_idusuario']?>" />
        <div class="linea">
            <label for="nick_<?=$d_user['us_idusuario']?>">Nick / Alias:</label>
            <input type="text" id="nick_<?=$d_user['us_idusuario']?>" name="nick_<?=$d_user['us_idusuario']?>" value="<?=$d_user['us_nick']?>" disabled="disabled">
            <input type="submit" id="guardadatos_<?=$d_user['us_idusuario']?>" name="guardadatos_<?=$d_user['us_idusuario']?>" value="Guardar" style="margin:0px; display:none" />
        </div>
        <div class="linea">
            <label for="correo_<?=$d_user['us_idusuario']?>">Correo acceso:</label>
            <input type="text" id="correo_<?=$d_user['us_idusuario']?>" name="correo_<?=$d_user['us_idusuario']?>" value="<?=$d_user['us_correo']?>" disabled="disabled">
        </div>
        <div class="linea">
            <label for="alta_<?=$d_user['us_idusuario']?>">Fecha alta:</label>
            <input type="text" id="alta_<?=$d_user['us_idusuario']?>" name="alta_<?=$d_user['us_idusuario']?>" value="<?=fecha_esp($d_user['us_fecha_alta'])?>" disabled="disabled">
        </div>
        <div class="linea">
            <label for="estado_<?=$d_user['us_idusuario']?>">Estado:</label>
            <select id="estado_<?=$d_user['us_idusuario']?>" name="estado_<?=$d_user['us_idusuario']?>" class="orig" onchange="comprueba_cambios('edita_usuario')">
            	<?php foreach($l_estados as $estado){?>
                <option value="<?=$estado->eu_idestado?>"<?=$estado->eu_idestado==$d_user['us_estado']?' selected="selected"':''?>><?=$estado->eu_nombre?></option>
                <?php }?>
            </select>
            <?php if($d_user['us_estado']==3 && $d_user['us_fecha_baja']!='0000-00-00 00:00:00'){?>
            <span style="float: left; margin: 7px 20px;">Fecha de baja: <?=fecha_esp($d_user['us_fecha_baja'])?></span>
        <?php }?>
            <input type="hidden" id="estado_<?=$d_user['us_idusuario']?>_def" name="estado_<?=$d_user['us_idusuario']?>_def" value="<?=$d_user['us_estado']?>">
        </div>
    </form>
</div>
<?php }
unset($_SESSION['datos_'._ID_PAG_]['edita_usuario']);
?>