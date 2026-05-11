
		<div id="informemes" class="col col-12 col-sm-8 d-flex flex-column align-items-start justify-content-center p-3">
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho fs_16">Total facturado:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_facturado)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Importe venta MO:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ventamo)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Importe venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($ventapr)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Coste venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($pagadoprovrec)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$porcentpr<$obj_ventapr?'r':'v'?>"><?=moneda_puntocoma($margenpr)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">% Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$porcentpr<$obj_ventapr?'r':'v'?>"><?=moneda_puntocoma($porcentpr)?> %</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Coste otras compras:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($pagadoprovotros)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Coste personal:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costepers)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho">Gastos estructura:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($costeestr)?> &euro;</span>
                </div>
            </div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho fs_16">Total ingresos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_ingresos)?> &euro;</span>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho fs_16">Total gastos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($total_gastos)?> &euro;</span>
                </div>
            </div>
            
            <div class="linea" style="height:1px; background-color:#555"></div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho fs_16">Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$margenbruto<0?'r':'v'?>"><?=moneda_puntocoma($margenbruto)?> &euro;</span>
                </div>
            </div>
            
            <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
                <label class="ancho fs_16">% Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$porcmargenbruto<0?'r':'v'?>"><?=moneda_puntocoma($porcmargenbruto)?> %</span>
                </div>
            </div>

		</div>