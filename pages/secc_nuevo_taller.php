<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']==1){
		$mensaje='No se ha podido guardar';
		if(isset($_SESSION['datos_'._ID_PAG_]['nuevo_taller']['mensaje'])){
			$mensaje=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['mensaje'];
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
<div class="linea taller_NEW">
    <form action="<?=_RAIZ_?>procesando.php" onsubmit="return valida_nuevotaller('NEW');" method="post" name="nuevo_taller" id="nuevo_taller">
        <input type="hidden" id="idproceso" name="idproceso" value="nuevo_taller" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>talleres/nuevo_taller" />
        <input type="hidden" id="idtaller" name="idtaller" value="NEW" />
        <div class="linea">
            <label for="tipo_NEW">Tipo taller:</label>
            <select id="tipo_NEW" name="tipo_NEW" onchange="cambiatipo(this.value)" >
                <option value="1">Taller</option>
                <option value="2">Red</option>
            </select>
            <input type="submit" id="guardadatos_NEW" name="guardadatos_NEW" value="Guardar" style="margin:0px" />
        </div>
        <div class="linea" id="parared">
            <label for="red_NEW">De la red:</label>
            <select id="red_NEW" name="red_NEW" onchange="cambiared(this.value)">
            	<option value="0">Ninguna</option>
            	<?php foreach($l_redes as $red){?>
                <option value="<?=$red->ta_idtaller?>"><?=$red->ta_nombre?></option>
                <?php }?>
            </select>
        </div>
        <div class="linea" id="esmodulo">
            <label for="contrato_NEW">M&oacute;dulo:</label>
            <select id="contrato_NEW" name="contrato_NEW">
            	<?php foreach($l_contratos as $contrato){?>
                <option value="<?=$contrato->tc_idtipo?>"><?=$contrato->tc_nombre?></option>
                <?php }?>
            </select>
        </div>
        <div class="linea">
            <label for="pago_NEW">Pago:</label>
            <select id="pago_NEW" name="pago_NEW">
            	<?php foreach($l_abonos as $abono){?>
                <option value="<?=$abono->ta_idtipo?>"><?=$abono->ta_nombre?></option>
                <?php }?>
            </select>
        </div>
        <div class="linea">
            <label for="razsoc_NEW">Raz&oacute;n social:</label>
            <input type="text" id="razsoc_NEW" name="razsoc_NEW" value="" required="required">
        </div>
        <div class="linea">
            <label for="cif_NEW">NIF / CIF:</label>
            <input type="text" id="cif_NEW" name="cif_NEW" value="" required="required" onkeyup="cambianif(this.id)">
        </div>
        <div class="linea">
            <label for="nomcom_NEW">Nombre comercial:</label>
            <input type="text" id="nomcom_NEW" name="nomcom_NEW" value="">
        </div>
        <div class="linea">
            <label for="contacto_NEW">Contacto:</label>
            <input type="text" id="contacto_NEW" name="contacto_NEW" value="">
        </div>
        <div class="linea">
            <label for="socio_NEW">Socio:</label>
            <input type="text" id="socio_NEW" name="socio_NEW" value="">
        </div>
        <div class="linea">
            <label for="telefono_NEW">Tel&eacute;fono:</label>
            <input type="text" id="telefono_NEW" name="telefono_NEW" value="" required="required" onkeyup="limpiatlf(this.id)">
        </div>
        <div class="linea">
            <label for="correo_NEW">E-mail:</label>
            <input type="text" id="correo_NEW" name="correo_NEW" value="" required="required">
        </div>
        <div class="linea">
            <label for="dirr_NEW">Direcci&oacute;n:</label>
            <input type="text" id="dirr_NEW" name="dirr_NEW" value="" required="required">
        </div>
        <div class="linea">
            <label for="cp_NEW">C&oacute;digo postal:</label>
            <input type="text" id="cp_NEW" name="cp_NEW" value="" required="required">
        </div>
        <div class="linea">
            <label for="loc_NEW">Localidad:</label>
            <input type="text" id="loc_NEW" name="loc_NEW" value="" required="required">
        </div>
        <div class="linea">
            <label for="prov_NEW">Provincia:</label>
            <input type="text" id="prov_NEW" name="prov_NEW" value="" required="required">
        </div>
        
    </form>
</div>
<?php 
unset($_SESSION['datos_'._ID_PAG_]['nuevo_taller']);
?>