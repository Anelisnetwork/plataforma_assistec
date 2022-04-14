<?php
$datos_red=fetch_array('SELECT * from talleres where 1 and ta_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idred'].' and ta_idtipo=2');

if($datos_red==''||$datos_red==NULL){
	echo 'No está autorizado';
	exit();
}

$talleres=list_object('select * from talleres where 1 and ta_idparent='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idred'].' and ta_idtipo=1 and ta_idtaller!=1462 group by ta_idtaller order by ta_nombre asc');
	
	//echo 'select distinct ta_idtaller from talleres, usuarios_facturacion where 1 and ta_idtaller=uf_idtaller'.$filtro_busq.''.$filtro_tipo.''.$filtro_datos.' order by ta_nombre asc';exit;
	
$titulo='Listado_talleres';

titulo_hoja($titulo);

valor_celda($col.$cell,'Nombre taller');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'ID');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Token');negrita($col.$cell);centrado($col.$cell);$col++;
$cell++;

$col='A';
valor_celda($col.$cell,u8d_($datos_red['ta_nombre']));negrita($col.$cell);$col++;
valor_celda_txt($col.$cell,en__id($datos_red['ta_idtaller']));negrita($col.$cell);$col++;
valor_celda_txt($col.$cell,$datos_red['ta_log_token']);negrita($col.$cell);$col++;
$cell++;

foreach ($talleres as $taller){
	$col='A';
	valor_celda($col.$cell,u8d_($taller->ta_nombre));$col++;
	valor_celda_txt($col.$cell,en__id($taller->ta_idtaller));$col++;
	valor_celda_txt($col.$cell,$taller->ta_log_token);$col++;
	$cell++;
}

$colfinal=$col;

ancho_auto('A',$colfinal);
?>