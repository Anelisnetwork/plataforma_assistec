<?php
if(isset($_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores'])){
    if($_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']==1){
        $mensaje='No se ha podido guardar';
        if(isset($_SESSION['datos_'._ID_PAG_]['edita_taller']['mensaje'])){
            $mensaje=$_SESSION['datos_'._ID_PAG_]['edita_taller']['mensaje'];
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

if($d_tall==''||$d_tall==NULL){?>
    <div class="linea">
        <span class="oswald fs_16 texto_r">NO HAY DATOS</span>
    </div>
<?php }
else{?>
    <form action="<?=_RAIZ_?>procesando.php" onsubmit="return valida_nuevotaller('<?=$d_tall[0]->ta_idtaller?>');" method="post" name="edita_taller" id="edita_taller">
        <div class="linea">
            <span class="fs_12 ubuntu texto_n"><strong>ID:</strong> <?=en__id($d_tall[0]->ta_idtaller)?></span>
        </div>
        <div class="linea">
            <span style="float:left" class="oswald fs_16 texto_r">Datos de contrato:</span><div class="link mostrarocultar" id="mostrarocultar_datoscontrato" style="background-position:bottom"></div>
            <input type="submit" id="guardadatos_<?=$d_tall[0]->ta_idtaller?>" name="guardadatos_<?=$d_tall[0]->ta_idtaller?>" value="Guardar" style="margin:0px; display:none" />
        </div>
        <div id="datoscontrato" class="div_mostrarocultar" style="float:left">
            <div class="linea taller_<?=$d_tall[0]->ta_idtaller?>">
                <input type="hidden" id="idproceso" name="idproceso" value="edita_taller" />
                <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>talleres/editar_taller/<?=$d_tall[0]->ta_idtaller?>" />
                <input type="hidden" id="idtaller" name="idtaller" value="<?=$d_tall[0]->ta_idtaller?>" />
                <div class="linea">
                    <label for="tipo_<?=$d_tall[0]->ta_idtaller?>">Tipo taller:</label>
                    <select id="tipo_<?=$d_tall[0]->ta_idtaller?>" name="tipo_<?=$d_tall[0]->ta_idtaller?>" onchange="cambiatipo(this.value); comprueba_cambios('edita_taller')" class="orig" >
                        <option value="1"<?=$d_tall[0]->ta_idtipo==1?' selected="selected"':''?>>Taller</option>
                        <option value="2"<?=$d_tall[0]->ta_idtipo==2?' selected="selected"':''?>>Red</option>
                    </select>
                    <input type="hidden" id="tipo_<?=$d_tall[0]->ta_idtaller?>_def" name="tipo_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_idtipo?>" />
                </div>
                <div class="linea">
                    <label>Token acceso:</label>
                    <span style="float:left; margin:9px"><?=$d_tall[0]->ta_log_token?></span>
                </div>
                <div class="linea" id="parared"<?=$d_tall[0]->ta_idtipo==2?' style="display:none"':''?>>
                    <label for="red_<?=$d_tall[0]->ta_idtaller?>">De la red:</label>
                    <select id="red_<?=$d_tall[0]->ta_idtaller?>" name="red_<?=$d_tall[0]->ta_idtaller?>" onchange="cambiared(this.value); comprueba_cambios('edita_taller')" class="orig">
                        <option value="0"<?=$d_tall[0]->ta_idparent==0?' selected="selected"':''?>>Ninguna</option>
                        <?php foreach($l_redes as $red){?>
                            <option value="<?=$red->ta_idtaller?>"<?=$d_tall[0]->ta_idparent==$red->ta_idtaller?' selected="selected"':''?>><?=$red->ta_nombre?></option>
                        <?php }?>
                    </select>
                    <input type="hidden" id="red_<?=$d_tall[0]->ta_idtaller?>_def" name="red_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_idparent?>" />
                </div>
                <div class="linea" id="esmodulo"<?=$d_tall[0]->ta_idparent!=0?' style="display:none"':''?>>
                    <label for="contrato_<?=$d_tall[0]->ta_idtaller?>">M&oacute;dulo:</label>
                    <select id="contrato_<?=$d_tall[0]->ta_idtaller?>" name="contrato_<?=$d_tall[0]->ta_idtaller?>" class="orig" onchange="comprueba_cambios('edita_taller')">
                        <?php foreach($l_contratos as $contrato){?>
                            <option value="<?=$contrato->tc_idtipo?>"<?=$d_tall[0]->ta_contrato==$contrato->tc_idtipo?' selected="selected"':''?>><?=$contrato->tc_nombre?></option>
                        <?php }?>
                    </select>
                    <input type="hidden" id="contrato_<?=$d_tall[0]->ta_idtaller?>_def" name="contrato_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_contrato?>" />
                </div>
                <div class="linea">
                    <label for="pago_<?=$d_tall[0]->ta_idtaller?>">Pago:</label>
                    <select id="pago_<?=$d_tall[0]->ta_idtaller?>" name="pago_<?=$d_tall[0]->ta_idtaller?>" class="orig" onchange="comprueba_cambios('edita_taller')">
                        <?php foreach($l_abonos as $abono){?>
                            <option value="<?=$abono->ta_idtipo?>"<?=$d_tall[0]->ta_abono==$abono->ta_idtipo?' selected="selected"':''?>><?=$abono->ta_nombre?></option>
                        <?php }?>
                    </select>
                    <input type="hidden" id="pago_<?=$d_tall[0]->ta_idtaller?>_def" name="pago_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_abono?>" />
                </div>
            </div>
        </div>
        <div class="linea">
            <span style="float:left" class="oswald fs_16 texto_r">Objetivos:</span><div class="link mostrarocultar" id="mostrarocultar_objetivos"></div>
        </div>
        <div id="objetivos" class="div_mostrarocultar" style="float:left; display:none">
            <div class="linea taller_<?=$d_tall[0]->ta_idtaller?>">
                <div class="linea">
                    <label for="objventas_<?=$d_tall[0]->ta_idtaller?>">Ventas (&euro;):</label>
                    <input type="number" id="objventas_<?=$d_tall[0]->ta_idtaller?>" name="objventas_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_objventas?>" class="orig" onkeyup="comprueba_cambios('edita_taller')" onchange="comprueba_cambios('edita_taller')" style="width:100px">
                    <input type="hidden" id="objventas_<?=$d_tall[0]->ta_idtaller?>_def" name="objventas_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_objventas?>" />
                </div>
                <div class="linea">
                    <label for="objmargenrec_<?=$d_tall[0]->ta_idtaller?>">Margen rec. (%):</label>
                    <input type="number" id="objmargenrec_<?=$d_tall[0]->ta_idtaller?>" name="objmargenrec_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_objmargenrec?>" class="orig" onkeyup="comprueba_cambios('edita_taller')" onchange="comprueba_cambios('edita_taller')" style="width:100px">
                    <input type="hidden" id="objmargenrec_<?=$d_tall[0]->ta_idtaller?>_def" name="objmargenrec_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_objmargenrec?>" />
                </div>
                <div class="linea">
                    <label for="objeficacia_<?=$d_tall[0]->ta_idtaller?>">Eficacia (%):</label>
                    <input type="number" id="objeficacia_<?=$d_tall[0]->ta_idtaller?>" name="objeficacia_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_objeficacia?>" class="orig" onkeyup="comprueba_cambios('edita_taller')" onchange="comprueba_cambios('edita_taller')" style="width:100px">
                    <input type="hidden" id="objeficacia_<?=$d_tall[0]->ta_idtaller?>_def" name="objeficacia_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_objeficacia?>" />
                </div>
                <div class="linea">
                    <label for="objproductividad_<?=$d_tall[0]->ta_idtaller?>">Productividad (%):</label>
                    <input type="number" id="objproductividad_<?=$d_tall[0]->ta_idtaller?>" name="objproductividad_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_objproductividad?>" class="orig" onkeyup="comprueba_cambios('edita_taller')" onchange="comprueba_cambios('edita_taller')" style="width:100px">
                    <input type="hidden" id="objproductividad_<?=$d_tall[0]->ta_idtaller?>_def" name="objproductividad_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_objproductividad?>" />
                </div>
                <div class="linea">
                    <label for="objrendimiento_<?=$d_tall[0]->ta_idtaller?>">Rendimiento (%):</label>
                    <input type="number" id="objrendimiento_<?=$d_tall[0]->ta_idtaller?>" name="objrendimiento_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_objrendimiento?>" class="orig" onkeyup="comprueba_cambios('edita_taller')" onchange="comprueba_cambios('edita_taller')" style="width:100px">
                    <input type="hidden" id="objrendimiento_<?=$d_tall[0]->ta_idtaller?>_def" name="objrendimiento_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_objrendimiento?>" />
                </div>
            </div>
        </div>

        <div class="linea">
            <span style="float:left" class="oswald fs_16 texto_r">Datos del taller:</span><div class="link mostrarocultar" id="mostrarocultar_datostaller"></div>
        </div>
        <div id="datostaller" class="div_mostrarocultar" style="float:left; display:none">
            <div class="linea taller_<?=$d_tall[0]->ta_idtaller?>">
                <div class="linea">
                    <label for="nomcom_<?=$d_tall[0]->ta_idtaller?>">Nombre del taller:</label>
                    <input type="text" id="nomcom_<?=$d_tall[0]->ta_idtaller?>" name="nomcom_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall[0]->ta_nombre)?>" class="orig" required="required" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="nomcom_<?=$d_tall[0]->ta_idtaller?>_def" name="nomcom_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall[0]->ta_nombre)?>" />
                </div>
                <div class="linea">
                    <label for="contacto_<?=$d_tall[0]->ta_idtaller?>">Contacto:</label>
                    <input type="text" id="contacto_<?=$d_tall[0]->ta_idtaller?>" name="contacto_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall[0]->ta_contacto)?>" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="contacto_<?=$d_tall[0]->ta_idtaller?>_def" name="contacto_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall[0]->ta_contacto)?>" />
                </div>
                <div class="linea">
                    <label for="socio_<?=$d_tall[0]->ta_idtaller?>">Socio:</label>
                    <input type="text" id="socio_<?=$d_tall[0]->ta_idtaller?>" name="socio_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall[0]->ta_socio)?>" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="socio_<?=$d_tall[0]->ta_idtaller?>_def" name="socio_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall[0]->ta_socio)?>" />
                </div>
                <div class="linea">
                    <label for="telefono_<?=$d_tall[0]->ta_idtaller?>">Tel&eacute;fono:</label>
                    <input type="text" id="telefono_<?=$d_tall[0]->ta_idtaller?>" name="telefono_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_telefono1?>" required="required" onkeyup="limpiatlf(this.id); comprueba_cambios('edita_taller')" class="orig">
                    <input type="hidden" id="telefono_<?=$d_tall[0]->ta_idtaller?>_def" name="telefono_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_telefono1?>" />
                </div>
                <div class="linea">
                    <label for="telefono2_<?=$d_tall[0]->ta_idtaller?>">M&oacute;vil:</label>
                    <input type="text" id="telefono2_<?=$d_tall[0]->ta_idtaller?>" name="telefono2_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_telefono2?>" onkeyup="limpiatlf(this.id); comprueba_cambios('edita_taller')" class="orig">
                    <input type="hidden" id="telefono2_<?=$d_tall[0]->ta_idtaller?>_def" name="telefono2_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_telefono2?>" />
                </div>
                <div class="linea">
                    <label for="correo_<?=$d_tall[0]->ta_idtaller?>">E-mail:</label>
                    <input type="text" id="correo_<?=$d_tall[0]->ta_idtaller?>" name="correo_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_email?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="correo_<?=$d_tall[0]->ta_idtaller?>_def" name="correo_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_email?>" />
                </div>
                <div class="linea">
                    <label for="dirr_<?=$d_tall[0]->ta_idtaller?>">Direcci&oacute;n:</label>
                    <input type="text" id="dirr_<?=$d_tall[0]->ta_idtaller?>" name="dirr_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall[0]->ta_direccion)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="dirr_<?=$d_tall[0]->ta_idtaller?>_def" name="dirr_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall[0]->ta_direccion)?>" />
                </div>
                <div class="linea">
                    <label for="cp_<?=$d_tall[0]->ta_idtaller?>">C&oacute;digo postal:</label>
                    <input type="text" id="cp_<?=$d_tall[0]->ta_idtaller?>" name="cp_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall[0]->ta_cp?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="cp_<?=$d_tall[0]->ta_idtaller?>_def" name="cp_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_cp?>" />
                </div>
                <div class="linea">
                    <label for="loc_<?=$d_tall[0]->ta_idtaller?>">Localidad:</label>
                    <input type="text" id="loc_<?=$d_tall[0]->ta_idtaller?>" name="loc_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall[0]->ta_localidad)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="loc_<?=$d_tall[0]->ta_idtaller?>_def" name="loc_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall[0]->ta_localidad)?>" />
                </div>
                <div class="linea">
                    <label for="prov_<?=$d_tall[0]->ta_idtaller?>">Provincia:</label>
                    <input type="text" id="prov_<?=$d_tall[0]->ta_idtaller?>" name="prov_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall[0]->ta_provincia)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="prov_<?=$d_tall[0]->ta_idtaller?>_def" name="prov_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall[0]->ta_provincia)?>" />
                </div>
                <div class="linea">
                    <label for="avisodatos_<?=$d_tall[0]->ta_idtaller?>">Enviar recordatorio de introducción de datos:</label>
                    <select id="avisodatos_<?=$d_tall[0]->ta_idtaller?>" name="avisodatos_<?=$d_tall[0]->ta_idtaller?>" class="orig" onchange="comprueba_cambios('edita_taller')" >
                        <option title="Enviar avisos" value="0"<?=$d_tall[0]->ta_avisodatos==0?' selected="selected"':''?>>Sí</option>
                        <option title="No enviar avisos" value="1"<?=$d_tall[0]->ta_avisodatos==1?' selected="selected"':''?>>No</option>
                    </select>
                    <input type="hidden" id="avisodatos_<?=$d_tall[0]->ta_idtaller?>_def" name="avisodatos_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_avisodatos?>" />
                </div>
            </div>
        </div>

        <div class="linea">
            <span style="float:left" class="oswald fs_16 texto_r">Datos de facturaci&oacute;n:</span><div class="link mostrarocultar" id="mostrarocultar_datosfacturacion"></div>
        </div>
        <div id="datosfacturacion" class="div_mostrarocultar" style="float:left; display:none">
            <div class="linea taller_<?=$d_tall[0]->ta_idtaller?>">
                <div class="linea">
                    <label for="nofacturar_<?=$d_tall[0]->ta_idtaller?>">Emitir facturas:</label>
                    <select id="nofacturar_<?=$d_tall[0]->ta_idtaller?>" name="nofacturar_<?=$d_tall[0]->ta_idtaller?>" class="orig" onchange="comprueba_cambios('edita_taller')" >
                        <option title="Emitir facturas" value="0"<?=$d_tall[0]->ta_nofacturar==0?' selected="selected"':''?>>Sí</option>
                        <option title="No emitir facturas" value="1"<?=$d_tall[0]->ta_nofacturar==1?' selected="selected"':''?>>No</option>
                    </select>
                    <input type="hidden" id="nofacturar_<?=$d_tall[0]->ta_idtaller?>_def" name="nofacturar_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall[0]->ta_nofacturar?>" />
                </div>
                <div class="linea">
                    <label for="tipoiva_<?=$d_tall[0]->ta_idtaller?>">Tipo IVA:</label>
                    <select id="tipoiva_<?=$d_tall[0]->ta_idtaller?>" name="tipoiva_<?=$d_tall[0]->ta_idtaller?>" class="orig" onchange="comprueba_cambios('edita_taller')" >
                        <?php foreach ($tipos_iva as $tipo_iva){?>
                            <option title="<?=$tipo_iva->ti_descripcion?>" value="<?=$tipo_iva->ti_idtipo?>"<?=$d_tall_fac[0]->uf_tipoiva==$tipo_iva->ti_idtipo?' selected="selected"':''?>><?=number_format($tipo_iva->ti_valor, 2)?> %</option>
                        <?php }?>
                    </select>
                    <input type="hidden" id="tipoiva_<?=$d_tall[0]->ta_idtaller?>_def" name="tipoiva_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_tipoiva?>" />
                </div>
                <div class="linea">
                    <label class="faq" title="Recargo de equivalencia (5,2%)" for="retiene_<?=$d_tall[0]->ta_idtaller?>">R.E.:</label>
                    <input type="checkbox" id="retiene_<?=$d_tall[0]->ta_idtaller?>" name="retiene_<?=$d_tall[0]->ta_idtaller?>" value="1"<?=$d_tall_fac[0]->uf_retiene==1?' checked="checked"':''?> style="float:left; margin-top:8px" class="orig" onclick="comprueba_cambios('edita_taller')"><span style="float:left; margin:9px" class="fs_10">(Indicar si el cliente tiene recargo de equivalencia.)</span>
                    <input type="hidden" id="retiene_<?=$d_tall[0]->ta_idtaller?>_def" name="retiene_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_retiene?>" />
                </div>
                <div class="linea">
                    <label for="razsoc_<?=$d_tall[0]->ta_idtaller?>">Raz&oacute;n social:</label>
                    <input type="text" id="razsoc_<?=$d_tall[0]->ta_idtaller?>" name="razsoc_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall_fac[0]->uf_denomsoc)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="razsoc_<?=$d_tall[0]->ta_idtaller?>_def" name="razsoc_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall_fac[0]->uf_denomsoc)?>" />
                </div>
                <div class="linea">
                    <label for="cif_<?=$d_tall[0]->ta_idtaller?>">NIF / CIF:</label>
                    <input type="text" id="cif_<?=$d_tall[0]->ta_idtaller?>" name="cif_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall_fac[0]->uf_cifnif?>" required="required" class="orig" onkeyup="cambianif(this.id); comprueba_cambios('edita_taller')">
                    <input type="hidden" id="cif_<?=$d_tall[0]->ta_idtaller?>_def" name="cif_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_cifnif?>" />
                </div>
                <div class="linea">
                    <label for="nomcomf_<?=$d_tall[0]->ta_idtaller?>">Nombre comercial:</label>
                    <input type="text" id="nomcomf_<?=$d_tall[0]->ta_idtaller?>" name="nomcomf_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall_fac[0]->uf_nomcom)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="nomcomf_<?=$d_tall[0]->ta_idtaller?>_def" name="nomcomf_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall_fac[0]->uf_nomcom)?>" />
                </div>
                <div class="linea">
                    <label for="contactof_<?=$d_tall[0]->ta_idtaller?>">Contacto:</label>
                    <input type="text" id="contactof_<?=$d_tall[0]->ta_idtaller?>" name="contactof_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall_fac[0]->uf_contacto)?>" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="contactof_<?=$d_tall[0]->ta_idtaller?>_def" name="contactof_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall_fac[0]->uf_contacto)?>" />
                </div>
                <div class="linea">
                    <label for="telefonof_<?=$d_tall[0]->ta_idtaller?>">Tel&eacute;fono:</label>
                    <input type="text" id="telefonof_<?=$d_tall[0]->ta_idtaller?>" name="telefonof_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall_fac[0]->uf_telefono1?>" required="required" onkeyup="limpiatlf(this.id); comprueba_cambios('edita_taller')" class="orig">
                    <input type="hidden" id="telefonof_<?=$d_tall[0]->ta_idtaller?>_def" name="telefonof_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_telefono1?>" />
                </div>
                <div class="linea">
                    <label for="telefono2f_<?=$d_tall[0]->ta_idtaller?>">M&oacute;vil:</label>
                    <input type="text" id="telefono2f_<?=$d_tall[0]->ta_idtaller?>" name="telefono2f_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall_fac[0]->uf_telefono2?>" onkeyup="limpiatlf(this.id); comprueba_cambios('edita_taller')" class="orig">
                    <input type="hidden" id="telefono2f_<?=$d_tall[0]->ta_idtaller?>_def" name="telefono2f_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_telefono2?>" />
                </div>
                <div class="linea">
                    <label for="correof_<?=$d_tall[0]->ta_idtaller?>">E-mail:</label>
                    <input type="text" id="correof_<?=$d_tall[0]->ta_idtaller?>" name="correof_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall_fac[0]->uf_email?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="correof_<?=$d_tall[0]->ta_idtaller?>_def" name="correof_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_email?>" />
                </div>
                <div class="linea">
                    <label for="dirrf_<?=$d_tall[0]->ta_idtaller?>">Direcci&oacute;n:</label>
                    <input type="text" id="dirrf_<?=$d_tall[0]->ta_idtaller?>" name="dirrf_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall_fac[0]->uf_direccion)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="dirrf_<?=$d_tall[0]->ta_idtaller?>_def" name="dirrf_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall_fac[0]->uf_direccion)?>" />
                </div>
                <div class="linea">
                    <label for="cpf_<?=$d_tall[0]->ta_idtaller?>">C&oacute;digo postal:</label>
                    <input type="text" id="cpf_<?=$d_tall[0]->ta_idtaller?>" name="cpf_<?=$d_tall[0]->ta_idtaller?>" value="<?=$d_tall_fac[0]->uf_cp?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="cpf_<?=$d_tall[0]->ta_idtaller?>_def" name="cpf_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=$d_tall_fac[0]->uf_cp?>" />
                </div>
                <div class="linea">
                    <label for="locf_<?=$d_tall[0]->ta_idtaller?>">Localidad:</label>
                    <input type="text" id="locf_<?=$d_tall[0]->ta_idtaller?>" name="locf_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall_fac[0]->uf_localidad)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="locf_<?=$d_tall[0]->ta_idtaller?>_def" name="locf_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall_fac[0]->uf_localidad)?>" />
                </div>
                <div class="linea">
                    <label for="provf_<?=$d_tall[0]->ta_idtaller?>">Provincia:</label>
                    <input type="text" id="provf_<?=$d_tall[0]->ta_idtaller?>" name="provf_<?=$d_tall[0]->ta_idtaller?>" value="<?=u8d_($d_tall_fac[0]->uf_provincia)?>" required="required" class="orig" onkeyup="comprueba_cambios('edita_taller')">
                    <input type="hidden" id="provf_<?=$d_tall[0]->ta_idtaller?>_def" name="provf_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=u8d_($d_tall_fac[0]->uf_provincia)?>" />
                </div>
                <div class="linea">
                    <label for="observ_<?=$d_tall[0]->ta_idtaller?>">Observaciones:</label>
                </div>
                <div class="linea">
                    <textarea id="observ_<?=$d_tall[0]->ta_idtaller?>" name="observ_<?=$d_tall[0]->ta_idtaller?>" class="orig" onkeyup="comprueba_cambios('edita_taller')"><?=u8d_($d_tall_fac[0]->uf_observaciones)?></textarea>
                    <input type="hidden" id="observ_<?=$d_tall[0]->ta_idtaller?>_def" name="observ_<?=$d_tall[0]->ta_idtaller?>_def" value="<?=html_(u8d_($d_tall_fac[0]->uf_observaciones))?>" />
                </div>
            </div>
        </div>
    </form>
<?php }
unset($_SESSION['datos_'._ID_PAG_]['edita_taller']);
?>