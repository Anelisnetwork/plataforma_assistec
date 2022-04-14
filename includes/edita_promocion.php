<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']==1){
		$mensaje='No se ha podido guardar';
		if(isset($_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje'])){
			$mensaje=$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje'];
		}?>
    <script>
	alertify.error("<?=$mensaje?>");
	</script>
	<?php }
	else{
		$mensaje='Guardado correctamente';
		if(isset($_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje'])){
			$mensaje=$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje'];
		}?>
    <script>
	alertify.success("<?=$mensaje?>");
	</script>
	<?php }
}
?>

<script>
bkLib.onDomLoaded(function() {
	new nicEditor({iconsPath : '<?=_RAIZ_?>js/nicEdit/nicEditorIcons.gif',buttonList : ['fontFamily','fontSize','bold','italic','underline','strikeThrough','left','center','right','justify','link','unlink','forecolor','bgcolor']}).panelInstance('descripcion_<?=$idpromo?>');
});
</script>
<div class="linea usuario_<?=$idpromo?> colizq">
    <form action="<?=_RAIZ_?>procesando.php" method="post" onsubmit="return comprueba_promocion('<?=$idpromo?>');" name="nueva_promocion" id="nueva_promocion" enctype="multipart/form-data">
        <input type="hidden" id="idproceso" name="idproceso" value="edita_promocion" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>promociones/<?=$idpromo=='NEW'?'nueva_promocion':'editar_promocion/'.$idpromo?>" />
        <input type="hidden" id="idpromocion" name="idpromocion" value="<?=$idpromo?>" />
        <div class="linea">
            <label for="tipo_<?=$idpromo?>"><strong>Tipo promoci&oacute;n:</strong></label>
            <select id="tipo_<?=$idpromo?>" name="tipo_<?=$idpromo?>" onchange="tipo_promo(this.value)"<?=$idpromo!='NEW'?' disabled="disabled"':''?> >
                <option value="1"<?=$idpromo!='NEW'&&$d_promo[0]->pr_tipo==1?' selected="selected"':''?>>Suscripci&oacute;n</option>
                <option value="2"<?=$idpromo!='NEW'&&$d_promo[0]->pr_tipo==2?' selected="selected"':''?>>Obsequio</option>
                <option value="3"<?=$idpromo!='NEW'&&$d_promo[0]->pr_tipo==3?' selected="selected"':''?>>Libre</option>
            </select>
            <input type="submit" id="guardadatos_<?=$idpromo?>" name="guardadatos_<?=$idpromo?>" value="Guardar" style="margin:0px" />
        </div>
        <div class="linea prom_tipo" id="estipo_1">
            <label class="doslineas" for="meses_<?=$idpromo?>"><strong>Mensualidades gratis:</strong></label>
            <input type="number" id="meses_<?=$idpromo?>" name="meses_<?=$idpromo?>" value="1">
        </div>
        <div class="linea">
            <label for="activa_<?=$idpromo?>"><strong>Activa:</strong></label>
            <input type="checkbox" id="activa_<?=$idpromo?>" name="activa_<?=$idpromo?>" value="1"<?=$idpromo=='NEW'?' disabled="disabled"':''?><?=$idpromo=='NEW'?' checked="checked"':($d_promo[0]->pr_activa==1?' checked="checked"':'')?> style="float:left; margin-top:10px" />
        </div>
        <div class="linea">
            <label for="desde_<?=$idpromo?>"><strong>Fecha inicio:</strong></label>
            <input type="date"<?=$idpromo=='NEW'?' min="'.date('Y-m-d').'"':''?> id="desde_<?=$idpromo?>" name="desde_<?=$idpromo?>" value="<?=$idpromo=='NEW'?'':quita_hora($d_promo[0]->pr_desde)?>" />
        </div>
        <div class="linea">
            <label for="hasta_<?=$idpromo?>"><strong>Fecha fin:</strong></label>
            <input type="date"<?=$idpromo=='NEW'?' min="'.date('Y-m-d').'"':''?> id="hasta_<?=$idpromo?>" name="hasta_<?=$idpromo?>" value="<?=$idpromo=='NEW'?'':quita_hora($d_promo[0]->pr_hasta)?>" />
        </div>
        
        <div class="linea">
            <label for="titulo_<?=$idpromo?>"><strong>T&iacute;tulo:</strong></label>
            <input type="text" id="titulo_<?=$idpromo?>" name="titulo_<?=$idpromo?>" value="<?=$idpromo=='NEW'?'':u8d_($d_promo[0]->pr_titulo)?>" />
        </div>
        <div class="linea">
            <label for="imagen_<?=$idpromo?>" style="width:auto"><strong>Imagen:</strong> <span style="font-size:12px; font-style:italic">(formatos: .jpg .png .gif | m&aacute;ximo 300Kb)</span></label><br clear="all" />
            <?php if($idpromo!='NEW'&&$d_promo[0]->pr_imagen!=''){?>
            <div style="background-repeat:no-repeat; background-position:center center; background-size:contain; float:left; width:200px; height:150px; background-image:url(<?=_RAIZ_?>imagenes/promociones/<?=$d_promo[0]->pr_imagen?>)"></div><br clear="all" /><br clear="all" />
            <?php }?>
            <input type="file" id="imagen_<?=$idpromo?>" name="imagen_<?=$idpromo?>" />
        </div>
        <div class="linea" id="adj_archivo"<?=$idpromo=='NEW'||$d_promo[0]->pr_tipo!=3?' style="display:none"':''?>>
            <label for="archivo_<?=$idpromo?>" style="width:auto"><strong>Archivo para descarga:</strong> <span style="font-size:12px; font-style:italic">(formatos: .pdf | m&aacute;ximo 3Mb)</span></label><br clear="all" />
            <?php if($idpromo!='NEW'&&$d_promo[0]->pr_archivo!=''){?>
            <span></span><br clear="all" />
            <?php }?>
            <input type="file" id="archivo_<?=$idpromo?>" name="archivo_<?=$idpromo?>" />
        </div>
        <div class="linea">
            <label for="descripcion_<?=$idpromo?>"><strong>Descripci&oacute;n:</strong></label>
            <textarea id="descripcion_<?=$idpromo?>" name="descripcion_<?=$idpromo?>" style="width:500px; height:300px">
            	<?=$idpromo=='NEW'?'':u8d_($d_promo[0]->pr_descripcion)?>
            </textarea>
        </div>
    </form>
</div>
<?php if($idpromo!='NEW'){?>
<div class="colder" style="padding-right:20px; width:260px;">
    <span class="oswald">Pendientes de promoci&oacute;n</span>
    <div class="scroll" style="width:260px">
        <?php if (count($pendientes)==0){?>
        <span class="dato_hist">NO HAY DATOS</span>
        <?php }
        else{
            foreach($pendientes as $pendiente){?>
            <div id="estpromo_<?=$pendiente->ta_idtaller?>">
            <?php 
			$pr_durpromo=$pendiente->ta_durpromo;
			$pr_tipo=$d_promo[0]->pr_tipo;
			$pr_nombre=u8d_($pendiente->ta_nombre);
			$pr_idtaller=$pendiente->ta_idtaller;
			include('includes/linea_est_promo.php');
			?>
            </div>
        <?php }
        }?>
    </div>
</div>
<?php 
}
unset($_SESSION['datos_'._ID_PAG_]['edita_promocion']);
?>