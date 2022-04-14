<?php
!isset($idtaller)?$idtaller=$contenido_de[2]:false;
!isset($idmes)?$idmes=$contenido_de[3]:false;;
!isset($idano)?$idano=$contenido_de[4]:false;;

if(num_rows("select ta_idtaller from talleres where ta_idtaller={$idtaller}")==0||num_rows("select da_iddato from datos_actividad where da_idtaller={$idtaller} and da_mes='{$idmes}' and da_ano='{$idano}'")==0){
	exit("Datos incorrectos");
}

$datos=fetch_array("select * from datos_actividad where da_idtaller={$idtaller} and da_mes='{$idmes}' and da_ano='{$idano}'");

$acumulado=dame_acumulado($idano,$idtaller);

$porcentajes=personal_porcentaje($idtaller);

$hpresencia=horas_presencia($datos['da_iddato']);
$hfacturadas=$datos['da_facturadomo']/$datos['da_impmo'];

$facturadoxvehiculo=$datos['da_facturadomo']/$datos['da_entradastaller'];
$facturadoxvehiculo_ac=$acumulado['ventamo']/$acumulado['entradastaller'];

$hfactxoperario=$hfacturadas/$porcentajes[4];
$hfactxoperario_ac=$acumulado['hfacturadas']/$porcentajes[4]/$acumulado['nmeses'];

$facturadoxoperario=$datos['da_facturadomo']/$porcentajes[4];
$facturadoxoperario_ac=$acumulado['ventamo']/$porcentajes[4]/$acumulado['nmeses'];

$productividad=porcentaje_($datos['da_horasfichadasor'],$hpresencia);
$eficacia=porcentaje_($hfacturadas,$hpresencia);
$rendimiento=porcentaje_($hfacturadas,$datos['da_horasfichadasor']);

$ventapr=$datos['da_facturadorec']+$datos['da_facturadootros'];
$costepr=$datos['da_pagadoprovrec']+$datos['da_pagadoprovotros'];
$porcentpr=number_format(margen_sobre_coste($costepr,$ventapr),2);
$ventasobj=$costepr+($costepr*$datos['da_objmargenrec']/100);

