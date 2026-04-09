<?php
//echo '<pre>'; var_dump($datos_acumulados); echo '</pre>';
$coste_hora_teorico=round($datos_acumulados['coste_hora_teorico'],2);
$coste_hora_real=round($datos_acumulados['coste_hora_real'],2);
/*$coste_hora_teorico=$datos_acumulados['horaspotenciales']==0?0:(($datos_acumulados['costeestr']/$datos_acumulados['nmeses']*12)+($datos_acumulados['costepers']/$datos_acumulados['nmeses']*12))/$datos_acumulados['horaspotenciales'];
$coste_hora_real=$coste_hora_teorico*round($datos_acumulados['eficacia'])/100;*/
//echo round($datos_acumulados['eficacia']);
