<?php if(isset($_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores'])||isset($_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores']==1||$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores']==1){?>
    <script>
	alertify.error("Error al guardar");
	</script>
	<?php }
	else{?>
    <script>
	alertify.success("Guardado correctamente");
	</script>
	<?php }
}
?>
<div class="linea" style="margin-top:15px">
	<span style="float:left" class="oswald fs_16 texto_r">Informaci&oacute;n:</span><div class="link mostrarocultar" id="mostrarocultar_infotaller" style="background-position:bottom"></div>
</div>
<div id="infotaller" class="div_mostrarocultar" style="float:left;">	
	<div class="linea">
		<label for="pvpmo_<?=$taller->ta_idtaller?>" class="ancho">Importe de la MO:</label><input type="text" id="pvpmo_<?=$taller->ta_idtaller?>" name="pvpmo_<?=$taller->ta_idtaller?>" class="peq" value="25" style="width:30px; text-align:right"><span class="fs_14" style="float:left; margin:7px;">&euro;/H. jornada</span>
	</div>
    <div class="linea">
        <label for="vstock_<?=$taller->ta_idtaller?>" class="ancho">Valor stock actual:</label><input type="text" id="vstock_<?=$taller->ta_idtaller?>" name="vstock_<?=$taller->ta_idtaller?>" class="peq" value="12450" style="width:50px; text-align:right"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
	</div>
	<div class="linea">
		<label for="dms_<?=$taller->ta_idtaller?>" class="ancho">DMS<span class="fs_12"> (Programa de gesti&oacute;n)</span>:</label><input type="checkbox" id="dms_<?=$taller->ta_idtaller?>" name="dms_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="dmsprov_<?=$datos_facturacion[0]->uf_iddir?>">Proveedor:</label><input type="text" id="dmsprov_<?=$datos_facturacion[0]->uf_iddir?>" name="dmsprov_<?=$datos_facturacion[0]->uf_iddir?>" class="peq" value="">
	</div>
	<div class="linea">
		<label for="fichan_<?=$taller->ta_idtaller?>" class="ancho">Operarios fichan:</label><input type="checkbox" checked="checked" id="fichan_<?=$taller->ta_idtaller?>" name="fichan_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="fichancomo_<?=$datos_facturacion[0]->uf_iddir?>">C&oacute;mo:</label><input type="text" id="fichancomo_<?=$datos_facturacion[0]->uf_iddir?>" name="fichancomo_<?=$datos_facturacion[0]->uf_iddir?>" class="peq" value="Clave personal">
	</div>
    <div class="linea">
		<label for="distrip_<?=$taller->ta_idtaller?>" class="ancho doslineas">Distribuidor piezas principal:</label><input type="checkbox" id="distrip_<?=$taller->ta_idtaller?>" name="distrip_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="ndistrip_<?=$datos_facturacion[0]->uf_iddir?>">Nombre:</label><input type="text" id="ndistrip_<?=$datos_facturacion[0]->uf_iddir?>" name="ndistrip_<?=$datos_facturacion[0]->uf_iddir?>" class="peq" value="">
	</div>
    <div class="linea">
		<label for="asist_<?=$taller->ta_idtaller?>" class="ancho">Asistencia t&eacute;cnica:</label><input type="checkbox" checked="checked" id="asist_<?=$taller->ta_idtaller?>" name="asist_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="nasist_<?=$datos_facturacion[0]->uf_iddir?>">Nombre:</label><input type="text" id="nasist_<?=$datos_facturacion[0]->uf_iddir?>" name="nasist_<?=$datos_facturacion[0]->uf_iddir?>" class="peq" value="">
	</div>
    <div class="linea">
		<label for="ecom_<?=$taller->ta_idtaller?>" class="ancho">Comercio electr&oacute;nico:</label><input type="checkbox" checked="checked" id="ecom_<?=$taller->ta_idtaller?>" name="ecom_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="necom_<?=$datos_facturacion[0]->uf_iddir?>">Nombre:</label><input type="text" id="necom_<?=$datos_facturacion[0]->uf_iddir?>" name="necom_<?=$datos_facturacion[0]->uf_iddir?>" class="peq" value="miwebdeltaller.com">
	</div>
    <div class="linea">
		<label for="espera_<?=$taller->ta_idtaller?>" class="ancho">Zona de espera:</label><input type="checkbox" checked="checked" id="espera_<?=$taller->ta_idtaller?>" name="espera_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="citas_<?=$taller->ta_idtaller?>" class="ancho">Pantalla de citas:</label><input type="checkbox" id="citas_<?=$taller->ta_idtaller?>" name="citas_<?=$taller->ta_idtaller?>" value="1">
	</div>
    <div class="linea">
		<label for="cafe_<?=$taller->ta_idtaller?>" class="ancho">M&aacute;quinas de bebidas y caf&eacute;:</label><input type="checkbox" checked="checked" id="cafe_<?=$taller->ta_idtaller?>" name="cafe_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="ofertas_<?=$taller->ta_idtaller?>" class="ancho doslineas">Ofertas comerciales en recepci&oacute;n:</label><input type="checkbox" checked="checked" id="ofertas_<?=$taller->ta_idtaller?>" name="ofertas_<?=$taller->ta_idtaller?>" value="1">
	</div>
    <div class="linea">
		<label for="tlfase_<?=$taller->ta_idtaller?>" class="ancho doslineas">Tel&eacute;fonos inal&aacute;mbricos asesores:</label><input type="checkbox" id="tlfase_<?=$taller->ta_idtaller?>" name="tlfase_<?=$taller->ta_idtaller?>" value="1">
        <div class="sep_form"></div>
        <label for="porcita_<?=$taller->ta_idtaller?>" class="ancho doslineas">% de entradas al taller con cita previa:</label><input type="text" id="porcita_<?=$datos_facturacion[0]->uf_iddir?>" name="porcita_<?=$datos_facturacion[0]->uf_iddir?>" class="peq" value="70" style="width:30px">
	</div>
</div>