<?php
$tipo=clean_post('tipo');
$iditem=clean_post('iditem');

if($tipo!=''&&$iditem!=''){
	switch($tipo){
		case 'equipamiento':
			echo query('delete from equipamiento_taller where et_idequip='.$iditem.'')?'true':'No se ha podido eliminar';
			break;
		case 'empleado':
			$estado=fetch_array('select pt_activo from personal_taller where pt_idpersonal='.$iditem.'','pt_activo');
			$estado_n=$estado==1?0:1;
			echo query('update personal_taller set pt_activo='.$estado_n.' where pt_idpersonal='.$iditem.'')?'true':'No se ha podido eliminar';
			break;
		default:
			echo 'No hay tipo de elemento definido';
	}
}
else{
	echo 'No se han pasado datos';
}



?>