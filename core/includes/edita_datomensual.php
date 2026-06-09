<?php

show_errors('on');

$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['hayerrores']=0;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['mensaje']='Guardado correctamente';

$url_dest=clean_post('url_dest');

$id_taller=clean_post('idtaller');

$id_taller==''||$url_dest==''?fuera_de_aqui():null;

$iddatoact=clean_post('iddatoact');

$datoact=$iddatoact;

$empleados_directos=dame_empleados($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'],1);

$nempleados=0;
foreach($empleados_directos as $empleado_directo){
	$marcado=clean_post('activaemp_'.$empleado_directo->pt_idpersonal);
	$nempleados+=$marcado!=''?1:0;
}



if($datoact!='NEW'&&!is_numeric($datoact)){
	$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['mensaje']='Error al guardar - NO NUMBER';
	fuera_de_aqui($url_dest);
}

$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']=0;

if($datoact=='NEW'){//Nuevo registro
	$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']=1;
}

$mes=$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['mes']=clean_post('mesdato_'.$datoact);
$ano=$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['ano']=clean_post('anodato_'.$datoact);
$importemo=clean_post('importemo_'.$datoact);
!is_numeric($importemo)||$importemo<=0?$importemo=0:null;
$diaslab=clean_post('diaslab_'.$datoact);
!is_numeric($diaslab)||$diaslab<=0?$diaslab=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['diaslab']=$diaslab;
$horaspresencia=clean_post('horaspresencia_'.$datoact);
!is_numeric($horaspresencia)||$horaspresencia<=0?$horaspresencia=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['horaspresencia']=$horaspresencia;
$presenciaxemp=clean_post('presenciaxemp');
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['presenciaxemp']=$presenciaxemp;
$horasfac=clean_post('horasfac_'.$datoact);
!is_numeric($horasfac)||$horasfac<=0?$horasfac=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['horasfac']=$horasfac;
$horasimproductivas=clean_post('horasimproductivas_'.$datoact);
!is_numeric($horasimproductivas)||$horasimproductivas<=0?$horasimproductivas=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['horasimproductivas']=$horasimproductivas;
$nofacturado=clean_post('nofacturado_'.$datoact);
!is_numeric($nofacturado)||$nofacturado<=0?$nofacturado=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['nofacturado']=$nofacturado;
$facturadomo=clean_post('facturadomo_'.$datoact);
!is_numeric($facturadomo)||$facturadomo<=0?$facturadomo=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['facturadomo']=$facturadomo;
$facturadorec=clean_post('facturadorec_'.$datoact);
!is_numeric($facturadorec)||$facturadorec<=0?$facturadorec=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['facturadorec']=$facturadorec;
$facturadootros=clean_post('facturadootros_'.$datoact);
!is_numeric($facturadootros)||$facturadootros<=0?$facturadootros=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['facturadootros']=$facturadootros;
/*
$cobradomo=clean_post('cobradomo_'.$datoact);
!is_numeric($cobradomo)||$cobradomo<=0?$cobradomo=0:'';
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['cobradomo']=$cobradomo;
$cobradorec=clean_post('cobradorec_'.$datoact);
!is_numeric($cobradorec)||$cobradorec<=0?$cobradorec=0:'';
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['cobradorec']=$cobradorec;
$cobradootros=clean_post('cobradootros_'.$datoact);
!is_numeric($cobradootros)||$cobradootros<=0?$cobradootros=0:'';
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['cobradootros']=$cobradootros;
*/
$pagadoprovrec=clean_post('pagadoprovrec_'.$datoact);
!is_numeric($pagadoprovrec)||$pagadoprovrec<=0?$pagadoprovrec=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['pagadoprovrec']=$pagadoprovrec;
$pagadoprovotros=clean_post('pagadoprovotros_'.$datoact);
!is_numeric($pagadoprovotros)||$pagadoprovotros<=0?$pagadoprovotros=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['pagadoprovotros']=$pagadoprovotros;
$costepersonal=clean_post('costepersonal_'.$datoact);
!is_numeric($costepersonal)||$costepersonal<=0?$costepersonal=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['costepersonal']=$costepersonal;
$costeestructura=clean_post('costeestructura_'.$datoact);
!is_numeric($costeestructura)||$costeestructura<=0?$costeestructura=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['costeestructura']=$costeestructura;
$horasfichadasor=clean_post('horasfichadasor_'.$datoact);
!is_numeric($horasfichadasor)||$horasfichadasor<=0?$horasfichadasor=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['horasfichadasor']=$horasfichadasor;
$horasasignadas=clean_post('horasasignadas_'.$datoact);
!is_numeric($horasasignadas)||$horasasignadas<=0?$horasasignadas=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['horasasignadas']=$horasasignadas;
$horasfac=clean_post('horasfac_'.$datoact);
!is_numeric($horasfac)||$horasfac<=0?$horasfac=0:null;
$horasimproductivas=clean_post('horasimproductivas_'.$datoact);
!is_numeric($horasimproductivas)||$horasimproductivas<=0?$horasimproductivas=0:null;
$nofacturado=clean_post('nofacturado_'.$datoact);
!is_numeric($nofacturado)||$nofacturado<=0?$nofacturado=0:null;
$entradastaller=clean_post('entradastaller_'.$datoact);
!is_numeric($entradastaller)||$entradastaller<=0?$entradastaller=0:null;
$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['entradastaller']=$entradastaller;

if($facturadomo<=0||$importemo<=0||$horasfichadasor<=0||$facturadorec<=0||$facturadootros<=0||$pagadoprovrec<=0||$pagadoprovotros<=0){
	$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']=0;
}

$tipopresencia=$presenciaxemp!=1?2:$presenciaxemp;
	
if($datoact=='NEW'){//Nuevo registro
	if(num_rows('select da_iddato from datos_actividad where da_idtipo=1 and da_idtaller='.$id_taller.' and da_mes='.$mes.' and da_ano='.$ano)!=0){//Ya existe un registro de ese mes y año
		$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['mensaje']='Ya existe un dato guardado del mes indicado';
	}
	else{
		$objetivos=fetch_array('select ta_objventas, ta_objmargenrec, ta_objeficacia, ta_objproductividad, ta_objrendimiento from talleres where ta_idtaller='.$id_taller);
		$consulta="insert into datos_actividad (da_idtaller, da_mes, da_ano, da_tipopresencia, da_impmo, da_diaslaborables, da_horaspresencia, da_horasfac, da_horasimproductivas, da_nofacturado, da_facturadomo, da_facturadorec, da_facturadootros, da_pagadoprovrec, da_pagadoprovotros, da_costepersonal, da_costeestructura, da_horasfichadasor, da_horasasignadas, da_entradastaller, da_objventas, da_objmargenrec, da_objeficacia, da_objproductividad, da_objrendimiento) values (".$id_taller.", ".$mes.", ".$ano.", ".$tipopresencia.", ".$importemo.", ".$diaslab.",".$horaspresencia.", ".$horasfac.", ".$horasimproductivas.", ".$nofacturado.", ".$facturadomo.", ".$facturadorec.", ".$facturadootros.", ".$pagadoprovrec.", ".$pagadoprovotros.", ".$costepersonal.", ".$costeestructura.", ".$horasfichadasor.", ".$horasasignadas.", ".$entradastaller.", ".$objetivos['ta_objventas'].", ".$objetivos['ta_objmargenrec'].", ".$objetivos['ta_objeficacia'].", ".$objetivos['ta_objproductividad'].", ".$objetivos['ta_objrendimiento'].")";
		if(!query($consulta)){
			$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['hayerrores']=1;
			$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['mensaje']='Error al guardar - INSERTANDO '.$consulta;

		}
		else{
			$nuevodatoact=insertado();
		}
	}
}
else{//Editamos registro
    $consulta='update datos_actividad set da_diaslaborables='.$diaslab.', da_horaspresencia='.$horaspresencia.', da_horasfac='.$horasfac.', da_horasimproductivas='.$horasimproductivas.', da_nofacturado='.$nofacturado.', da_facturadomo='.$facturadomo.', da_facturadorec='.$facturadorec.', da_facturadootros='.$facturadootros.', da_pagadoprovrec='.$pagadoprovrec.', da_pagadoprovotros='.$pagadoprovotros.', da_costepersonal='.$costepersonal.', da_costeestructura='.$costeestructura.', da_horasfichadasor='.$horasfichadasor.', da_horasasignadas='.$horasasignadas.', da_entradastaller='.$entradastaller.' where da_idtaller='.$id_taller.' and da_iddato='.$datoact;
	if(!query($consulta)){
		$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['mensaje']='Error al guardar - EDITANDO '.$consulta;
	}
	else{
		query('delete from presencia_personal where pp_iddato='.$datoact);
		$nuevodatoact=$datoact;
	}
}


		
foreach($empleados_directos as $empleado_directo){
	$marcado=clean_post('activaemp_'.$empleado_directo->pt_idpersonal);
	if($marcado!=''){
		$extraspagadas=clean_post('extraspagadas_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
		!is_numeric($extraspagadas)||$extraspagadas<=0?$extraspagadas=0:null;
		$diasvacaciones=clean_post('diasvacaciones_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
		!is_numeric($diasvacaciones)||$diasvacaciones<=0?$diasvacaciones=0:null;
		$diasbaja=clean_post('diasbaja_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
		!is_numeric($diasbaja)||$diasbaja<=0?$diasbaja=0:null;
		$diaspermiso=clean_post('diaspermiso_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
		!is_numeric($diaspermiso)||$diaspermiso<=0?$diaspermiso=0:null;
		$diasformacion=clean_post('diasformacion_'.$empleado_directo->pt_idpersonal.'_'.$datoact);
		!is_numeric($diasformacion)||$diasformacion<=0?$diasformacion=0:null;
		query('insert into presencia_personal (pp_iddato, pp_idpersonal, pp_extraspagadas, pp_diasvacaciones, pp_diasbaja, pp_diaspermiso, pp_diasformacion) values ('.$nuevodatoact.', '.$empleado_directo->pt_idpersonal.', '.$extraspagadas.', '.$diasvacaciones.', '.$diasbaja.', '.$diaspermiso.', '.$diasformacion.')');
	}
}

if($_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']==1&&$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['hayerrores']==0){
	$_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']=en__('pdf_infome_mensual%%imprimir%%'.$id_taller.'%%'.$mes.'%%'.$ano.'');
}
else{
    $_SESSION['datos_'._ID_PAG_]['edita_datomensual']['enviamail']=0;
}

fuera_de_aqui($url_dest);