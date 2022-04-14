<div class="cont_seccion" id="secc-<?=$seccion?>">
	<?php 
    if(isset($_SESSION['datos_'._ID_PAG_]['edita_cliente']['hayerrores'])){
        if($_SESSION['datos_'._ID_PAG_]['edita_cliente']['hayerrores']==1){?>
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
    $clientes=dame_clientes($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);?>
    <div class="linea">
        <span style="float:left" class="oswald fs_16">A&Ntilde;ADIR CLIENTE</span><div class="link mostrarocultar" id="mostrarocultar_nuevocliente"></div>
    </div>
    <div id="nuevocliente" class="div_mostrarocultar" style="display:none">
        <div class="linea empleado_NEW">
            <form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_cliente" id="nuevo_cliente">
                <input type="hidden" id="idproceso" name="idproceso" value="edita_cliente" />
                <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>clientes" />
                <input type="hidden" id="idcliente" name="idcliente" value="NEW" />
                <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
                <div class="linea">
                <label for="nomcom_NEW">Nombre comercial:</label><input type="text" id="nomcom_NEW" name="nomcom_NEW" value="">
                <input type="submit" id="guardadatos_facturacion" name="guardadatos_facturacion" value="Guardar" style="margin:0px" />
            </div>
            <div class="linea">
                <label for="razsoc_NEW">Raz&oacute;n social:</label><input type="text" id="razsoc_NEW" name="razsoc_NEW" value="">
            </div>
            <div class="linea">
                <label for="nifcif_NEW">NIF/CIF:</label><input type="text" id="nifcif_NEW" name="nifcif_NEW" class="peq" value="">
            </div>
            <div class="linea">
                <label for="direccion_NEW">Direcci&oacute;n:</label><input type="text" id="direccion_NEW" name="direccion_NEW" value="">
            </div>
            <div class="linea">
                <label for="cp_NEW">C&oacute;digo postal:</label><input type="text" id="cp_NEW" name="cp_NEW" class="peq" value="">
            </div>
            <div class="linea">
                <label for="localidad_NEW">Localidad:</label><input type="text" id="localidad_NEW" name="localidad_NEW" value="">
            </div>
            <div class="linea">
                <label for="provincia_NEW">Provincia:</label><input type="text" id="provincia_NEW" name="provincia_NEW" value="">
            </div>
            <div class="linea">
                <label for="telefono_NEW">Tel&eacute;fono:</label><input type="text" id="telefono_NEW" name="telefono_NEW" class="peq" value="">
                <div class="sep_form"></div>
                <label for="movil_NEW">M&oacute;vil:</label><input type="text" id="movil_NEW" name="movil_NEW" class="peq" value="">
            </div>
            <div class="linea">
                <label for="correo_NEW">Correo-e:</label><input type="text" id="correo_NEW" name="correo_NEW" value="">
            </div>
            <div class="linea">
                <label for="contacto_NEW">Contacto:</label><input type="text" id="contacto_NEW" name="contacto_NEW" value="">
            </div>
            <div class="linea">
                <textarea class="orig" id="observaciones_NEW" name="observaciones_NEW" placeholder="Observaciones"></textarea>
            </div>
        </form>
        </div>
    </div>
    <div id="contclientes" class="div_mostrarocultar">
    <?php if(count($clientes)>0){
        foreach($clientes as $cliente){?>
        <div class="linea empleado">
            <form action="<?=_RAIZ_?>procesando.php" method="post" name="edita_cliente" id="edita_cliente">
                <input type="hidden" id="idproceso" name="idproceso" value="edita_cliente" />
                <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>clientes" />
                <input type="hidden" id="idcliente" name="idcliente" value="NEW" />
                <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
                <div class="linea">
                <label for="nomcom_NEW">Nombre comercial:</label><input type="text" class="orig" id="nomcom_NEW" name="nomcom_NEW" value="" onkeyup="comprueba_cambios('nuevo_cliente')">
                <input type="hidden" id="nomcom_NEW_def" name="nomcom_NEW_def" value="">
                <input type="submit" id="guardadatos_facturacion" name="guardadatos_facturacion" value="Guardar" style="margin:0px; display:none" />
            </div>
            <div class="linea">
                <label for="razsoc_NEW">Raz&oacute;n social:</label><input type="text" class="orig" id="razsoc_NEW" name="razsoc_NEW" value="<?=u8d_($datos_facturacion[0]->uf_denomsoc)?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="razsoc_NEW_def" name="razsoc_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_denomsoc)?>">
            </div>
            <div class="linea">
                <label for="nifcif_NEW">NIF/CIF:</label><input type="text" id="nifcif_NEW" name="nifcif_NEW" class="peq orig" value="<?=u8d_($datos_facturacion[0]->uf_cifnif)?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="nifcif_NEW_def" name="nifcif_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_cifnif)?>">
            </div>
            <div class="linea">
                <label for="direccionf_NEW">Direcci&oacute;n:</label><input type="text" class="orig" id="direccionf_NEW" name="direccionf_NEW" value="<?=u8d_($datos_facturacion[0]->uf_direccion)?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="direccionf_NEW_def" name="direccionf_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_direccion)?>">
            </div>
            <div class="linea">
                <label for="cpf_NEW">C&oacute;digo postal:</label><input type="text" id="cpf_NEW" name="cpf_NEW" class="peq orig" value="<?=$datos_facturacion[0]->uf_cp?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="cpf_NEW_def" name="cpf_NEW_def" value="<?=$datos_facturacion[0]->uf_cp?>">
            </div>
            <div class="linea">
                <label for="localidadf_NEW">Localidad:</label><input type="text" class="orig" id="localidadf_NEW" name="localidadf_NEW" value="<?=u8d_($datos_facturacion[0]->uf_localidad)?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="localidadf_NEW_def" name="localidadf_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_localidad)?>">
            </div>
            <div class="linea">
                <label for="provinciaf_NEW">Provincia:</label><input type="text" class="orig" id="provinciaf_NEW" name="provinciaf_NEW" value="<?=u8d_($datos_facturacion[0]->uf_provincia)?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="provinciaf_NEW_def" name="provinciaf_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_provincia)?>">
            </div>
            <div class="linea">
                <label for="telefonof_NEW">Tel&eacute;fono:</label><input type="text" id="telefonof_NEW" name="telefonof_NEW" class="peq orig" value="<?=$datos_facturacion[0]->uf_telefono1?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="telefonof_NEW_def" name="telefonof_NEW_def" value="<?=$datos_facturacion[0]->uf_telefono1?>">
                <div class="sep_form"></div>
                <label for="movilf_NEW">M&oacute;vil:</label><input type="text" id="movilf_NEW" name="movilf_NEW" class="peq orig" value="<?=$datos_facturacion[0]->uf_telefono2?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="movilf_NEW_def" name="movilf_NEW_def" value="<?=$datos_facturacion[0]->uf_telefono2?>">
            </div>
            <div class="linea">
                <label for="correof_NEW">Correo-e:</label><input type="text" class="orig" id="correof_NEW" name="correof_NEW" value="<?=$datos_facturacion[0]->uf_email?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="correof_NEW_def" name="correof_NEW_def" value="<?=$datos_facturacion[0]->uf_email?>">
            </div>
            <div class="linea">
                <label for="contactof_NEW">Contacto:</label><input type="text" class="orig" id="contactof_NEW" name="contactof_NEW" value="<?=u8d_($datos_facturacion[0]->uf_contacto)?>" onkeyup="comprueba_cambios('datos_facturacion')">
                <input type="hidden" id="contactof_NEW_def" name="contactof_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_contacto)?>">
            </div>
            <div class="linea">
                <textarea class="orig" id="observaciones_NEW" name="observaciones_NEW" placeholder="Observaciones" onkeyup="comprueba_cambios('datos_facturacion')"><?=u8d_($datos_facturacion[0]->uf_observaciones)?></textarea>
                <input type="hidden" id="observaciones_NEW_def" name="observaciones_NEW_def" value="<?=u8d_($datos_facturacion[0]->uf_observaciones)?>">
            </div>
        </form>
        </div>
    <?php }
    }
    unset($_SESSION['datos_'._ID_PAG_]['edita_empleado']);?>
    </div>
</div>