<script>
    $(document).ready(function() {
        drawChart_columnas_upd('datos_stats', 'acum_evol_4%%0%%<?=$anho_acumulado?>', 'Horas facturadas por operario', 'stats_acum_evol_4');
        drawChart_linear_upd('datos_stats', 'acum_evol_1%%0%%<?=$anho_acumulado?>', 'Importe medio por OR', 'stats_acum_evol_1');
        drawChart_columnas_upd('datos_stats', 'acum_evol_2%%0%%<?=$anho_acumulado?>', '€ facturados por operario', 'stats_acum_evol_2');
        drawChart_linear_upd('datos_stats', 'acum_evol_3%%0%%<?=$anho_acumulado?>', 'Horas facturadas por OR', 'stats_acum_evol_3');
    })
</script>