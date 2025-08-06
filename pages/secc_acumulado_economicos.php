        <?php
        //echo '<pre>'; var_dump($datos_acumulados); echo '</pre>';
        $coste_hora_teorico=round($datos_acumulados['coste_hora_teorico'],2);
        $coste_hora_real=round($datos_acumulados['coste_hora_real'],2);
		/*$coste_hora_teorico=$datos_acumulados['horaspotenciales']==0?0:(($datos_acumulados['costeestr']/$datos_acumulados['nmeses']*12)+($datos_acumulados['costepers']/$datos_acumulados['nmeses']*12))/$datos_acumulados['horaspotenciales'];
		$coste_hora_real=$coste_hora_teorico*round($datos_acumulados['eficacia'])/100;*/
		//echo round($datos_acumulados['eficacia']);
		?>
        <div id="informemes" class="div_mostrarocultar colizq" style="float:left;">
            <?php if(isset($anho_acumulado)){?>
			<div class="linea">
            	<span class="oswald fs_16">Informe econ&oacute;mico acumulado del a&ntilde;o <?=$anho_acumulado?></span>
            </div>
            <?php }?>
            
            <div class="linea">
                <label class="ancho fs_16">Total facturado:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($datos_acumulados['total_facturado'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe venta MO:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventamo'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventapr'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Coste venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costeprov'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14<?=$datos_acumulados['margenpr']<0?' texto_r':''?>"><?=moneda_puntocoma($datos_acumulados['margenpr'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">% Margen venta PR:</label>
                <div class="dato">
                    <span class="oswald fs_14<?=$datos_acumulados['porcentpr']<0?' texto_r':''?>"><?=moneda_puntocoma($datos_acumulados['porcentpr'])?> %</span>
                </div>
            </div>

            <div class="linea">
                <label class="ancho">Coste otras compras:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costeotro'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Coste personal:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costepers'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Gastos estructura:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['costeestr'])?> &euro;</span>
                </div>
            </div>
            
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Precio medio hora:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['hfacturadas'] == 0 ? 0 : $datos_acumulados['ventamo']/$datos_acumulados['hfacturadas'])?> &euro;</span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Coste hora:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($coste_hora_real)?> &euro;</span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">Margen:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$datos_acumulados['hfacturadas'] == 0 || ($datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']-$coste_hora_real)<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['hfacturadas'] == 0 ? 0 :$datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']-$coste_hora_real)?> &euro;</span>
                </div>
            </div>
            <div class="linea" style="background-color:#f5f5f5; margin:0px">
                <label class="ancho">% beneficio:</label>
                <div class="dato">
                    <span class="oswald fs_14 texto_<?=$datos_acumulados['hfacturadas'] == 0 || ($datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']-$coste_hora_real)<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['hfacturadas'] == 0 ? 0 :margen_sobre_coste($coste_hora_real,$datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']))?>%</span>
                </div>
            </div>
            
            <div class="linea">
                <label class="ancho fs_16">Total ingresos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($datos_acumulados['total_ingresos'])?> &euro;</span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho fs_16">Total gastos:</label>
                <div class="dato">
                    <span class="oswald fs_16"><?=moneda_puntocoma($datos_acumulados['total_gastos'])?> &euro;</span>
                </div>
            </div>
            
            <div class="linea" style="height:1px; background-color:#555"></div>
            
            <div class="linea">
                <label class="ancho fs_16">Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$datos_acumulados['margenbruto']<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['margenbruto'])?> &euro;</span>
                </div>
            </div>
            
            <div class="linea">
                <label class="ancho fs_16">% Margen bruto:</label>
                <div class="dato">
                    <span class="oswald fs_16 texto_<?=$datos_acumulados['porcmargenbruto']<0?'r':'v'?>"><?=moneda_puntocoma($datos_acumulados['porcmargenbruto'])?> %</span>
                </div>
            </div>
            
		</div>
        <?php   if(isset($anho_acumulado)){?>
        <div class="colder_graf">
			<div id="stats_acum_econ_1" class="stat_ratio">
			<script>
                $(document).ready(function() {
                    drawChart_columnas_legend('datos_stats', 'acum_econ_1%%0%%<?=$anho_acumulado?>', 'Ingresos Vs Costes', 'stats_acum_econ_1');
                })
            </script>
            </div>
            <div id="stats_acum_econ_2" class="stat_ratio">
			<script>
                $(document).ready(function() {
                    drawChart_columnas_legend('datos_stats', 'acum_econ_2%%0%%<?=$anho_acumulado?>', 'Venta MO y PR y coste PR', 'stats_acum_econ_2');
                })
            </script>
            </div>
		</div>
        <?php   }?>