<?php
!isset($idtaller)?$idtaller=$contenido_de[2]:false;
!isset($idmes)?$idmes=$contenido_de[3]:false;;
!isset($idano)?$idano=$contenido_de[4]:false;;

if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.'')==0||num_rows('select da_iddato from datos_actividad where da_idtaller='.$idtaller.' and da_mes="'.$idmes.'" and da_ano="'.$idano.'"')==0){
	exit('Datos incorrectos');
}

$datos=fetch_array('select * from datos_actividad where da_idtaller='.$idtaller.' and da_mes="'.$idmes.'" and da_ano="'.$idano.'"');

$hpresencia=horas_presencia($datos['da_iddato']);
$hfacturadas=$datos['da_facturadomo']/$datos['da_impmo'];

$productividad=porcentaje_($datos['da_horasfichadasor'],$hpresencia);
$eficacia=porcentaje_($hfacturadas,$hpresencia);
$rendimiento=porcentaje_($hfacturadas,$datos['da_horasfichadasor']);

$ventapr=$datos['da_facturadorec']+$datos['da_facturadootros'];
$costepr=$datos['da_pagadoprovrec']+$datos['da_pagadoprovotros'];
$porcentpr=number_format(margen_sobre_coste($costepr,$ventapr),2);
$ventasobj=$costepr+($costepr*$datos['da_objmargenrec']/100);

$horaspotenciales=$hpresencia*$datos['da_objeficacia']/100;
$coste_hora=$horaspotenciales==0?0:($datos['da_costeestructura']+$datos['da_costepersonal'])/$horaspotenciales;

$nombre_archivo='Informe_mensual_'.$idtaller.'_'.nom_mes($datos['da_mes']).'_'.$datos['da_ano'];
?>
<style>

