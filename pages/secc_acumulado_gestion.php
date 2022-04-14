		<?php
		$tiempo_medio_cliente=$datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller'];
		$horas_productivas=$datos_acumulados['sum_hprod']*0.9;//Un 10% de tiempo no productivo
		$capacidad_teorica=$horas_productivas/$tiempo_medio_cliente;
		$entradas_dia=round($datos_acumulados['entradastaller']/$datos_acumulados['diaslaborables'],2);
		
		//echo $tiempo_medio_cliente.'<br>'.$horas_productivas.'<br>'.$capacidad_teorica.'<br>'.$entradas_dia.'<br>'.$datos_acumulados['diaslaborables'].'<br>';
		?>
        <div id="informemes" class="div_mostrarocultar colizq" style="float:left;">	
			<div class="linea">
            	<span class="oswald fs_16">Informe de gesti&oacute;n acumulado del a&ntilde;o <?=$anho_acumulado?></span>
            </div>
            
            <div class="linea">
                <label class="ancho">Productividad:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$datos_acumulados['productividad']<$datos_acumulados['objproductividad']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['productividad'])?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Eficacia:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$datos_acumulados['eficacia']<$datos_acumulados['objeficacia']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['eficacia'])?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Rendimiento:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$datos_acumulados['rendimiento']<$datos_acumulados['objrendimiento']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['rendimiento'])?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                	<span class="oswald fs_14 texto_<?=$datos_acumulados['porcentpr']<$datos_acumulados['objmargenrec']?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['porcentpr'])?> %</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">N&ordm; entradas:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=$entradas_dia?></span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Capacidad te&oacute;rica:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=round($capacidad_teorica)?></span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Desviaci&oacute;n:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$entradas_dia-$capacidad_teorica<0?'r':'v'?>"><?=round($entradas_dia-$capacidad_teorica)?></span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">% desviaci&oacute;n:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$entradas_dia-$capacidad_teorica<0?'r':'v'?>"><?=moneda_puntocoma(margen_sobre_coste($capacidad_teorica,$entradas_dia))?>%</span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Tiempo medio por entrada:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=faltan2($tiempo_medio_cliente*3600)?></span>
                </div>
            </div>

            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <div id="stats_acum_gest_3" class="stat_ratio">
                    <script>
                        $(document).ready(function() {
                            drawChart_columnas('datos_stats', 'acum_gest_3%%0%%<?=$anho_acumulado?>', 'Entradas al taller', 'stats_acum_gest_3');
                        })
                    </script>
                </div>
            </div>

            
            <!--<div class="linea">
                <label class="ancho">Fidelizaci&oacute;n de clientes:</label>
                <div class="dato">
                    <span class="oswald"><?/*=moneda_puntocoma($datos_acumulados['fidelizacion'])*/?> %</span>
                </div>
            </div>-->
            
		</div>
        <div class="colder_graf">
			<div id="stats_acum_gest_1" class="stat_ratio">
			<script>
                $(document).ready(function() {
                    drawChart_columnas_legend('datos_stats', 'acum_gest_1%%0%%<?=$anho_acumulado?>', 'Productividad / Eficacia / Rendimiento (%)', 'stats_acum_gest_1');
                })
            </script>
            </div>

            <div id="stats_acum_gest_2" class="stat_ratio" style="margin-top: 130px">
			<script>
                $(document).ready(function() {
                    drawChart_linear('datos_stats', 'acum_gest_2%%0%%<?=$anho_acumulado?>', 'Margen venta PR (%)', 'stats_acum_gest_2');
                })
            </script>
            </div>

		</div>