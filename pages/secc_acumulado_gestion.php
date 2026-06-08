<div id="informemes" class="div_mostrarocultar  col col-12 col-md-6 d-flex flex-column align-items-start justify-content-start p-3">
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Ocupación:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$datos_acumulados['productividad']<$datos_acumulados['objproductividad']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['productividad'])?> %</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Eficacia/Productividad:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$datos_acumulados['eficacia']<$datos_acumulados['objeficacia']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['eficacia'])?> %</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Rendimiento:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$datos_acumulados['rendimiento']<$datos_acumulados['objrendimiento']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['rendimiento'])?> %</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Margen Recambio:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$datos_acumulados['porcentpr']<$datos_acumulados['objmargenrec']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['porcentpr'])?> %</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">N&ordm; entradas:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=$entradas_dia?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
        <label class="ancho">Capacidad te&oacute;rica:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=round($capacidad_teorica)?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
        <label class="ancho">Desviaci&oacute;n:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$entradas_dia-$capacidad_teorica<0?'r':'v'?>"><?=round($entradas_dia-$capacidad_teorica)?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
        <label class="ancho">% desviaci&oacute;n:</label>
        <div class="dato">
            <span class="oswald fs_14 texto_<?=$entradas_dia-$capacidad_teorica<0?'r':'v'?>"><?=moneda_puntocoma(margen_sobre_coste($capacidad_teorica,$entradas_dia))?>%</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1 text-bg-light rounded" >
        <label class="ancho">Tiempo medio por entrada:</label>
        <div class="dato">
            <span class="oswald fs_14"><?=faltan2($tiempo_medio_cliente*3600)?></span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1" >
        <div id="stats_acum_gest_3" class="stat_ratio w-100">
        </div>
    </div>
</div>
<div class="colder_graf col col-12 col-md-6 d-flex flex-column align-items-center align-items-md-end justify-content-start p-3">
    <div id="stats_acum_gest_1" class="stat_ratio w-100 mb-4">
    </div>

    <div id="stats_acum_gest_2" class="stat_ratio w-100">
    </div>

</div>