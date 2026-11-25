<?php
$tiempo_medio_cliente=$datos_acumulados['entradastaller']==0?0:$datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller'];
$obj_ocupacion=dato_taller('ta_objproductividad', $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
$horas_productivas=$datos_acumulados['sum_hprod']*((float)$obj_ocupacion/100);
$capacidad_teorica=$tiempo_medio_cliente==0?0:$horas_productivas/$tiempo_medio_cliente;
$entradas_dia=$datos_acumulados['diaslaborables']==0?0:round($datos_acumulados['entradastaller']/$datos_acumulados['diaslaborables'],2);

//echo $tiempo_medio_cliente.'<br>'.$horas_productivas.'<br>'.$capacidad_teorica.'<br>'.$entradas_dia.'<br>'.$datos_acumulados['diaslaborables'].'<br>';