<?php
$hpresencia=horas_presencia($iddato);
$productividad=porcentaje_($dato_mensual[0]->da_horasfichadasor,$hpresencia);

$hfacturadas=$dato_mensual[0]->da_facturadomo/$dato_mensual[0]->da_impmo;
$eficacia=porcentaje_($hfacturadas,$hpresencia);

$rendimiento=porcentaje_($hfacturadas,$dato_mensual[0]->da_horasfichadasor);

$ventapr=$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$costepr=$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros;
//$porcentpr=margen_sobre_coste($costepr,$ventapr);
$margenpr=$ventapr-$dato_mensual[0]->da_pagadoprovrec;
$porcentpr=$margenpr/$ventapr*100;

$total_facturado=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$mediaor=$total_facturado/$dato_mensual[0]->da_entradastaller;

$ventamo=$dato_mensual[0]->da_facturadomo;
$mediamo=$ventamo/$dato_mensual[0]->da_entradastaller;

$mediapr=$ventapr/$dato_mensual[0]->da_entradastaller;

$horas_productivas=horas_presencia_pot($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'])*($dato_mensual[0]->da_objproductividad/100);//Un 10% de tiempo no productivo

$infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
$totalbbdd=$infotaller[0]->it_totalclientes;
$fidelizacion=porcentaje_($dato_mensual[0]->da_entradastaller,$totalbbdd);;

?>
		<div id="informemes" class="div_mostrarocultar colizq" style="float:left;">	
			<div class="linea">
            	<span class="oswald fs_16">Informe de gesti&oacute;n de partida (<?=$dato_mensual[0]->da_mes?> mes<?=$dato_mensual[0]->da_mes>1?'es':''?>)</span>
            </div>
            
            <div class="linea">
                <label class="ancho">Productividad:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$productividad<0?'r':'v'?>"><?=moneda_puntocoma($productividad)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Eficacia:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$eficacia<0?'r':'v'?>"><?=moneda_puntocoma($eficacia)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Rendimiento:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$rendimiento<0?'r':'v'?>"><?=moneda_puntocoma($rendimiento)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                	<span class="oswald fs_14 texto_<?=$porcentpr<0?'r':'v'?>"><?=moneda_puntocoma($porcentpr)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">N&ordm; entradas:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=$dato_mensual[0]->da_entradastaller?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Tiempo medio por entrada:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=faltan2(($horas_productivas/$dato_mensual[0]->da_entradastaller)*3600/$dato_mensual[0]->da_mes)?></span>
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
                <label class="ancho">Importe PR por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediapr)?> &euro;</span>
                </div>
            </div>
            
            <!--<div class="linea">
                <label class="ancho">Fidelizaci&oacute;n de clientes:</label>
                <div class="dato">
                    <span class="oswald"><?/*=moneda_puntocoma($fidelizacion)*/?> %</span>
                </div>
            </div>-->
            
		</div>