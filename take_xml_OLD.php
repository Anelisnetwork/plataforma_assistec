<?php

$xml_res = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><respuesta></respuesta>');
$rs_resultado=$xml_res->addChild('rs_resultado');
$rs_resultado->addChild('resultado', 'KO');
$rs_resultado->addChild('mensaje', 'EN DESARROLLO');
echo $xml_res->asXML();
exit();

require_once('core/core.php');

open_bd();

$hay_errores=0;
$mensaje='Datos recibidos';

$xml_res = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><respuesta></respuesta>');

$rs_resultado=$xml_res->addChild('rs_resultado');
$rs_datos_acceso=$xml_res->addChild('rs_datos_acceso');

try{
	$datos=new SimpleXMLElement($_POST['dato']);
}
catch(Exception $e){
	$hay_errores=1;
	$mensaje='El archivo XML no tiene el formato adecuado';
}

if($hay_errores==1){
	$rs_resultado->addChild('resultado', 'KO');
	$rs_resultado->addChild('mensaje', $mensaje);
	echo $xml_res->asXML();
	exit;
}
else{
	$rs_resultado->addChild('resultado', 'OK');
	$rs_resultado->addChild('mensaje', 'Archivo recibido');

	if(isset($datos->datosred->idred)){
		$idred=de__id($datos->datosred->idred);
	}
	else{
		$rs_datos_acceso->addChild('resultado', 'KO');
		$rs_datos_acceso->addChild('mensaje', 'No ha indicado red de talleres');
		echo $xml_res->asXML();
		exit;
	}
	if($idred!=4){
		$rs_datos_acceso->addChild('resultado', 'KO');
		$rs_datos_acceso->addChild('mensaje', 'El ID de red de talleres no es válido en entorno de pruebas.');
		echo $xml_res->asXML();
		exit;
	}
	if(isset($datos->datosred->token)){
		$token=$datos->datosred->token;
	}
	else{
		$rs_datos_acceso->addChild('resultado', 'KO');
		$rs_datos_acceso->addChild('mensaje', 'No ha indicado la clave de acceso de su red de talleres');
		echo $xml_res->asXML();
		exit;
	}

	if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idred.' and ta_idtipo=2')!=1){
		$rs_datos_acceso->addChild('resultado', 'KO');
		$rs_datos_acceso->addChild('mensaje', 'No existe red de talleres con el ID que nos ha indicado');
		echo $xml_res->asXML();
;
		exit;
	}
	if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idred.' and ta_idtipo=2 and ta_log_token="'.$token.'"')!=1){
		$rs_datos_acceso->addChild('resultado', 'KO');
		$rs_datos_acceso->addChild('mensaje', 'La clave de acceso indicada no es correcta');
		echo $xml_res->asXML();
		exit;
	}
	
	$rs_datos_acceso->addChild('resultado', 'OK');
	$rs_datos_acceso->addChild('mensaje', 'Datos de acceso correctos');
	
	$alta_talleres=isset($datos->nuevo_taller)?1:0;
	$datos_actividad=isset($datos->actividad)?1:0;
	
	if($datos_actividad==1){//Si se envían datos de actividad
		foreach($datos->actividad as $dato_actividad){//Para cada taller (dato actividad)
			$rs_datos_actividad=$xml_res->addChild('rs_datos_actividad');
			if(isset($dato_actividad->idtaller)){
				$idtaller=de__id($dato_actividad->idtaller);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo $xml_res->asXML();
				continue;
			}
			if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.' and ta_idtipo=1 and ta_idparent='.$idred.'')!=1){//El taller no existe
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'No existe taller con el ID que nos ha indicado');
				//echo $xml_res->asXML();
				continue;
			}
			else{
				$nombre_taller=dato_taller('ta_nombre', $idtaller);
				//echo 'Cargando datos de actividad para el taller '.$nombre_taller.'<br>';
			}
			
			if(isset($dato_actividad->tipo)){
				$tipo=$dato_actividad->tipo;
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <tipo>.<br>';
				continue;
			}
			if($tipo!=1&&$tipo!=2){
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'El tipo de actividad indicado no es correcto');
				//echo 'El tipo de actividad indicado no es correcto.<br>';
				continue;
			}
			
			if(isset($dato_actividad->mes)){
				$mes=intval($dato_actividad->mes);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <mes>.<br>';
				continue;
			}
			if($mes<1||$mes>12){
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'El mes debe estar comprendido entre 01 y 12 (2 dígitos)');
				//echo 'El mes debe estar comprendido entre 01 y 12 (2 dígitos).<br>';
				continue;
			}
			
			if(isset($dato_actividad->anho)){
				$anho=$tipo==1?$dato_actividad->anho:0;
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <anho>.<br>';
				continue;
			}
			if($tipo==1&&(strlen($anho)!=4||$anho<2015)){
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'El año debe ser posterior a 2014 (4 dígitos)');
				//echo 'El año debe ser posterior a 2014 (4 dígitos).<br>';
				continue;
			}
			
			if(isset($dato_actividad->dias)){
				$dias=$dato_actividad->dias;
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <dias>.<br>';
				continue;
			}
			if($dias<1||$dias>366){
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Debe indicar los días laborables del mes o período de la actividad (entre 1 y 366)');
				//echo 'Debe indicar los días laborables del mes o período de la actividad.<br>';
				continue;
			}
			
			if(isset($dato_actividad->preciomo)){
				$preciomo=floatval($dato_actividad->preciomo);
			}
			else{
				$preciomo=0;
			}
			$preciomo<=0?$preciomo=fetch_array('select it_impmo from info_taller where it_idtaller='.$idtaller.'','it_impmo'):'';
			if($preciomo<=0){
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Debe indicar el precio de la hora de MO o configurarlo en su ficha del panel');
				//echo 'Debe indicar el precio de la hora de MO o configurarlo en su ficha del panel.<br>';
				continue;
			}
			
			if(isset($dato_actividad->facturadomo)){
				$facturadomo=floatval($dato_actividad->facturadomo);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <facturadomo>.<br>';
				continue;
			}
			if(isset($dato_actividad->facturadorec)){
				$facturadorec=floatval($dato_actividad->facturadorec);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <facturadorec>.<br>';
				continue;
			}
			if(isset($dato_actividad->facturadovarios)){
				$facturadovarios=floatval($dato_actividad->facturadovarios);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <facturadovarios>.<br>';
				continue;
			}
			if(isset($dato_actividad->pagadorec)){
				$pagadorec=floatval($dato_actividad->pagadorec);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <pagadorec>.<br>';
				continue;
			}
			if(isset($dato_actividad->pagadovarios)){
				$pagadovarios=floatval($dato_actividad->pagadovarios);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <pagadovarios>.<br>';
				continue;
			}
			if(isset($dato_actividad->costepersonal)){
				$costepersonal=floatval($dato_actividad->costepersonal);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <costepersonal>.<br>';
				continue;
			}
			if(isset($dato_actividad->costeestructura)){
				$costeestructura=floatval($dato_actividad->costeestructura);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <costeestructura>.<br>';
				continue;
			}
			if(isset($dato_actividad->horasor)){
				$horasor=floatval($dato_actividad->horasor);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <horasor>.<br>';
				continue;
			}
			if(isset($dato_actividad->horasasignadas)){
				$horasasignadas=floatval($dato_actividad->horasasignadas);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <horasasignadas>.<br>';
				continue;
			}
			if(isset($dato_actividad->entradas)){
				$entradas=intval($dato_actividad->entradas);
			}
			else{
				$rs_datos_actividad->addChild('resultado', 'KO');
				$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
				//echo 'No existe el campo <entradas>.<br>';
				continue;
			}

			$hpresencia=0;
			if(isset($dato_actividad->empleado)){//Si hay datos de empleados
				$empleados=array();
				foreach($dato_actividad->empleado as $empleado){//Para cada empleado
					$rs_empleado=$rs_datos_actividad->addChild('rs_empleado');
					if(isset($empleado->idpersonal)){
						$idpersonal=de__id($empleado->idpersonal);
					}
					else{
						$rs_empleado->addChild('resultado', 'KO');
						$rs_empleado->addChild('mensaje', 'Faltan campos, revise la documentación.');
						//echo 'No existe el campo <idpersonal>.<br>';
						continue;
					}
					if(num_rows('select pt_idpersonal from personal_taller where pt_idpersonal='.$idpersonal.' and pt_idtaller='.$idtaller.'')!=1){//No existe este empleado
						$rs_empleado->addChild('resultado', 'KO');
						$rs_empleado->addChild('mensaje', 'No existe empleado con el ID que nos ha indicado');
						//echo 'No existe empleado con el ID que nos ha indicado.<br>';
						continue;
					}
					$jornada=fetch_array('select pt_jornada from personal_taller where pt_idtaller='.$idtaller.' and pt_idpersonal='.$idpersonal.'','pt_jornada');
					$porcent=fetch_array('select sum(pf_porcentaje) as PORCENT from personal_funciones, cargos_personal where pf_idpersonal='.$idpersonal.' and pf_idcargo=cp_idpersonal and cp_idtipo=1 group by pf_idpersonal','PORCENT');
					$porcent=$porcent==''||$porcent==NULL?0:$porcent;
					$hprod=$jornada*$porcent/100;
					$hpresencia+=($hprod*$dias);
					$extras_pagadas=isset($empleado->extras_pagadas)?floatval($empleado->extras_pagadas):0;
					$dias_vacaciones=isset($empleado->dias_vacaciones)?floatval($empleado->dias_vacaciones):0;
					$dias_baja=isset($empleado->dias_baja)?floatval($empleado->dias_baja):0;
					$horas_permiso=isset($empleado->horas_permiso)?floatval($empleado->horas_permiso):0;
					$dias_formacion=isset($empleado->dias_formacion)?floatval($empleado->dias_formacion):0;
					$empleados[]=array('idpersonal'=>$idpersonal,'extras_pagadas'=>$extras_pagadas,'dias_vacaciones'=>$dias_vacaciones,'dias_baja'=>$dias_baja,'horas_permiso'=>$horas_permiso,'dias_formacion'=>$dias_formacion);
					
					$rs_empleado->addChild('resultado', 'OK');
					$rs_empleado->addChild('mensaje', 'Datos de personal correctos');
				}//Para cada empleado
			}//Si hay datos de empleados
			else{//Si no hay datos de empleados
				if(isset($dato_actividad->hpresencia)){
					$hpresencia=floatval($dato_actividad->hpresencia);
				}
				else{
					$rs_datos_actividad->addChild('resultado', 'KO');
					$rs_datos_actividad->addChild('mensaje', 'No ha indicado datos de empleados ni existe el campo de horas de presencia');
					//echo 'No ha indicado datos de empleados ni existe el campo <hpresencia>.<br>';
					continue;
				}
			}//Si no hay datos de empleados

			$hcobradas=$preciomo>0?$facturadomo/$preciomo:0;
			
			if($hpresencia>0&&$hpresencia>$hcobradas){
				$hperdidas=$hpresencia-$hcobradas;
				$nofacturado=$hperdidas*$preciomo;
			}
			else{
				$hperdidas=0;
				$nofacturado=0;
			}
			
			$filtro_extra=$tipo==0?'':' and da_mes='.$mes.' and da_ano='.$anho.'';
			$iddato=fetch_array('select da_iddato from datos_actividad where da_idtipo='.$tipo.' and da_idtaller='.$idtaller.''.$filtro_extra.'','da_iddato');
			if($iddato==''||$iddato==NULL){//Es un dato nuevo
				$objetivos=fetch_array('select ta_objventas, ta_objmargenrec, ta_objeficacia, ta_objproductividad, ta_objrendimiento from talleres where ta_idtaller='.$idtaller.'');
				if(!query('insert into datos_actividad (da_idtaller, da_mes, da_ano, da_tipopresencia, da_impmo, da_diaslaborables, da_horaspresencia, da_horasfac, da_horasimproductivas, da_nofacturado, da_facturadomo, da_facturadorec, da_facturadootros, da_pagadoprovrec, da_pagadoprovotros, da_costepersonal, da_costeestructura, da_horasfichadasor, da_horasasignadas, da_entradastaller, da_objventas, da_objmargenrec, da_objeficacia, da_objproductividad, da_objrendimiento) values ('.$idtaller.', '.$mes.', '.$anho.', 2, '.$preciomo.', '.$dias.', '.$hpresencia.', '.$hcobradas.', '.$hperdidas.', '.$nofacturado.', '.$facturadomo.', '.$facturadorec.', '.$facturadovarios.', '.$pagadorec.', '.$pagadovarios.', '.$costepersonal.', '.$costeestructura.', '.$horasor.', '.$horasasignadas.', '.$entradas.', '.$objetivos['ta_objventas'].', '.$objetivos['ta_objmargenrec'].', '.$objetivos['ta_objeficacia'].', '.$objetivos['ta_objproductividad'].', '.$objetivos['ta_objrendimiento'].')')){
					$rs_datos_actividad->addChild('resultado', 'KO');
					$rs_datos_actividad->addChild('mensaje', 'No se ha podido guardar el dato de actividad para el taller '.$nombre_taller.'');
					//echo 'No se ha podido guardar el dato de actividad para el taller '.$nombre_taller.'.<br>';
					continue;
				}
				else{
					$iddato=insertado();
				}
			}//Es un dato nuevo
			else{//Editamos dato existente
				$datos_extra=$tipo==0?'da_mes='.$mes.', ':'';
				if(!query('update datos_actividad set '.$datos_extra.'da_tipopresencia=2, da_diaslaborables='.$dias.', da_horaspresencia='.$hpresencia.', da_horasfac='.$hcobradas.', da_horasimproductivas='.$hperdidas.', da_nofacturado='.$nofacturado.', da_facturadomo='.$facturadomo.', da_facturadorec='.$facturadorec.', da_facturadootros='.$facturadovarios.', da_pagadoprovrec='.$pagadorec.', da_pagadoprovotros='.$pagadovarios.', da_costepersonal='.$costepersonal.', da_costeestructura='.$costeestructura.', da_horasfichadasor='.$horasor.', da_horasasignadas='.$horasasignadas.', da_entradastaller='.$entradas.' where da_idtaller='.$idtaller.' and da_iddato='.$iddato.'')){
					$rs_datos_actividad->addChild('resultado', 'KO');
					$rs_datos_actividad->addChild('mensaje', 'No se ha podido actualizar los datos de actividad para el taller '.$nombre_taller.'');
					//echo 'No se ha podido actualizar los datos de actividad para el taller '.$nombre_taller.'.<br>';
					continue;
				}
				else{
					query('delete from presencia_personal where pp_iddato='.$iddato.'');
				}
			}//Editamos dato existente
			
			if(isset($empleados)){
				$error_personal=0;
				foreach($empleados as $empleado){
					if(!query('insert into presencia_personal (pp_iddato, pp_idpersonal, pp_extraspagadas, pp_diasvacaciones, pp_diasbaja, pp_diaspermiso, pp_diasformacion) values ('.$iddato.', '.$empleado['idpersonal'].', '.$empleado['extras_pagadas'].', '.$empleado['dias_vacaciones'].', '.$empleado['dias_baja'].', '.$empleado['horas_permiso'].', '.$empleado['dias_formacion'].')')){
						$error_personal=1;
					}
				}
				if($error_personal==1){//ha habido errores al guardar los datos de presencia del personal
					query('delete from presencia_personal where pp_iddato='.$iddato.'');
					$rs_datos_actividad->addChild('resultado', 'KO');
					$rs_datos_actividad->addChild('mensaje', 'No se ha podido actualizar los datos presencia de personal para el taller '.$nombre_taller.'');
					//echo 'No se ha podido actualizar los datos presencia de personal para el taller '.$nombre_taller.'.<br>';
					continue;
				}
				else{
					query('update datos_actividad set da_tipopresencia=1 where da_iddato='.$iddato.'');
				}
			}
			$rs_datos_actividad->addChild('resultado', 'OK');
			$rs_datos_actividad->addChild('mensaje', 'Guardado correctamente el dato de actividad para el taller '.$nombre_taller.'');
			//echo 'Guardado correctamente el dato de actividad para el taller '.$nombre_taller.'<br><br>';
		}//Para cada taller (dato actividad)
	}//Si se envían datos de actividad
	
	
	if($alta_talleres==1){//Si se envían datos de nuevo taller
		foreach($datos->nuevo_taller as $nuevo_taller){//Para cada nuevo taller
			$rs_nuevo_taller=$xml_res->addChild('rs_nuevo_taller');
			if(isset($nuevo_taller->correo)){
				$correo=$nuevo_taller->correo;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if(!VerificarDireccionCorreo($correo)){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'La dirección de correo '.$correo.' no tiene el formato correcto');
				continue;
			}
			if(num_rows('select us_correo from usuarios where us_correo="'.$rg_email.'"')!=0){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'La dirección de correo '.$correo.' no es válida');
				continue;
			}
			
			if(isset($nuevo_taller->password)){
				$password=$nuevo_taller->password;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if(strlen($password)<5){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'La contraseña debe tener al menos 5 caracteres');
				continue;
			}
			if(formato_pass($password)==0){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'La contraseña sólo puede contener números, letras, y los caracteres - _ & @ $');
				continue;
			}
			
			if(isset($nuevo_taller->nombre)){
				$nombre=$nuevo_taller->nombre;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if($nombre==''){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Debe indicar el nombre del taller');
				continue;
			}
			
			if(isset($nuevo_taller->direccion)){
				$direccion=$nuevo_taller->direccion;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if($direccion==''){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Debe indicar la dirección del taller');
				continue;
			}
			
			if(isset($nuevo_taller->codigo_postal)){
				$codigo_postal=$nuevo_taller->codigo_postal;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if(formato_cp($codigo_postal)==0){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'El código postal no es correcto, sólo puede contener números y el guión medio (-)');
				continue;
			}
			
			if(isset($nuevo_taller->localidad)){
				$localidad=$nuevo_taller->localidad;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if($localidad==''){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Debe indicar la localidad del taller');
				continue;
			}
			
			if(isset($nuevo_taller->provincia)){
				$provincia=$nuevo_taller->provincia;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if($provincia==''){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Debe indicar la provincia del taller');
				continue;
			}
			
			if(isset($nuevo_taller->telefono)){
				$telefono=limpia_tlf($nuevo_taller->telefono);
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			if($telefono==''){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Debe indicar el teléfono del taller');
				continue;
			}
			
			if(isset($nuevo_taller->contacto)){
				$contacto=$nuevo_taller->contacto;
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			
			if(isset($nuevo_taller->nifcif)){
				$nifcif=limpia_nifcif($nuevo_taller->nifcif);
			}
			else{
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'Faltan campos, revise la documentación.');
				continue;
			}
			
			$tipo=1;
			$pago=5;
			
			$datosred=list_object('select ta_contrato, ta_vencimiento from talleres where ta_idtaller="'.$idred.'" and ta_idtipo=2');
			$contrato=$datosred[0]->ta_contrato;
			$vencimiento=$datosred[0]->ta_vencimiento;
			
			$sec_pass=secure_md5($password);
			
			if(!query('INSERT into usuarios (us_correo, us_pass, us_fecha_alta, us_estado) VALUES ("'.$correo.'", "'.$sec_pass.'", "'.date('Y-m-d H:i:s').'", "1")')){
				$rs_nuevo_taller->addChild('resultado', 'KO');
				$rs_nuevo_taller->addChild('mensaje', 'No se ha podido crear el usuario para el taller '.$nombre.'');
				continue;
			}
			else{
				$idusuario=insertado();
				if(!query('insert into talleres (ta_idtipo, ta_idparent, ta_nombre, ta_contacto, ta_telefono1, ta_email, ta_direccion, ta_cp, ta_localidad, ta_provincia, ta_contrato, ta_abono, ta_vencimiento) values ('.$tipo.', '.$idred.', "'.u8_($nombre).'", "'.u8_($contacto).'", "'.$telefono.'", "'.$correo.'", "'.u8_($direccion).'", "'.$codigo_postal.'", "'.u8_($localidad).'", "'.u8_($provincia).'", '.$contrato.', '.$pago.', "'.$vencimiento.'")')){
					query('delete from usuarios where us_idusuario="'.$idusuario.'"');
					$rs_nuevo_taller->addChild('resultado', 'KO');
					$rs_nuevo_taller->addChild('mensaje', 'No se ha podido guardar el taller '.$nombre.'');
					continue;
				}
				else{
					$nuevotaller=insertado();
					if(!query('insert into usuarios_facturacion (uf_idtaller, uf_denomsoc, uf_cifnif, uf_nomcom, uf_contacto, uf_telefono1, uf_email, uf_direccion, uf_cp, uf_localidad, uf_provincia) values ("'.$nuevotaller.'", "'.u8_($nombre).'", "'.$nifcif.'", "'.u8_($nombre).'", "'.u8_($contacto).'", "'.$telefono.'", "'.$correo.'", "'.u8_($direccion).'", "'.$codigo_postal.'", "'.u8_($localidad).'", "'.u8_($provincia).'")')){
						query('delete from usuarios where us_idusuario="'.$idusuario.'"');
						query('delete from talleres where ta_idtaller="'.$nuevotaller.'"');
						$rs_nuevo_taller->addChild('resultado', 'KO');
						$rs_nuevo_taller->addChild('mensaje', 'No se ha podido guardar los datos de facturación para el taller '.$nombre.'');
						continue;
					}
					else{
						$nuevadirfac=insertado();
						query('update usuarios set us_idtaller="'.$nuevotaller.'" where us_idusuario="'.$idusuario.'"');
						query('update talleres set ta_iddirfac='.$nuevadirfac.' where ta_idtaller='.$nuevotaller.'' );
						query('INSERT into info_taller (it_idtaller) VALUES ("'.$nuevotaller.'")');
						query('INSERT into datos_actividad (da_mes, da_idtaller, da_idtipo) VALUES (1, "'.$nuevotaller.'", 0)');
					}
				}
			}
			$rs_nuevo_taller->addChild('resultado', 'OK');
			$rs_nuevo_taller->addChild('mensaje', 'Creado nuevo taller '.$nombre.'');
		}//Para cada nuevo taller
	}//Si se envían datos de nuevo taller
}

close_bd();

echo $xml_res->asXML();
?>