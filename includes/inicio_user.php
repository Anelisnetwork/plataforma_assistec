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
<div class="cont_seccion">
    <div class="linea_estats" style="display: flex; align-items: center; flex-flow: row nowrap; justify-content: space-around;">
        <table cellpadding="4" cellspacing="0" border="1" style="box-sizing: border-box; border-collapse: collapse">
            <tr style="background-color: #DDD">
                <td colspan="4" align="center" class="oswald">CÁLCULO COSTE HORA</td>
            </tr>
            <tr>
                <td align="center" width="120" style="font-weight: bold">Precio Medio MO</td>
                <td align="center" width="120" style="font-weight: bold">Coste Real</td>
                <td align="center" width="120" style="font-weight: bold">Diferencia</td>
                <td align="center" width="120" style="font-weight: bold">Coste Teórico</td>
            </tr>
            <tr>
                <td align="center"><?=moneda_puntocoma($precio_medio_mo,2).' €'?></td>
                <td align="center"><?=moneda_puntocoma($coste_hora_real,2).' €'?></td>
                <td align="center" class="texto_<?=$precio_medio_mo>=$coste_hora_real?'v':'r'?>"><?=moneda_puntocoma(($precio_medio_mo-$coste_hora_real),2).' €'?></td>
                <td align="center"><?=moneda_puntocoma($coste_hora_teorico,2).' €'?></td>
            </tr>
        </table>

        <table cellpadding="4" cellspacing="0" border="1" style="box-sizing: border-box; border-collapse: collapse">
            <tr style="background-color: #DDD">
                <td align="center" class="oswald">HORAS POTENCIALES<span style="font-size: 10px; color: #333">(Beta) </span></td>
                <td align="center" class="oswald">HORAS PERDIDAS<span style="font-size: 10px; color: #333">(Beta) </span></td>
            </tr>
            <tr>
                <td align="center" style="height: 41px"><h3 style="margin: 0"><?=$horaspotenciales.' h/año'?></h3></td>
                <td align="center" style="height: 41px"><h3 style="margin: 0; color: #E2001A"><?=$horasimproductivas>0 ? $horasimproductivas.' h/año':'---'?></h3></td>
            </tr>
        </table>
    </div>

    <br clear="all"><br clear="all">

    <div style="display: flex; align-items: center; flex-flow: row nowrap; justify-content: center; color: #E2001A">
        <span style="font-size: 10px; color: #333">(Beta) </span>El taller ha dejado de facturar <?=number_format(($horaspotenciales-$hfacturadas)*$coste_hora_teorico,2,',','.')?> € de mano de obra.<span style="font-size: 10px; color: #333"> (Beta) </span>
    </div>

	<div class="linea_estats">
    	<div class="cuadro_res">
        	<div class="titulo">
            	<span class="oswald">Resultado ventas MO y piezas</span>
            </div>
            <div class="st_datos">
            	<div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">&Uacute;ltimo mes</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($ventas)?'v':($ventas[0]>=$objventas?'v':'r')?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[0]).' &euro;'?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Media 3 meses</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($ventas)?'v':($ventas[1]>=$objventas?'v':'r')?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[1]).' &euro;'?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span title="Objetivo marcado" class="faq oswald">Incremento</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($ventas)?'v':($ventas[0]>=$ventas[1]?'v':'r')?>"><?=empty($ventas)?'- - -':moneda_puntocoma($ventas[0]-$ventas[1]).' &euro;'?></span>
                    </div>
                </div>
            </div>
            <div class="st_pie">
                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_ventas" id="descarga_informe_ventas">
                	<span class="fs_12">Descargar informe</span>
                    <input type="image" src="<?=_RAIZ_?>imagenes/descargar.png" style="float:right; margin-left:15px; width:15px; height:15px" title="Descargar" />
                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_ventas" />
                    <select name="st_ventas" id="st_ventas">
                    <?php foreach($anhos as $anho){?>
                        <option value="<?=$anho->da_ano?>"><?=$anho->da_ano?></option>
                    <?php }?>
                    </select>
                </form>
            </div>
        </div>
        
        <div id="stats_ventas" class="stat_inicio">
        <script>
			$(document).ready(function() {
				drawChart_columnas('datos_stats', 'ventas_mo_rec%%0', 'Ventas MO y piezas (6 meses)', 'stats_ventas');
			})
        </script>
        </div>
    </div>
    
    
    <div class="linea_estats">
    	<div class="cuadro_res">
        	<div class="titulo">
            	<span class="oswald">Eficacia:</span>
            </div>
            <div class="st_datos">
            	<div class="st_datos" style="padding:0px; text-align:center">
                	<span class="ubuntu fs_12 texto_r">(horas facturadas/horas presencia)</span>
                </div>
            	<div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">&Uacute;ltimo mes</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($eficacia_stats)?'- - -':($eficacia_stats[0]>=$objeficacia?'v':'r')?>"><?=empty($eficacia_stats)?'---':(moneda_puntocoma($eficacia_stats[0]).' %')?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Media 3 meses</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($eficacia_stats)?'- - -':($eficacia_stats[1]>=$objeficacia?'v':'r')?>"><?=empty($eficacia_stats)?'---':(moneda_puntocoma($eficacia_stats[1]).' %')?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Objetivo</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_v"><?=$objeficacia==0?'- - -':moneda_puntocoma($objeficacia).' %'?></span>
                    </div>
                </div>
            </div>
            <div class="st_pie">
                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_eficacia" id="descarga_informe_eficacia">
                	<span class="fs_12">Descargar informe</span>
                    <input type="image" src="<?=_RAIZ_?>imagenes/descargar.png" style="float:right; margin-left:15px; width:15px; height:15px" title="Descargar" />
                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_eficacia" />
                    <select name="st_eficacia" id="st_eficacia">
                    <?php foreach($anhos as $anho){?>
                        <option value="<?=$anho->da_ano?>"><?=$anho->da_ano?></option>
                    <?php }?>
                    </select>
                </form>
            </div>
        </div>
        
        <div id="stats_eficacia" class="stat_inicio">
        <script>
			$(document).ready(function() {
				drawChart_columnas('datos_stats', 'eficacia%%0', 'Eficacia (6 meses)', 'stats_eficacia');
			})
        </script>
        </div>
    </div>
    
    <!--<div class="linea_estats">
    	<div class="cuadro_res">
        	<div class="titulo">
            	<span class="oswald">Productividad:</span>
            </div>
            <div class="st_datos">
            	<div class="st_datos" style="padding:0px; text-align:center">
                	<span class="ubuntu fs_12 texto_r">(horas trabajadas/horas presencia)</span>
                </div>
            	<div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">&Uacute;ltimo mes</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?/*=empty($productividad_stats)?'- - -':($productividad_stats[0]>=$objproductividad?'v':'r')*/?>"><?/*=empty($productividad_stats)?'---':(moneda_puntocoma($productividad_stats[0]).' %')*/?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Media 3 meses</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?/*=empty($productividad_stats)?'- - -':($productividad_stats[1]>=$objproductividad?'v':'r')*/?>"><?/*=empty($productividad_stats)?'---':(moneda_puntocoma($productividad_stats[1]).' %')*/?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Objetivo</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_v"><?/*=$objproductividad==0?'- - -':moneda_puntocoma($objproductividad).' %'*/?></span>
                    </div>
                </div>
            </div>
            <div class="st_pie">
                <form action="<?/*=_RAIZ_*/?>descarga_excel/" method="post" name="descarga_informe_productividad" id="descarga_informe_productividad">
                	<span class="fs_12">Descargar informe</span>
                    <input type="image" src="<?/*=_RAIZ_*/?>imagenes/descargar.png" style="float:right; margin-left:15px; width:15px; height:15px" title="Descargar" />
                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_productividad" />
                    <select name="st_productividad" id="st_productividad">
                    <?php /*foreach($anhos as $anho){*/?>
                        <option value="<?/*=$anho->da_ano*/?>"><?/*=$anho->da_ano*/?></option>
                    <?php /*}*/?>
                    </select>
                </form>
            </div>
        </div>
        
        <div id="stats_productividad" class="stat_inicio">
        <script>
			$(document).ready(function() {
				drawChart_columnas('datos_stats', 'productividad%%0', 'Productividad (6 meses)', 'stats_productividad');
			})
        </script>
        </div>
    </div>-->
    
    
    <!--<div class="linea_estats">
    	<div class="cuadro_res">
        	<div class="titulo">
            	<span class="oswald">Rendimiento:</span>
            </div>
            <div class="st_datos">
            	<div class="st_datos" style="padding:0px; text-align:center">
                	<span class="ubuntu fs_12 texto_r">(horas facturadas/horas fichadas OR)</span>
                </div>
            	<div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">&Uacute;ltimo mes</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?/*=empty($rendimiento_stats)?'- - -':($rendimiento_stats[0]>=$objrendimiento?'v':'r')*/?>"><?/*=empty($rendimiento_stats)?'---':(moneda_puntocoma($rendimiento_stats[0]).' %')*/?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Media 3 meses</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?/*=empty($rendimiento_stats)?'- - -':($rendimiento_stats[1]>=$objrendimiento?'v':'r')*/?>"><?/*=empty($rendimiento_stats)?'---':(moneda_puntocoma($rendimiento_stats[1]).' %')*/?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Objetivo</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_v"><?/*=$objrendimiento==0?'- - -':moneda_puntocoma($objrendimiento).' %'*/?></span>
                    </div>
                </div>
            </div>
            <div class="st_pie">
                <form action="<?/*=_RAIZ_*/?>descarga_excel/" method="post" name="descarga_informe_rendimiento" id="descarga_informe_rendimiento">
                	<span class="fs_12">Descargar informe</span>
                    <input type="image" src="<?/*=_RAIZ_*/?>imagenes/descargar.png" style="float:right; margin-left:15px; width:15px; height:15px" title="Descargar" />
                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_rendimiento" />
                    <select name="st_rendimiento" id="st_rendimiento">
                    <?php /*foreach($anhos as $anho){*/?>
                        <option value="<?/*=$anho->da_ano*/?>"><?/*=$anho->da_ano*/?></option>
                    <?php /*}*/?>
                    </select>
                </form>
            </div>
        </div>
        
        <div id="stats_rendimiento" class="stat_inicio">
        <script>
			$(document).ready(function() {
				drawChart_columnas('datos_stats', 'rendimiento%%0', 'Rendimiento (6 meses)', 'stats_rendimiento');
			})
        </script>
        </div>
    </div>-->
    
    
    <div class="linea_estats">
    	<div class="cuadro_res">
        	<div class="titulo">
            	<span class="oswald">Margen de la venta de piezas</span>
            </div>
            <div class="st_datos">
            	<div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">&Uacute;ltimo mes</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($margenrec)?'- - -':($margenrec[0]>=$objmargenrec?'v':'r')?>"><?=empty($margenrec)?'---':(moneda_puntocoma($margenrec[0]).' %')?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Media 3 meses</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($margenrec)?'- - -':($margenrec[1]>=$objmargenrec?'v':'r')?>"><?=empty($margenrec)?'---':(moneda_puntocoma($margenrec[1]).' %')?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Objetivo</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_v"><?=$objmargenrec==0?'- - -':moneda_puntocoma($objmargenrec).' %'?></span>
                    </div>
                </div>
            </div>
            <div class="st_pie">
                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="descarga_informe_margen" id="descarga_informe_margen">
                	<span class="fs_12">Descargar informe</span>
                    <input type="image" src="<?=_RAIZ_?>imagenes/descargar.png" style="float:right; margin-left:15px; width:15px; height:15px" title="Descargar" />
                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_margen" />
                    <select name="st_margen" id="st_margen">
                    <?php foreach($anhos as $anho){?>
                        <option value="<?=$anho->da_ano?>"><?=$anho->da_ano?></option>
                    <?php }?>
                    </select>
                </form>
            </div>
        </div>
        
        <div id="stats_margenrec" class="stat_inicio">
        <script>
			$(document).ready(function() {
				drawChart_columnas('datos_stats', 'margen_rec%%0', 'Margen de la venta de piezas (6 meses)', 'stats_margenrec');
			})
        </script>
        </div>
    </div>

    <div class="linea_estats">
        <div class="cuadro_res">
            <div class="titulo">
                <span class="oswald">€ por entrada al taller</span>
            </div>
            <div class="st_datos">
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">&Uacute;ltimo mes</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($euro_entradas)?'r':'v'?>"><?=empty($euro_entradas)?'---':moneda_puntocoma($euro_entradas[0],2).' €'?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Media 3 meses</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($euro_entradas)?'r':'v'?>"><?=empty($euro_entradas)?'---':moneda_puntocoma($euro_entradas[1],2).' €'?></span>
                    </div>
                </div>
                <div class="st_dato">
                    <div class="st_it">
                        <span class="oswald">Variación</span>
                    </div>
                    <div class="st_it">
                        <span class="oswald texto_<?=empty($euro_entradas)?'r':($euro_entradas[0]-$euro_entradas[1]<0?'r':'v')?>"><?=empty($euro_entradas)?'- - -':moneda_puntocoma(($euro_entradas[0]-$euro_entradas[1]),2).' €'?></span>
                    </div>
                </div>
            </div>
            <!--<div class="st_pie">
                <form action="<?/*=_RAIZ_*/?>descarga_excel/" method="post" name="descarga_informe_pvpentrada" id="descarga_informe_pvpentrada">
                    <span class="fs_12">Descargar informe</span>
                    <input type="image" src="<?/*=_RAIZ_*/?>imagenes/descargar.png" style="float:right; margin-left:15px; width:15px; height:15px" title="Descargar" />
                    <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="informe_pvpentrada" />
                    <select name="st_pvpentrada" id="st_pvpentrada">
                        <?php /*foreach($anhos as $anho){*/?>
                            <option value="<?/*=$anho->da_ano*/?>"><?/*=$anho->da_ano*/?></option>
                        <?php /*}*/?>
                    </select>
                </form>
            </div>-->
        </div>

        <div id="stats_pvpentrada" class="stat_inicio">
            <script>
                $(document).ready(function() {
                    drawChart_linear('datos_stats', 'pvpentrada%%0', '€ por entrada al taller (6 meses)', 'stats_pvpentrada');
                })
            </script>
        </div>
    </div>
    
    
    
</div>