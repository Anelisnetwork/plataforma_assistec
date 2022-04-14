<?php

$_SESSION['datos_'._ID_PAG_]['edita_datosactividad']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_taller=clean_post('idtaller');

$id_taller==''||$url_dest==''?fuera_de_aqui():'';

$iddatoact=explode(',',clean_post('iddatoact'));

$empleados_directos=dame_empleados(1);

$nempleados=0;
foreach($empleados_directos as $empleado_directo){
	$marcado=clean_post('activaemp_'.$empleado_directo->pt_idpersonal);
	$nempleados+=$marcado!=''?1:0;
}

if($nempleados==0){
	$_SESSION['datos_'._ID_PAG_]['edita_datosactividad']['hayerrores']=1;
	fuera_de_aqui($url_dest);
}

foreach($iddatoact as $datoact){
	$nmeses=clean_post('nmeses_'.$datoact);
	!is_numeric($nmeses)||$nmeses<=0?$nmeses=0:1;
	$importemo=clean_post('importemo_'.$datoact);
	!is_numeric($importemo)||$importemo<=0?$importemo=0:'';
	$diaslab=clean_post('diaslab_'.$datoact);
	!is_numeric($diaslab)||$diaslab<=0?$diaslab=0:'';
	$facturadomo=clean_post('facturadomo_'.$datoact);
	!is_numeric($facturadomo)||$facturadomo<=0?$facturadomo=0:'';
	$facturadorec=clean_post('facturadorec_'.$datoact);
	!is_numeric($facturadorec)||$facturadorec<=0?$facturadorec=0:'';
	$facturadootros=clean_post('facturadootros_'.$datoact);
	!is_numeric($facturadootros)||$facturadootros<=0?$facturadootros=0:'';
	/*
	$cobradomo=clean_post('cobradomo_'.$datoact);
	!is_numeric($cobradomo)||$cobradomo<=0?$cobradomo=0:'';
	$cobradorec=clean_post('cobradorec_'.$datoact);
	!is_numeric($cobradorec)||$cobradorec<=0?$cobradorec=0:'';
	$cobradootros=clean_post('cobradootros_'.$datoact);
	!is_numeric($cobradootros)||$cobradootros<=0?$cobradootros=0:'';
	*/
	$pagadoprovrec=clean_post('pagadoprovrec_'.$datoact);
	!is_numeric($pagadoprovrec)||$pagadoprovrec<=0?$pagadoprovrec=0:'';
	$pagadoprovotros=clean_post('pagadoprovotros_'.$datoact);
	!is_numeric($pagadoprovotros)||$pagadoprovotros<=0?$pagadoprovotros=0:'';
	$costepersonal=clean_post('costepersonal_'.$datoact);
	!is_numeric($costepersonal)||$costepersonal<=0?$costepersonal=0:'';
	$costeestructura=clean_post('costeestructura_'.$datoact);
	!is_numeric($costeestructura)||$costeestructura<=0?$costeestructura=0:'';
	$horasfichadasor=clean_post('horasfichadasor_'.$datoact);
	!is_numeric($horasfichadasor)||$horasfichadasor<=0?$horasfichadasor=0:'';
	$horasasignadas=clean_post('horasasignadas_'.$datoact);
	!is_numeric($horasasignadas)||$horasasignadas<=0?$horasasignadas=0:'';
	$horasfac=clean_post('horasfac_'.$datoact);
	!is_numeric($horasfac)||$horasfac<=0?$horasfac=0:'';
	$horasimproductivas=clean_post('horasimproductivas_'.$datoact);
	!is_numeric($horasimproductivas)||$horasimproductivas<=0?$horasimproductivas=0:'';
	$nofacturado=clean_post('nofacturado_'.$datoact);
	!is_numeric($nofacturado)||$nofacturado<=0?$nofacturado=0:'';
	$entradastaller=clean_post('entradastaller_'.$datoact);
	!is_numeric($entradastaller)||$entradastaller<=0?$entradastaller=0:'';
			
	query('delete from presencia_personal where pp_iddato='.$datoact.'');
	
	foreach($empleados_directos as $empleado_directo){
		$marcado=clean_post('activaemp_'.$empleado_directo->pt_idpersonal);
		if($marcado!=''){
			$extraspagadas=clean_post('extraspagadas_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
			!is_numeric($extraspagadas)||$extraspagadas<=0?$extraspagadas=0:'';
			$diasvacaciones=clean_post('diasvacaciones_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
			!is_numeric($diasvacaciones)||$diasvacaciones<=0?$diasvacaciones=0:'';
			$diasbaja=clean_post('diasbaja_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
			!is_numeric($diasbaja)||$diasbaja<=0?$diasbaja=0:'';
			$diaspermiso=clean_post('diaspermiso_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
			!is_numeric($diaspermiso)||$diaspermiso<=0?$diaspermiso=0:'';
			$diasformacion=clean_post('diasformacion_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
			!is_numeric($diasformacion)||$diasformacion<=0?$diasformacion=0:'';
			query('insert into presencia_personal (pp_iddato, pp_idpersonal, pp_extraspagadas, pp_diasvacaciones, pp_diasbaja, pp_diaspermiso, pp_diasformacion) values ('.$datoact.', '.$empleado_directo->pt_idpersonal.', '.$extraspagadas.', '.$diasvacaciones.', '.$diasbaja.', '.$diaspermiso.', '.$diasformacion.')');
		}
	}
	
	if(!query('update datos_actividad set da_mes='.$nmeses.', da_impmo='.$importemo.', da_diaslaborables='.$diaslab.', da_horasfac='.$horasfac.', da_horasimproductivas='.$horasimproductivas.', da_nofacturado='.$nofacturado.', da_facturadomo='.$facturadomo.', da_facturadorec='.$facturadorec.', da_facturadootros='.$facturadootros.', da_pagadoprovrec='.$pagadoprovrec.', da_pagadoprovotros='.$pagadoprovotros.', da_costepersonal='.$costepersonal.', da_costeestructura='.$costeestructura.', da_horasfichadasor='.$horasfichadasor.', da_horasasignadas='.$horasasignadas.', da_entradastaller='.$entradastaller.' where da_idtaller='.$id_taller.' and da_iddato='.$datoact.'')){
		$_SESSION['datos_'._ID_PAG_]['edita_datosactividad']['hayerrores']=1;
		break;
	}
}



fuera_de_aqui($url_dest);

?>