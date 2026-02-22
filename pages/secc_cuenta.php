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
<div class="col col-12 col-lg-8 d-flex flex-column align-items-center justify-content-start">
        <div class="d-flex flex-column align-items-start justify-content-between w-100 mb-3">
        <span class="fs_12 ubuntu texto_n"><strong>ID:</strong> <?=en__id($taller->ta_idtaller)?></span>
        <br>
        <span class="fs_12 ubuntu texto_n"><strong style="float: left">Silent login:</strong> <span style="width: 400px; overflow: hidden; height: 50px; overflow-wrap: break-word; float: left; margin-left: 15px;"><?=$datos_usuario['us_accesosilent']?></span></span>
    </div>

    <div class="d-flex flex-row align-items-start justify-content-between w-100 mb-3 p-2 bg-primary rounded mostrarocultar" id="mostrarocultar_datosacceso" style="cursor: pointer">
        <span style="float:left" class="oswald fs_16 text-white">Datos de acceso:</span>
        <div class="fa fa-plus fs_20 text-white"></div>
    </div>
    <div id="datosacceso" class="div_mostrarocultar  col-12 col-md-10">
        <form action="<?=_RAIZ_?>procesando.php" onsubmit="return comprueba_pass('<?=$datos_usuario['us_idusuario']?>');" method="post" name="datos_acceso" id="datos_acceso" class="w-100">
            <input type="hidden" id="idproceso" name="idproceso" value="datos_acceso" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
            <input type="hidden" id="idusuario" name="idusuario" value="<?=$_SESSION['datos_'._ID_PAG_]['idusuario']?>" />
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="alias_<?=$datos_usuario['us_idusuario']?>">Alias / Nick:</label>
                <input type="text" class="orig form-control form-control-sm" id="alias_<?=$datos_usuario['us_idusuario']?>" name="alias_<?=$datos_usuario['us_idusuario']?>" value="<?=$datos_usuario['us_nick']?>" onkeyup="comprueba_cambios('datos_acceso')" style="width: auto">
                <input type="hidden" id="alias_<?=$datos_usuario['us_idusuario']?>_def"" name="alias_<?=$datos_usuario['us_idusuario']?>_def" value="<?=$datos_usuario['us_nick']?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="acccorreo_<?=$datos_usuario['us_idusuario']?>">Correo de acceso:</label>
                <input type="text" class="orig form-control form-control-sm" id="acccorreo_<?=$datos_usuario['us_idusuario']?>" name="acccorreo_<?=$datos_usuario['us_idusuario']?>" value="<?=$datos_usuario['us_correo']?>" onkeyup="comprueba_cambios('datos_acceso')" style="width: auto">
                <input type="hidden" id="acccorreo_<?=$datos_usuario['us_idusuario']?>_def" name="acccorreo_<?=$datos_usuario['us_idusuario']?>_def" value="<?=$datos_usuario['us_correo']?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="accpass_<?=$datos_usuario['us_idusuario']?>">Nueva contrase&ntilde;a:</label>
                <input type="password" id="accpass_<?=$datos_usuario['us_idusuario']?>" class="orig  form-control form-control-sm" name="accpass_<?=$datos_usuario['us_idusuario']?>" autocomplete="new-password" value="" onkeyup="cambia_pass('<?=$datos_usuario['us_idusuario']?>'); comprueba_cambios('datos_acceso')" style="width: auto">
                <input type="hidden" id="accpass_<?=$datos_usuario['us_idusuario']?>_def" name="accpass_<?=$datos_usuario['us_idusuario']?>_def" value="">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3" id="rep_pass" style="display:none">
                <label for="accpass_<?=$datos_usuario['us_idusuario']?>">Repita contrase&ntilde;a:</label>
                <input type="password" id="accpass2_<?=$datos_usuario['us_idusuario']?>" class="orig  form-control form-control-sm" name="accpass2_<?=$datos_usuario['us_idusuario']?>" value="" onkeyup="cambia_pass('<?=$datos_usuario['us_idusuario']?>'); comprueba_cambios('datos_acceso')" style="width: auto">
                <input type="hidden" id="accpass2_<?=$datos_usuario['us_idusuario']?>_def" name="accpass2_<?=$datos_usuario['us_idusuario']?>_def" value="">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3" id="ant_pass" style="display:none">
                <label for="accpass_<?=$datos_usuario['us_idusuario']?>">Contrase&ntilde;a actual:</label>
                <input type="password" id="accpass3_<?=$datos_usuario['us_idusuario']?>" class="orig form-control form-control-sm" name="accpass3_<?=$datos_usuario['us_idusuario']?>" value="" onkeyup="comprueba_cambios('datos_acceso')" style="width: auto">
                <input type="hidden" id="accpass3_<?=$datos_usuario['us_idusuario']?>_def" name="accpass3_<?=$datos_usuario['us_idusuario']?>_def" value="">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-end  align-items-sm-center justify-content-end w-100 mb-3">
                <input type="submit" id="guardadatos_acceso" name="guardadatos_acceso" value="Guardar" class="btn btn-sm btn-secondary col-12 col-sm-auto" style="display:none" />
            </div>
        </form>
    </div>

    <div class="d-flex flex-row align-items-start justify-content-between w-100 mb-3 p-2 bg-primary rounded mostrarocultar" style="cursor: pointer" id="mostrarocultar_datosgen">
        <span style="" class="oswald fs_16 text-white">Datos de generales:</span>
        <div class="fa fa-plus fs_20 text-white " style="cursor: pointer"></div>
    </div>
    <div id="datosgen" class="div_mostrarocultar col-12 col-md-10" style=" display:none">
        <form action="<?=_RAIZ_?>procesando.php" method="post" name="datos_generales" id="datos_generales">
            <input type="hidden" id="idproceso" name="idproceso" value="datos_generales" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="nomcom_<?=$taller->ta_idtaller?>">Nombre del taller:</label>
                <input type="text" class="orig form-control form-controls-sm" id="nomcom_<?=$taller->ta_idtaller?>" name="nomcom_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_nombre)?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="nomcom_<?=$taller->ta_idtaller?>_def" name="nomcom_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_nombre)?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="direccion_<?=$taller->ta_idtaller?>">Direcci&oacute;n:</label>
                <input type="text" class="orig form-control form-controls-sm" id="direccion_<?=$taller->ta_idtaller?>" name="direccion_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_direccion)?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="direccion_<?=$taller->ta_idtaller?>_def" name="direccion_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_direccion)?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="cp_<?=$taller->ta_idtaller?>">C&oacute;digo postal:</label>
                <input type="text" id="cp_<?=$taller->ta_idtaller?>" name="cp_<?=$taller->ta_idtaller?>" class="peq orig form-control form-controls-sm" value="<?=$taller->ta_cp?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="cp_<?=$taller->ta_idtaller?>_def" name="cp_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_cp?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="localidad_<?=$taller->ta_idtaller?>">Localidad:</label>
                <input type="text" class="orig form-control form-controls-sm" id="localidad_<?=$taller->ta_idtaller?>" name="localidad_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_localidad)?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="localidad_<?=$taller->ta_idtaller?>_def" name="localidad_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_localidad)?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="provincia_<?=$taller->ta_idtaller?>">Provincia:</label>
                <input type="text" class="orig form-control form-controls-sm" id="provincia_<?=$taller->ta_idtaller?>" name="provincia_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_provincia)?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="provincia_<?=$taller->ta_idtaller?>_def" name="provincia_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_provincia)?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="telefono_<?=$taller->ta_idtaller?>">Tel&eacute;fono:</label>
                <input type="text" id="telefono_<?=$taller->ta_idtaller?>" name="telefono_<?=$taller->ta_idtaller?>" class="peq orig form-control form-controls-sm" value="<?=$taller->ta_telefono1?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="telefono_<?=$taller->ta_idtaller?>_def" name="telefono_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_telefono1?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="movil_<?=$taller->ta_idtaller?>">M&oacute;vil:</label>
                <input type="text" id="movil_<?=$taller->ta_idtaller?>" name="movil_<?=$taller->ta_idtaller?>" class="peq orig form-control form-controls-sm" value="<?=$taller->ta_telefono2?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="movil_<?=$taller->ta_idtaller?>_def" name="movil_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_telefono2?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="correo_<?=$taller->ta_idtaller?>">Correo-e:</label>
                <input type="text" class="orig form-control form-controls-sm" id="correo_<?=$taller->ta_idtaller?>" name="correo_<?=$taller->ta_idtaller?>" value="<?=$taller->ta_email?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="correo_<?=$taller->ta_idtaller?>_def" name="correo_<?=$taller->ta_idtaller?>_def" value="<?=$taller->ta_email?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="contacto_<?=$taller->ta_idtaller?>">Contacto:</label>
                <input type="text" class="orig form-control form-controls-sm" id="contacto_<?=$taller->ta_idtaller?>" name="contacto_<?=$taller->ta_idtaller?>" value="<?=u8d_($taller->ta_contacto)?>" onkeyup="comprueba_cambios('datos_generales')" style="width: auto">
                <input type="hidden" id="contacto_<?=$taller->ta_idtaller?>_def" name="contacto_<?=$taller->ta_idtaller?>_def" value="<?=u8d_($taller->ta_contacto)?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-end  align-items-sm-center justify-content-end w-100 mb-3">
                <input type="submit" id="guardadatos_generales" name="guardadatos_generales" value="Guardar" class="btn btn-sm btn-secondary col-12 col-sm-auto" style="display:none" />
            </div>
        </form>
    </div>



    <div class="d-flex flex-row align-items-start justify-content-between w-100 mb-3 p-2 bg-primary rounded mostrarocultar" style="cursor: pointer" id="mostrarocultar_datosfac">
        <span style="float:left" class="oswald fs_16 text-white">Datos de facturaci&oacute;n:</span>
        <div class="fa fa-plus fs_20 text-white  " ></div>
    </div>
    <div id="datosfac" class="div_mostrarocultar  col-12 col-md-10" style="display:none">
        <?php $datos_facturacion=dame_datos_facturacion($taller->ta_iddirfac);?>
        <form action="<?=_RAIZ_?>procesando.php" method="post" name="datos_facturacion" id="datos_facturacion">
            <input type="hidden" id="idproceso" name="idproceso" value="datos_facturacion" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
            <input type="hidden" id="iddir" name="iddir" value="<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" />
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="nomcomf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Nombre comercial:</label>
                <input type="text" class="orig form-control form-controls-sm" id="nomcomf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="nomcomf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_nomcom??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="nomcomf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="nomcomf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_nomcom??''?>">

            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="razsoc_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Raz&oacute;n social:</label>
                <input type="text" class="orig form-control form-controls-sm" id="razsoc_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="razsoc_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_denomsoc??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="razsoc_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="razsoc_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_denomsoc??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="nifcif_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">NIF/CIF:</label>
                <input type="text" id="nifcif_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="nifcif_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" class="peq orig form-control form-controls-sm" value="<?=$datos_facturacion[0]->uf_cifnif??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="nifcif_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="nifcif_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_cifnif??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="direccionf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Direcci&oacute;n:</label>
                <input type="text" class="orig form-control form-controls-sm" id="direccionf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="direccionf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_direccion??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="direccionf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="direccionf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_direccion??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="cpf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">C&oacute;digo postal:</label>
                <input type="text" id="cpf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="cpf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" class="peq orig form-control form-controls-sm" value="<?=$datos_facturacion[0]->uf_cp??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="cpf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="cpf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_cp??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="localidadf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Localidad:</label>
                <input type="text" class="orig form-control form-controls-sm" id="localidadf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="localidadf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_localidad??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="localidadf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="localidadf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_localidad??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="provinciaf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Provincia:</label>
                <input type="text" class="orig form-control form-controls-sm" id="provinciaf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="provinciaf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_provincia??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="provinciaf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="provinciaf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_provincia??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="telefonof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Tel&eacute;fono:</label>
                <input type="text" id="telefonof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="telefonof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" class="peq orig form-control form-controls-sm" value="<?=$datos_facturacion[0]->uf_telefono1??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="telefonof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="telefonof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_telefono1??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="movilf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">M&oacute;vil:</label>
                <input type="text" id="movilf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="movilf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" class="peq orig form-control form-controls-sm" value="<?=$datos_facturacion[0]->uf_telefono2??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="movilf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="movilf_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_telefono2??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="correof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Correo-e:</label>
                <input type="text" class="orig form-control form-controls-sm" id="correof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="correof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_email??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="correof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="correof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_email??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <label for="contactof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>">Contacto:</label>
                <input type="text" class="orig form-control form-controls-sm" id="contactof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="contactof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" value="<?=$datos_facturacion[0]->uf_contacto??''?>" onkeyup="comprueba_cambios('datos_facturacion')" style="width: auto">
                <input type="hidden" id="contactof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="contactof_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_contacto??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3">
                <textarea class="orig  form-control form-controls-sm" id="observaciones_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" name="observaciones_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>" placeholder="Observaciones" onkeyup="comprueba_cambios('datos_facturacion')" style="resize: none"><?=$datos_facturacion[0]->uf_observaciones??''?></textarea>
                <input type="hidden" id="observaciones_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" name="observaciones_<?=$datos_facturacion[0]->uf_iddir??'NEW'?>_def" value="<?=$datos_facturacion[0]->uf_observaciones??''?>">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-end  align-items-sm-center justify-content-end w-100 mb-3">
                <input type="submit" id="guardadatos_facturacion" name="guardadatos_facturacion" value="Guardar" class="btn btn-sm btn-secondary col-12 col-sm-auto" style="display:none" />
            </div>
        </form>
    </div>
        <?php if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2){?>
    <div class="d-flex flex-column flex-sm-row align-items-start  align-items-sm-center justify-content-between w-100 mb-3" style="margin-top:15px">
        <span style="float:left" class="oswald fs_16 texto_r">Logotipo:</span>
    </div>
    <div class="d-flex flex-column align-items-center  align-items-sm-center justify-content-between w-100 mb-3">
        <form class="d-flex flex-column w-100" action="<?=_RAIZ_?>procesando.php" method="post" name="logo_corporativo" id="logo_corporativo" enctype="multipart/form-data">
            <input type="hidden" id="idproceso" name="idproceso" value="logo_corporativo" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/cuenta" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$taller->ta_idtaller?>" />
            <input style="padding-bottom: 10px" type="file" name="logo_corp" id="logo_corp">
            <span style="padding-bottom: 10px">imágenes JPG, PNG de 230px x 140px</span>
            <input type="submit" id="guardadatos_logo" name="guardadatos_logo" value="Guardar" class="btn btn-sm btn-secondary col-12 col-sm-auto" />
        </form>

        <div style="background-repeat: no-repeat;background-size: cover; height: 140px;width: 230px; float: left; margin:15px; background-image: url('<?=_RAIZ_?>imagenes/talleres/logotipos/<?=$taller->ta_logotipo?>') ">
        </div>
    </div>
</div>
        <?php }?>

<?php }
unset($_SESSION['datos_'._ID_PAG_]['datos_generales']);
unset($_SESSION['datos_'._ID_PAG_]['datos_facturacion']);
unset($_SESSION['datos_'._ID_PAG_]['datos_acceso']);
unset($_SESSION['proceso']['guardar_logotipo']);
?>