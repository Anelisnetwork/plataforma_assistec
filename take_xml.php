<?php
//var_dump($_POST);exit;
//$dat='{"comment":[{},{},{}],"datosred":{"idred":"AS0000jS6000xG0000","token":"c28df5dc3cb3d037e49ffb5fb65fa85d"},"actividad":{"idtaller":"AS0000jS0051xG0000","tipo":"1","mes":"01","anho":"2019","dias":"22","preciomo":"35","facturadomo":"5703.85","comment":[{},{},{},{},{},{},{},{}],"facturadorec":"6974.93","facturadovarios":"0","pagadorec":"0","pagadovarios":"0","costepersonal":"4000","costeestructura":"1500","horasor":"185.487","horasasignadas":"0","hpresencia":"396","entradas":"55","empleado":[{"idpersonal":"AS0000jS6910xG0000","extras_pagadas":{},"dias_vacaciones":"0","dias_baja":"0","horas_permiso":{},"dias_formacion":{}},{"idpersonal":"AS0000jS7910xG0000","extras_pagadas":{},"dias_vacaciones":"0","dias_baja":"0","horas_permiso":{},"dias_formacion":{}}]}}';

$testing=isset($testing)?$testing:0;

require_once('core/core.php');

show_errors('on');

open_bd();

ob_start();

$hay_errores=0;
$mensaje='Datos recibidos';

$xml_res = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><respuesta></respuesta>');

//var_dump($_POST);exit;

$rs_resultado=$xml_res->addChild('rs_resultado');
$rs_datos_acceso=$xml_res->addChild('rs_datos_acceso');

//var_dump($_POST['dato']);exit;

$idtaller=0;
$anho='';
$cerrado=0;
$haynuevo=0;
$datos=array();
$alta_talleres=0;

try{
	$datos=new SimpleXMLElement($_REQUEST['dato']);
	//$datos=json_decode($dat);
}
catch(Exception $e){
	$hay_errores=1;
	$mensaje='El archivo XML no tiene el formato adecuado -> '.$e;
    $datos=$_REQUEST;
}
//var_dump($datos);exit;

//echo de__id(trim($datos->datosred->idred));exit;


