<?php
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
    $porcentajes=personal_porcentaje($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
    foreach($datos_marcas as $k=>$d_p) {
        $anho = $anho_acumulado = clean_var_ob($d_p, 'anho');

        $datos_acumulados=dame_acumulado($anho_acumulado);
        if(count($datos_acumulados)==0){
            $comunicacion['com_resultado'] = 'KO';
            $comunicacion['com_mensaje'] = 'No hay datos con los parámetros indicados';
            goto end;
        }

        // Acumulado económicos
        $coste_hora_teorico=round($datos_acumulados['coste_hora_teorico'],2);
        $coste_hora_real=round($datos_acumulados['coste_hora_real'],2);
        $informe[$id_taller]['economico']['header']="Informe económico acumulado de ".$n_taller." del año ".$anho;
        $informe[$id_taller]['economico']['tot_facturado']=moneda_puntocoma($datos_acumulados['total_facturado']);
        $informe[$id_taller]['economico']['venta_mo']=moneda_puntocoma($datos_acumulados['ventamo']);
        $informe[$id_taller]['economico']['venta_pr']=moneda_puntocoma($datos_acumulados['ventapr']);
        $informe[$id_taller]['economico']['coste_pr']=moneda_puntocoma($datos_acumulados['costepr']);
        $informe[$id_taller]['economico']['margen_venta_pr']=moneda_puntocoma($datos_acumulados['margenpr']);
        $informe[$id_taller]['economico']['porcentaje_venta_pr']=moneda_puntocoma($datos_acumulados['porcentpr']);
        $informe[$id_taller]['economico']['coste_personal']=moneda_puntocoma($datos_acumulados['costepers']);
        $informe[$id_taller]['economico']['gasto_estructura']=moneda_puntocoma($datos_acumulados['costeestr']);
        $informe[$id_taller]['economico']['precio_medio_hora']=moneda_puntocoma($datos_acumulados['ventamo']/$datos_acumulados['hfacturadas']);
        $informe[$id_taller]['economico']['coste_hora']=moneda_puntocoma($coste_hora_real);
        $informe[$id_taller]['economico']['coste_hora_teorico']=moneda_puntocoma($coste_hora_teorico);
        $informe[$id_taller]['economico']['margen']=moneda_puntocoma($datos_acumulados['impmo_media']-$coste_hora_teorico);
        $informe[$id_taller]['economico']['porcentaje_beneficio']=moneda_puntocoma(margen_sobre_coste($coste_hora_teorico,$datos_acumulados['impmo_media']));
        $informe[$id_taller]['economico']['total_ingresos']=moneda_puntocoma($datos_acumulados['total_ingresos']);
        $informe[$id_taller]['economico']['total_gastos']=moneda_puntocoma($datos_acumulados['total_gastos']);
        $informe[$id_taller]['economico']['margen_bruto']=moneda_puntocoma($datos_acumulados['margenbruto']);
        $informe[$id_taller]['economico']['porcentaje_margen_bruto']=moneda_puntocoma($datos_acumulados['porcmargenbruto']);

        // Acumulado gestión
        $tiempo_medio_cliente=$datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller'];
        $horas_productivas=$datos_acumulados['sum_hprod']*0.9;//Un 10% de tiempo no productivo
        $capacidad_teorica=$horas_productivas/$tiempo_medio_cliente;
        $entradas_dia=round($datos_acumulados['entradastaller']/$datos_acumulados['diaslaborables'],2);
        $informe[$id_taller]['gestion']['header']="Informe de gestión acumulado de ".$n_taller." del año ".$anho;
        $informe[$id_taller]['gestion']['productividad']=moneda_puntocoma($datos_acumulados['productividad']);
        $informe[$id_taller]['gestion']['eficacia']=moneda_puntocoma($datos_acumulados['eficacia']);
        $informe[$id_taller]['gestion']['rendimiento']=moneda_puntocoma($datos_acumulados['rendimiento']);
        $informe[$id_taller]['gestion']['margen_venta_pr']=moneda_puntocoma($datos_acumulados['porcentpr']);
        $informe[$id_taller]['gestion']['entradas']=$entradas_dia;
        $informe[$id_taller]['gestion']['capacidad_teorica']=round($capacidad_teorica);
        $informe[$id_taller]['gestion']['desviacion']=round($entradas_dia-$capacidad_teorica);
        $informe[$id_taller]['gestion']['porcentaje_desviacion']=moneda_puntocoma(margen_sobre_coste($capacidad_teorica,$entradas_dia));
        $informe[$id_taller]['gestion']['tiempo_medio_entrada']=faltan2($tiempo_medio_cliente*3600);

        // Acumulado evolución
        $informe[$id_taller]['evolucion']['header']="Informe de evolución acumulado de ".$n_taller." del año ".$anho;
        $informe[$id_taller]['evolucion']['horas_facturadas']=moneda_puntocoma($datos_acumulados['hfacturadas']);
        $informe[$id_taller]['evolucion']['importe_medio_or']=moneda_puntocoma($datos_acumulados['mediaor']);
        $informe[$id_taller]['evolucion']['importe_mo_or']=moneda_puntocoma($datos_acumulados['mediamo']);
        $informe[$id_taller]['evolucion']['porcentaje_mo_or']=moneda_puntocoma(porcentaje_($datos_acumulados['mediamo'],$datos_acumulados['mediaor']));
        $informe[$id_taller]['evolucion']['importe_pr_or']=moneda_puntocoma($datos_acumulados['mediapr']);
        $informe[$id_taller]['evolucion']['porcentaje_pr_or']=moneda_puntocoma(porcentaje_($datos_acumulados['mediapr'],$datos_acumulados['mediaor']));
        $informe[$id_taller]['evolucion']['acumulado_horas_operario']=moneda_puntocoma($datos_acumulados['hfacturadas']/$porcentajes[4]);
        $informe[$id_taller]['evolucion']['media_horas_operario']=moneda_puntocoma($datos_acumulados['hfacturadas']/$datos_acumulados['nmeses']/$porcentajes[4]);
        $informe[$id_taller]['evolucion']['acumulado_mo_operario']=moneda_puntocoma($datos_acumulados['ventamo']/$porcentajes[4]);
        $informe[$id_taller]['evolucion']['media_mo_operario']=moneda_puntocoma($datos_acumulados['ventamo']/$porcentajes[4]/$datos_acumulados['nmeses']);
        $informe[$id_taller]['evolucion']['acumulado_pr_operario']=moneda_puntocoma($datos_acumulados['ventapr']/$porcentajes[4]);
        $informe[$id_taller]['evolucion']['media_pr_operario']=moneda_puntocoma($datos_acumulados['ventapr']/$porcentajes[4]/$datos_acumulados['nmeses']);
        $informe[$id_taller]['evolucion']['facturado_operario']=moneda_puntocoma($datos_acumulados['ventamo']/$porcentajes[4]+$datos_acumulados['ventapr']/$porcentajes[4]);
        $informe[$id_taller]['evolucion']['horas_or']=moneda_puntocoma($datos_acumulados['hfacturadas']/$datos_acumulados['entradastaller']);

    }
}

end:
$comunicacion['respuesta']=$informe;
//vd__($comunicacion);exit;
echo json_encode($comunicacion);