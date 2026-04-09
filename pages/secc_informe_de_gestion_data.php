<?php
$hpresencia=horas_presencia($iddato);
//echo $hpresencia;
$productividad=porcentaje_($dato_mensual[0]->da_horasfichadasor,$hpresencia);
$obj_prod=$dato_mensual[0]->da_objproductividad;

$hfacturadas=$dato_mensual[0]->da_facturadomo/$dato_mensual[0]->da_impmo;
$eficacia=porcentaje_($hfacturadas,$hpresencia);
$obj_efic=$dato_mensual[0]->da_objeficacia;

$rendimiento=porcentaje_($hfacturadas,$dato_mensual[0]->da_horasfichadasor);
$obj_rendi=$dato_mensual[0]->da_objrendimiento;

$ventapr=$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$costepr=$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros;
//$porcentpr=margen_sobre_coste($costepr,$ventapr);
$margenpr=$ventapr-$dato_mensual[0]->da_pagadoprovrec;
$porcentpr=$margenpr/$ventapr*100;
$obj_ventapr=$dato_mensual[0]->da_objmargenrec;

$total_facturado=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
$mediaor=$total_facturado/$dato_mensual[0]->da_entradastaller;

$ventamo=$dato_mensual[0]->da_facturadomo;
$mediamo=$ventamo/$dato_mensual[0]->da_entradastaller;

$mediapr=$ventapr/$dato_mensual[0]->da_entradastaller;

$infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
$totalbbdd=$infotaller[0]->it_totalclientes;
$fidelizacion=porcentaje_($dato_mensual[0]->da_entradastaller,$totalbbdd);;



$horas_productivas=horas_presencia_pot($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'])*($obj_prod/100);//Un 10% de tiempo no productivo
$tiempo_medio_cliente=$hfacturadas/$dato_mensual[0]->da_entradastaller;//21.6
$entradas_dia=$dato_mensual[0]->da_entradastaller/$dato_mensual[0]->da_diaslaborables;
$capacidad_teorica=$hfacturadas/$tiempo_medio_cliente/$dato_mensual[0]->da_diaslaborables;