$horaspotenciales=$hpresencia*$datos['da_objeficacia']/100;
$coste_horat=($datos['da_costeestructura']+$datos['da_costepersonal'])/1750*($porcentajes[4]*0.8);
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
                        Gran Vía Corts Catalanes, 1099, Planta 2 – Puerta 1<br />
                        08020 Barcelonas<br />
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

    <!-- NOMBRE DEL TALLER Y MES Y AÑO DEL INFORME  -->
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


    <br />

    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td style="width: 199px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Indicador</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Objetivo</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Real</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Desviación</strong>
            </td>
        </tr>
        <tr>
            <td style="width: 199px; padding: 10px 7px; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;">
                <strong><i><span style="color:#888">Eficacia</span></i></strong>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; padding: 10px 7px">
                <span style="color:#888"><?=number_format($datos['da_objeficacia'],0)?>%</span>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-left: 0px; padding: 10px 7px">
                    <span style="color:#888"><?=number_format($eficacia,0)?>%</span>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-left: 0px; padding: 10px 7px">
                    <span style="color:<?=$datos['da_objeficacia']<=$eficacia?'#2d9828':'#FF5353'?>"><?=number_format($eficacia-$datos['da_objeficacia'],0)?>%</span>
            </td>
        </tr>
        <tr>
            <td style="width: 199px; padding: 10px 7px; border-bottom: 1px solid #ccc">
                    <strong><i><span style="color:#888">Margen venta piezas</span></i></strong>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-top: 0px; padding: 10px 7px">
                    <span style="color:#888"><?=number_format($datos['da_objmargenrec'],0)?>%</span>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-top: 0px; border-left: 0px; padding: 10px 7px">
                    <span style="color:#888"><?=number_format($porcentpr,0)?>%</span>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-top: 0px; border-left: 0px; padding: 10px 7px">
                    <span style="color:<?=$datos['da_objmargenrec']<=$porcentpr?'#2d9828':'#FF5353'?>"><?=number_format($porcentpr-$datos['da_objmargenrec'],0)?>%</span>
            </td>
        </tr>
    </table>

    <br>

    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td style="width: 199px; text-align: center; padding: 3px 7px">
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">PVP</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Real</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
            </td>
        </tr>
        <tr>
            <td style="width: 199px; padding: 10px 7px; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;">
                <strong><i><span style="color:#888">Coste/Hora</span></i></strong>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; padding: 10px 7px">
                <span style="color:#888"><?=number_format($coste_horat,2,',','.')?> €</span>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-left: 0px; padding: 10px 7px">
                <span style="color:#888"><?=number_format($coste_hora,2,',','.')?> €</span>
            </td>
            <td style="width: 98px; text-align:center; border:1px solid #ccc; border-left: 0px; padding: 10px 7px">
                <span style="color:<?=$coste_horat-$coste_hora<0?'#FF5353':'#2d9828'?>"><?=number_format($coste_horat-$coste_hora,2,',','.')?> €</span>
            </td>
        </tr>
    </table>

    <br><br>

    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td style=" width:600px; padding:3px 20px;">
                    <strong>EFICACIA</strong>
            </td>
        </tr>
        <tr style="margin-top: 15px">
            <td style="width:600px; padding:3px 20px; line-height:140%">
                    La eficacia es el ratio que indica las horas facturadas entre las horas de presencia de los técnicos del taller.
            </td>
        </tr>
    </table>

    <br>

    <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style=" width:55px;">
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left">
                <strong>PRESENCIA</strong>
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left;">
                <?=number_format($hpresencia,0)?> Horas
            </td>
            <td style=" width:200px;"></td>
        </tr>
        <tr>
            <td style=" width:55px;">
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left">
                <strong>OBJETIVO HORAS</strong>
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left;">
                <?=number_format($horaspotenciales,0)?> Horas
            </td>
            <td style=" width:200px;"></td>
        </tr>
        <tr>
            <td style=" width:55px;">
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left">
                <strong>FACTURADAS MES</strong>
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left;">
                <?=number_format($hfacturadas,0)?> Horas
            </td>
            <td style=" width:200px;"></td>
        </tr>
        <tr>
            <td style=" width:55px;">
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left">
                <strong>PERDIDAS</strong>
            </td>
            <td style=" width:150px; padding:3px 20px; text-align: left;">
                <span style="color:<?=$horaspotenciales-$hfacturadas>0?'#FF5353':'#2d9828'?>"><?=number_format(max(0,$horaspotenciales-$hfacturadas),0)?> Horas</span>
            </td>
            <td style=" width:200px;"></td>
        </tr>
        <? if($horaspotenciales-$hfacturadas>0){?>
        <tr>
            <td colspan="4">
                <br>
            </td>
        </tr>
        <tr>
            <td style=" width:55px;">
            </td>
            <td colspan="3" style="width:300px; padding:3px 20px; line-height:140%; color: #FF5353;">
                <?=strtoupper(u8d_(dato_taller('ta_nombre',$datos['da_idtaller'])))?> dejó de facturar <?=number_format(($horaspotenciales-$hfacturadas)*$coste_horat,2,',','.')?> € de mano de obra.
            </td>
        </tr>
        <? }?>
        <tr>
            <td style=" width:55px;">
            </td>
            <td colspan="3" style="width:300px; padding:3px 20px; line-height:140%; font-size: 18px">
                <div style="width: 100%;">La eficacia de <?=strtoupper(u8d_(dato_taller('ta_nombre',$datos['da_idtaller'])))?> está en <div style="padding: 3px 5px; background-color: <?=$eficacia>=80?'#2d9828':($eficacia<80&&$eficacia>=65?'#F39C17':'#FF5353')?>; width: 85px; text-align: center; margin-left: 10px; margin-top: -2px"><?=number_format(max(-999,min(999,$eficacia)),2)?> %</div></div>
            </td>
        </tr>
        <tr>
            <td style=" width:55px;">
            </td>
            <td colspan="3" style="width:300px; padding:3px 20px; line-height:140%; font-size: 14px">
                <div style="width: 100%; font-style: italic; color: #0f3655; text-align: center">Si el % de eficacia se encontrara por debajo del 65%, póngase en contacto con ASSISTEC en web@assistec.es</div>
            </td>
        </tr>
    </table>
    <br>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td style=" width:600px; padding:3px 20px;">
                <strong>INDICADORES ACTIVIDAD TALLER</strong>
            </td>
        </tr>
    </table>
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td style="width: 199px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Indicador</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Mes</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Acumulado</strong>
            </td>
            <td style="width: 98px; text-align: center; padding: 3px 7px">
                <strong style="color: #888;">Desviación</strong>
            </td>
        </tr>
        <tr>
            <td style="width: 244px; padding: 10px 7px; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;">
                <strong><i><span style="color:#888">Facturación por vehículo reparado</span></i></strong>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; padding: 10px 7px">
                <span style="color:#888"><?=number_format($facturadoxvehiculo,2)?> €</span>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-left: 0px; padding: 10px 7px">
                <span style="color:#888"><?=number_format($facturadoxvehiculo_ac,2)?> €</span>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-left: 0px; padding: 10px 7px">
                <span style="color:<?=$facturadoxvehiculo>$facturadoxvehiculo_ac?'#2d9828':'#FF5353'?>"><?=number_format($facturadoxvehiculo-$facturadoxvehiculo_ac,2)?> €</span>
            </td>
        </tr>
        <tr>
            <td style="width: 244px; padding: 10px 7px; border-bottom: 1px solid #ccc">
                <strong><i><span style="color:#888">Horas facturadas por operario</span></i></strong>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-top: 0px; padding: 10px 7px">
                <span style="color:#888"><?=number_format($hfactxoperario,2)?></span>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-top: 0px; border-left: 0px; padding: 10px 7px">
                <span style="color:#888"><?=number_format($hfactxoperario_ac,2)?></span>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-top: 0px; border-left: 0px; padding: 10px 7px">
                <span style="color:<?=$hfactxoperario>$hfactxoperario_ac?'#2d9828':'#FF5353'?>"><?=number_format($hfactxoperario-$hfactxoperario_ac,2)?></span>
            </td>
        </tr>
        <tr>
            <td style="width: 244px; padding: 10px 7px; border-bottom: 1px solid #ccc">
                <strong><i><span style="color:#888">Importe facturado por operario</span></i></strong>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-top: 0px; padding: 10px 7px">
                <span style="color:#888"><?=number_format($facturadoxoperario,2)?> €</span>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-top: 0px; border-left: 0px; padding: 5px 7px">
                <span style="color:#888"><?=number_format($facturadoxoperario_ac,2)?> €</span>
            </td>
            <td style="width: 83px; text-align:center; border:1px solid #ccc; border-top: 0px; border-left: 0px; padding: 5px 7px">
                <span style="color:<?=$facturadoxoperario>$facturadoxoperario_ac?'#2d9828':'#FF5353'?>"><?=number_format($facturadoxoperario-$facturadoxoperario_ac,2)?> €</span>
            </td>
        </tr>
    </table>
    <br>
</page>

<page backtop="55mm" backbottom="10mm" backleft="0mm" backright="0mm" style="font-family:Arial; font-size:14px">
    <page_header>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="520" valign="top">
                    <img src="<?=_PATH_?>imagenes/assistec_pdf.png" style="margin-top:25px" />
                </td>
                <td width="200" valign="bottom">
                    <div style="line-height:120%; padding:60px 0px 0px 40px; float:right; border-left:1px solid #F00">
                        Gran Vía Corts Catalanes, 1099, Planta 2 – Puerta 1<br />
                        08020 Barcelona<br />
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
                <td width="720">
                    <div style="padding: 5px 20px; border: 1px solid #FF0000; text-align: center">
                        Puede acceder a su panel privado para un análisis más detallado de indicadores a través de:
                        <strong><a href="https://plataforma.assistec.es/" style="color:#FF0000">https://plataforma.assistec.es/</a></strong>
                    </div>
                </td>
            </tr>
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
                    Gracias por confiar en <strong><span style="color:#FF0000">ASSISTEC</span></strong>.<br>
                </div>
            </td>
        </tr>
    </table>
</page>