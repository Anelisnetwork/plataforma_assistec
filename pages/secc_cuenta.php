<?php if(isset($_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores'])||isset($_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores'])||isset($_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']) || isset($_SESSION['proceso']['guardar_logotipo']['resultado']) ){
	$mensaje_error='Error al guardar';
	if((isset($_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores'])&&$_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores']==1)||(isset($_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores'])&&$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores']==1)||(isset($_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores'])&&$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']==1) || (isset($_SESSION['proceso']['guardar_logotipo']['resultado']) && $_SESSION['proceso']['guardar_logotipo']['resultado']=='KO')){
		if(isset($_SESSION['datos_'._ID_PAG_]['datos_acceso']['mensaje'])){
			$mensaje_error=$_SESSION['datos_'._ID_PAG_]['datos_acceso']['mensaje'];
		}
        if(isset($_SESSION['proceso']['guardar_logotipo']['mensaje'])){
            $mensaje_error=$_SESSION['proceso']['guardar_logotipo']['mensaje'];
        }?>
    <script>
	alertify.error("<?=$mensaje_error?>");
	</script>
	<?php }
	else{?>
    <script>
	alertify.success("Guardado correctamente");
	</script>
	<?php }
}
	if(isset($_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrorespass'])&&$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrorespass']==1){?>
    <script>
	alertify.error("No se ha podido modificar la contraseña");
	</script>
	<?php }

$datos_usuario=dame_datos_usuario();

