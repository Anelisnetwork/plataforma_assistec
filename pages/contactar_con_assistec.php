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



<div class="cont_seccion">
    <div id="datosmensual" class="colizq" style="float:left;">	
        <form action="<?=_RAIZ_?>procesando.php" method="post" name="contacto" id="contacto">
            <input type="hidden" id="idproceso" name="idproceso" value="contacto" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>contactar_con_assistec" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />

            <div class="linea">
            	<span class="texto_r oswald fs_16">Formulario de contacto</span>
            </div>

            <div class="linea">
                <label class="ancho">Persona de contacto:</label>
                <br />
                <input type="text" id="perscont" name="perscont" value="<?=u8d_(dato_taller('ta_contacto'))?>" placeholder="&iquest;Con qui&eacute;n debemos tratar este asunto?">
            </div>
            <div class="linea">
                <label class="ancho">Tel&eacute;fono de contacto:</label>
                <br />
                <input type="text" id="tlfcont" name="tlfcont" value="<?=dato_taller('ta_telefono1')?>" placeholder="&iquest;En qu&eacute; n&uacute;mero podemos localizarle?">
            </div>
            <div class="linea">
                <label class="ancho">E-mail de contacto:</label>
                <br />
                <input type="text" id="mailcont" name="cont" value="<?=dato_taller('ta_email')?>" placeholder="&iquest;A qu&eacute; e-mail debemos responder?">
            </div>
            <div class="linea">
                <label class="ancho">Horario de contacto:</label>
                <br />
                <input type="text" id="horacont" name="horacont" value="Horario comercial" placeholder="En caso de llamarle &iquest;A qu&eacute; hora le viene mejor?">
            </div>
            <div class="linea">
                <label class="ancho">Asunto:</label>
                <br />
                <select id="asuntocont" name="asuntocont" style="width:420px">
                    <option value="Funcionamiento del panel">Funcionamiento del panel</option>
                    <option value="Facturacion">Facturaci&oacute;n</option>
                    <option value="Otras consultas">Otras consultas</option>
                </select>
            </div>
            <div class="linea">
                <label class="ancho">Comentarios:</label>
                <br />
                <textarea id="comentcont" name="comentcont" placeholder="Detalle su consulta" style="width:408px"></textarea>
            </div>
            <div class="linea">
                <input type="submit" id="subcont" name="subcont" value="Enviar" style="margin-right:80px;" />
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