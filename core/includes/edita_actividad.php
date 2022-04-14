<?php

$_SESSION['datos_'._ID_PAG_]['edita_actividad']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_taller=clean_post('idtaller');

$id_taller==''?fuera_de_aqui():'';

$actividades=tipos_actividad();

foreach ($actividades as $actividad){
	${'activ'.$actividad->tac_idactiv}=clean_post('activ_'.$actividad->tac_idactiv);
	if(${'activ'.$actividad->tac_idactiv}!=''){//Tiene esta actividad
		${'metros'.$actividad->tac_idactiv}=clean_post('metros_'.$actividad->tac_idactiv);
		!is_numeric(${'metros'.$actividad->tac_idactiv})||${'metros'.$actividad->tac_idactiv}<=0?${'metros'.$actividad->tac_idactiv}=0:'';
		${'puestos'.$actividad->tac_idactiv}=clean_post('puestos_'.$actividad->tac_idactiv);
		!is_numeric(${'puestos'.$actividad->tac_idactiv})||${'puestos'.$actividad->tac_idactiv}<=0?${'puestos'.$actividad->tac_idactiv}=0:'';
		${'elevadores'.$actividad->tac_idactiv}=clean_post('elevadores_'.$actividad->tac_idactiv);
		!is_numeric(${'elevadores'.$actividad->tac_idactiv})||${'elevadores'.$actividad->tac_idactiv}<=0?${'elevadores'.$actividad->tac_idactiv}=0:'';
		query('delete from actividad_taller where at_idtaller='.$id_taller.' and at_idactividad='.$actividad->tac_idactiv.'');
		query('insert into actividad_taller (at_idtaller, at_idactividad, at_metros, at_puestos, at_elevadores, at_notas) values ('.$id_taller.', '.$actividad->tac_idactiv.', '.${'metros'.$actividad->tac_idactiv}.', '.${'puestos'.$actividad->tac_idactiv}.', '.${'elevadores'.$actividad->tac_idactiv}.', "")');
	}
	else{//No tiene esta actividad
		query('delete from actividad_taller where at_idtaller='.$id_taller.' and at_idactividad='.$actividad->tac_idactiv.'');
	}
}

fuera_de_aqui($url_dest);

?>