$datos_taller=dame_datos_taller($datos_usuario['us_idtaller']);
	foreach($datos_taller as $taller){
		
	
?>

<div class="linea">
    <span class="fs_12 ubuntu texto_n"><strong>ID:</strong> <?=en__id($taller->ta_idtaller)?></span>
    <br>
    <span class="fs_12 ubuntu texto_n"><strong style="float: left">Silent login:</strong> <span style="width: 400px; overflow: hidden; height: 50px; overflow-wrap: break-word; float: left; margin-left: 15px;"><?=$datos_usuario['us_accesosilent']?></span></span>
</div>
                
<div class="linea">
	<span style="float:left" class="oswald fs_16 texto_r">Datos de acceso:</span><div class="link mostrarocultar" id="mostrarocultar_datosacceso" style="background-position:bottom"></div>
</div>
<div id="datosacceso" class="div_mostrarocultar" style="float:left">	
	<form action="<?=_RAIZ_?>procesando.php" onsubmit="return comprueba_pass('<?=$datos_usuario['us_idusuario']?>');" method="post" name="datos_acceso" id="datos_acceso">
        <input type="hidden" id="idproceso" name="idproceso" value="datos_acceso" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
        <input type="hidden" id="idusuario" name="idusuario" value="<?=$_SESSION['datos_'._ID_PAG_]['idusuario']?>" />
        <div class="linea">
            <label for="alias_<?=$datos_usuario['us_idusuario']?>">Alias / Nick:</label><input type="text" class="orig" id="alias_<?=$datos_usuario['us_idusuario']?>" name="alias_<?=$datos_usuario['us_idusuario']?>" value="<?=$datos_usuario['us_nick']?>" onkeyup="comprueba_cambios('datos_acceso')">
            <input type="hidden" id="alias_<?=$datos_usuario['us_idusuario']?>_def" name="alias_<?=$datos_usuario['us_idusuario']?>_def" value="<?=$datos_usuario['us_nick']?>">
            <input type="submit" id="guardadatos_acceso" name="guardadatos_acceso" value="Guardar" style="margin:0px; display:none" />
        </div>
        <div class="linea">
            <label for="acccorreo_<?=$datos_usuario['us_idusuario']?>">Correo de acceso:</label><input type="text" class="orig" id="acccorreo_<?=$datos_usuario['us_idusuario']?>" name="acccorreo_<?=$datos_usuario['us_idusuario']?>" value="<?=$datos_usuario['us_correo']?>" onkeyup="comprueba_cambios('datos_acceso')">
            <input type="hidden" id="acccorreo_<?=$datos_usuario['us_idusuario']?>_def" name="acccorreo_<?=$datos_usuario['us_idusuario']?>_def" value="<?=$datos_usuario['us_correo']?>">
        </div>
        <div class="linea">
            <label for="accpass_<?=$datos_usuario['us_idusuario']?>">Nueva contrase&ntilde;a:</label><input type="password" id="accpass_<?=$datos_usuario['us_idusuario']?>" class="orig" name="accpass_<?=$datos_usuario['us_idusuario']?>" value="" onkeyup="cambia_pass('<?=$datos_usuario['us_idusuario']?>'); comprueba_cambios('datos_acceso')">
            <input type="hidden" id="accpass_<?=$datos_usuario['us_idusuario']?>_def" name="accpass_<?=$datos_usuario['us_idusuario']?>_def" value="">
        </div>
        <div class="linea" id="rep_pass" style="display:none">
            <label for="accpass_<?=$datos_usuario['us_idusuario']?>">Repita contrase&ntilde;a:</label><input type="password" id="accpass2_<?=$datos_usuario['us_idusuario']?>" class="orig" name="accpass2_<?=$datos_usuario['us_idusuario']?>" value="" onkeyup="cambia_pass('<?=$datos_usuario['us_idusuario']?>'); comprueba_cambios('datos_acceso')">
            <input type="hidden" id="accpass2_<?=$datos_usuario['us_idusuario']?>_def" name="accpass2_<?=$datos_usuario['us_idusuario']?>_def" value="">
        </div>
        <div class="linea" id="ant_pass" style="display:none">
            <label for="accpass_<?=$datos_usuario['us_idusuario']?>">Contrase&ntilde;a actual:</label><input type="password" id="accpass3_<?=$datos_usuario['us_idusuario']?>" class="orig" name="accpass3_<?=$datos_usuario['us_idusuario']?>" value="" onkeyup="comprueba_cambios('datos_acceso')">
            <input type="hidden" id="accpass3_<?=$datos_usuario['us_idusuario']?>_def" name="accpass3_<?=$datos_usuario['us_idusuario']?>_def" value="">
        </div>
    </form>
</div>

<div class="linea" style="margin-top:15px">
	<span style="float:left" class="oswald fs_16 texto_r">Datos de generales:</span><div class="link mostrarocultar" id="mostrarocultar_datosgen"></div>
</div>
<div id="datosgen" class="div_mostrarocultar" style="float:left; display:none">
	<form action="<?=_RAIZ_?>procesando.php" method="post" name="datos_generales" id="datos_generales">
        <input type="hidden" id="idproceso" name="idproceso" value="datos_generales" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
        <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
        <div class="linea">
            <label for="nomcom_<?=$taller->ta_idtaller?>">Nombre del taller:</label><input type="text" class="orig" id="nomcom_<?=$taller->ta_idtaller?>" name="nomcom_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_nombre)?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="nomcom_<?=$taller->ta_idtaller?>_def" name="nomcom_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_nombre)?>">
            <input type="submit" id="guardadatos_generales" name="guardadatos_generales" value="Guardar" style="margin:0px; display:none" />
        </div>
        <div class="linea">
            <label for="direccion_<?=$taller->ta_idtaller?>">Direcci&oacute;n:</label><input type="text" class="orig" id="direccion_<?=$taller->ta_idtaller?>" name="direccion_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_direccion)?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="direccion_<?=$taller->ta_idtaller?>_def" name="direccion_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_direccion)?>">
        </div>
        <div class="linea">
            <label for="cp_<?=$taller->ta_idtaller?>">C&oacute;digo postal:</label><input type="text" id="cp_<?=$taller->ta_idtaller?>" name="cp_<?=$taller->ta_idtaller?>" class="peq orig" value="<?=$taller->ta_cp?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="cp_<?=$taller->ta_idtaller?>_def" name="cp_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_cp?>">
        </div>
        <div class="linea">
            <label for="localidad_<?=$taller->ta_idtaller?>">Localidad:</label><input type="text" class="orig" id="localidad_<?=$taller->ta_idtaller?>" name="localidad_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_localidad)?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="localidad_<?=$taller->ta_idtaller?>_def" name="localidad_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_localidad)?>">
        </div>
        <div class="linea">
            <label for="provincia_<?=$taller->ta_idtaller?>">Provincia:</label><input type="text" class="orig" id="provincia_<?=$taller->ta_idtaller?>" name="provincia_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_provincia)?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="provincia_<?=$taller->ta_idtaller?>_def" name="provincia_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_provincia)?>">
        </div>
        <div class="linea">
            <label for="telefono_<?=$taller->ta_idtaller?>">Tel&eacute;fono:</label><input type="text" id="telefono_<?=$taller->ta_idtaller?>" name="telefono_<?=$taller->ta_idtaller?>" class="peq orig" value="<?=$taller->ta_telefono1?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="telefono_<?=$taller->ta_idtaller?>_def" name="telefono_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_telefono1?>">
            <div class="sep_form"></div>
            <label for="movil_<?=$taller->ta_idtaller?>">M&oacute;vil:</label><input type="text" id="movil_<?=$taller->ta_idtaller?>" name="movil_<?=$taller->ta_idtaller?>" class="peq orig" value="<?=$taller->ta_telefono2?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="movil_<?=$taller->ta_idtaller?>_def" name="movil_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_telefono2?>">
        </div>
        <div class="linea">
            <label for="correo_<?=$taller->ta_idtaller?>">Correo-e:</label><input type="text" class="orig" id="correo_<?=$taller->ta_idtaller?>" name="correo_<?=$taller->ta_idtaller?>" value="<?=$taller->ta_email?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="correo_<?=$taller->ta_idtaller?>_def" name="correo_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_email?>">
        </div>
        <div class="linea">
            <label for="contacto_<?=$taller->ta_idtaller?>">Contacto:</label><input type="text" class="orig" id="contacto_<?=$taller->ta_idtaller?>" name="contacto_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_contacto)?>" onkeyup="comprueba_cambios('datos_generales')">
            <input type="hidden" id="contacto_<?=$taller->ta_idtaller?>_def" name="contacto_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_contacto)?>">
        </div>
    </form>
