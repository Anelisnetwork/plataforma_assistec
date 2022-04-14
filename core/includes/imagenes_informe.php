<?php
//ini_set("display_errors", 1);
//Poner esto donde se quiera llamar a la gráfica  <img src='._RAIZ_.'core/includes/rendimiento.php'>
require_once('../core.php');
open_bd();
//$contenido=en__('pdf_infome_mensual%%imprimir%%1%%10%%2015');

$contenido=clean_get('contenido');

$contenido==''?$contenido=en__('pdf_infome_mensual%%guardar%%1%%1%%2017'):false;

include('generar_informe.php');

if($contenido_de[0]=='imprimir') {
    fuera_de_aqui(_RAIZ_ . 'pdf/' . $contenido);
} else{
    //Insertamos en tabla envios_pendientes
}

close_bd();
?>