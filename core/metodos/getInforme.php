<?
/*vd__($_POST['acceso']);
vd__(json_decode($_POST['datos']));*/
//vd__($_POST);exit;

aaa_test(date('Y-m-d H:i:s'),'Acceso:'.$_POST['acceso'].' , Datos:'.$_POST['datos']);

$key=$_POST['acceso'];
$datos_marcas=json_decode($_POST['datos']);

$comunicacion['com_resultado'] = 'OK';
$comunicacion['com_mensaje'] = 'Conexión realizada correctamente';

$datos_acceso = fetch_assoc("SELECT * FROM astc_api_accesos WHERE clave='{$key}' AND descripcion='" . desencriptar($key) . "'");

if ($datos_acceso == '') {
    $comunicacion['com_resultado'] = 'KO';
    $comunicacion['com_mensaje'] = 'Los datos de acceso no son válidos';
    goto end;
}
if ($datos_acceso['estado'] == 0) {
    $comunicacion['com_resultado'] = 'KO';
    $comunicacion['com_mensaje'] = 'No tiene acceso a la aplicación';
    goto end;
}
$d_user=fetch_array("SELECT t.* FROM usuarios u INNER JOIN talleres t on u.us_idtaller = t.ta_idtaller WHERE us_accesoapi='{$datos_acceso['idacceso']}'");
$test = $datos_acceso['estado'] == 2;

if($d_user==''){
    $comunicacion['com_resultado'] = 'KO';
    $comunicacion['com_mensaje'] = 'Los datos indicados no corresponden a ningún usuario válido.';
    goto end;
}
if($d_user['ta_idtipo']==1){// Es un taller
    $q=" AND ta_idtaller='{$d_user['ta_idtaller']}'";
}
else{
    $q=" AND ta_idparent='{$d_user['ta_idtaller']}'";
}
$talleres=list_object("SELECT ta_idtaller, ta_nombre FROM talleres WHERE 1{$q}");

$informe=array();

