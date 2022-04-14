<?php 
require_once('../core/core.php');
$contenido=clean_post('contenido');
//$contenido='datos_stats';
open_bd();
include('../includes/'.$contenido.'.php');
close_bd();
?>