<?php
$contenido_de = explode('%%', (de__($contenido)));

$idtaller = $contenido_de[2];
$idmes = $contenido_de[3];
$idano = $contenido_de[4];


if (num_rows("SELECT ta_idtaller FROM talleres WHERE ta_idtaller=" . $idtaller) == 0 || num_rows("SELECT da_iddato FROM datos_actividad WHERE da_idtaller=" . $idtaller . " AND da_mes='" . $idmes . "' AND da_ano='" . $idano . "'") == 0) {
    exit("Datos incorrectos");
}

$datos = fetch_array("SELECT * FROM datos_actividad WHERE da_idtaller=" . $idtaller . " AND da_mes='" . $idmes . "' AND da_ano='" . $idano . "'");

$hpresencia = horas_presencia($datos['da_iddato']);
$hfacturadas = $datos['da_facturadomo'] / $datos['da_impmo'];

$productividad = porcentaje_($datos['da_horasfichadasor'], $hpresencia);
$eficacia = porcentaje_($hfacturadas, $hpresencia);
$rendimiento = porcentaje_($hfacturadas, $datos['da_horasfichadasor']);

$ventapr = $datos['da_facturadorec'] + $datos['da_facturadootros'];
$costepr = $datos['da_pagadoprovrec'] + $datos['da_pagadoprovotros'];
$porcentpr = number_format(margen_sobre_coste($costepr, $ventapr), 2);
$ventasobj = $costepr + ($costepr * $datos['da_objmargenrec'] / 100);

//echo $ventapr.' - '.$costepr.' - '.$porcentpr.' - '.$datos['da_objmargenrec'].' - '.$ventasobj;exit();

function grafica($chart, $nombre)
{
//header('content-type: image/png');
//header('Content-Disposition: attachment; filename="downloaded.png"');
    $url = 'https://chart.googleapis.com/chart';
    $context = stream_context_create(
        array('http' => array(
            'method' => 'POST',
            'content' => http_build_query($chart))));
    ob_start();
    //fpassthru(fopen($url, 'r', false, $context));
    $content = ob_get_clean();
//ob_end_clean();
    $file = fopen(_PATH_."archivos/tmp/" . $nombre . ".png", "w");
    fwrite($file, $content . PHP_EOL);
    fclose($file);
}

function grafica_pant($chart)
{
    header('content-type: image/png');
//header('Content-Disposition: attachment; filename="downloaded.png"');
    $url = 'https://chart.googleapis.com/chart';
    $context = stream_context_create(
        array('http' => array(
            'method' => 'POST',
            'content' => http_build_query($chart))));
//ob_start();
    fpassthru(fopen($url, 'r', false, $context));
//$content = ob_get_clean();
//$file = fopen("../../archivos/imagen.png", "w");
//fwrite($file, $content . PHP_EOL);
//fclose($file);
}

include('rendimiento.php');
include('efectividad.php');
include('margen_venta.php');

if($contenido_de[1]=='imprimir') {
    fuera_de_aqui(_RAIZ_ . 'pdf/' . $contenido);
}
else if(isset($idenvio)) {
    query("UPDATE envios_pendientes SET ep_accion=1 WHERE ep_idenvio=".$idenvio);
}
else{
    //Insertamos en tabla envios_pendientes
    query("INSERT INTO envios_pendientes (ep_idtaller, ep_mes, ep_ano) VALUES (".$idtaller.",'".$idmes."','".$idano."')");
    //query("UPDATE envios_pendientes SET ep_accion=1 WHERE ep_idenvio=".$idenvio);
}