if($hay_errores==1){
	$rs_resultado->addChild('resultado', 'KO');
	$rs_resultado->addChild('mensaje', $mensaje);
	echo $xml_res->asXML();
	$cerrado=1;
}
else{
	$rs_resultado->addChild('resultado', 'OK');
	$rs_resultado->addChild('mensaje', 'Archivo recibido');
    $idred=0;

	if(isset($datos->datosred->idred)){
		$idred=de__id(trim($datos->datosred->idred));
	}
	else{
		$rs_datos_acceso->addChild('resultado', 'KO');
		$rs_datos_acceso->addChild('mensaje', 'No ha indicado red de talleres');
		echo $xml_res->asXML();
		$cerrado=1;
	}

	if($cerrado==0){
		/*if($idred!=4){
			$rs_datos_acceso->addChild('resultado', 'KO');
			$rs_datos_acceso->addChild('mensaje', 'El ID de red de talleres no es válido en entorno de pruebas.');
			echo $xml_res->asXML();
			$cerrado=1;
		}*/

		if($cerrado==0){
            $token='0';
			if(isset($datos->datosred->token)){
				$token=$datos->datosred->token;
			}
			else{
				$rs_datos_acceso->addChild('resultado', 'KO');
				$rs_datos_acceso->addChild('mensaje', 'No ha indicado la clave de acceso de su red de talleres');
				echo $xml_res->asXML();
				$cerrado=1;
			}
			if($cerrado==0){
				if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idred.' and ta_idtipo=2')!=1){
					$rs_datos_acceso->addChild('resultado', 'KO');
					$rs_datos_acceso->addChild('mensaje', 'No existe red de talleres con el ID que nos ha indicado');
					echo $xml_res->asXML();
					$cerrado=1;
				}
				if($cerrado==0){
					if(num_rows("select ta_idtaller from talleres where ta_idtaller='{$idred}' and ta_idtipo=2 and ta_log_token='".$token."'")!=1){
						$rs_datos_acceso->addChild('resultado', 'KO');
						$rs_datos_acceso->addChild('mensaje', 'La clave de acceso indicada no es correcta');
						echo $xml_res->asXML();
						$cerrado=1;
					}
					
					if($cerrado==0){
						$rs_datos_acceso->addChild('resultado', 'OK');
						$rs_datos_acceso->addChild('mensaje', 'Datos de acceso correctos');
						
						$alta_talleres=isset($datos->nuevo_taller)?1:0;
						$datos_actividad=isset($datos->actividad)?1:0;
						
						if($datos_actividad==1){//Si se envían datos de actividad
							foreach($datos->actividad as $dato_actividad){//Para cada taller (dato actividad)
								$rs_datos_actividad=$xml_res->addChild('rs_datos_actividad');
								if(isset($dato_actividad->idtaller)){
									$idtaller=de__id(trim($dato_actividad->idtaller));
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo $xml_res->asXML();
									continue;
								}
								if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.' and ta_idtipo=1 and ta_idparent='.$idred)!=1){//El taller no existe
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
									$preciomo=floatvalue($dato_actividad->preciomo);
								}
								else{
									$preciomo=0;
								}
								$preciomo<=0?$preciomo=fetch_array('select it_impmo from info_taller where it_idtaller='.$idtaller,'it_impmo'):null;
								if($preciomo<=0){
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Debe indicar el precio de la hora de MO o configurarlo en su ficha del panel');
									//echo 'Debe indicar el precio de la hora de MO o configurarlo en su ficha del panel.<br>';
									continue;
								}
								
								if(isset($dato_actividad->facturadomo)){
									$facturadomo=floatvalue($dato_actividad->facturadomo);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <facturadomo>.<br>';
									continue;
								}
								if(isset($dato_actividad->facturadorec)){
									$facturadorec=floatvalue($dato_actividad->facturadorec);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <facturadorec>.<br>';
									continue;
								}
								if(isset($dato_actividad->facturadovarios)){
									$facturadovarios=floatvalue($dato_actividad->facturadovarios);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <facturadovarios>.<br>';
									continue;
								}
								if(isset($dato_actividad->pagadorec)){
									$pagadorec=floatvalue($dato_actividad->pagadorec);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <pagadorec>.<br>';
									continue;
								}
								if(isset($dato_actividad->pagadovarios)){
									$pagadovarios=floatvalue($dato_actividad->pagadovarios);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <pagadovarios>.<br>';
									continue;
								}
								if(isset($dato_actividad->costepersonal)){
									$costepersonal=floatvalue($dato_actividad->costepersonal);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <costepersonal>.<br>';
									continue;
								}
								if(isset($dato_actividad->costeestructura)){
									$costeestructura=floatvalue($dato_actividad->costeestructura);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <costeestructura>.<br>';
									continue;
								}
								if(isset($dato_actividad->horasor)){
									$horasor=floatvalue($dato_actividad->horasor);
								}
								else{
									$rs_datos_actividad->addChild('resultado', 'KO');
									$rs_datos_actividad->addChild('mensaje', 'Faltan campos, revise la documentación.');
									//echo 'No existe el campo <horasor>.<br>';
									continue;
								}
								if(isset($dato_actividad->horasasignadas)){
									$horasasignadas=floatvalue($dato_actividad->horasasignadas);
								}
								else{
                                    $horasasignadas=$horasor;
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

								$tipopresencia=1;
								$hpresencia=0;
                                $porpresencia=1;
                                if(isset($dato_actividad->hpresencia) && floatvalue($dato_actividad->hpresencia)!=0){
                                    $hpresencia=floatvalue($dato_actividad->hpresencia);
                                    $porpresencia=2;
                                    $tipopresencia=2;
                                }
                                if (isset($dato_actividad->empleado)) {//Si hay datos de empleados
                                    $empleados = array();
                                    foreach ($dato_actividad->empleado as $empleado) {//Para cada empleado
                                        $rs_empleado = $rs_datos_actividad->addChild('rs_empleado');
                                        if (isset($empleado->idpersonal)) {
                                            $idpersonal = de__id(trim($empleado->idpersonal));
                                        } else {
                                            $rs_empleado->addChild('resultado', 'KO');
                                            $rs_empleado->addChild('mensaje', 'Faltan campos, revise la documentación.');
                                            //echo 'No existe el campo <idpersonal>.<br>';
                                            continue;
                                        }
                                        if (num_rows('SELECT pt_idpersonal FROM personal_taller WHERE pt_idpersonal=' . $idpersonal . ' AND pt_idtaller=' . $idtaller) != 1) {//No existe este empleado
                                            $rs_empleado->addChild('resultado', 'KO');
                                            $rs_empleado->addChild('mensaje', 'No existe empleado con el ID que nos ha indicado');
                                            //echo 'No existe empleado con el ID que nos ha indicado.<br>';
                                            continue;
                                        }
                                        $jornada = fetch_array('SELECT pt_jornada FROM personal_taller WHERE pt_idtaller=' . $idtaller . ' AND pt_idpersonal=' . $idpersonal, 'pt_jornada');
                                        $porcent = fetch_array('SELECT sum(pf_porcentaje) AS PORCENT FROM personal_funciones, cargos_personal WHERE pf_idpersonal=' . $idpersonal . ' AND pf_idcargo=cp_idpersonal AND cp_idtipo=1 GROUP BY pf_idpersonal', 'PORCENT');
                                        $porcent = $porcent == '' || $porcent == NULL ? 0 : $porcent;
                                        $hprod = $jornada * $porcent / 100;
                                        $porpresencia==1?$hpresencia += ($hprod * $dias):false;
                                        $extras_pagadas = isset($empleado->extras_pagadas) ? floatvalue($empleado->extras_pagadas) : 0;
                                        $dias_vacaciones = isset($empleado->dias_vacaciones) ? floatvalue($empleado->dias_vacaciones) : 0;
                                        $dias_baja = isset($empleado->dias_baja) ? floatvalue($empleado->dias_baja) : 0;
                                        $horas_permiso = isset($empleado->horas_permiso) ? floatvalue($empleado->horas_permiso) : 0;
                                        $dias_formacion = isset($empleado->dias_formacion) ? floatvalue($empleado->dias_formacion) : 0;
                                        $empleados[] = array('idpersonal' => $idpersonal, 'extras_pagadas' => $extras_pagadas, 'dias_vacaciones' => $dias_vacaciones, 'dias_baja' => $dias_baja, 'horas_permiso' => $horas_permiso, 'dias_formacion' => $dias_formacion);

                                        $rs_empleado->addChild('resultado', 'OK');
                                        $rs_empleado->addChild('mensaje', 'Datos de personal correctos');
                                    }//Para cada empleado
                                }//Si hay datos de empleados
                                if($hpresencia==0) {//Si no hay horas de presencia
                                    $rs_datos_actividad->addChild('resultado', 'KO');
                                    $rs_datos_actividad->addChild('mensaje', 'No ha indicado datos de empleados ni existe el campo de horas de presencia');
                                    continue;
                                    //echo 'No ha indicado datos de empleados ni existe el campo <hpresencia>.<br>';
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
									$objetivos=fetch_array('select ta_objventas, ta_objmargenrec, ta_objeficacia, ta_objproductividad, ta_objrendimiento from talleres where ta_idtaller='.$idtaller);
									if(!query('insert into datos_actividad (da_idtaller, da_mes, da_ano, da_tipopresencia, da_impmo, da_diaslaborables, da_horaspresencia, da_horasfac, da_horasimproductivas, da_nofacturado, da_facturadomo, da_facturadorec, da_facturadootros, da_pagadoprovrec, da_pagadoprovotros, da_costepersonal, da_costeestructura, da_horasfichadasor, da_horasasignadas, da_entradastaller, da_objventas, da_objmargenrec, da_objeficacia, da_objproductividad, da_objrendimiento, da_testing) values ('.$idtaller.', '.$mes.', '.$anho.', '.$tipopresencia.', '.$preciomo.', '.$dias.', '.$hpresencia.', '.$hcobradas.', '.$hperdidas.', '.$nofacturado.', '.$facturadomo.', '.$facturadorec.', '.$facturadovarios.', '.$pagadorec.', '.$pagadovarios.', '.$costepersonal.', '.$costeestructura.', '.$horasor.', '.$horasasignadas.', '.$entradas.', '.$objetivos['ta_objventas'].', '.$objetivos['ta_objmargenrec'].', '.$objetivos['ta_objeficacia'].', '.$objetivos['ta_objproductividad'].', '.$objetivos['ta_objrendimiento'].', '.$testing.')')){
										$rs_datos_actividad->addChild('resultado', 'KO');
										$rs_datos_actividad->addChild('mensaje', 'No se ha podido guardar el dato de actividad para el taller <strong>'.$nombre_taller.'</strong>');
										//echo 'No se ha podido guardar el dato de actividad para el taller '.$nombre_taller.'.<br>';
										continue;
									}
									else{
										$iddato=insertado();
										$haynuevo=1;
									}
								}//Es un dato nuevo
								else{//Editamos dato existente
									$datos_extra=$tipo==0?'da_mes='.$mes.', ':'';
									if(!query('update datos_actividad set '.$datos_extra.'da_tipopresencia='.$tipopresencia.', da_diaslaborables='.$dias.', da_horaspresencia='.$hpresencia.', da_horasfac='.$hcobradas.', da_horasimproductivas='.$hperdidas.', da_nofacturado='.$nofacturado.', da_facturadomo='.$facturadomo.', da_facturadorec='.$facturadorec.', da_facturadootros='.$facturadovarios.', da_pagadoprovrec='.$pagadorec.', da_pagadoprovotros='.$pagadovarios.', da_costepersonal='.$costepersonal.', da_costeestructura='.$costeestructura.', da_horasfichadasor='.$horasor.', da_horasasignadas='.$horasasignadas.', da_entradastaller='.$entradas.' where da_idtaller='.$idtaller.' and da_iddato='.$iddato)){
										$rs_datos_actividad->addChild('resultado', 'KO');
										$rs_datos_actividad->addChild('mensaje', 'No se ha podido actualizar los datos de actividad para el taller <strong>'.$nombre_taller.'</strong>');
										//echo 'No se ha podido actualizar los datos de actividad para el taller '.$nombre_taller.'.<br>';
										continue;
									}
									else{
										query('delete from presencia_personal where pp_iddato='.$iddato);
									}
								}//Editamos dato existente
								
								if(isset($empleados)){
									$error_personal=0;
									foreach($empleados as $empleado){
										if(!query('insert into presencia_personal (pp_iddato, pp_idpersonal, pp_extraspagadas, pp_diasvacaciones, pp_diasbaja, pp_diaspermiso, pp_diasformacion, pp_testing) values ('.$iddato.', '.$empleado['idpersonal'].', '.$empleado['extras_pagadas'].', '.$empleado['dias_vacaciones'].', '.$empleado['dias_baja'].', '.$empleado['horas_permiso'].', '.$empleado['dias_formacion'].', '.$testing.')')){
											$error_personal=1;
										}
									}
									if($error_personal==1){//ha habido errores al guardar los datos de presencia del personal
										query('delete from presencia_personal where pp_iddato='.$iddato);
                                        query('update datos_actividad set da_tipopresencia=2 where da_iddato='.$iddato);
										$rs_datos_actividad->addChild('resultado', 'KO');
										$rs_datos_actividad->addChild('mensaje', 'No se ha podido actualizar los datos presencia de personal para el taller <strong>'.$nombre_taller.'</strong>');
										//echo 'No se ha podido actualizar los datos presencia de personal para el taller '.$nombre_taller.'.<br>';
										continue;
									}
								}
								$rs_datos_actividad->addChild('resultado', 'OK');
								$rs_datos_actividad->addChild('mensaje', 'Guardado correctamente el dato de actividad para el taller <strong>'.$nombre_taller.'</strong>');
								//echo 'Guardado correctamente el dato de actividad para el taller '.$nombre_taller.'<br><br>';
							}//Para cada taller (dato actividad)
						}//Si se envían datos de actividad
					}
				}
			}
		}
	}
	
	if($cerrado==0){
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
				if(num_rows("select us_correo from usuarios where us_correo='".$correo."'")!=0){
					$rs_nuevo_taller->addChild('resultado', 'KO');
					$rs_nuevo_taller->addChild('mensaje', 'La dirección de correo <strong>'.$correo.'</strong> no es válida');
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
				
				$datosred=list_object("select ta_contrato, ta_vencimiento from talleres where ta_idtaller='".$idred."' and ta_idtipo=2");
				$contrato=$datosred[0]->ta_contrato;
				$vencimiento=$datosred[0]->ta_vencimiento;
				
				$sec_pass=secure_md5($password);
                $token_silent=encriptar($correo.'%%'.$sec_pass);
				
				if(!query("INSERT into usuarios (us_correo, us_pass, us_fecha_alta, us_estado, us_testing, us_accesosilent) VALUES ('".$correo."', '".$sec_pass."', '".date("Y-m-d H:i:s")."', '1', ".$testing.", '".$token_silent."')")){
					$rs_nuevo_taller->addChild('resultado', 'KO');
					$rs_nuevo_taller->addChild('mensaje', 'No se ha podido crear el usuario para el taller <strong>'.$nombre.'</strong>');
					continue;
				}
				else{
					$idusuario=insertado();
					if(!query("insert into talleres (ta_idtipo, ta_idparent, ta_nombre, ta_contacto, ta_telefono1, ta_email, ta_direccion, ta_cp, ta_localidad, ta_provincia, ta_contrato, ta_abono, ta_vencimiento, ta_testing) values (".$tipo.", ".$idred.", '".u8_($nombre)."', '".u8_($contacto)."', '".$telefono."', '".$correo."', '".u8_($direccion)."', '".$codigo_postal."', '".u8_($localidad)."', '".u8_($provincia)."', ".$contrato.", ".$pago.", '".$vencimiento."', ".$testing.")")){
						query("delete from usuarios where us_idusuario='".$idusuario."'");
						$rs_nuevo_taller->addChild('resultado', 'KO');
						$rs_nuevo_taller->addChild('mensaje', 'No se ha podido guardar el taller <strong>'.$nombre.'</strong>');
						continue;
					}
					else{
						$nuevotaller=insertado();
						if(!query("insert into usuarios_facturacion (uf_idtaller, uf_denomsoc, uf_cifnif, uf_nomcom, uf_contacto, uf_telefono1, uf_email, uf_direccion, uf_cp, uf_localidad, uf_provincia, uf_testing) values ('".$nuevotaller."', '".u8_($nombre)."', '".$nifcif."', '".u8_($nombre)."', '".u8_($contacto)."', '".$telefono."', '".$correo."', '".u8_($direccion)."', '".$codigo_postal."', '".u8_($localidad)."', '".u8_($provincia)."', ".$testing.")")){
							query("delete from usuarios where us_idusuario='".$idusuario."'");
							query("delete from talleres where ta_idtaller='".$nuevotaller."'");
							$rs_nuevo_taller->addChild('resultado', 'KO');
							$rs_nuevo_taller->addChild('mensaje', 'No se ha podido guardar los datos de facturación para el taller <strong>'.$nombre.'</strong>');
							continue;
						}
						else{
							$nuevadirfac=insertado();
							query("update usuarios set us_idtaller='".$nuevotaller."' where us_idusuario='".$idusuario."'");
							query("update talleres set ta_iddirfac=".$nuevadirfac." where ta_idtaller=".$nuevotaller);
							query("INSERT into info_taller (it_idtaller, it_testing) VALUES ('".$nuevotaller."', ".$testing.")");
							query("INSERT into datos_actividad (da_mes, da_idtaller, da_idtipo, da_testing) VALUES (1, '".$nuevotaller."', 0, ".$testing.")");
						}
					}
				}
				$rs_nuevo_taller->addChild('resultado', 'OK');
				$rs_nuevo_taller->addChild('mensaje', 'Creado nuevo taller <strong>'.$nombre.'</strong>');
			}//Para cada nuevo taller
		}//Si se envían datos de nuevo taller
	}
}

