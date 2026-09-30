<?php
exit();
if(isset($_SESSION['datos_'._ID_PAG_]['edita_datosactividad']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_datosactividad']['hayerrores']==1){?>
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
$datos_actividad=datos_actividad();
$empleados_directos=dame_empleados($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'],1);

$imp_mo=dame_impmo_actual();

?>
<div id="datosactividad" class="div_mostrarocultar" style="float:left;">
    <?php if($imp_mo==0.00){?>
    <div class="linea" style="text-align:center">
        <span class="oswald fs_18 texto_r">Primero debe completar los datos relativos a la <a href="<?=_RAIZ_?>datos_del_taller/informacion/">informaci&oacute;n del taller</a>.</span>
    </div>
    <?php }
    else if(count($empleados_directos)<=0){?>
    <div class="linea" style="text-align:center">
        <span class="oswald fs_18 texto_r">Primero debe dar de alta al personal del taller; puede hacerlo desde <a href="<?=_RAIZ_?>datos_del_taller/personal/">AQU&Iacute;</a></span>
    </div>
    <?php }
    else{?>
    <form action="<?=_RAIZ_?>procesando.php" method="post" name="edita_datosactividad" id="edita_datosactividad">
        <input type="hidden" id="idproceso" name="idproceso" value="edita_datosactividad" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/datos_de_actividad" />
        <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
        <input type="hidden" id="iddatoact" name="iddatoact" value="<?=$datos_actividad[0]->da_iddato?>" />
        <input type="hidden" id="empleados_dir" name="empleados_dir" value="<?=count($empleados_directos)?>" />
        
        <input type="hidden" id="importemo_<?=$datos_actividad[0]->da_iddato?>" name="importemo_<?=$datos_actividad[0]->da_iddato?>" value="<?=$datos_actividad[0]->da_impmo==0.00?$imp_mo:$datos_actividad[0]->da_impmo?>" />
        <div class="linea">
            <span class="tit_mes" style="margin-left:180px;"><strong>KM 0</strong></span>
        </div>
        <div class="linea">
            <label class="ancho">N&ordm; de meses:</label>
            <input type="text" id="nmeses_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="nmeses_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_mes?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="nmeses_<?=$datos_actividad[0]->da_iddato?>_def" name="nmeses_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_mes?>" />
            
            <input type="submit" style="display:none" id="edita_datoactividad" name="edita_datoactividad" value="Guardar" />
        </div>
        
        <div class="linea">
            <label class="ancho">N&ordm; de d&iacute;as laborables:</label>
            <input type="text" id="diaslab_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diaslab_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_diaslaborables?>" onkeyup="comprueba_num(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>'); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="diaslab_<?=$datos_actividad[0]->da_iddato?>_def" name="diaslab_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_diaslaborables?>" />
            
        </div>
        
        <div class="linea">
            <label class="ancho faq">N&ordm; horas presencia:</label>
            <input type="text" id="horaspresencia_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right<?=$datos_actividad[0]->da_tipopresencia==1?'; background-color:#ffd7b4':''?>" name="horaspresencia_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_horaspresencia?>" onkeyup="comprueba_num(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>'); comprueba_cambios('edita_datosactividad')"<?=$datos_actividad[0]->da_tipopresencia==1?' readonly="readonly"':''?>>
            <input type="hidden" id="horaspresencia_<?=$datos_actividad[0]->da_iddato?>_def" name="horaspresencia_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_horaspresencia?>" />
        </div>
        
        <div class="linea">
                <span class="tit_mes oswald_l" style="width:auto; margin-left:120px;">Indicar presencia por empleado</span>
                <input type="checkbox" name="presenciaxemp" id="presenciaxemp" style="float:left; margin-top:9px" value="1"<?=$datos_actividad[0]->da_tipopresencia==1?' checked="checked"':''?> onclick="muestra_empleados('<?=$datos_actividad[0]->da_iddato?>')" />
            </div>
        
        <div id="empleados" style="float:left; border:1px solid #333<?=$datos_actividad[0]->da_tipopresencia==1?'':'; display:none'?>">
            
        <!--PARA CADA EMPLEADO DIRECTO-->
        <?php foreach($empleados_directos as $empleado_directo){
            $presencia_empleado0=dame_presencia($datos_actividad[0]->da_iddato, $empleado_directo->pt_idpersonal);
            $jornada_emp=dame_jornadas(1, $empleado_directo->pt_idpersonal);?>
        <div class="linea">
            <span class="tit_mes oswald_l" style="width:auto; margin-left:120px;">Datos de: <span class="texto_r"><?=u8d_($empleado_directo->pt_nombre)?></span></span>
            <input type="hidden" name="jornada_<?=$empleado_directo->pt_idpersonal?>" id="jornada_<?=$empleado_directo->pt_idpersonal?>" value="<?=$jornada_emp[2]?>" />
            <input type="checkbox" class="pres_emp orig" name="activaemp_<?=$empleado_directo->pt_idpersonal?>" id="activaemp_<?=$empleado_directo->pt_idpersonal?>" style="float:left; margin-top:9px" value="<?=$empleado_directo->pt_idpersonal?>"<?=$presencia_empleado0!=''?' checked="checked"':''?> onclick="muestra_datosemp(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>'); comprueba_cambios('edita_datosactividad')" />
            <span class="tit_mes ubuntu fs_12" style="width:auto; margin-left:5px; margin-top:2px">(<?=$jornada_emp[0]?> h. al <?=$jornada_emp[1]?>%)</span>
            <input type="hidden" name="activaemp_<?=$empleado_directo->pt_idpersonal?>_def" id="activaemp_<?=$empleado_directo->pt_idpersonal?>_def" value="<?=$presencia_empleado0!=''?$empleado_directo->pt_idpersonal:'0'?>" />
        </div>
        <div id="empleado_<?=$empleado_directo->pt_idpersonal?>"<?=$presencia_empleado0!=''?'':' style="display:none"'?>>
            <div class="linea">
                <label class="ancho">Horas extras pagadas:</label>
                <input type="text" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_extraspagadas']?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
                <input type="hidden" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_extraspagadas']?>" />
            </div>
            <div class="linea">
                <label class="ancho">D&iacute;as de vacaciones:</label>
                <input type="text" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasvacaciones']?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
                <input type="hidden" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasvacaciones']?>" />
            </div>
            <div class="linea">
                <label class="ancho">D&iacute;as de baja:</label>
                <input type="text" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasbaja']?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
                <input type="hidden" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasbaja']?>" />
            </div>
            <div class="linea">
                <label class="ancho">Horas de permiso:</label>
                <input type="text" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diaspermiso']?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
                <input type="hidden" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diaspermiso']?>" />
            </div>
            <div class="linea">
                <label class="ancho">D&iacute;as de formaci&oacute;n:</label>
                <input type="text" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasformacion']?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
                <input type="hidden" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasformacion']?>" />
            </div>
        </div>
        <?php }?>
            <!--PARA CADA EMPLEADO DIRECTO-->
        </div>
        
        <div class="linea">
            <span class="tit_mes oswald_l" style="width:auto; margin-left:175px;">Datos econ&oacute;micos</span>
        </div>
        <div class="linea">
            <label class="ancho faq" title="Introducir el importe de facturación de la mano de obra">Importe facturado de MO:</label>
            <input type="text" id="facturadomo_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="facturadomo_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_facturadomo?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad'); datos_presencia('<?=$datos_actividad[0]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadomo_<?=$datos_actividad[0]->da_iddato?>_def" name="facturadomo_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_facturadomo?>" />
        </div>
        <div class="linea">
            <label class="ancho faq" title="Introducir el importe de facturación del recambio (piezas y pintura)">Importe facturado de REC:</label>
            <input type="text" id="facturadorec_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="facturadorec_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_facturadorec?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadorec_<?=$datos_actividad[0]->da_iddato?>_def" name="facturadorec_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_facturadorec?>" />
        </div>
        <div class="linea">
            <label class="ancho faq" title="Importe facturados como material limpieza o gestión residuos">Importe varios facturado:</label>
            <input type="text" id="facturadootros_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="facturadootros_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_facturadootros?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadootros_<?=$datos_actividad[0]->da_iddato?>_def" name="facturadootros_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_facturadootros?>" />
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>Total importes facturados:</strong></label>
            <input type="text" id="facturado_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="facturado_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_facturadomo+$datos_actividad[0]->da_facturadorec+$datos_actividad[0]->da_facturadootros,2)?>" disabled="disabled">
        </div>
		<?php if(1==0){?>
        <div class="linea">
            <label class="ancho">Importe cobrado de MO:</label>
            <input type="text" id="cobradomo_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="cobradomo_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_cobradomo?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradomo_<?=$datos_actividad[0]->da_iddato?>_def" name="cobradomo_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_cobradomo?>" />
        </div>
        <div class="linea">
            <label class="ancho">Importe cobrado de REC:</label>
            <input type="text" id="cobradorec_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="cobradorec_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_cobradorec?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradorec_<?=$datos_actividad[0]->da_iddato?>_def" name="cobradorec_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_cobradorec?>" />
        </div>
        <div class="linea">
            <label class="ancho">Importe varios cobrado:</label>
            <input type="text" id="cobradootros_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="cobradootros_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_cobradootros?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradootros_<?=$datos_actividad[0]->da_iddato?>_def" name="cobradootros_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_cobradootros?>" />
        </div>
        <div class="linea">
            <label class="ancho"><strong>Total importes cobrados:</strong></label>
            <input type="text" id="cobrado_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="cobrado_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_cobradomo+$datos_actividad[0]->da_cobradorec+$datos_actividad[0]->da_cobradootros,2)?>" disabled="disabled">
        </div>
        <?php }?>
        <div class="linea">
            <label class="ancho doslineas faq" title="Anotar el importe de los albaranes o facturas de proveedores de piezas de recambios / pintura del mes">Importe pagado proveedores REC:</label>
            <input type="text" id="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_pagadoprovrec?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>_def" name="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_pagadoprovrec?>" />
        </div>
        <div class="linea">
            <label class="ancho doslineas faq" title="Indicar cifra de importes pagados a proveedores de taller (protecciones, pequeño material, consumibles…)">Importe pagado otros proveedores:</label>
            <input type="text" id="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_pagadoprovotros?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>_def" name="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_pagadoprovotros?>" />
        </div>
        <div class="linea">
            <label class="ancho faq" title="Nóminas + Seguridad Social">Coste de personal:</label>
            <input type="text" id="costepersonal_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="costepersonal_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_costepersonal?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="costepersonal_<?=$datos_actividad[0]->da_iddato?>_def" name="costepersonal_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_costepersonal?>" />
        </div>
        <div class="linea">
            <label class="ancho faq" title="Anotar gastos de alquiler, seguros, acreedores de servicio, suministros, etc…">Coste estructura:</label>
            <input type="text" id="costeestructura_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="costeestructura_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_costeestructura?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="costeestructura_<?=$datos_actividad[0]->da_iddato?>_def" name="costeestructura_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_costeestructura?>" />
        </div>
        
        <div class="linea">
            <span class="tit_mes oswald_l" style="width:auto; margin-left:175px;">Ratios de gesti&oacute;n</span>
        </div>
        <div class="linea">
            <label class="ancho faq" title="Horas fichadas en OR de vehículos">N&ordm; horas fichadas en OR:</label>
            <input type="text" id="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_horasfichadasor?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>_def" name="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_horasfichadasor?>" />
        </div>
        <div class="linea">
            <label class="ancho faq" title="Horas asignadas en las OR (Los tiempos que se asignan según los temparios del fabricante para las reparaciones)<br>En caso de no disponer de este dato, indicar el número de horas fichadas en OR.">N&ordm; horas asignadas:</label>
            <input type="text" id="horasasignadas_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="horasasignadas_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_horasasignadas?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="horasasignadas_<?=$datos_actividad[0]->da_iddato?>_def" name="horasasignadas_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_horasasignadas?>" />
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>N&ordm; horas facturadas:</strong></label>
            <input type="text" id="horasfac_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right;" name="horasfac_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=moneda_punto($datos_actividad[0]->da_horasfac,2)?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="horasfac_<?=$datos_actividad[0]->da_iddato?>_def" name="horasfac_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_horasfac?>" />
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>Horas perdidas:</strong></label>
            <input type="text" id="horasimproductivas_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="horasimproductivas_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasimproductivas,2)?>" readonly="readonly">
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>Importe no facturado:</strong></label>
            <input type="text" id="nofacturado_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="nofacturado_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_nofacturado,2)?>" readonly="readonly">
        </div>
        
        <div class="linea">
            <label class="ancho faq" title="Número de órdenes de repación abiertas en el mes">Entradas al taller:</label>
            <input type="text" id="entradastaller_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="entradastaller_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_entradastaller?>" onkeyup="comprueba_num(this.id); comprueba_cambios('edita_datosactividad')">
            <input type="hidden" id="entradastaller_<?=$datos_actividad[0]->da_iddato?>_def" name="entradastaller_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_entradastaller?>" />
        </div>
    </form>
    <?php }?>
</div>
<?php unset($_SESSION['datos_'._ID_PAG_]['edita_datosactividad']);?>