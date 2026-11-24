<div id="informemes" class="evolucion-columnas div_mostrarocultar   col col-12 col-md-6 d-flex flex-column align-items-start justify-content-start p-3">
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <span class=" fs_18">Informe de evoluci&oacute;n acumulado del a&ntilde;o <?=$anho_acumulado?></span>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <span class="fs_14">Horas acumuladas <?=moneda_puntocoma($datos_acumulados['hfacturadas'])?></span>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1" style="margin-top: 25px">
        <label class="ancho texto_r"><strong>CONCEPTO</strong></label>
        <div class="dato">
            <span class=" fs_14 texto_r">Acumulado</span>
        </div>
        <div class="dato">
            <span class=" fs_14 texto_r">Media</span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Ticket medio:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($datos_acumulados['mediaor'])?> &euro;</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Ticket medio MO:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($datos_acumulados['mediamo'])?> &euro;</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">% MO por OR:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(porcentaje_($datos_acumulados['mediamo'],$datos_acumulados['mediaor']))?>%</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Ticket medio piezas:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($datos_acumulados['mediapr'])?> &euro;</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho faq" title="Pintura y Recambio">% MATERIALES por OR:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(porcentaje_($datos_acumulados['mediapr'],$datos_acumulados['mediaor']))?>%</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Ticket medio de compra:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($ticketmedioc)?> €</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Margen operativo:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($datos_acumulados['mediaor']-$ticketmedioc)?> €</span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?='---'?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Horas facturadas x operario:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($porcentajes[4]==0?0:$datos_acumulados['hfacturadas']/$porcentajes[4])?></span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(($porcentajes[4]==0||$datos_acumulados['nmeses']==0)?0:$datos_acumulados['hfacturadas']/$datos_acumulados['nmeses']/$porcentajes[4])?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">€ MO x operario:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($porcentajes[4]==0?0:$datos_acumulados['ventamo']/$porcentajes[4])?></span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(($porcentajes[4]==0||$datos_acumulados['nmeses']==0)?0:$datos_acumulados['ventamo']/$porcentajes[4]/$datos_acumulados['nmeses'])?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho faq" title="Pintura y Recambio">€ MATERIALES x operario:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($porcentajes[4]==0?0:$datos_acumulados['ventapr']/$porcentajes[4])?></span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(($porcentajes[4]==0||$datos_acumulados['nmeses']==0)?0:$datos_acumulados['ventapr']/$porcentajes[4]/$datos_acumulados['nmeses'])?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Total facturado x operario:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($porcentajes[4]==0?0:$datos_acumulados['ventamo']/$porcentajes[4]+$datos_acumulados['ventapr']/$porcentajes[4])?></span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(($porcentajes[4]==0||$datos_acumulados['nmeses']==0)?0:($datos_acumulados['ventamo']/$porcentajes[4]+$datos_acumulados['ventapr']/$porcentajes[4])/$datos_acumulados['nmeses'])?></span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <label class="ancho">Nº horas por OR:</label>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma($datos_acumulados['entradastaller']==0?0:$datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller'])?></span>
        </div>
        <div class="dato">
            <span class=" fs_14"><?=moneda_puntocoma(($datos_acumulados['entradastaller']==0||$datos_acumulados['nmeses']==0)?0:($datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller'])/$datos_acumulados['nmeses'])?></span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-between w-100 mb-1 p-1">
        <div id="stats_acum_evol_4" class="stat_ratio w-100">
        </div>
    </div>
</div>

<div class="colder_graf col col-12 col-md-6 d-flex flex-column align-items-center align-items-md-end justify-content-start p-3">
    <div id="stats_acum_evol_1" class="stat_ratio w-100 mb-4">
    </div>
    <div id="stats_acum_evol_2" class="stat_ratio w-100 mb-4">
    </div>
    <div id="stats_acum_evol_3" class="stat_ratio w-100">
    </div>
</div>
