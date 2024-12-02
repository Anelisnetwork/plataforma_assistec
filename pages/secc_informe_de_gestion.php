<?php
$hpresencia=horas_presencia($iddato);
//echo $hpresencia;
$productividad=porcentaje_($dato_mensual[0]->da_horasfichadasor,$hpresencia);
$obj_prod=$dato_mensual[0]->da_objproductividad;

$hfacturadas=$dato_mensual[0]->da_facturadomo/$dato_mensual[0]->da_impmo;
$eficacia=porcentaje_($hfacturadas,$hpresencia);
$obj_efic=$dato_mensual[0]->da_objeficacia;

$rendimiento=porcentaje_($hfacturadas,$dato_mensual[0]->da_horasfichadasor);
$obj_rendi=$dato_mensual[0]->da_objrendimiento;

$ventapr=$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$costepr=$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros;
//$porcentpr=margen_sobre_coste($costepr,$ventapr);
$margenpr=$ventapr-$dato_mensual[0]->da_pagadoprovrec;
$porcentpr=$margenpr/$ventapr*100;
$obj_ventapr=$dato_mensual[0]->da_objmargenrec;

$total_facturado=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$mediaor=$total_facturado/$dato_mensual[0]->da_entradastaller;

$ventamo=$dato_mensual[0]->da_facturadomo;
$mediamo=$ventamo/$dato_mensual[0]->da_entradastaller;

$mediapr=$ventapr/$dato_mensual[0]->da_entradastaller;

$infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
$totalbbdd=$infotaller[0]->it_totalclientes;
$fidelizacion=porcentaje_($dato_mensual[0]->da_entradastaller,$totalbbdd);;



$horas_productivas=horas_presencia_pot($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'])*($obj_prod/100);//Un 10% de tiempo no productivo
$tiempo_medio_cliente=$horas_productivas/$dato_mensual[0]->da_entradastaller;//21.6
$entradas_dia=$dato_mensual[0]->da_entradastaller/$dato_mensual[0]->da_diaslaborables;
$capacidad_teorica=$horas_productivas/$tiempo_medio_cliente/$dato_mensual[0]->da_diaslaborables;

//echo 'Horas productivas: '.$horas_productivas;

//echo $tiempo_medio_cliente.'<br>'.$horas_productivas.'<br>'.$capacidad_teorica.'<br>'.$entradas_dia.'<br>'.$dato_mensual[0]->da_diaslaborables.'<br>';
?>
		<div id="informemes" class="div_mostrarocultar colizq" style="float:left;">	
			<div class="linea">
            	<span class="oswald fs_16">Informe de gesti&oacute;n del mes de <?=nom_mes($dato_mensual[0]->da_mes)?> de <?=$dato_mensual[0]->da_ano?></span>
            </div>
            
            <div class="linea">
                <label class="ancho faq" title="(horas trabajadas/horas presencia)">Productividad:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$productividad<$obj_prod?'r':'v'?>"><?=moneda_puntocoma($productividad)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho faq" title="(horas facturadas/horas presencia)">Eficacia:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$eficacia<$obj_efic?'r':'v'?>"><?=moneda_puntocoma($eficacia)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho faq" title="(horas facturadas/horas fichadas OR)">Rendimiento:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$rendimiento<$obj_rendi?'r':'v'?>"><?=moneda_puntocoma($rendimiento)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                	<span class="oswald fs_14 texto_<?=$porcentpr<$obj_ventapr?'r':'v'?>"><?=moneda_puntocoma($porcentpr)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">N&ordm; entradas/día:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=round($entradas_dia)?></span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Capacidad te&oacute;rica entradas:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=round($capacidad_teorica)?></span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Desviaci&oacute;n:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)<0?'r':'v'?>"><?=number_format(($dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)),0,',','.')?></span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">% desviaci&oacute;n:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)<0?'r':'v'?>"><?=number_format(margen_sobre_coste(($capacidad_teorica*$dato_mensual[0]->da_diaslaborables),$dato_mensual[0]->da_entradastaller),0,',','.')?>%</span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Tiempo medio por entrada:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=faltan2(($horas_productivas/$dato_mensual[0]->da_entradastaller)*3600)?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe medio por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediaor)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe MO por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediamo)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">% MO por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma(porcentaje_($mediamo,$mediaor))?>%</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe PR por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediapr)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">% PR por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma(porcentaje_($mediapr,$mediaor))?>%</span>
                </div>
            </div>
            
            <!--<div class="linea">
                <label class="ancho">Fidelizaci&oacute;n de clientes:</label>
                <div class="dato">
                    <span class="oswald"><?/*=moneda_puntocoma($fidelizacion)*/?> %</span>
                </div>
            </div>-->
            
            <div class="linea" style="margin-top:25px;">
                <span class="oswald fs_16" style="float:right;">Descargar informe<a href="<?=_RAIZ_.'genera_informe/'.en__('pdf_infome_mensual%%imprimir%%'.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].'%%'.$dato_mensual[0]->da_mes.'%%'.$dato_mensual[0]->da_ano.'').'/'?>" target="_blank" style="float:right; margin:3px 15px"><img src="<?=_RAIZ_?>imagenes/pdf.png" /></a></span>
            </div>
            
		</div>