foreach($talleres as $taller){
    $id_taller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']=$taller->ta_idtaller;
    $n_taller=$taller->ta_nombre;
    foreach($datos_marcas as $k=>$d_p) {
        $tipo = clean_var_ob($d_p, 'tipo');
        $mes = $d_p->mes*1;
        $anho = clean_var_ob($d_p, 'anho');

        $dato_mensual=datos_actividad(1, $mes, $anho);
        if(count($dato_mensual)==0){
            $comunicacion['com_resultado'] = 'KO';
            $comunicacion['com_mensaje'] = 'No hay datos con los parámetros indicados';
            goto end;
        }
        $dato_mensual[0]->nombre_taller=$n_taller;
        $iddato=$dato_mensual[0]->da_iddato;

        // Datos económicos
        $total_facturado=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
        $ventamo=$dato_mensual[0]->da_facturadomo;
        $ventapr=$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
        $costepr=$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros;
        $margenpr=$ventapr-$dato_mensual[0]->da_pagadoprovrec;
        $obj_ventas=$dato_mensual[0]->da_objventas;
        $porcentpr=margen_sobre_coste($dato_mensual[0]->da_pagadoprovrec,$ventapr);
        $obj_ventapr=$dato_mensual[0]->da_objmargenrec;
        $costepers=$dato_mensual[0]->da_costepersonal;
        $costeestr=$dato_mensual[0]->da_costeestructura;
        $total_ingresos=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
        $total_gastos=$costepr+$costepers+$costeestr;
        $margenbruto=$total_ingresos-$total_gastos;
        $porcmargenbruto=margen_sobre_coste($total_gastos,$total_ingresos);
        $informe[$id_taller]['economico']['header']="Informe económico de ".$n_taller." del mes de ".nom_mes($dato_mensual[0]->da_mes)." de ".$dato_mensual[0]->da_ano;
        $informe[$id_taller]['economico']['tot_facturado']=moneda_puntocoma($total_facturado);
        $informe[$id_taller]['economico']['venta_mo']=moneda_puntocoma($ventamo);
        $informe[$id_taller]['economico']['venta_pr']=moneda_puntocoma($ventapr);
        $informe[$id_taller]['economico']['coste_pr']=moneda_puntocoma($dato_mensual[0]->da_pagadoprovrec);
        $informe[$id_taller]['economico']['margen_venta_pr']=moneda_puntocoma($margenpr);
        $informe[$id_taller]['economico']['porcentaje_venta_pr']=moneda_puntocoma($porcentpr);
        $informe[$id_taller]['economico']['coste_personal']=moneda_puntocoma($costepers);
        $informe[$id_taller]['economico']['gasto_estructura']=moneda_puntocoma($costeestr);
        $informe[$id_taller]['economico']['total_ingresos']=moneda_puntocoma($total_ingresos);
        $informe[$id_taller]['economico']['total_gastos']=moneda_puntocoma($total_gastos);
        $informe[$id_taller]['economico']['margen_bruto']=moneda_puntocoma($margenbruto);
        $informe[$id_taller]['economico']['porcentaje_margen_bruto']=moneda_puntocoma($porcmargenbruto);

        // Datos de gestión
        $hpresencia=horas_presencia($iddato);
        $productividad=porcentaje_($dato_mensual[0]->da_horasfichadasor,$hpresencia);
        $obj_prod=$dato_mensual[0]->da_objproductividad;
        $hfacturadas=$dato_mensual[0]->da_facturadomo/$dato_mensual[0]->da_impmo;
        $eficacia=porcentaje_($hfacturadas,$hpresencia);
        $obj_efic=$dato_mensual[0]->da_objeficacia;
        $rendimiento=porcentaje_($hfacturadas,$dato_mensual[0]->da_horasfichadasor);
        $obj_rendi=$dato_mensual[0]->da_objrendimiento;
        $ventapr=$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
        $costepr=$dato_mensual[0]->da_pagadoprovrec+$dato_mensual[0]->da_pagadoprovotros;
        $porcentpr=margen_sobre_coste($costepr,$ventapr);
        $obj_ventapr=$dato_mensual[0]->da_objmargenrec;
        $total_facturado=$dato_mensual[0]->da_facturadomo+$dato_mensual[0]->da_facturadorec+$dato_mensual[0]->da_facturadootros;
        $mediaor=$total_facturado/$dato_mensual[0]->da_entradastaller;
        $ventamo=$dato_mensual[0]->da_facturadomo;
        $mediamo=$ventamo/$dato_mensual[0]->da_entradastaller;
        $mediapr=$ventapr/$dato_mensual[0]->da_entradastaller;
        $infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
        $totalbbdd=$infotaller[0]->it_totalclientes;
        $fidelizacion=porcentaje_($dato_mensual[0]->da_entradastaller,$totalbbdd);;
        $tiempo_medio_cliente=$hfacturadas/$dato_mensual[0]->da_entradastaller;//21.6
        $horas_productivas=horas_presencia_pot($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'])*($obj_prod/100);//Un 10% de tiempo no productivo
        $capacidad_teorica=$horas_productivas/$tiempo_medio_cliente;
        $entradas_dia=$dato_mensual[0]->da_entradastaller/$dato_mensual[0]->da_diaslaborables;

        $informe[$id_taller]['gestion']['header']="Informe de gestión de ".$n_taller." del mes de ".nom_mes($dato_mensual[0]->da_mes)." de ".$dato_mensual[0]->da_ano;
        $informe[$id_taller]['gestion']['productividad']=moneda_puntocoma($productividad);
        $informe[$id_taller]['gestion']['efectividad']=moneda_puntocoma($eficacia);
        $informe[$id_taller]['gestion']['rendimiento']=moneda_puntocoma($rendimiento);
        $informe[$id_taller]['gestion']['margen_venta_pr']=moneda_puntocoma($porcentpr);
        $informe[$id_taller]['gestion']['entradas']=$dato_mensual[0]->da_entradastaller;
        $informe[$id_taller]['gestion']['capacidad_entradas']=round($capacidad_teorica*$dato_mensual[0]->da_diaslaborables);
        $informe[$id_taller]['gestion']['desviacion']=number_format(($dato_mensual[0]->da_entradastaller-($capacidad_teorica*$dato_mensual[0]->da_diaslaborables)),0,',','.');
        $informe[$id_taller]['gestion']['porcentaje_desviacion']=number_format(margen_sobre_coste(($capacidad_teorica*$dato_mensual[0]->da_diaslaborables),$dato_mensual[0]->da_entradastaller),0,',','.');
        $informe[$id_taller]['gestion']['tiempo_medio_entrada']=faltan2(($hfacturadas/$dato_mensual[0]->da_entradastaller)*3600);
        $informe[$id_taller]['gestion']['importe_medio_or']=moneda_puntocoma($mediaor);
        $informe[$id_taller]['gestion']['importe_mo_or']=moneda_puntocoma($mediamo);
        $informe[$id_taller]['gestion']['porcentaje_mo_or']=moneda_puntocoma(porcentaje_($mediamo,$mediaor));
        $informe[$id_taller]['gestion']['importe_pr_or']=moneda_puntocoma($mediapr);
        $informe[$id_taller]['gestion']['porcentaje_pr_or']=moneda_puntocoma(porcentaje_($mediapr,$mediaor));
    }
}

end:
$comunicacion['respuesta']=$informe;
//vd__($comunicacion);exit;
echo json_encode($comunicacion);