*{
	color:#555;
}
td {
   padding:0; margin:0;
}
tr {
   padding:0; margin:0;
}
</style>
<page backtop="55mm" backbottom="10mm" backleft="0mm" backright="0mm" style="font-family:Arial; font-size:14px">

    <page_header>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
            	<td width="520" valign="top">
                	<img src="<?=_PATH_?>imagenes/assistec_pdf.png" style="margin-top:25px" />
                </td>
                <td width="200" valign="bottom">
                	<div style="line-height:120%; padding:60px 0px 0px 40px; float:right; border-left:1px solid #F00">
                        C/ Sant Jaume, 134<br />
                        08150 Parets del Vallès<br />
                        BARCELONA<br /><br />
                        <strong><span style="color:#F00">T/</span></strong> 628 478 051<br />
                        <strong><span style="color:#F00">E/</span></strong> mbaez@assistec.es<br />
                        <strong><span style="color:#F00">www.assistec.es</span></strong><br />
                    </div>
                </td>
            </tr>
        </table>
    </page_header>
    
    <page_footer>
    	<table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
            	<td width="720" align="right">
                	[[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>












    
	<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="90">
                <div style="padding:3px 10px;">
                    <i><strong>Taller:</strong></i>
                </div>
            </td>
            <td colspan="2" width="508" valign="bottom">
                <div style="padding:3px 10px;">
                    <strong><?=strtoupper(u8d_(dato_taller('ta_nombre',$datos['da_idtaller'])))?></strong>
                </div>
            </td>
        </tr>
        <tr>
            <td width="90">
                <div style="padding:3px 10px; border-top:1px solid #333">
                    <i>Fecha:</i>
                </div>
            </td>
            <td width="150" valign="bottom">
                <div style="padding:3px 10px; background-color:#CCC; border:1px solid #333">
                    <?=nom_mes($datos['da_mes'])?> <?=$datos['da_ano']?>
                </div>
            </td>
            <td width="358">
            </td>
        </tr>
    </table>
    <br /><br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="38" align="right">
            	<img src="<?=_PATH_?>imagenes/index.png" />
            </td>
            <td width="562">
                <div style="padding:3px 20px;">
                    <strong>RATIOS DE TALLER:</strong>
                </div>
            </td>
        </tr>
    </table>
    <br /><br />
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="199">
            	<div style="padding:3px 5px;">
                    <strong><i><span style="color:#888">Indicador</span></i></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center">
                    <strong><span style="color:#888">Objetivo</span></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center">
                    <strong><span style="color:#888">Real</span></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center">
                    <strong><span style="color:#888">Desviación</span></strong>
                </div>
            </td>
        </tr>
        <!--<tr>
            <td width="199">
            	<div style="padding:3px 5px; border-top:1px solid #ccc">
                    <strong><i><span style="color:#888">Productividad</span></i></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc; background-color:#EEE">
                    <span style="color:#888"><?/*=number_format($datos['da_objproductividad'],0)*/?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc; background-color:#EEE">
                    <span style="color:#888"><?/*=number_format($productividad,0)*/?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc; background-color:#EEE">
                    <span style="color:#FF5353"><?/*=number_format($datos['da_objproductividad']-$productividad,0)*/?>%</span>
                </div>
            </td>
        </tr>-->
        <tr>
            <td width="199">
            	<div style="padding:3px 5px; border-top:1px solid #ccc">
                    <strong><i><span style="color:#888">Eficacia</span></i></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#888"><?=number_format($datos['da_objeficacia'],0)?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#888"><?=number_format($eficacia,0)?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#FF5353"><?=number_format($datos['da_objeficacia']-$eficacia,0)?>%</span>
                </div>
            </td>
        </tr>
        <!--<tr>
            <td width="199">
            	<div style="padding:3px 5px; border-top:1px solid #ccc">
                    <strong><i><span style="color:#888">Rendimiento</span></i></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc; background-color:#EEE">
                    <span style="color:#888"><?/*=number_format($datos['da_objrendimiento'],0)*/?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc; background-color:#EEE">
                    <span style="color:#888"><?/*=number_format($rendimiento,0)*/?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc; background-color:#EEE">
                    <span style="color:#FF5353"><?/*=number_format($datos['da_objrendimiento']-$rendimiento,0)*/?>%</span>
                </div>
            </td>
        </tr>-->
        <tr>
            <td width="199">
            	<div style="padding:3px 5px; border-top:1px solid #ccc">
                    <strong><i><span style="color:#888">Margen venta piezas</span></i></strong>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#888"><?=number_format($datos['da_objmargenrec'],0)?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#888"><?=number_format($porcentpr,0)?>%</span>
                </div>
            </td>
            <td width="98">
            	<div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#FF5353"><?=number_format($datos['da_objmargenrec']-$porcentpr,0)?>%</span>
                </div>
            </td>
        </tr>
    </table>

    <br /><br />
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="199">

            </td>
            <td width="98">
                <div style="padding:3px 5px; text-align:center">
                    <strong><span style="color:#888">PVP</span></strong>
                </div>
            </td>
            <td width="98">
                <div style="padding:3px 5px; text-align:center">
                    <strong><span style="color:#888">Real</span></strong>
                </div>
            </td>
            <td width="98">
        </tr>
        <tr>
            <td width="199">
                <div style="padding:3px 5px; border-top:1px solid #ccc">
                    <strong><i><span style="color:#888">Coste Hora</span></i></strong>
                </div>
            </td>
            <td width="98">
                <div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#888"><?=number_format($datos['da_objmargenrec'],0)?>%</span>
                </div>
            </td>
            <td width="98">
                <div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#888"><?=number_format($porcentpr,0)?>%</span>
                </div>
            </td>
            <td width="98">
                <div style="padding:3px 5px; text-align:center; border:1px solid #ccc;">
                    <span style="color:#FF5353"><?=number_format($datos['da_objmargenrec']-$porcentpr,0)?>%</span>
                </div>
            </td>
        </tr>
    </table>
    <br /><br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="38" align="right">
            	<img src="<?=_PATH_?>imagenes/index.png" />
            </td>
            <td width="562">
                <div style="padding:3px 20px;">
                    <strong>AREAS DE MEJORA:</strong>
                </div>
            </td>
        </tr>
    </table>
    <br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="600">
                <div style="padding:3px 20px;">
                    <strong>Productividad</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td width="600">
            </td>
        </tr>
        <tr>
            <td width="600">
                <div style="padding:3px 20px; line-height:140%">
                    La productividad se mide de las horas fichadas en OR de clientes entre las horas de presencia, es un indicador de la actividad del taller, que comparándola con el rendimiento nos facilita información de su capacidad para absorber mayor número de vehículos.
                </div>
                <div style="padding:3px 20px; line-height:140%">
                    Si su productividad se encuentra un 5% del ratio óptimo, las consecuencias pueden estar derivadas:
                    <ul>
                    <li>Una no correcta planificación de las citas</li>
                    <li>Reparto de la carga de taller no acorde a las cualidades de sus técnicos</li>
                    <li>No disponer de un plan de marketing</li>
                    <li>Falta de acuerdos con Aseguradoras / Renting</li>
                    <li>Retraso en las entregas de vehículos finalizados</li>
                    <li>Rotación alta de vehículos – tiempo de inmovilizado prolongado</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>
</page>

<page backtop="55mm" backbottom="10mm" backleft="0mm" backright="0mm" style="font-family:Arial; font-size:14px">

    <page_header>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="520" valign="top">
                    <img src="<?=_PATH_?>imagenes/assistec.png" width="150" />
                </td>
                <td width="200" valign="bottom">
                    <div style="line-height:120%; padding:60px 0px 0px 40px; float:right; border-left:1px solid #F00">
                        C/ Sant Jaume, 134<br />
                        08150 Parets del Vallès<br />
                        BARCELONA<br /><br />
                        <strong><span style="color:#F00">T/</span></strong> 628 478 051<br />
                        <strong><span style="color:#F00">E/</span></strong> mbaez@assistec.es<br />
                        <strong><span style="color:#F00">www.assistec.es</span></strong><br />
                    </div>
                </td>
            </tr>
        </table>
    </page_header>

    <page_footer>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="720" align="right">
                    [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="600">
                <div style="padding:3px 20px;">
                    <strong>Eficacia</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td width="600">
            </td>
        </tr>
        <tr>
            <td width="600">
                <div style="padding:3px 20px; line-height:140%">
                    La Eficacia se mide de las horas facturadas entre las horas de presencia.
                </div>
            </td>
        </tr>
    </table>
    <br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="300">
                <div style="width:300px;">
                    <img src="<?=_PATH_?>archivos/tmp/efectividad_<?=$idtaller?>_<?=$idmes?>_<?=$idano?>.png">
                </div>
            </td>
            <td width="300">
                <div style="padding:25px; width:250px; line-height:120%">
                    <i>Su taller en el mes de <?=nom_mes($datos['da_mes'])?> tenía una capacidad para facturar <strong><?=number_format($hpresencia,0)?> horas</strong>. Estas son las horas productivas de sus operarios por los días hábiles.<br /><br /><span style="color:#FF0000">Por tanto <strong style="color:#FF0000">han dejado de facturar <?=number_format($hpresencia-$hfacturadas,0)?> horas</strong> sobre el total de su capacidad de horas productivas.</span></i>
                </div>
            </td>
        </tr>
    </table>
    <br /><br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="600">
                <div style="padding:3px 20px;">
                    <strong>Rendimiento</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td width="600">
            </td>
        </tr>
        <tr>
            <td width="600">
                <div style="padding:3px 20px; line-height:140%">
                    El Rendimiento se mide de las horas facturadas entre las horas fichadas en las OR de clientes, es un indicador que mide la eficiencia de los operarios y de las intervenciones.
                </div>
            </td>
        </tr>
    </table>
    <br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="300">
                <div style="width:300px;">
                    <img src="<?=_PATH_?>archivos/tmp/rendimiento_<?=$idtaller?>_<?=$idmes?>_<?=$idano?>.png">
                </div>
            </td>
            <td width="300">
                <div style="padding:25px; width:250px; line-height:120%">
                    <i><strong style="color:#FF0000">Su taller ha dejado de facturar <?=number_format($datos['da_horasfichadasor']-$hfacturadas,0)?> horas del total asignado</strong><br /><br />Ustedes asignaron <strong><?=number_format($datos['da_horasfichadasor'],0)?> horas</strong> en los vehículos que entraron a taller y <strong>facturaron <?=number_format($hfacturadas,0)?></strong>, consiguiendo un ingreso de <strong><?=number_format($datos['da_impmo']*$hfacturadas,2,',','.')?> €</strong>. Si hubieran facturado el total de <?=number_format($datos['da_horasfichadasor'],0)?> horas, <strong style="color:#FF0000">los ingresos habrían sido de <?=number_format($datos['da_impmo']*$datos['da_horasfichadasor'],2,',','.')?> €</strong>.</i>
                </div>
            </td>
        </tr>
    </table>

</page>

<page backtop="55mm" backbottom="10mm" backleft="0mm" backright="0mm" style="font-family:Arial; font-size:14px">

    <page_header>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="520" valign="top">
                    <img src="<?=_PATH_?>imagenes/assistec.png" width="150" />
                </td>
                <td width="200" valign="bottom">
                    <div style="line-height:120%; padding:60px 0px 0px 40px; float:right; border-left:1px solid #F00">
                        C/ Sant Jaume, 134<br />
                        08150 Parets del Vallès<br />
                        BARCELONA<br /><br />
                        <strong><span style="color:#F00">T/</span></strong> 628 478 051<br />
                        <strong><span style="color:#F00">E/</span></strong> mbaez@assistec.es<br />
                        <strong><span style="color:#F00">www.assistec.es</span></strong><br />
                    </div>
                </td>
            </tr>
        </table>
    </page_header>

    <page_footer>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="720" align="right">
                    [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="600">
                <div style="padding:3px 20px;">
                    <strong>Margen venta de piezas</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td width="600">
            </td>
        </tr>
        <tr>
            <td width="600">
                <div style="padding:3px 20px; line-height:140%">
                    Es el margen que da la venta de las piezas de las OR de clientes o de ventas de contado.<br />La desviación entre el objetivo fijado según medias estándar es del <?=number_format($datos['da_objmargenrec']-$porcentpr,0)?>%.
                </div>
            </td>
        </tr>
    </table>
    <br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="300">
                <div style="width:300px;">
                    <img src="<?=_PATH_?>archivos/tmp/margenventa_<?=$idtaller?>_<?=$idmes?>_<?=$idano?>.png">
                </div>
            </td>
            <td width="300">
                <div style="padding:25px; width:250px; line-height:120%">
                    <i>Este margen les ha dado un beneficio de <strong><?=number_format($ventapr-$costepr,2,',','.')?> €</strong>. Habiendo alcanzado el objetivo del mes, sus ingresos netos habrían supuesto <strong><?=number_format($ventasobj-$costepr,2,',','.')?> €</strong><br /><br /><span style="color:#FF0000">Por tanto han dejado de ingresar por este concepto <?=number_format($ventasobj-$ventapr,2,',','.')?> €.</span></i>
                </div>
            </td>
        </tr>
    </table>
    <?php if($porcentpr<$datos['da_objmargenrec']){?>
    <br/><br/>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="600">
                <div style="padding:3px 20px; line-height:140%">
                    Se le aconseja revisar la imputación de las piezas en las órdenes de reparación, esta desviación sobre el margen puede venir derivado:
                    <ul>
                    <li>No apuntar en la orden las piezas sustituidas</li>
                    <li>Revisar en mantenimientos la imputación del aceite</li>
                    <li>Descuentos por encima del margen de compra</li>
                    <li>No utilizar un vale de pedido</li>
                    <li>No tener definido un procedimiento de compras</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>
    <?php }?>
    <br /><br /><br /><br />
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="600">
                <div style="line-height:120%">
                    En su área privada de ASSISTEC tiene a su disposición este informe así como el histórico de su actividad.<br />
Así mismo le recordamos que ASSISTEC pone a su disposición módulos más avanzados o apoyo presencial para ayudarle a la mejora continua.<br /><br />
Gracias por confiar en <strong><span style="color:#FF0000">ASSISTEC</span></strong>.
                </div>
            </td>
        </tr>
    </table>
</page>