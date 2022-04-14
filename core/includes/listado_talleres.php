<?php
$titulo='Listado_talleres';

titulo_hoja($titulo);

$datos=fetch_array('select ta_nombre, ta_log_token from talleres where ta_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idred'].'');
$talleres=list_object('select ta_idtaller, ta_nombre from talleres where ta_idparent='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idred'].' order by ta_nombre asc');

$ntalleres=count($talleres);

if($ntalleres==0){//No hay talleres
	fuera_de_aqui();
	exit();
}

valor_celda($col.$cell,'NOMBRE');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'TOKEN');negrita($col.$cell);centrado($col.$cell);
$cell++;

$col='A';
valor_celda($col.$cell,u8d_($datos['ta_nombre']));$col++;
valor_celda($col.$cell,$datos['ta_log_token']);
$cell++;
$cell++;

$col='A';
valor_celda($col.$cell,'Nombre taller');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'ID');negrita($col.$cell);centrado($col.$cell);
$cell++;
foreach($talleres as $taller){
	$col='A';
	valor_celda($col.$cell,u8d_($taller->ta_nombre));$col++;
	valor_celda($col.$cell,en__id($taller->ta_idtaller));
	$cell++;
	$empleados=list_object('select pt_idpersonal, pt_nombre from personal_taller where pt_idtaller='.$taller->ta_idtaller.' order by pt_nombre asc');
	if(count($empleados)>0){
		$col='A';
		$col++;
		valor_celda($col.$cell,'Nombre empleado');negrita($col.$cell);centrado($col.$cell);$col++;
		valor_celda($col.$cell,'ID');negrita($col.$cell);centrado($col.$cell);
		$cell++;
		foreach($empleados as $empleado){
			$col='A';
			$col++;
			valor_celda($col.$cell,u8d_($empleado->pt_nombre));$col++;
			valor_celda($col.$cell,en__id($empleado->pt_idpersonal));
			$cell++;
			$colfinal=$col;
		}
	}
	$cell++;
}

ancho_auto('A',$colfinal);
?>