//exit;
if($cerrado==0) {
    if (isset($_REQUEST['envio_form'])) {

        //echo 'POST';exit;
        $respuesta = $xml_res;
        /** @noinspection PhpUndefinedFieldInspection */
        $resultado_envio = $respuesta->rs_resultado->resultado;
        //echo $respuesta->rs_resultado->mensaje.'<br>';
        if ($resultado_envio == 'KO') {//Ha habido errores el enviar el archivo
            $cerrado = 1;
        }

        if ($cerrado == 0) {
            //echo '<br>';

            /** @noinspection PhpUndefinedFieldInspection */
            $resultado_conexion = $respuesta->rs_datos_acceso->resultado;
            //echo $respuesta->rs_datos_acceso->mensaje.'<br>';
            if ($resultado_conexion == 'KO') {//Ha habido errores con los datos de acceso
                $cerrado = 1;
            }

            if ($cerrado == 0) {
                //echo '<br>';

                if (isset($respuesta->rs_datos_actividad)) {//Hay respuesta de datos de actividad
                    foreach ($respuesta->rs_datos_actividad as $rs_datos_actividad) {
                        //echo '<strong>Guardando datos de actividad:</strong><br>';
                        if (isset($rs_datos_actividad->rs_empleado)) {//Hay datos de empleados
                            foreach ($rs_datos_actividad->rs_empleado as $rs_empleado) {
                                /** @noinspection PhpUndefinedFieldInspection */
                                $resultado_empleado = $rs_empleado->resultado;
                                //echo $rs_empleado->mensaje.'<br>';
                                if ($resultado_empleado == 'KO') {//Ha habido errores al cargar los datos del empleado
                                    continue;
                                }
                            }
                        }
                        /** @noinspection PhpUndefinedFieldInspection */
                        $resultado_datos_act = $rs_datos_actividad->resultado;
                        //echo $rs_datos_actividad->mensaje.'<br>';
                        if ($resultado_datos_act == 'KO') {//Ha habido errores al cargar los datos de actividad
                            continue;
                        }
                        //echo '<br>';
                    }
                }

                if (isset($respuesta->rs_nuevo_taller)) {//Hay respuesta de nuevo taller
                    foreach ($respuesta->rs_nuevo_taller as $rs_nuevo_taller) {
                        //echo '<strong>Dando de alta nuevo taller:</strong><br>';
                        /** @noinspection PhpUndefinedFieldInspection */
                        $resultado_nuevo_taller = $rs_nuevo_taller->resultado;
                        //echo $rs_nuevo_taller->mensaje.'<br>';
                        if ($rs_nuevo_taller == 'KO') {//Ha habido errores al crear el nuevo taller
                            continue;
                        }
                        //echo '<br>';
                    }
                }
            }
        }
    } else {
        echo $xml_res->asXML();
    }
}

$content = ob_get_clean();

echo $content;

$datos=$_REQUEST;
$entrada=str_replace('\'','"',json_encode($datos));

$content=str_replace('\'','"',json_encode(addslashes($content)));

query("INSERT INTO log_xml (fecha, contenido, resultado, testing) VALUES ('".date('Y-m-d H:i:s')."','".$entrada."','".$content."','.$testing.')");

if($haynuevo!=0){//Se han insertado nuevos datos, vamos a crear las imágenes para el informe y programar el envío
    //$contenido=$haynuevo;
    $testing==0?query("INSERT INTO envios_pendientes (ep_idtaller, ep_mes, ep_ano) VALUES (".$idtaller.",'".$mes."','".$anho."')"):null;
    //include('core/includes/generar_informe.php');
}

//echo "INSERT INTO log_xml (fecha, contenido, resultado, testing) VALUES ('".date('Y-m-d H:i:s')."','".$entrada."','".$content."',1)";

close_bd();