</div>



<div class="linea" style="margin-top:15px">
	<span style="float:left" class="oswald fs_16 texto_r">Datos de facturaci&oacute;n:</span><div class="link mostrarocultar" id="mostrarocultar_datosfac"></div>
</div>
<div id="datosfac" class="div_mostrarocultar" style="float:left; display:none">
	<?php $datos_facturacion=dame_datos_facturacion($taller->ta_iddirfac);?>
    <form action="<?=_RAIZ_?>procesando.php" method="post" name="datos_facturacion" id="datos_facturacion">
        <input type="hidden" id="idproceso" name="idproceso" value="datos_facturacion" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
        <input type="hidden" id="iddir" name="iddir" value="<?=$datos_facturacion[0]->uf_iddir?>" />
        <div class="linea">
            <label for="nomcomf_<?=$datos_facturacion[0]->uf_iddir?>">Nombre comercial:</label><input type="text" class="orig" id="nomcomf_<?=$datos_facturacion[0]->uf_iddir?>" name="nomcomf_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=u8d_($datos_facturacion[0]->uf_nomcom)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="nomcomf_<?=$datos_facturacion[0]->uf_iddir?>_def" name="nomcomf_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_nomcom)?>">
            <input type="submit" id="guardadatos_facturacion" name="guardadatos_facturacion" value="Guardar" style="margin:0px; display:none" />
        </div>
        <div class="linea">
            <label for="razsoc_<?=$datos_facturacion[0]->uf_iddir?>">Raz&oacute;n social:</label><input type="text" class="orig" id="razsoc_<?=$datos_facturacion[0]->uf_iddir?>" name="razsoc_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=u8d_($datos_facturacion[0]->uf_denomsoc)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="razsoc_<?=$datos_facturacion[0]->uf_iddir?>_def" name="razsoc_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_denomsoc)?>">
        </div>
        <div class="linea">
            <label for="nifcif_<?=$datos_facturacion[0]->uf_iddir?>">NIF/CIF:</label><input type="text" id="nifcif_<?=$datos_facturacion[0]->uf_iddir?>" name="nifcif_<?=$datos_facturacion[0]->uf_iddir?>" class="peq orig" value="<?=u8d_($datos_facturacion[0]->uf_cifnif)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="nifcif_<?=$datos_facturacion[0]->uf_iddir?>_def" name="nifcif_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_cifnif)?>">
        </div>
        <div class="linea">
            <label for="direccionf_<?=$datos_facturacion[0]->uf_iddir?>">Direcci&oacute;n:</label><input type="text" class="orig" id="direccionf_<?=$datos_facturacion[0]->uf_iddir?>" name="direccionf_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=u8d_($datos_facturacion[0]->uf_direccion)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="direccionf_<?=$datos_facturacion[0]->uf_iddir?>_def" name="direccionf_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_direccion)?>">
        </div>
        <div class="linea">
            <label for="cpf_<?=$datos_facturacion[0]->uf_iddir?>">C&oacute;digo postal:</label><input type="text" id="cpf_<?=$datos_facturacion[0]->uf_iddir?>" name="cpf_<?=$datos_facturacion[0]->uf_iddir?>" class="peq orig" value="<?=$datos_facturacion[0]->uf_cp?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="cpf_<?=$datos_facturacion[0]->uf_iddir?>_def" name="cpf_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=$datos_facturacion[0]->uf_cp?>">
        </div>
        <div class="linea">
            <label for="localidadf_<?=$datos_facturacion[0]->uf_iddir?>">Localidad:</label><input type="text" class="orig" id="localidadf_<?=$datos_facturacion[0]->uf_iddir?>" name="localidadf_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=u8d_($datos_facturacion[0]->uf_localidad)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="localidadf_<?=$datos_facturacion[0]->uf_iddir?>_def" name="localidadf_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_localidad)?>">
        </div>
        <div class="linea">
            <label for="provinciaf_<?=$datos_facturacion[0]->uf_iddir?>">Provincia:</label><input type="text" class="orig" id="provinciaf_<?=$datos_facturacion[0]->uf_iddir?>" name="provinciaf_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=u8d_($datos_facturacion[0]->uf_provincia)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="provinciaf_<?=$datos_facturacion[0]->uf_iddir?>_def" name="provinciaf_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_provincia)?>">
        </div>
        <div class="linea">
            <label for="telefonof_<?=$datos_facturacion[0]->uf_iddir?>">Tel&eacute;fono:</label><input type="text" id="telefonof_<?=$datos_facturacion[0]->uf_iddir?>" name="telefonof_<?=$datos_facturacion[0]->uf_iddir?>" class="peq orig" value="<?=$datos_facturacion[0]->uf_telefono1?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="telefonof_<?=$datos_facturacion[0]->uf_iddir?>_def" name="telefonof_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=$datos_facturacion[0]->uf_telefono1?>">
            <div class="sep_form"></div>
            <label for="movilf_<?=$datos_facturacion[0]->uf_iddir?>">M&oacute;vil:</label><input type="text" id="movilf_<?=$datos_facturacion[0]->uf_iddir?>" name="movilf_<?=$datos_facturacion[0]->uf_iddir?>" class="peq orig" value="<?=$datos_facturacion[0]->uf_telefono2?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="movilf_<?=$datos_facturacion[0]->uf_iddir?>_def" name="movilf_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=$datos_facturacion[0]->uf_telefono2?>">
        </div>
        <div class="linea">
            <label for="correof_<?=$datos_facturacion[0]->uf_iddir?>">Correo-e:</label><input type="text" class="orig" id="correof_<?=$datos_facturacion[0]->uf_iddir?>" name="correof_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=$datos_facturacion[0]->uf_email?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="correof_<?=$datos_facturacion[0]->uf_iddir?>_def" name="correof_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=$datos_facturacion[0]->uf_email?>">
        </div>
        <div class="linea">
            <label for="contactof_<?=$datos_facturacion[0]->uf_iddir?>">Contacto:</label><input type="text" class="orig" id="contactof_<?=$datos_facturacion[0]->uf_iddir?>" name="contactof_<?=$datos_facturacion[0]->uf_iddir?>" value="<?=u8d_($datos_facturacion[0]->uf_contacto)?>" onkeyup="comprueba_cambios('datos_facturacion')">
            <input type="hidden" id="contactof_<?=$datos_facturacion[0]->uf_iddir?>_def" name="contactof_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_contacto)?>">
        </div>
        <div class="linea">
            <textarea class="orig" id="observaciones_<?=$datos_facturacion[0]->uf_iddir?>" name="observaciones_<?=$datos_facturacion[0]->uf_iddir?>" placeholder="Observaciones" onkeyup="comprueba_cambios('datos_facturacion')"><?=u8d_($datos_facturacion[0]->uf_observaciones)?></textarea>
            <input type="hidden" id="observaciones_<?=$datos_facturacion[0]->uf_iddir?>_def" name="observaciones_<?=$datos_facturacion[0]->uf_iddir?>_def" value="<?=u8d_($datos_facturacion[0]->uf_observaciones)?>">
        </div>
    </form>
