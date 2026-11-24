
		<div id="informemes" class="div_mostrarocultar col col-12 col-sm-8 d-flex flex-column align-items-start justify-content-start p-3">	
			<div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
            	<span class="oswald fs_16">Informe de gesti&oacute;n del mes de <?=nom_mes($dato_mensual[0]->da_mes)?> de <?=$dato_mensual[0]->da_ano?></span>
            </div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho faq" title="(horas trabajadas/horas presencia)">Ocupación:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$productividad<$obj_prod?'r':'v'?>"><?=moneda_puntocoma($productividad)?> %</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho faq" title="(horas facturadas/horas presencia)">Eficacia/Productividad:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$eficacia<$obj_efic?'r':'v'?>"><?=moneda_puntocoma($eficacia)?> %</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho faq" title="(horas facturadas/horas fichadas OR)">Rendimiento:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$rendimiento<$obj_rendi?'r':'v'?>"><?=moneda_puntocoma($rendimiento)?> %</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Margen Recambio:</label>
                <div class="dato">
                	<span class="oswald fs_14 texto_<?=$porcentpr<$obj_ventapr?'r':'v'?>"><?=moneda_puntocoma($porcentpr)?> %</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">N&ordm; entradas/día:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=round($entradas_dia)?></span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
                <label class="ancho">Capacidad te&oacute;rica entradas:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=round($capacidad_teorica)?></span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
                <label class="ancho">Desviaci&oacute;n:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)<0?'r':'v'?>"><?=number_format(($dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)),0,',','.')?></span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
                <label class="ancho">% desviaci&oacute;n:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)<0?'r':'v'?>"><?=number_format(margen_sobre_coste(($capacidad_teorica*$dato_mensual[0]->da_diaslaborables),$dato_mensual[0]->da_entradastaller),0,',','.')?>%</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
                <label class="ancho">Tiempo medio por entrada:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=faltan2(($dato_mensual[0]->da_entradastaller==0?0:($horas_productivas/$dato_mensual[0]->da_entradastaller))*3600)?></span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Ticket medio:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediaor)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Ticket medio MO:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediamo)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">% MO por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma(porcentaje_($mediamo,$mediaor))?>%</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Ticket medio piezas:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediapr)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho faq" title="Pintura y Recambio">% MATERIALES por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma(porcentaje_($mediapr,$mediaor))?>%</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Ticket medio de compra:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ticketmedioc)?> €</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Margen operativo:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($mediaor-$ticketmedioc)?> €</span>
                </div>
            </div>
		</div>
