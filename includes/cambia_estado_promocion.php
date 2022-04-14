<?php
$idtaller=clean_post('idtaller');
$durpromo=clean_post('durpromo');

$ndur=$durpromo==1?0:1;

if(query('update talleres set ta_durpromo='.$ndur.' where ta_idtaller='.$idtaller.'')){
	$durpromo=$ndur;
}

$datos=fetch_array('select ta_nombre, ta_durpromo, ta_idpromo from talleres where ta_idtaller='.$idtaller.'');

$pr_durpromo=$datos['ta_durpromo'];
$pr_tipo=fetch_array('select pr_tipo from promociones where pr_idpromocion='.$datos['ta_idpromo'].'','pr_tipo');
$pr_nombre=u8d_($datos['ta_nombre']);
$pr_idtaller=$idtaller;

include ('linea_est_promo.php');
?>