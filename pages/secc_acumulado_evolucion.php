		<?php
		//echo $tiempo_medio_cliente.'<br>'.$horas_productivas.'<br>'.$capacidad_teorica.'<br>'.$entradas_dia.'<br>'.$datos_acumulados['diaslaborables'].'<br>';
		?>
        <div id="informemes" class="div_mostrarocultar colizq" style="float:left;">
			<div class="linea">
            	<span class="oswald fs_18">Informe de evoluci&oacute;n acumulado del a&ntilde;o <?=$anho_acumulado?></span>
            </div>
            <div class="linea">
            	<span class="fs_14">Horas acumuladas <?=moneda_puntocoma($datos_acumulados['hfacturadas'])?></span>
            </div>

            <div class="linea" style="margin-top: 25px">
                <label class="ancho texto_r"><strong>CONCEPTO</strong></label>
                <div class="dato">
                    <span class="oswald fs_14 texto_r">Acumulado</span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14 texto_r">Media</span>
                </div>
            </div>

            <div class="linea">
                <label class="ancho">Importe medio por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['mediaor'])?> &euro;</span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?='---'?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe MO por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['mediamo'])?> &euro;</span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?='---'?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">% MO por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma(porcentaje_($datos_acumulados['mediamo'],$datos_acumulados['mediaor']))?>%</span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?='---'?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Importe PR por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['mediapr'])?> &euro;</span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?='---'?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">% PR por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma(porcentaje_($datos_acumulados['mediapr'],$datos_acumulados['mediaor']))?>%</span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?='---'?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Horas facturadas x operario:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['hfacturadas']/$porcentajes[4])?></span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['hfacturadas']/$datos_acumulados['nmeses']/$porcentajes[4])?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">€ MO x operario:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventamo']/$porcentajes[4])?></span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventamo']/$porcentajes[4]/$datos_acumulados['nmeses'])?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">€ PR x operario:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventapr']/$porcentajes[4])?></span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventapr']/$porcentajes[4]/$datos_acumulados['nmeses'])?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Total facturado x operario:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['ventamo']/$porcentajes[4]+$datos_acumulados['ventapr']/$porcentajes[4])?></span>
                </div>
            </div>
            <div class="linea">
                <label class="ancho">Nº horas por OR:</label>
                <div class="dato">
                    <span class="oswald fs_14"><?=moneda_puntocoma($datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller'])?></span>
                </div>
                <div class="dato">
                    <span class="oswald fs_14"><?='---'?></span>
                </div>
            </div>

            <div class="linea" style="background-color:#f5f5f5; margin:0px; margin-top: 18px">
                <div id="stats_acum_evol_4" class="stat_ratio">
                    <script>
                        $(document).ready(function() {
                            drawChart_columnas('datos_stats', 'acum_evol_4%%0%%<?=$anho_acumulado?>', 'Horas facturadas por operario', 'stats_acum_evol_4');
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

        <div class="colder_graf" style="border-left: 1px solid #333; box-sizing: border-box">
            <div id="stats_acum_evol_1" class="stat_ratio">
                <script>
                    $(document).ready(function() {
                        drawChart_linear('datos_stats', 'acum_evol_1%%0%%<?=$anho_acumulado?>', 'Importe medio por OR', 'stats_acum_evol_1');
                    })
                </script>
            </div>
            <div id="stats_acum_evol_2" class="stat_ratio" style="margin-top: 30px">
                <script>
                    $(document).ready(function() {
                        drawChart_columnas('datos_stats', 'acum_evol_2%%0%%<?=$anho_acumulado?>', '€ facturados por operario', 'stats_acum_evol_2');
                    })
                </script>
            </div>
            <div id="stats_acum_evol_3" class="stat_ratio" style="margin-top: 30px">
                <script>
                    $(document).ready(function() {
                        drawChart_linear('datos_stats', 'acum_evol_3%%0%%<?=$anho_acumulado?>', 'Horas facturadas por OR', 'stats_acum_evol_3');
                    })
                </script>
            </div>
        </div>
