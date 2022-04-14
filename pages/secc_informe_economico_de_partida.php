<?php
$total_facturado=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$ventamo=$dato_mensual[0]->da_facturadomo;
$ventapr=$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$costepr=$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros;
$margenpr=$ventapr-$dato_mensual[0]->da_pagadoprovrec;
$porcentpr=margen_sobre_coste($dato_mensual[0]->da_pagadoprovrec,$ventapr);
$costepers=$dato_mensual[0]->da_costepersonal;
$costeestr=$dato_mensual[0]->da_costeestructura;
$total_ingresos=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$total_gastos=$costepr+$costepers+$costeestr;
$margenbruto=$total_ingresos-$total_gastos;
$porcmargenbruto=margen_sobre_coste($total_gastos,$total_ingresos);
?>
		<div id="informemes" class="div_mostrarocultar colizq" style="float:left;">	
			<div class="linea">
            	<span class="oswald fs_16">Informe econ&oacute;mico de partida (<?=$dato_mensual[0]->da_mes?> mes<?=$dato_mensual[0]->da_mes>1?'es':''?>)</span>
            </div>
            
            <div class="linea">
                <label class="ancho fs_16">Total facturado:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_facturado)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe venta MO:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ventamo)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ventapr)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Coste venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costepr)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$margenpr<0?'r':'v'?>"><?=moneda_puntocoma($margenpr)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">% Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$porcentpr<0?'r':'v'?>"><?=moneda_puntocoma($porcentpr)?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Coste personal:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costepers)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Gastos estructura:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costeestr)?> &euro;</span>
                </div>
            </div>
            
            <div class="linea">
                <label class="ancho fs_16">Total ingresos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_ingresos)?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho fs_16">Total gastos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_gastos)?> &euro;</span>
                </div>
            </div>
            
            <div class="linea" style="height:1px; background-color:#555"></div>
            
            <div class="linea">
                <label class="ancho fs_16">Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$margenbruto<0?'r':'v'?>"><?=moneda_puntocoma($margenbruto)?> &euro;</span>
                </div>
            </div>
            
            <div class="linea">
                <label class="ancho fs_16">% Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$porcmargenbruto<0?'r':'v'?>"><?=moneda_puntocoma($porcmargenbruto)?> %</span>
                </div>
            </div>
            
		</div>