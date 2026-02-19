<?php
$total_facturado=isset($dato_mensual[0])?$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros:0;
$ventamo=isset($dato_mensual[0])?$dato_mensual[0]->da_facturadomo:0;
$ventapr=isset($dato_mensual[0])?$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros:0;
$costepr=isset($dato_mensual[0])?$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros:0;
$margenpr=isset($dato_mensual[0])?$ventapr-$dato_mensual[0]->da_pagadoprovrec:0;
$obj_ventas=isset($dato_mensual[0])?$dato_mensual[0]->da_objventas:0;
//$porcentprisset($dato_mensual[0])?=margen_sobre_coste($dato_mensual[0]->da_pagadoprovrec,$ventapr):0;
$porcentpr=isset($dato_mensual[0])?$margenpr/$ventapr*100:0;
$obj_ventapr=isset($dato_mensual[0])?$dato_mensual[0]->da_objmargenrec:0;
$costepers=isset($dato_mensual[0])?$dato_mensual[0]->da_costepersonal:0;
$costeestr=isset($dato_mensual[0])?$dato_mensual[0]->da_costeestructura:0;
$total_ingresos=isset($dato_mensual[0])?$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros:0;
$total_gastos=isset($dato_mensual[0])?$costepr+$costepers+$costeestr:0;
$margenbruto=isset($dato_mensual[0])?$total_ingresos-$total_gastos:0;
$porcmargenbruto=isset($dato_mensual[0])?$margenbruto/$total_ingresos*100:0;
$pagadoprovrec=isset($dato_mensual[0])?$dato_mensual[0]->da_pagadoprovrec:0;
$pagadoprovotros=isset($dato_mensual[0])?$dato_mensual[0]->da_pagadoprovotros:0;
?>
		<div id="informemes" class="div_mostrarocultar col col-12 col-sm-8 d-flex flex-column align-items-start justify-content-start p-3">
			<div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
            	<span class="oswald fs_16"><?=isset($dato_mensual[0])?"Informe econ&oacute;mico del mes de ".nom_mes($dato_mensual[0]->da_mes)." de ".$dato_mensual[0]->da_ano : "No hay informe"?></span>
            </div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho fs_16">Total facturado:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_facturado)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Importe venta MO:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ventamo)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Importe venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ventapr)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Coste venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($pagadoprovrec)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$porcentpr<$obj_ventapr?'r':'v'?>"><?=moneda_puntocoma($margenpr)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">% Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$porcentpr<$obj_ventapr?'r':'v'?>"><?=moneda_puntocoma($porcentpr)?> %</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Coste otras compras:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($pagadoprovotros)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Coste personal:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costepers)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho">Gastos estructura:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costeestr)?> &euro;</span>
                </div>
            </div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho fs_16">Total ingresos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_ingresos)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho fs_16">Total gastos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_gastos)?> &euro;</span>
                </div>
            </div>
            
            <div class="linea" style="height:1px; background-color:#555"></div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho fs_16">Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$margenbruto<0?'r':'v'?>"><?=moneda_puntocoma($margenbruto)?> &euro;</span>
                </div>
            </div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1">
                <label class="ancho fs_16">% Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$porcmargenbruto<0?'r':'v'?>"><?=moneda_puntocoma($porcmargenbruto)?> %</span>
                </div>
            </div>
            
            <div class="linea" style="margin-top:25px;">
                <?php if(isset($dato_mensual[0])){?>
                <span class="oswald fs_16" style="float:right;">Descargar informe<a href="<?=_RAIZ_.'genera_informe/'.en__('pdf_infome_mensual%%imprimir%%'.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].'%%'.$dato_mensual[0]->da_mes.'%%'.$dato_mensual[0]->da_ano.'').'/'?>" target="_blank" style="float:right; margin:3px 15px"><img src="<?=_RAIZ_?>imagenes/pdf.png" /></a></span>
                <?php }?>
            </div>
            
		</div>