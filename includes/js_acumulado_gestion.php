<script>
    $(document).ready(function() {
        drawChart_columnas_upd('datos_stats', 'acum_gest_3%%0%%<?=$anho_acumulado?>', 'Entradas al taller', 'stats_acum_gest_3');
        drawChart_columnas_legend_upd('datos_stats', 'acum_gest_1%%0%%<?=$anho_acumulado?>', 'Ocupación / Eficacia / Rendimiento (%)', 'stats_acum_gest_1');
        drawChart_linear_upd('datos_stats', 'acum_gest_2%%0%%<?=$anho_acumulado?>', 'Margen venta PR (%)', 'stats_acum_gest_2');
    })
</script>