</div>
<? if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2){?>
<div class="linea" style="margin-top:15px">
    <span style="float:left" class="oswald fs_16 texto_r">Logotipo:</span>
</div>
<div class="linea">
    <form  style="display: flex; flex-flow: column" action="<?=_RAIZ_?>procesando.php" method="post" name="datos_acceso" id="datos_acceso" enctype="multipart/form-data">
        <input type="hidden" id="idproceso" name="idproceso" value="logo_corporativo" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
        <input type="hidden" id="idtaller" name="idtaller" value="<?=$taller->ta_idtaller?>" />
        <input style="padding-bottom: 10px" type="file" name="logo_corp" id="logo_corp">
        <span style="padding-bottom: 10px">imágenes JPG, PNG de 230px x 140px</span>
        <input type="submit" id="guardadatos_logo" name="guardadatos_logo" value="Guardar" style="margin: 0" />
    </form>

    <div style="background-repeat: no-repeat;background-size: cover; height: 140px;width: 230px; float: left; margin:15px; background-image: url('<?=_RAIZ_?>imagenes/talleres/logotipos/<?=$taller->ta_logotipo?>') ">
    </div>
</div>
            <? }?>

<?php }
unset($_SESSION['datos_'._ID_PAG_]['datos_generales']);
unset($_SESSION['datos_'._ID_PAG_]['datos_facturacion']);
unset($_SESSION['datos_'._ID_PAG_]['datos_acceso']);
unset($_SESSION['proceso']['guardar_logotipo']);
?>