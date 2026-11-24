<?php
$datos_ultimo_anho=dame_acumulado_ult();

$precio_medio_mo=$datos_ultimo_anho['coste_medio_mo'];
$coste_hora_teorico=round($datos_ultimo_anho['coste_hora_teorico'],2);
$coste_hora_real=round($datos_ultimo_anho['coste_hora_real'],2);
$horaspotenciales=round($datos_ultimo_anho['horaspotenciales'],0);
$horasimproductivas=round($datos_ultimo_anho['horasimproductivas'],0);
$hfacturadas=round($datos_ultimo_anho['hfacturadas'],0);
//$coste_hora_real=$datos_ultimo_anho['coste_hora_real'];
//$coste_hora_teorico=$datos_ultimo_anho['coste_hora_teorico'];

//echo $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']==1?$datos_ultimo_anho['costeestr']:'';

//echo '<pre>'; var_dump($datos_ultimo_anho); echo '</pre>';

$ventas=dame_ventas();
$entradas=dame_entradas();
$euro_entradas=array();
if(!empty($ventas)&&!empty($entradas)){
    $euro_entradas[0]=$entradas[0]!=0?round($ventas[0]/$entradas[0],2):0;
    $euro_entradas[1]=$entradas[1]!=0?round($ventas[1]/$entradas[1],2):0;
}
$margenrec=margen_rec();
$eficacia_stats=dame_eficacia(3);
$productividad_stats=dame_productividad(3);
$rendimiento_stats=dame_rendimiento(3);
$anhos=dame_anhos();
/*
if($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==1){//Módulo Básico
	$objventas=0;
	$objmargenrec=0;
	$objeficacia=0;
	$objproductividad=0;
	$objrendimiento=0;
	$incremento=dame_variacion();
}
else if($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==2||$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==3){//Módulos Avanzado y Plus*/
	$objventas=dato_taller('ta_objventas');
	$objmargenrec=dato_taller('ta_objmargenrec');
	$objeficacia=dato_taller('ta_objeficacia');
	$objproductividad=dato_taller('ta_objproductividad');
	$objrendimiento=dato_taller('ta_objrendimiento');
//}

$eficaciaCurrent = empty($eficacia_stats)?'0':round($eficacia_stats[0]);
$eficaciaAvg = empty($eficacia_stats)?'0':round($eficacia_stats[1]);
$eficaciaTrg = $objeficacia==0?80:moneda_puntocoma($objeficacia);

