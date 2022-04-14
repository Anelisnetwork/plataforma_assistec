<?php
//require_once('core/core.php');

if(!isset($_GET['token'])||$_GET['token']!=md5('laconcongrelos')){
	exit('Hola, ke ase?');
}

require_once('/var/www/vhosts/assistec.es/httpdocs/plataforma/core/core.php');

open_bd();

query('delete from talleres where ta_testing=1');
query('delete from datos_actividad where da_testing=1');
query('delete from presencia_personal where pp_testing=1');
query('delete from usuarios where us_testing=1');
query('delete from usuarios_facturacion where uf_testing=1');
query('delete from info_taller where it_testing=1');
	
close_bd();
?>