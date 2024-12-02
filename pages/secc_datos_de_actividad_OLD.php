<?php 
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
$empleados_directos=dame_empleados(1);

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
        <input type="hidden" id="iddatoact" name="iddatoact" value="<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>" />
        <input type="hidden" id="empleados_dir" name="empleados_dir" value="<?=count($empleados_directos)?>" />
        
        <input type="hidden" id="importemo_<?=$datos_actividad[0]->da_iddato?>" name="importemo_<?=$datos_actividad[0]->da_iddato?>" value="<?=$datos_actividad[0]->da_impmo==0.00?$imp_mo:$datos_actividad[0]->da_impmo?>" />
        <input type="hidden" id="importemo_<?=$datos_actividad[1]->da_iddato?>" name="importemo_<?=$datos_actividad[1]->da_iddato?>" value="<?=$datos_actividad[1]->da_impmo==0.00?$imp_mo:$datos_actividad[1]->da_impmo?>" />
        <input type="hidden" id="importemo_<?=$datos_actividad[2]->da_iddato?>" name="importemo_<?=$datos_actividad[2]->da_iddato?>" value="<?=$datos_actividad[2]->da_impmo==0.00?$imp_mo:$datos_actividad[2]->da_impmo?>" />
        <div class="linea">
            <span class="tit_mes" style="margin-left:180px;"><strong>Mes 1</strong></span>
            <span class="tit_mes"><strong>Mes 2</strong></span>
            <span class="tit_mes"><strong>Mes 3</strong></span>
            <span class="tit_mes"><strong>Total 3 meses</strong></span>
        </div>
        <div class="linea">
            <label class="ancho">N&ordm; de d&iacute;as laborables:</label>
            <input type="text" id="diaslab_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diaslab_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_diaslaborables?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('0', 'diaslab_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="diaslab_<?=$datos_actividad[0]->da_iddato?>_def" name="diaslab_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_diaslaborables?>" />
            
            
            <input type="text" id="diaslab_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="diaslab_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_diaslaborables?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('0', 'diaslab_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="diaslab_<?=$datos_actividad[1]->da_iddato?>_def" name="diaslab_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_diaslaborables?>" />
            <input type="text" id="diaslab_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="diaslab_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_diaslaborables?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('0', 'diaslab_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="diaslab_<?=$datos_actividad[2]->da_iddato?>_def" name="diaslab_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_diaslaborables?>" />
            <input type="text" id="diaslab_total" style="text-align:right; margin-left:15px" name="diaslab_total" class="peq" value="<?=$datos_actividad[0]->da_diaslaborables+$datos_actividad[1]->da_diaslaborables+$datos_actividad[2]->da_diaslaborables?>" disabled="disabled">
            <input type="submit" style="display:none" id="edita_datoactividad" name="edita_datoactividad" value="Guardar" />
        </div>
        
        <!--PARA CADA EMPLEADO DIRECTO-->
        <?php foreach($empleados_directos as $empleado_directo){
            $presencia_empleado0=dame_presencia($datos_actividad[0]->da_iddato, $empleado_directo->pt_idpersonal);
            $presencia_empleado1=dame_presencia($datos_actividad[1]->da_iddato, $empleado_directo->pt_idpersonal);
            $presencia_empleado2=dame_presencia($datos_actividad[2]->da_iddato, $empleado_directo->pt_idpersonal);
            $jornada_emp=dame_jornadas(1, $empleado_directo->pt_idpersonal);?>
        <div class="linea">
            <span class="tit_mes oswald_l" style="width:auto; margin-left:120px;">Datos de: <span class="texto_r"><?=u8d_($empleado_directo->pt_nombre)?></span></span>
            <input type="hidden" name="jornada_<?=$empleado_directo->pt_idpersonal?>" id="jornada_<?=$empleado_directo->pt_idpersonal?>" value="<?=$jornada_emp[2]?>" />
            <input type="checkbox" class="pres_emp orig" name="activaemp_<?=$empleado_directo->pt_idpersonal?>" id="activaemp_<?=$empleado_directo->pt_idpersonal?>" style="float:left; margin-top:9px" value="<?=$empleado_directo->pt_idpersonal?>"<?=$presencia_empleado0!=''||$presencia_empleado1!=''||$presencia_empleado1!=''?' checked="checked"':''?> onclick="muestra_datosemp(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); comprueba_cambios('edita_datosactividad')" />
            <span class="tit_mes ubuntu fs_12" style="width:auto; margin-left:5px; margin-top:2px">(<?=$jornada_emp[0]?> h. al <?=$jornada_emp[1]?>%)</span>
            <input type="hidden" name="activaemp_<?=$empleado_directo->pt_idpersonal?>_def" id="activaemp_<?=$empleado_directo->pt_idpersonal?>_def" value="<?=$presencia_empleado0!=''||$presencia_empleado1!=''||$presencia_empleado1!=''?$empleado_directo->pt_idpersonal:'0'?>" />
        </div>
        <div id="empleado_<?=$empleado_directo->pt_idpersonal?>"<?=$presencia_empleado0!=''||$presencia_empleado1!=''||$presencia_empleado1!=''?'':' style="display:none"'?>>
            <div class="linea">
                <label class="ancho">Horas extras pagadas:</label>
                <input type="text" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_extraspagadas']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'extraspagadas_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_extraspagadas']?>" />
                
                <input type="text" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_extraspagadas']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'extraspagadas_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_extraspagadas']?>" />
                
                <input type="text" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_extraspagadas']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'extraspagadas_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_extraspagadas']?>" />
                
                <input type="text" id="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_total" style="text-align:right; margin-left:15px" name="extraspagadas_<?=$empleado_directo->pt_idpersonal?>_total" class="peq" value="<?=$presencia_empleado0['pp_extraspagadas']+$presencia_empleado1['pp_extraspagadas']+$presencia_empleado2['pp_extraspagadas']?>" disabled="disabled">
            </div>
            <div class="linea">
                <label class="ancho">D&iacute;as de vacaciones:</label>
                <input type="text" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasvacaciones']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasvacaciones']?>" />
                
                <input type="text" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diasvacaciones']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diasvacaciones']?>" />
                
                <input type="text" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diasvacaciones']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diasvacaciones']?>" />
                
                <input type="text" id="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_total" style="text-align:right; margin-left:15px" name="diasvacaciones_<?=$empleado_directo->pt_idpersonal?>_total" class="peq" value="<?=$presencia_empleado0['pp_diasvacaciones']+$presencia_empleado1['pp_diasvacaciones']+$presencia_empleado2['pp_diasvacaciones']?>" disabled="disabled">
            </div>
            <div class="linea">
                <label class="ancho">D&iacute;as de baja:</label>
                <input type="text" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasbaja']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasbaja_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasbaja']?>" />
                
                <input type="text" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diasbaja']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasbaja_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diasbaja']?>" />
                
                <input type="text" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diasbaja']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasbaja_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diasbaja']?>" />
                <input type="text" id="diasbaja_<?=$empleado_directo->pt_idpersonal?>_total" style="text-align:right; margin-left:15px" name="diasbaja_<?=$empleado_directo->pt_idpersonal?>_total" class="peq" value="<?=$presencia_empleado0['pp_diasbaja']+$presencia_empleado1['pp_diasbaja']+$presencia_empleado2['pp_diasbaja']?>" disabled="disabled">
            </div>
            <div class="linea">
                <label class="ancho">Horas de permiso:</label>
                <input type="text" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diaspermiso']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diaspermiso_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diaspermiso']?>" />
                
                <input type="text" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diaspermiso']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diaspermiso_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diaspermiso']?>" />
                
                <input type="text" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diaspermiso']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diaspermiso_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diaspermiso']?>" />
                <input type="text" id="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_total" style="text-align:right; margin-left:15px" name="diaspermiso_<?=$empleado_directo->pt_idpersonal?>_total" class="peq" value="<?=$presencia_empleado0['pp_diaspermiso']+$presencia_empleado1['pp_diaspermiso']+$presencia_empleado2['pp_diaspermiso']?>" disabled="disabled">
            </div>
            <div class="linea">
                <label class="ancho">D&iacute;as de formaci&oacute;n:</label>
                <input type="text" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasformacion']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasformacion_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$presencia_empleado0==''?'0.00':$presencia_empleado0['pp_diasformacion']?>" />
                
                <input type="text" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diasformacion']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasformacion_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$presencia_empleado1==''?'0.00':$presencia_empleado1['pp_diasformacion']?>" />
                
                <input type="text" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diasformacion']?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'diasformacion_<?=$empleado_directo->pt_idpersonal?>_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
                <input type="hidden" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$presencia_empleado2==''?'0.00':$presencia_empleado2['pp_diasformacion']?>" />
                <input type="text" id="diasformacion_<?=$empleado_directo->pt_idpersonal?>_total" style="text-align:right; margin-left:15px" name="diasformacion_<?=$empleado_directo->pt_idpersonal?>_total" class="peq" value="<?=$presencia_empleado0['pp_diasformacion']+$presencia_empleado1['pp_diasformacion']+$presencia_empleado2['pp_diasformacion']?>" disabled="disabled">
            </div>
        </div>
        <?php }?>
            <!--PARA CADA EMPLEADO DIRECTO-->
            
        <div class="linea">
            <span class="tit_mes oswald_l" style="width:auto; margin-left:175px;">Datos econ&oacute;micos</span>
        </div>
        <div class="linea">
            <label class="ancho faq" title="Introducir el importe de facturación de la mano de obra">Importe facturado de MO:</label>
            <input type="text" id="facturadomo_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="facturadomo_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_facturadomo?>" onkeyup="comprueba_num(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumalinea_datosact('2', 'facturadomo_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadomo_<?=$datos_actividad[0]->da_iddato?>_def" name="facturadomo_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_facturadomo?>" />
            <input type="text" id="facturadomo_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="facturadomo_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_facturadomo?>" onkeyup="comprueba_num(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumalinea_datosact('2', 'facturadomo_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')"; sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')>
            <input type="hidden" id="facturadomo_<?=$datos_actividad[1]->da_iddato?>_def" name="facturadomo_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_facturadomo?>" />
            <input type="text" id="facturadomo_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="facturadomo_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_facturadomo?>" onkeyup="comprueba_num(this.id); datos_presencia('<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumalinea_datosact('2', 'facturadomo_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')"; sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')>
            <input type="hidden" id="facturadomo_<?=$datos_actividad[2]->da_iddato?>_def" name="facturadomo_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_facturadomo?>" />
            <input type="text" id="facturadomo_total" style="text-align:right; margin-left:15px" name="facturadomo_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_facturadomo+$datos_actividad[1]->da_facturadomo+$datos_actividad[2]->da_facturadomo,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho faq" title="Introducir el importe de facturación del recambio (piezas y pintura)">Importe facturado de REC:</label>
            <input type="text" id="facturadorec_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="facturadorec_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_facturadorec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'facturadorec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadorec_<?=$datos_actividad[0]->da_iddato?>_def" name="facturadorec_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_facturadorec?>" />
            <input type="text" id="facturadorec_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="facturadorec_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_facturadorec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'facturadorec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadorec_<?=$datos_actividad[1]->da_iddato?>_def" name="facturadorec_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_facturadorec?>" />
            <input type="text" id="facturadorec_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="facturadorec_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_facturadorec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'facturadorec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadorec_<?=$datos_actividad[2]->da_iddato?>_def" name="facturadorec_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_facturadorec?>" />
            <input type="text" id="facturadorec_total" style="text-align:right; margin-left:15px" name="facturadorec_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_facturadorec+$datos_actividad[1]->da_facturadorec+$datos_actividad[2]->da_facturadorec,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho faq" title="Importe facturados como material limpieza o gestión residuos">Importe varios facturado:</label>
            <input type="text" id="facturadootros_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="facturadootros_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_facturadootros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'facturadootros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadootros_<?=$datos_actividad[0]->da_iddato?>_def" name="facturadootros_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_facturadootros?>" />
            <input type="text" id="facturadootros_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="facturadootros_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_facturadootros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'facturadootros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadootros_<?=$datos_actividad[1]->da_iddato?>_def" name="facturadootros_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_facturadootros?>" />
            <input type="text" id="facturadootros_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="facturadootros_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_facturadootros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'facturadootros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('facturado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="facturadootros_<?=$datos_actividad[2]->da_iddato?>_def" name="facturadootros_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_facturadootros?>" />
            <input type="text" id="facturadootros_total" style="text-align:right; margin-left:15px" name="facturadootros_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_facturadootros+$datos_actividad[1]->da_facturadootros+$datos_actividad[2]->da_facturadootros,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>Total importes facturados:</strong></label>
            <input type="text" id="facturado_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="facturado_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_facturadomo+$datos_actividad[0]->da_facturadorec+$datos_actividad[0]->da_facturadootros,2)?>" disabled="disabled">
            <input type="text" id="facturado_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="facturado_<?=$datos_actividad[1]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[1]->da_facturadomo+$datos_actividad[1]->da_facturadorec+$datos_actividad[1]->da_facturadootros,2)?>" disabled="disabled">
            <input type="text" id="facturado_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="facturado_<?=$datos_actividad[2]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[2]->da_facturadomo+$datos_actividad[2]->da_facturadorec+$datos_actividad[2]->da_facturadootros,2)?>" disabled="disabled">
            <input type="text" id="facturado_total" style="text-align:right; margin-left:15px" name="facturado_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_facturadomo+$datos_actividad[0]->da_facturadorec+$datos_actividad[0]->da_facturadootros+$datos_actividad[1]->da_facturadomo+$datos_actividad[1]->da_facturadorec+$datos_actividad[1]->da_facturadootros+$datos_actividad[2]->da_facturadomo+$datos_actividad[2]->da_facturadorec+$datos_actividad[2]->da_facturadootros,2)?>" disabled="disabled">
        </div>

        <div class="linea">
            <label class="ancho">Importe cobrado de MO:</label>
            <input type="text" id="cobradomo_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="cobradomo_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_cobradomo?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradomo_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradomo_<?=$datos_actividad[0]->da_iddato?>_def" name="cobradomo_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_cobradomo?>" />
            <input type="text" id="cobradomo_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="cobradomo_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_cobradomo?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradomo_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradomo_<?=$datos_actividad[1]->da_iddato?>_def" name="cobradomo_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_cobradomo?>" />
            <input type="text" id="cobradomo_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="cobradomo_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_cobradomo?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradomo_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradomo_<?=$datos_actividad[2]->da_iddato?>_def" name="cobradomo_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_cobradomo?>" />
            <input type="text" id="cobradomo_total" style="text-align:right; margin-left:15px" name="cobradomo_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_cobradomo+$datos_actividad[1]->da_cobradomo+$datos_actividad[2]->da_cobradomo,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho">Importe cobrado de REC:</label>
            <input type="text" id="cobradorec_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="cobradorec_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_cobradorec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradorec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradorec_<?=$datos_actividad[0]->da_iddato?>_def" name="cobradorec_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_cobradorec?>" />
            <input type="text" id="cobradorec_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="cobradorec_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_cobradorec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradorec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradorec_<?=$datos_actividad[1]->da_iddato?>_def" name="cobradorec_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_cobradorec?>" />
            <input type="text" id="cobradorec_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="cobradorec_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_cobradorec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradorec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradorec_<?=$datos_actividad[2]->da_iddato?>_def" name="cobradorec_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_cobradorec?>" />
            <input type="text" id="cobradorec_total" style="text-align:right; margin-left:15px" name="cobradorec_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_cobradorec+$datos_actividad[1]->da_cobradorec+$datos_actividad[2]->da_cobradorec,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho">Importe varios cobrado:</label>
            <input type="text" id="cobradootros_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="cobradootros_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_cobradootros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradootros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradootros_<?=$datos_actividad[0]->da_iddato?>_def" name="cobradootros_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_cobradootros?>" />
            <input type="text" id="cobradootros_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="cobradootros_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_cobradootros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradootros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradootros_<?=$datos_actividad[1]->da_iddato?>_def" name="cobradootros_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_cobradootros?>" />
            <input type="text" id="cobradootros_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="cobradootros_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_cobradootros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'cobradootros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>'); sumacol_datosact('cobrado_','<?=$datos_actividad[0]->da_iddato?>')">
            <input type="hidden" id="cobradootros_<?=$datos_actividad[2]->da_iddato?>_def" name="cobradootros_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_cobradootros?>" />
            <input type="text" id="cobradootros_total" style="text-align:right; margin-left:15px" name="cobradootros_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_cobradootros+$datos_actividad[1]->da_cobradootros+$datos_actividad[2]->da_cobradootros,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho"><strong>Total importes cobrados:</strong></label>
            <input type="text" id="cobrado_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="cobrado_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_cobradomo+$datos_actividad[0]->da_cobradorec+$datos_actividad[0]->da_cobradootros,2)?>" disabled="disabled">
            <input type="text" id="cobrado_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="cobrado_<?=$datos_actividad[1]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[1]->da_cobradomo+$datos_actividad[1]->da_cobradorec+$datos_actividad[1]->da_cobradootros,2)?>" disabled="disabled">
            <input type="text" id="cobrado_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="cobrado_<?=$datos_actividad[2]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[2]->da_cobradomo+$datos_actividad[2]->da_cobradorec+$datos_actividad[2]->da_cobradootros,2)?>" disabled="disabled">
            <input type="text" id="cobrado_total" style="text-align:right; margin-left:15px" name="cobrado_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_cobradomo+$datos_actividad[0]->da_cobradorec+$datos_actividad[0]->da_cobradootros+$datos_actividad[1]->da_cobradomo+$datos_actividad[1]->da_cobradorec+$datos_actividad[1]->da_cobradootros+$datos_actividad[2]->da_cobradomo+$datos_actividad[2]->da_cobradorec+$datos_actividad[2]->da_cobradootros,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <label class="ancho doslineas faq" title="Anotar el importe de los albaranes o facturas de proveedores de piezas de recambios / pintura del mes">Importe pagado proveedores REC:</label>
            <input type="text" id="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_pagadoprovrec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'pagadoprovrec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>_def" name="pagadoprovrec_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_pagadoprovrec?>" />
            <input type="text" id="pagadoprovrec_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="pagadoprovrec_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_pagadoprovrec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'pagadoprovrec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="pagadoprovrec_<?=$datos_actividad[1]->da_iddato?>_def" name="pagadoprovrec_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_pagadoprovrec?>" />
            <input type="text" id="pagadoprovrec_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="pagadoprovrec_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_pagadoprovrec?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'pagadoprovrec_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="pagadoprovrec_<?=$datos_actividad[2]->da_iddato?>_def" name="pagadoprovrec_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_pagadoprovrec?>" />
            <input type="text" id="pagadoprovrec_total" style="text-align:right; margin-left:15px" name="pagadoprovrec_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_pagadoprovrec+$datos_actividad[1]->da_pagadoprovrec+$datos_actividad[2]->da_pagadoprovrec,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho doslineas faq" title="Indicar cifra de importes pagados a proveedores de taller (protecciones, pequeño material, consumibles…)">Importe pagado otros proveedores:</label>
            <input type="text" id="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_pagadoprovotros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'pagadoprovotros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>_def" name="pagadoprovotros_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_pagadoprovotros?>" />
            <input type="text" id="pagadoprovotros_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="pagadoprovotros_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_pagadoprovotros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'pagadoprovotros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="pagadoprovotros_<?=$datos_actividad[1]->da_iddato?>_def" name="pagadoprovotros_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_pagadoprovotros?>" />
            <input type="text" id="pagadoprovotros_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="pagadoprovotros_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_pagadoprovotros?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'pagadoprovotros_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="pagadoprovotros_<?=$datos_actividad[2]->da_iddato?>_def" name="pagadoprovotros_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_pagadoprovotros?>" />
            <input type="text" id="pagadoprovotros_total" style="text-align:right; margin-left:15px" name="pagadoprovotros_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_pagadoprovotros+$datos_actividad[1]->da_pagadoprovotros+$datos_actividad[2]->da_pagadoprovotros,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho faq" title="Nóminas + Seguridad Social">Coste de personal:</label>
            <input type="text" id="costepersonal_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="costepersonal_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_costepersonal?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'costepersonal_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="costepersonal_<?=$datos_actividad[0]->da_iddato?>_def" name="costepersonal_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_costepersonal?>" />
            <input type="text" id="costepersonal_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="costepersonal_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_costepersonal?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'costepersonal_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="costepersonal_<?=$datos_actividad[1]->da_iddato?>_def" name="costepersonal_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_costepersonal?>" />
            <input type="text" id="costepersonal_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="costepersonal_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_costepersonal?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'costepersonal_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="costepersonal_<?=$datos_actividad[2]->da_iddato?>_def" name="costepersonal_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_costepersonal?>" />
            <input type="text" id="costepersonal_total" style="text-align:right; margin-left:15px" name="costepersonal_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_costepersonal+$datos_actividad[1]->da_costepersonal+$datos_actividad[2]->da_costepersonal,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho faq" title="Anotar gastos de alquiler, seguros, acreedores de servicio, suministros, etc…">Coste estructura:</label>
            <input type="text" id="costeestructura_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="costeestructura_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_costeestructura?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'costepersonal_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="costeestructura_<?=$datos_actividad[0]->da_iddato?>_def" name="costeestructura_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_costeestructura?>" />
            <input type="text" id="costeestructura_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="costeestructura_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_costeestructura?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'costepersonal_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="costeestructura_<?=$datos_actividad[1]->da_iddato?>_def" name="costeestructura_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_costeestructura?>" />
            <input type="text" id="costeestructura_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="costeestructura_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_costeestructura?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'costepersonal_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="costeestructura_<?=$datos_actividad[2]->da_iddato?>_def" name="costeestructura_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_costeestructura?>" />
            <input type="text" id="costeestructura_total" style="text-align:right; margin-left:15px" name="costeestructura_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_costeestructura+$datos_actividad[1]->da_costeestructura+$datos_actividad[2]->da_costeestructura,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <span class="tit_mes oswald_l" style="width:auto; margin-left:175px;">Ratios de gesti&oacute;n</span>
        </div>
        <div class="linea">
            <label class="ancho faq" title="Horas fichadas en OR de vehículos">N&ordm; horas fichadas en OR:</label>
            <input type="text" id="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_horasfichadasor?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'horasfichadasor_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>_def" name="horasfichadasor_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_horasfichadasor?>" />
            <input type="text" id="horasfichadasor_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="horasfichadasor_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_horasfichadasor?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'horasfichadasor_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="horasfichadasor_<?=$datos_actividad[1]->da_iddato?>_def" name="horasfichadasor_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_horasfichadasor?>" />
            <input type="text" id="horasfichadasor_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="horasfichadasor_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_horasfichadasor?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'horasfichadasor_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="horasfichadasor_<?=$datos_actividad[2]->da_iddato?>_def" name="horasfichadasor_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_horasfichadasor?>" />
            <input type="text" id="horasfichadasor_total" style="text-align:right; margin-left:15px" name="horasfichadasor_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasfichadasor+$datos_actividad[1]->da_horasfichadasor+$datos_actividad[2]->da_horasfichadasor,2)?>" disabled="disabled">
        </div>
        <div class="linea">
            <label class="ancho faq" title="Horas asignadas en las OR (Los tiempos que se asignan según los temparios del fabricante para las reparaciones)<br>En caso de no disponer de este dato, indicar el número de horas fichadas en OR.">N&ordm; horas asignadas:</label>
            <input type="text" id="horasasignadas_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="horasasignadas_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_horasasignadas?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'horasasignadas_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="horasasignadas_<?=$datos_actividad[0]->da_iddato?>_def" name="horasasignadas_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_horasasignadas?>" />
            <input type="text" id="horasasignadas_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="horasasignadas_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_horasasignadas?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'horasasignadas_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="horasasignadas_<?=$datos_actividad[1]->da_iddato?>_def" name="horasasignadas_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_horasasignadas?>" />
            <input type="text" id="horasasignadas_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="horasasignadas_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_horasasignadas?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('2', 'horasasignadas_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="horasasignadas_<?=$datos_actividad[2]->da_iddato?>_def" name="horasasignadas_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_horasasignadas?>" />
            <input type="text" id="horasasignadas_total" style="text-align:right; margin-left:15px" name="horasasignadas_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasasignadas+$datos_actividad[1]->da_horasasignadas+$datos_actividad[2]->da_horasasignadas,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>N&ordm; horas facturadas:</strong></label>
            <input type="text" id="horasfac_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="horasfac_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasfac,2)?>" readonly="readonly">
            <input type="text" id="horasfac_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="horasfac_<?=$datos_actividad[1]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[1]->da_horasfac,2)?>" readonly="readonly">
            <input type="text" id="horasfac_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="horasfac_<?=$datos_actividad[2]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[2]->da_horasfac,2)?>" readonly="readonly">
            <input type="text" id="horasfac_total" style="text-align:right; margin-left:15px" name="horasfac_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasfac+$datos_actividad[1]->da_horasfac+$datos_actividad[2]->da_horasfac,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>Horas perdidas:</strong></label>
            <input type="text" id="horasimproductivas_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="horasimproductivas_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasimproductivas,2)?>" readonly="readonly">
            <input type="text" id="horasimproductivas_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="horasimproductivas_<?=$datos_actividad[1]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[1]->da_horasimproductivas,2)?>" readonly="readonly">
            <input type="text" id="horasimproductivas_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="horasimproductivas_<?=$datos_actividad[2]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[2]->da_horasimproductivas,2)?>" readonly="readonly">
            <input type="text" id="horasimproductivas_total" style="text-align:right; margin-left:15px" name="horasimproductivas_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_horasimproductivas+$datos_actividad[1]->da_horasimproductivas+$datos_actividad[2]->da_horasimproductivas,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <label class="ancho"><strong>Importe no facturado:</strong></label>
            <input type="text" id="nofacturado_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right; background-color:#ffd7b4" name="nofacturado_<?=$datos_actividad[0]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_nofacturado,2)?>" readonly="readonly">
            <input type="text" id="nofacturado_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="nofacturado_<?=$datos_actividad[1]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[1]->da_nofacturado,2)?>" readonly="readonly">
            <input type="text" id="nofacturado_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px; background-color:#ffd7b4" name="nofacturado_<?=$datos_actividad[2]->da_iddato?>" class="peq" value="<?=moneda_punto($datos_actividad[2]->da_nofacturado,2)?>" readonly="readonly">
            <input type="text" id="nofacturado_total" style="text-align:right; margin-left:15px" name="nofacturado_total" class="peq" value="<?=moneda_punto($datos_actividad[0]->da_nofacturado+$datos_actividad[1]->da_nofacturado+$datos_actividad[2]->da_nofacturado,2)?>" disabled="disabled">
        </div>
        
        <div class="linea">
            <label class="ancho faq" title="Número de órdenes de repación abiertas en el mes">Entradas al taller:</label>
            <input type="text" id="entradastaller_<?=$datos_actividad[0]->da_iddato?>" style="text-align:right" name="entradastaller_<?=$datos_actividad[0]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[0]->da_entradastaller?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('0', 'entradastaller_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="entradastaller_<?=$datos_actividad[0]->da_iddato?>_def" name="entradastaller_<?=$datos_actividad[0]->da_iddato?>_def" value="<?=$datos_actividad[0]->da_entradastaller?>" />
            <input type="text" id="entradastaller_<?=$datos_actividad[1]->da_iddato?>" style="text-align:right; margin-left:15px" name="entradastaller_<?=$datos_actividad[1]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[1]->da_entradastaller?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('0', 'entradastaller_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="entradastaller_<?=$datos_actividad[1]->da_iddato?>_def" name="entradastaller_<?=$datos_actividad[1]->da_iddato?>_def" value="<?=$datos_actividad[1]->da_entradastaller?>" />
            <input type="text" id="entradastaller_<?=$datos_actividad[2]->da_iddato?>" style="text-align:right; margin-left:15px" name="entradastaller_<?=$datos_actividad[2]->da_iddato?>" class="peq orig" value="<?=$datos_actividad[2]->da_entradastaller?>" onkeyup="comprueba_num(this.id); sumalinea_datosact('0', 'entradastaller_','<?=$datos_actividad[0]->da_iddato?>,<?=$datos_actividad[1]->da_iddato?>,<?=$datos_actividad[2]->da_iddato?>')">
            <input type="hidden" id="entradastaller_<?=$datos_actividad[2]->da_iddato?>_def" name="entradastaller_<?=$datos_actividad[2]->da_iddato?>_def" value="<?=$datos_actividad[2]->da_entradastaller?>" />
            <input type="text" id="entradastaller_total" style="text-align:right; margin-left:15px" name="entradastaller_total" class="peq" value="<?=$datos_actividad[0]->da_entradastaller+$datos_actividad[1]->da_entradastaller+$datos_actividad[2]->da_entradastaller?>" disabled="disabled">
        </div>
    </form>
    <?php }?>
</div>
<?php unset($_SESSION['datos_'._ID_PAG_]['edita_datosactividad']);?>