$margenCurrent = empty($margenrec)?'0':round($margenrec[0]);
$margenAvg = empty($margenrec)?'0':round($margenrec[1]);
$margenTrg = $objmargenrec==0?25:moneda_puntocoma($objmargenrec);
//echo secure_md5('123456');
?>
<div class="row row-cols-1 row-cols-md-2 g-3 mt-1">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <h3 class="card-title d-flex align-items-center gap-2 m-0">
                    Cálculo coste hora
                </h3>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-start justify-content-between">
                    <div class="col col-12 col-sm-4 d-flex flex-column align-items-center justify-content-between">
                        <span class="fz-13px fw-medium d-block mb-1">Precio medio MO</span>
                        <h3 class="h6 mb-1 fs-5 mb-5"><?=moneda_puntocoma($precio_medio_mo,2).' €'?></h3>
                    </div>
                    <div class="col col-12 col-sm-4 d-flex flex-column align-items-center justify-content-between">
                        <span class="fz-13px fw-medium d-block mb-1">Coste real</span>
                        <h3 class="h6 mb-1 fs-5 mb-5"><?=moneda_puntocoma($coste_hora_real,2).' €'?></h3>
                    </div>
                    <div class="col col-12 col-sm-4 d-flex flex-column align-items-center justify-content-between">
                        <span class="fz-13px fw-medium d-block mb-1">Coste teórico</span>
                        <h3 class="h6 mb-1 fs-5 mb-5"><?=moneda_puntocoma($coste_hora_teorico,2).' €'?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex align-items-center justify-content-center">
                        <div class="p-px-2 pr-px-10 border rounded-pill d-inline-flex align-items-center gap-2">
                            <span class="bg-label-<?=$precio_medio_mo>=$coste_hora_real?'success':'danger'?> px-px-8 py-px-1 rounded-pill d-inline-flex align-items-center gap-1 fz-16px fw-medium">
                                <i class="fa fa-arrow-<?=$precio_medio_mo>=$coste_hora_real?'up':'down'?>"></i>
                                <?=moneda_puntocoma(($precio_medio_mo-$coste_hora_real),2).' €'?>
                            </span>
                            <span class="fz-14px fw-medium">
                                Diferencia
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <h3 class="card-title d-flex align-items-center gap-2 m-0">
                    Horas potenciales vs perdidas
                </h3>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-start justify-content-between">
                    <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                        <span class="fz-13px fw-medium d-block mb-1">Horas potenciales</span>
                        <h3 class="h6 mb-1 fs-5 mb-5"><?=$horaspotenciales.' h/año'?></h3>
                    </div>
                    <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                        <span class="fz-13px fw-medium d-block mb-1">Horas perdidas</span>
                        <h3 class="h6 mb-1 fs-5 mb-5"><?=$horasimproductivas>0 ? $horasimproductivas.' h/año':'---'?></h3>
                    </div>
                </div>
                <div class="row<?=$horasimproductivas>0 ? '':' d-none'?> d-flex align-items-center justify-content-center">
                    <div class="col col-12 col-md-10 d-flex align-items-center justify-content-center">
                        <div class="p-px-2 border rounded-pill d-inline-flex align-items-center justify-content-center">
                            <span class="bg-label-warning px-px-8 py-px-1 rounded-pill d-inline-flex align-items-center justify-content-center fz-16px fw-medium">
                                <i class="fa fa-triangle-exclamation me-2"></i>
                                El taller ha dejado de facturar <?=number_format($horasimproductivas*$precio_medio_mo,2,',','.')?> € de mano de obra.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BLOQUE VENTAS MO PIEZAS -->
