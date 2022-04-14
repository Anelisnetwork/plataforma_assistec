<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_info']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_info']['hayerrores']==1){?>
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
$infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];
$hay_datos=count($infotaller)>0;
?>
<div id="infotaller" class="div_mostrarocultar" style="float:left;">	
	<form action="<?=_RAIZ_?>procesando.php" method="post" name="edita_info" id="edita_info">
        <input type="hidden" id="idproceso" name="idproceso" value="edita_info" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/informacion" />
        <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
        <div class="linea">
            <label for="pvpmo_<?=$idtaller?>" class="ancho">Importe de la MO:</label><input type="text" id="pvpmo_<?=$idtaller?>" name="pvpmo_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_impmo:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')"><span class="fs_14" style="float:left; margin:7px;">&euro;/H. jornada</span>
            <input type="hidden" id="pvpmo_<?=$idtaller?>_def" name="pvpmo_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_impmo:0?>" />
            <input type="submit" style="display:none" id="edita_info_<?=$idtaller?>" name="edita_info_<?=$idtaller?>" value="Guardar" />
        </div>
        <div class="linea">
            <label for="hconvenio_<?=$idtaller?>" class="ancho">Horas convenio anuales:</label><input type="text" id="hconvenio_<?=$idtaller?>" name="hconvenio_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->hconvenio:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="hconvenio_<?=$idtaller?>_def" name="hconvenio_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->hconvenio:0?>" />
        </div>
        <div class="linea">
            <label for="vstock_<?=$idtaller?>" class="ancho">Valor stock actual:</label><input type="text" id="vstock_<?=$idtaller?>" name="vstock_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_valorstock:0?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_info')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
            <input type="hidden" id="vstock_<?=$idtaller?>_def" name="vstock_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_valorstock:0?>" />
        </div>
        <div class="linea">
            <label for="parking_<?=$idtaller?>" class="ancho">Puestos aparcamiento:</label><input type="text" id="parking_<?=$idtaller?>" name="parking_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_parking:0?>" style="width:30px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="parking_<?=$idtaller?>_def" name="parking_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_parking:0?>" />
        </div>
        <div class="linea">
            <label for="sustit_<?=$idtaller?>" class="ancho">Veh&iacute;culos de sustituci&oacute;n:</label><input type="text" id="sustit_<?=$idtaller?>" name="sustit_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_vehicsus:0?>" style="width:30px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="sustit_<?=$idtaller?>_def" name="sustit_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_vehicsus:0?>" />
        </div>
        <div class="linea">
            <label for="clitot_<?=$idtaller?>" class="ancho">Clientes totales en BBDD:</label><input type="text" id="clitot_<?=$idtaller?>" name="clitot_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_totalclientes:0?>" style="width:50px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="clitot_<?=$idtaller?>_def" name="clitot_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_totalclientes:0?>" />
        </div>
        <div class="linea">
            <label for="clivisit_<?=$idtaller?>" class="ancho doslineas">Clientes con visitas<br />el &uacute;ltimo a&ntilde;o:</label><input type="text" id="clivisit_<?=$idtaller?>" name="clivisit_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_clivisitas:0?>" style="width:50px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="clivisit_<?=$idtaller?>_def" name="clivisit_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_clivisitas:0?>" />
        </div>
        <div class="linea">
            <label for="clinuevos_<?=$idtaller?>" class="ancho doslineas">Clientes nuevos<br />el &uacute;ltimo a&ntilde;o:</label><input type="text" id="clinuevos_<?=$idtaller?>" name="clinuevos_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_clinuevos:0?>" style="width:50px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="clinuevos_<?=$idtaller?>_def" name="clinuevos_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_clinuevos:0?>" />
        </div>
        <div class="linea">
            <label for="dms_<?=$idtaller?>" class="ancho">DMS<span class="fs_12"> (Programa de gesti&oacute;n)</span>:</label><input type="checkbox" class="orig" id="dms_<?=$idtaller?>" name="dms_<?=$idtaller?>" value="1"<?=$hay_datos&&$infotaller[0]->it_tienedms==1?' checked="checked"':''?> onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="dms_<?=$idtaller?>_def" name="dms_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_tienedms:0?>" />
            <div class="sep_form"></div>
            <label for="dmsprov_<?=$idtaller?>">Proveedor:</label><input type="text" id="dmsprov_<?=$idtaller?>" name="dmsprov_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?u8d_($infotaller[0]->it_provdms):''?>">
            <input type="hidden" id="dmsprov_<?=$idtaller?>_def" name="dmsprov_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_provdms):''?>" onkeyup="comprueba_cambios('edita_info')" />
        </div>
        <div class="linea">
            <label for="fichan_<?=$idtaller?>" class="ancho">Operarios fichan:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_fichan==1?' checked="checked"':''?> class="orig" id="fichan_<?=$idtaller?>" name="fichan_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="fichan_<?=$idtaller?>_def" name="fichan_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_fichan:0?>" />
            <div class="sep_form"></div>
            <label for="fichancomo_<?=$idtaller?>">C&oacute;mo:</label><input type="text" id="fichancomo_<?=$idtaller?>" name="fichancomo_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?u8d_($infotaller[0]->it_comofichan):''?>" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="fichancomo_<?=$idtaller?>_def" name="fichancomo_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_comofichan):''?>" />
        </div>
        <div class="linea">
            <label for="distrip_<?=$idtaller?>" class="ancho doslineas">Distribuidor piezas principal:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_distrip==1?' checked="checked"':''?> class="orig" id="distrip_<?=$idtaller?>" name="distrip_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="distrip_<?=$idtaller?>_def" name="distrip_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_distrip:0?>" />
            <div class="sep_form"></div>
            <label for="ndistrip_<?=$idtaller?>">Nombre:</label><input type="text" id="ndistrip_<?=$idtaller?>" name="ndistrip_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomdistri):''?>" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="ndistrip_<?=$idtaller?>_def" name="ndistrip_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomdistri):''?>" />
        </div>
        <div class="linea">
            <label for="asist_<?=$idtaller?>" class="ancho">Asistencia t&eacute;cnica:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_asistec==1?' checked="checked"':''?> class="orig" id="asist_<?=$idtaller?>" name="asist_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="asist_<?=$idtaller?>_def" name="asist_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_asistec:0?>" />
            <div class="sep_form"></div>
            <label for="nasist_<?=$idtaller?>">Nombre:</label><input type="text" id="nasist_<?=$idtaller?>" name="nasist_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomasist):''?>" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="nasist_<?=$idtaller?>_def" name="nasist_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomasist):''?>" />
        </div>
        <div class="linea">
            <label for="ecom_<?=$idtaller?>" class="ancho">Comercio electr&oacute;nico:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_comelec==1?' checked="checked"':''?> class="orig" id="ecom_<?=$idtaller?>" name="ecom_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="ecom_<?=$idtaller?>_def" name="ecom_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_comelec:0?>" />
            <div class="sep_form"></div>
            <label for="necom_<?=$idtaller?>">Nombre:</label><input type="text" id="necom_<?=$idtaller?>" name="necom_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomcomelec):''?>" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="necom_<?=$idtaller?>_def" name="necom_<?=$idtaller?>_def" value="<?=$hay_datos?u8d_($infotaller[0]->it_nomcomelec):''?>" />
        </div>
        <div class="linea">
            <label for="espera_<?=$idtaller?>" class="ancho">Zona de espera:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_zonaespera==1?' checked="checked"':''?> class="orig" id="espera_<?=$idtaller?>" name="espera_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="espera_<?=$idtaller?>_def" name="espera_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_zonaespera:0?>" />
            <div class="sep_form"></div>
            <label for="citas_<?=$idtaller?>" class="ancho">Pantalla de citas:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_pantcitas==1?' checked="checked"':''?> class="orig" id="citas_<?=$idtaller?>" name="citas_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="citas_<?=$idtaller?>_def" name="citas_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_pantcitas:0?>" />
        </div>
        <div class="linea">
            <label for="cafe_<?=$idtaller?>" class="ancho">M&aacute;quinas de bebidas y caf&eacute;:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_maqcafe==1?' checked="checked"':''?> class="orig" id="cafe_<?=$idtaller?>" name="cafe_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="cafe_<?=$idtaller?>_def" name="cafe_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_maqcafe:0?>" />
            <div class="sep_form"></div>
            <label for="ofertas_<?=$idtaller?>" class="ancho doslineas">Ofertas comerciales en recepci&oacute;n:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_ofrecep==1?' checked="checked"':''?> class="orig" id="ofertas_<?=$idtaller?>" name="ofertas_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="ofertas_<?=$idtaller?>_def" name="ofertas_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_ofrecep:0?>" />
        </div>
        <div class="linea">
            <label for="tlfase_<?=$idtaller?>" class="ancho doslineas">Tel&eacute;fonos inal&aacute;mbricos asesores:</label><input type="checkbox"<?=$hay_datos&&$infotaller[0]->it_telinal==1?' checked="checked"':''?> class="orig" id="tlfase_<?=$idtaller?>" name="tlfase_<?=$idtaller?>" value="1" onchange="comprueba_cambios('edita_info')">
            <input type="hidden" id="tlfase_<?=$idtaller?>_def" name="tlfase_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_telinal:0?>" />
            <div class="sep_form"></div>
            <label for="porcita_<?=$idtaller?>" class="ancho doslineas">% de entradas al taller con cita previa:</label><input type="text" id="porcita_<?=$idtaller?>" name="porcita_<?=$idtaller?>" class="peq orig" value="<?=$hay_datos?$infotaller[0]->it_porcentr:0?>" style="width:50px; text-align:right" onkeyup="comprueba_cambios('edita_info')">
            <input type="hidden" id="porcita_<?=$idtaller?>_def" name="porcita_<?=$idtaller?>_def" value="<?=$hay_datos?$infotaller[0]->it_porcentr:0?>" />
        </div>
</div>
<?php unset($_SESSION['datos_'._ID_PAG_]['edita_info']);?>