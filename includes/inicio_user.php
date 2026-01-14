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

//echo secure_md5('123456');
?>
<div class="d-flex flex-column align-items-start justify-content-start w-100 py-3 px-1 px-sm-3">
    <div class="w-100 d-flex flex-column flex-md-row justify-content-between align-items-start">
        <div class="col col-12 col-md-6 borde_gris rounded m-1">
            <div class="table-responsive">
                <table class="table table-sm mb-0" >
                    <thead class="text-center">
                    <tr class="">
                        <th colspan="4" class="oswald bg-grisl">CÁLCULO COSTE HORA</th>
                    </tr>
                    <tr class="align-middle">
                        <th class="fw-bold">Precio Medio MO</th>
                        <th class="fw-bold">Coste Real</th>
                        <th class="fw-bold">Diferencia</th>
                        <th class="fw-bold">Coste Teórico</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td><?=moneda_puntocoma($precio_medio_mo,2).' €'?></td>
                            <td><?=moneda_puntocoma($coste_hora_real,2).' €'?></td>
                            <td class="text-<?=$precio_medio_mo>=$coste_hora_real?'success':'danger'?>"><?=moneda_puntocoma(($precio_medio_mo-$coste_hora_real),2).' €'?></td>
                            <td><?=moneda_puntocoma($coste_hora_teorico,2).' €'?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col col-12 col-md-6 borde_gris rounded m-1">
            <div class="table-responsive">
                <table cellpadding="4" cellspacing="0" border="0" style="box-sizing: border-box; border-collapse: collapse" class="w-100">
                    <tr class="bg-grisl">
                        <td align="center" class="oswald">HORAS POTENCIALES<span style="font-size: 10px; color: #333">(Beta) </span></td>
                        <td align="center" class="oswald">HORAS PERDIDAS<span style="font-size: 10px; color: #333">(Beta) </span></td>
                    </tr>
                    <tr>
                        <td align="center" style="height: 41px"><h3 style="margin: 0"><?=$horaspotenciales.' h/año'?></h3></td>
                        <td align="center" style="height: 41px"><h3 style="margin: 0; color: #EF7F1F"><?=$horasimproductivas>0 ? $horasimproductivas.' h/año':'---'?></h3></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="w-100 d-flex align-items-center justify-content-center nowrap mb-5" style="color: #EF7F1F">
        <span style="font-size: 10px; color: #333">(Beta) </span>El taller ha dejado de facturar <?=number_format(($horaspotenciales-$hfacturadas)*$coste_hora_teorico,2,',','.')?> € de mano de obra.<span style="font-size: 10px; color: #333"> (Beta) </span>
    </div>

	<div class="w-100 d-flex flex-column flex-md-row align-items-start justify-content-between mb-3">
    	<div class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center borde_gris rounded mb-2 mx-md-1">
        	<div class="w-100 align-items-center justify-content-center text-center bg-grisl oswald py-2">
            	Resultado ventas MO y piezas
            </div>
            <div class="w-100 d-flex flex-row align-items-start justify-content-between nowrap my-3">
            	<div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    &Uacute;ltimo mes
                    <span class="text-<?=empty($ventas)?'success':($ventas[0]>=$objventas?'success':'danger')?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[0]).' &euro;'?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    Media 3 meses
                    <span class="text-<?=empty($ventas)?'success':($ventas[1]>=$objventas?'success':'danger')?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[1]).' &euro;'?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    <span title="Objetivo marcado" class="faq">Incremento</span>
                    <span class="text-<?=empty($ventas)?'success':($ventas[0]>=$ventas[1]?'success':'danger')?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[0]-$ventas[1]).' &euro;'?></span>
                </div>
            </div>
            <div class="w-100 d-flex align-items-center justify-content-around mb-3">
                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_ventas" id="descarga_informe_ventas" class="w-100 d-flex align-items-center justify-content-center">
                	<span class="fs_12 me-2">Descargar informe</span>

                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_ventas" />
                    <select name="st_ventas" id="st_ventas" class="form-control-sm me-2">
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
        
        <div id="stats_ventas" class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">
        <script>
			$(document).ready(function() {
                drawChart_columnas_upd('datos_stats', 'ventas_mo_rec%%0', 'Ventas MO y piezas (6 meses)', 'stats_ventas');
			})
        </script>
        </div>
    </div>


    <div class="w-100 d-flex flex-column flex-md-row align-items-start justify-content-between mb-3">
        <div class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center borde_gris rounded mb-2 mx-md-1">
            <div class="w-100 d-flex flex-column align-items-center justify-content-center text-center bg-grisl oswald py-2">
            	Eficacia:
                <span class="ubuntu fs_12 texto_r">(horas facturadas/horas presencia)</span>
            </div>
            <div class="w-100 d-flex flex-row align-items-start justify-content-between nowrap my-3">
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    &Uacute;ltimo mes
                    <span class="text-<?=empty($eficacia_stats)?'- - -':($eficacia_stats[0]>=$objeficacia?'success':'danger')?>"><?=empty($eficacia_stats)?'---':(moneda_puntocoma($eficacia_stats[0]).' %')?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    Media 3 meses
                    <span class="text-<?=empty($eficacia_stats)?'- - -':($eficacia_stats[1]>=$objeficacia?'success':'danger')?>"><?=empty($eficacia_stats)?'---':(moneda_puntocoma($eficacia_stats[1]).' %')?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    <span title="Objetivo marcado" class="faq">Objetivo</span>
                    <span class="text-success"><?=$objeficacia==0?'- - -':moneda_puntocoma($objeficacia).' %'?></span>
                </div>
            </div>
            <div class="w-100 d-flex align-items-center justify-content-around mb-3">
                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_eficacia" id="descarga_informe_eficacia" class="w-100 d-flex align-items-center justify-content-center">
                    <span class="fs_12 me-2">Descargar informe</span>

                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_eficacia" />
                    <select name="st_eficacia" id="st_eficacia" class="form-control-sm me-2">
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
        
        <div id="stats_eficacia" class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">
        <script>
			$(document).ready(function() {
				drawChart_columnas_upd('datos_stats', 'eficacia%%0', 'Eficacia (6 meses)', 'stats_eficacia');
			})
        </script>
        </div>
    </div>

    <div class="w-100 d-flex flex-column flex-md-row align-items-start justify-content-between mb-3">
        <div class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center borde_gris rounded mb-2 mx-md-1">
            <div class="w-100 d-flex flex-column align-items-center justify-content-center text-center bg-grisl oswald py-2">
                Margen de la venta de piezas:
            </div>
            <div class="w-100 d-flex flex-row align-items-start justify-content-between nowrap my-3">
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    &Uacute;ltimo mes
                    <span class="text-<?=empty($margenrec)?'- - -':($margenrec[0]>=$objmargenrec?'success':'danger')?>"><?=empty($margenrec)?'---':(moneda_puntocoma($margenrec[0]).' %')?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    Media 3 meses
                    <span class="text-<?=empty($margenrec)?'- - -':($margenrec[1]>=$objmargenrec?'success':'danger')?>"><?=empty($margenrec)?'---':(moneda_puntocoma($margenrec[1]).' %')?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    <span title="Objetivo marcado" class="faq">Objetivo</span>
                    <span class="text-success"><?=$objmargenrec==0?'- - -':moneda_puntocoma($objmargenrec).' %'?></span>
                </div>
            </div>
            <div class="w-100 d-flex align-items-center justify-content-around mb-3">
                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_margen" id="descarga_informe_margen" class="w-100 d-flex align-items-center justify-content-center">
                    <span class="fs_12 me-2">Descargar informe</span>

                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_margen" />
                    <select name="st_eficacia" id="st_eficacia" class="form-control-sm me-2">
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

        <div id="stats_margenrec" class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">
            <script>
                $(document).ready(function() {
                    drawChart_columnas_upd('datos_stats', 'margen_rec%%0', 'Margen de la venta de piezas (6 meses)', 'stats_margenrec');
                })
            </script>
        </div>
    </div>

    <div class="w-100 d-flex flex-column flex-md-row align-items-start justify-content-between mb-3">
        <div class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center borde_gris rounded mb-2 mx-md-1">
            <div class="w-100 d-flex flex-column align-items-center justify-content-center text-center bg-grisl oswald py-2">
                € por entrada al taller:
            </div>
            <div class="w-100 d-flex flex-row align-items-start justify-content-between nowrap my-3">
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    &Uacute;ltimo mes
                    <span class="text-<?=empty($euro_entradas)?'danger':'success'?>"><?=empty($euro_entradas)?'---':(moneda_puntocoma($euro_entradas[0], 2).' €')?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    Media 3 meses
                    <span class="text-<?=empty($euro_entradas)?'danger':'success'?>"><?=empty($euro_entradas)?'---':(moneda_puntocoma($euro_entradas[1], 2).' €')?></span>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center oswald">
                    <span title="Objetivo marcado" class="faq">Variación</span>
                    <span class="text-<?=empty($euro_entradas)?'danger':($euro_entradas[0]-$euro_entradas[1]<0?'danger':'success')?>"><?=empty($euro_entradas)?'- - -':moneda_puntocoma(($euro_entradas[0]-$euro_entradas[1]),2).' €'?></span>
                </div>
            </div>
        </div>

        <div id="stats_pvpentrada" class="col-12 col-md-6 col-xl-5 d-flex flex-column align-items-start justify-content-center mb-2 mx-md-1">
            <script>
                $(document).ready(function() {
                    drawChart_columnas_upd('datos_stats', 'pvpentrada%%0', '€ por entrada al taller (6 meses)', 'stats_pvpentrada');
                })
            </script>
        </div>
    </div>
</div>