<div class="row g-3 mt-1">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title d-flex align-items-center m-0">
                            Ventas MO y piezas
                        </h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_ventas" id="descarga_informe_ventas" class="w-100 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <span class="fs_12 me-2 text-nowrap">Descargar informe</span>

                            <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_ventas" />
                            <select name="st_ventas" id="st_ventas" class="form-select form-select-sm w-auto">
                                <?php foreach($anhos as $anho){?>
                                    <option value="<?=$anho->da_ano?>"><?=$anho->da_ano?></option>
                                <?php }?>
                            </select>
                            <button type="submit" title="Descargar" class="btn btn-sm btn-secondary form-control-sm">
                                <i class=" fa fa-download"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="row d-flex align-items-start justify-content-between">
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <span class="fz-13px fw-medium d-block mb-1">Último mes</span>
                                <h3 class="h6 mb-1 fs-5 mb-5 text-<?=empty($ventas)||$ventas[0]>=$objventas?'success':'danger'?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[0]).' &euro;'?></h3>
                            </div>
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <span class="fz-13px fw-medium d-block mb-1">Media 3 meses</span>
                                <h3 class="h6 mb-1 fs-5 mb-5 text-<?=empty($ventas)||$ventas[1]>=$objventas?'success':'danger'?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[1]).' &euro;'?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center justify-content-center">
                                <div class="p-px-2 pr-px-10 border rounded-pill d-inline-flex align-items-center gap-2">
                                        <span class="bg-label-<?=empty($ventas)||$ventas[0]>=$ventas[1]?'success':'danger'?> px-px-8 py-px-1 rounded-pill d-inline-flex align-items-center gap-1 fz-16px fw-medium">
                                            <i class="fa fa-arrow-<?=empty($ventas)||$ventas[0]>=$ventas[1]?'up':'down'?>"></i>
                                            <?=empty($ventas)?'- - -':moneda_puntocoma($ventas[0]-$ventas[1]).' €'?>
                                        </span>
                                    <span class="fz-14px fw-medium">
                                            Incremento
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="stats_ventas" class="d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLOQUE VENTAS MO PIEZAS -->
<!-- BLOQUE EFICACIA -->
<div class="row g-3 mt-1">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title d-flex align-items-center m-0">
                            Eficacia/Productividad
                        </h3>
                        <span class="fs_12 text-secondary">(horas facturadas/horas presencia)</span>
                    </div>
                    <div class="col-12 col-sm-6">
                        <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_eficacia" id="descarga_informe_eficacia" class="w-100 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <span class="fs_12 me-2 text-nowrap">Descargar informe</span>

                            <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_eficacia" />
                            <select name="st_eficacia" id="st_eficacia" class="form-select form-select-sm w-auto">
                                <?php foreach($anhos as $anho){?>
                                    <option value="<?=$anho->da_ano?>"><?=$anho->da_ano?></option>
                                <?php }?>
                            </select>
                            <button type="submit" title="Descargar" class="btn btn-sm btn-secondary form-control-sm">
                                <i class=" fa fa-download"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="row d-flex align-items-start justify-content-between">
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <analog-gauge value="<?=$eficaciaCurrent?>" suffix="%" label="Último mes" min="0" max="100" min-label="Baja" max-label="Alta" class="gauge_eficacia" values="0%,20%,40%,60%,80%,100%"></analog-gauge>
                            </div>
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <analog-gauge value="<?=$eficaciaAvg?>" suffix="%" label="Media 6 meses" min="0" max="100" min-label="Baja" max-label="Alta" class="gauge_eficacia" values="0%,20%,40%,60%,80%,100%"></analog-gauge>
                            </div>
                            <?php $analogGaugeRange = 190;?>
                            <style>
                                .gauge_eficacia {
                                    --analog-gauge-range: <?=$analogGaugeRange?>deg;
                                    --analog-gauge-bdw: 15cqi;
                                    --analog-gauge-bg: red, orange, yellow, lightgreen, green <?=(int) $eficaciaTrg*$analogGaugeRange/100?>deg, green var(--analog-gauge-range), #0000 0 var(--analog-gauge-range);
                                    --analog-gauge-label-ps: center center;
                                    --analog-gauge-segments: 10;
                                }
                            </style>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center justify-content-center">
                                <div class="p-px-2 pr-px-10 border rounded-pill d-inline-flex align-items-center gap-2">
                                        <span class="bg-label-<?=$eficaciaCurrent>=$eficaciaTrg?'success':'danger'?> px-px-8 py-px-1 rounded-pill d-inline-flex align-items-center gap-1 fz-16px fw-medium">
                                            <i class="fa fa-arrow-<?=$eficaciaCurrent>=$eficaciaTrg?'up':'down'?>"></i>
                                            <?=$eficaciaTrg.' %'?>
                                        </span>
                                    <span class="fz-14px fw-medium">
                                            Objetivo
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="stats_eficacia" class="d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLOQUE EFICACIA -->
<!-- BLOQUE MARGEN VENTA PIEZAS -->
<div class="row g-3 mt-1">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title d-flex align-items-center m-0">
                            Margen de venta de piezas
                        </h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_margen" id="descarga_informe_margen" class="w-100 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <span class="fs_12 me-2 text-nowrap">Descargar informe</span>

                            <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_margen" />
                            <select name="st_margen" id="st_margen" class="form-select form-select-sm w-auto">
                                <?php foreach($anhos as $anho){?>
                                    <option value="<?=$anho->da_ano?>"><?=$anho->da_ano?></option>
                                <?php }?>
                            </select>
                            <button type="submit" title="Descargar" class="btn btn-sm btn-secondary form-control-sm">
                                <i class=" fa fa-download"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="row d-flex align-items-start justify-content-between">
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <analog-gauge value="<?=$margenCurrent?>" suffix="%" label="Último mes" min="0" max="100" min-label="Baja" max-label="Alta" class="gauge_margenrec" values="0%,20%,40%,60%,80%,100%"></analog-gauge>
                            </div>
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <analog-gauge value="<?=$margenAvg?>" suffix="%" label="Media 6 meses" min="0" max="100" min-label="Baja" max-label="Alta" class="gauge_margenrec" values="0%,20%,40%,60%,80%,100%"></analog-gauge>
                            </div>
                            <?php $analogGaugeRange = 190;?>
                            <style>
                                .gauge_margenrec {
                                    --analog-gauge-range: <?=$analogGaugeRange?>deg;
                                    --analog-gauge-bdw: 15cqi;
                                    --analog-gauge-bg: red, orange, yellow, lightgreen, green <?=(int)$margenTrg*$analogGaugeRange/100?>deg, green var(--analog-gauge-range), #0000 0 var(--analog-gauge-range);
                                    --analog-gauge-label-ps: center center;
                                    --analog-gauge-segments: 10;
                                }
                            </style>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center justify-content-center">
                                <div class="p-px-2 pr-px-10 border rounded-pill d-inline-flex align-items-center gap-2">
                                        <span class="bg-label-<?=$margenCurrent>=$margenTrg?'success':'danger'?> px-px-8 py-px-1 rounded-pill d-inline-flex align-items-center gap-1 fz-16px fw-medium">
                                            <i class="fa fa-arrow-<?=$margenCurrent>=$margenTrg?'up':'down'?>"></i>
                                            <?=$margenTrg.' %'?>
                                        </span>
                                    <span class="fz-14px fw-medium">
                                            Objetivo
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="stats_margenrec" class="d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLOQUE MARGEN VENTA PIEZAS -->
<!-- BLOQUE INGRESOS POR ENTRADA -->
<div class="row g-3 mt-1">
    <div class="col">
        <div class="card shadow-custom rounded-custom">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="col-12">
                        <h3 class="card-title d-flex align-items-center m-0">
                            Ticket medio
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-body p-6 position-relative z-1">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="row d-flex align-items-start justify-content-between">
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <span class="fz-13px fw-medium d-block mb-1">Último mes</span>
                                <h3 class="h6 mb-1 fs-5 mb-5 text-<?=empty($euro_entradas)?'danger':'success'?>"><?=empty($euro_entradas)?'- - -':moneda_puntocoma($euro_entradas[0]).' &euro;'?></h3>
                            </div>
                            <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-between">
                                <span class="fz-13px fw-medium d-block mb-1">Media 3 meses</span>
                                <h3 class="h6 mb-1 fs-5 mb-5 text-<?=empty($euro_entradas)?'danger':'success'?>"><?=empty($euro_entradas)?'- - -':moneda_puntocoma($euro_entradas[1]).' &euro;'?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center justify-content-center">
                                <div class="p-px-2 pr-px-10 border rounded-pill d-inline-flex align-items-center gap-2">
                                        <span class="bg-label-<?=empty($euro_entradas)||$euro_entradas[1]>$euro_entradas[0]?'danger':'success'?> px-px-8 py-px-1 rounded-pill d-inline-flex align-items-center gap-1 fz-16px fw-medium">
                                            <i class="fa fa-arrow-<?=empty($euro_entradas)||$euro_entradas[1]>$euro_entradas[0]?'down':'up'?>"></i>
                                            <?=empty($euro_entradas)?'- - -':moneda_puntocoma($euro_entradas[0]-$euro_entradas[1]).' €'?>
                                        </span>
                                    <span class="fz-14px fw-medium">
                                            Variación
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="stats_pvpentrada" class="d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLOQUE INGRESOS POR ENTRADA -->