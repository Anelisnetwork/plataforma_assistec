<?php if(isset($_SESSION['datos_'._ID_PAG_]['contacto']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['contacto']['hayerrores']==1){?>
    	<script>
			alertify.error("No se ha podido enviar el formulario");
		</script>
	<?php }
	else{?>
    	<script>
			alertify.alert('Formulario enviado correctamente','Gracias por contactar con Assitec.<br>En breve recibirá respuesta.');
		</script>
	<?php }
}
?>



<div class="d-flex flex-column align-items-center justify-content-start w-100 p-2 p-sm-5">
    <div id="datosmensual" class=" col-12 col-lg-6 d-flex flex-column align-items-center justify-content-start">
        <form action="<?=_RAIZ_?>procesando.php" method="post" class="w-100" name="contacto" id="contacto">
            <input type="hidden" id="idproceso" name="idproceso" value="contacto" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>contactar_con_assistec" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />

            <div class="d-flex flex-row align-items-start align-items-sm-center justify-content-start w-100 mb-2">
            	<span class="texto_r oswald fs_16">Formulario de contacto</span>
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <label for="perscont" class="ancho">Persona de contacto:</label>
                <input type="text" id="perscont" name="perscont" class="form-control form-control-sm" value="<?=u8d_(dato_taller('ta_contacto'))?>" placeholder="&iquest;Con qui&eacute;n debemos tratar este asunto?" style="width: auto">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <label class="ancho">Tel&eacute;fono de contacto:</label>
                <input type="text" id="tlfcont" name="tlfcont" class="form-control form-control-sm" value="<?=dato_taller('ta_telefono1')?>" placeholder="&iquest;En qu&eacute; n&uacute;mero podemos localizarle?" style="width: auto">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <label class="ancho">E-mail de contacto:</label>
                <input type="text" id="mailcont" name="cont" class="form-control form-control-sm" value="<?=dato_taller('ta_email')?>" placeholder="&iquest;A qu&eacute; e-mail debemos responder?" style="width: auto">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <label class="ancho">Horario de contacto:</label>
                <input type="text" id="horacont" name="horacont" class="form-control form-control-sm" value="Horario comercial" placeholder="En caso de llamarle &iquest;A qu&eacute; hora le viene mejor?" style="width: auto">
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <label class="ancho">Asunto:</label>
                <select id="asuntocont" name="asuntocont" class="form-select form-select-sm" style="width:auto">
                    <option value="Funcionamiento del panel">Funcionamiento del panel</option>
                    <option value="Facturacion">Facturaci&oacute;n</option>
                    <option value="Otras consultas">Otras consultas</option>
                </select>
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <label class="ancho">Comentarios:</label>
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-start justify-content-sm-between w-100 mb-2">
                <textarea id="comentcont" name="comentcont" class="form-control form-control-sm" placeholder="Detalle su consulta"></textarea>
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-end w-100 mb-2">
                <input type="submit" id="subcont" name="subcont" value="Enviar" class="btn btn-secondary col-12 col-sm-auto" />
            </div>
            
        </form>
    </div>
    <div class="colder2">
    	<div class="mail_assistec">
        	<span class="ubuntu texto_r fs_16">web<img class="algarroba" src="<?=_RAIZ_?>imagenes/algarroba.png" height="14" />assistec.es</span>
        </div>
    </div>
</div>
<?php unset ($_SESSION['datos_'._ID_PAG_]['contacto']);?>