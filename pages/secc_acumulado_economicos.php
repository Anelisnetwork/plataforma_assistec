<div id="informemes" class="col-12<?=isset($anho_acumulado) ? ' col-md-6' : ' col-sm-8'?> d-flex flex-column align-items-start justify-content-center p-3">
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho fs_16">Total facturado:</label>
        <div class="dato">
            <span class="oswald fs_16"><?=moneda_puntocoma($datos_acumulados['total_facturado'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Importe venta MO:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventamo'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Importe venta PR:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventapr'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Coste venta PR:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costeprov'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Margen venta PR:</label>
        <div class="dato">
            <span class="oswald fs_14<?=$datos_acumulados['margenpr']<0?' texto_r':''?>"><?=moneda_puntocoma($datos_acumulados['margenpr'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">% Margen venta PR:</label>
        <div class="dato">
            <span class="oswald fs_14<?=$datos_acumulados['porcentpr']<0?' texto_r':''?>"><?=moneda_puntocoma($datos_acumulados['porcentpr'])?> %</span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Coste otras compras:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costeotro'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Coste personal:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costepers'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Gastos estructura:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costeestr'])?> &euro;</span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded">
        <label class="ancho">Precio medio hora:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['hfacturadas'] == 0 ? 0 : $datos_acumulados['ventamo']/$datos_acumulados['hfacturadas'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded">
        <label class="ancho">Coste hora:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=moneda_puntocoma($coste_hora_real)?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded">
        <label class="ancho">Margen:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$datos_acumulados['hfacturadas'] == 0 || ($datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']-$coste_hora_real)<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['hfacturadas'] == 0 ? 0 :$datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']-$coste_hora_real)?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded">
        <label class="ancho">% beneficio:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$datos_acumulados['hfacturadas'] == 0 || ($datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']-$coste_hora_real)<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['hfacturadas'] == 0 ? 0 :margen_sobre_coste($coste_hora_real,$datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']))?>%</span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho fs_16">Total ingresos:</label>
        <div class="dato">
            <span class="oswald fs_16"><?=moneda_puntocoma($datos_acumulados['total_ingresos'])?> &euro;</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho fs_16">Total gastos:</label>
        <div class="dato">
            <span class="oswald fs_16"><?=moneda_puntocoma($datos_acumulados['total_gastos'])?> &euro;</span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1" style="height:1px; background-color:#555"></div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho fs_16">Margen bruto:</label>
        <div class="dato">
            <span class="oswald fs_16 texto_<?=$datos_acumulados['margenbruto']<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['margenbruto'])?> &euro;</span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho fs_16">% Margen bruto:</label>
        <div class="dato">
            <span class="oswald fs_16 texto_<?=$datos_acumulados['porcmargenbruto']<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['porcmargenbruto'])?> %</span>
        </div>
    </div>

</div>
<?php   if(isset($anho_acumulado)){?>
<div class="col-12 col-md-6 d-flex flex-column align-items-center align-items-md-end justify-content-start p-3">
    <div id="stats_acum_econ_1" class="stat_ratio w-100 mb-4">
    </div>
    <div id="stats_acum_econ_2" class="stat_ratio w-100">
    </div>
</div>
<?php   }?>