<?php
function carga_datos_cuadro($datos_usuario){
    return true;
}
	
function datos_usuario($iduser){
    $idtaller = '';
	$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']='';
	//$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']='';
	$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']=0;
	$rango=$_SESSION['datos_'._ID_PAG_]['datos_user']['rango']=fetch_array('SELECT us_rango from usuarios where us_idusuario='.$iduser.'','us_rango');
	if($rango==3){//Usuario estándar
		$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']=fetch_array('SELECT us_idtaller from usuarios where us_idusuario='.$iduser.'','us_idtaller');
		$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']=fetch_array('SELECT ta_contrato from talleres where ta_idtaller='.$idtaller.'','ta_contrato');
		$idred=$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']=fetch_array('SELECT ta_idparent from talleres where ta_idtaller='.$idtaller.'','ta_idparent');
		query('update talleres set ta_ultacceso="'.date('Y-m-d H:i:s').'" where ta_idtaller='.$idtaller.'');
		$f_logo=$idred==0?" AND ta_idtaller='{$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']}'":" AND ta_idtaller='{$idred}'";
        $_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']=fetch_array("SELECT ta_logotipo from talleres where 1{$f_logo}",'ta_logotipo');
	}
	else if($rango==2){//Administrador
		$idred=$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']=fetch_array('SELECT us_idtaller from usuarios where us_idusuario='.$iduser.'','us_idtaller');
		$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']=isset($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'])&&$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']!=''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:fetch_array('SELECT ta_idtaller from talleres where ta_idparent='.$idred.' order by ta_nombre asc limit 0,1','ta_idtaller');
		$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']=fetch_array('SELECT ta_contrato from talleres where ta_idtaller='.$idred.'','ta_contrato');
		query('update talleres set ta_ultacceso="'.date('Y-m-d H:i:s').'" where ta_idtaller='.$idred.'');
        $idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];
        $f_logo=" AND ta_idtaller='{$idred}'";
        $_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']=fetch_array("SELECT ta_logotipo from talleres where 1{$f_logo}",'ta_logotipo');
	}
    if($idtaller !== ''){
        $datos_taller_info          = parse_taller_info($idtaller);
        $datos_taller_actividad     = parse_taller_actividad($idtaller);
        $datos_taller_personal      = parse_taller_personal($idtaller);
        $datos_taller_equipamiento  = parse_taller_equipamiento($idtaller);
        $datos_taller_gastos        = parse_taller_gastos($idtaller);
        $datos_taller_mensual       = parse_taller_datos_mes($idtaller);
        $datos_taller_acumulado     = parse_taller_datos_acumulado($idtaller);
        //vd__($datos_taller_info);
        $_SESSION['datos_'._ID_PAG_]['tallerSessionInfo']           = $datos_taller_info;
        $_SESSION['datos_'._ID_PAG_]['tallerSessionActividad']      = $datos_taller_actividad;
        $_SESSION['datos_'._ID_PAG_]['tallerSessionPersonal']       = $datos_taller_personal;
        $_SESSION['datos_'._ID_PAG_]['tallerSessionEquipamientos']  = $datos_taller_equipamiento;
        $_SESSION['datos_'._ID_PAG_]['tallerSessionGastos']         = $datos_taller_gastos;
        $_SESSION['datos_'._ID_PAG_]['tallerSessionDatosMes']       = $datos_taller_mensual;
        $_SESSION['datos_'._ID_PAG_]['tallerSessionDatosAcumulado'] = $datos_taller_acumulado;

        $_SESSION['datos_'._ID_PAG_]['datos_user']['hayKm0']        = $datos_taller_gastos['coste_personal'] > 0 && $datos_taller_gastos['suministros']>0 && $datos_taller_gastos['servicios_profesionales'] > 0 && $datos_taller_info['importe_mo'] > 0 && $datos_taller_info['horas_convenio'] > 0 && $datos_taller_personal['empleados_total'] > 0;

        $_SESSION['datos_'._ID_PAG_]['datos_user']['mesPasado'] = mesPasado($idtaller);
    }
    $_SESSION['datos_'._ID_PAG_]['datos_user']['nick'] = dame_dato_usuario('us_nick', $iduser);
}

function en__id($id){
	$id=conceros($id,12);
	$id=str_split($id,4);
	return 'AS'.$id[1][3].$id[1][2].$id[1][1].$id[1][0].'jS'.$id[2][3].$id[2][2].$id[2][1].$id[2][0].'xG'.$id[0];
}

function de__id($id){
	$paso1=explode('xG',$id);
	$id1=$paso1[1];
	$paso2=explode('jS',$paso1[0]);
	$id3=$paso2[1][3].$paso2[1][2].$paso2[1][1].$paso2[1][0];
	$id2=$paso2[0][5].$paso2[0][4].$paso2[0][3].$paso2[0][2];
	return intval($id1.$id2.$id3);
}

function parse_taller_datos_mes($idtaller){
	$idtaller = (int)$idtaller;
	$hoy = new DateTime('first day of this month');
	$inicio = clone $hoy;
	$inicio->modify('-11 months');

	$inicioMes = (int)$inicio->format('n');
	$inicioAnho = (int)$inicio->format('Y');
	$finMes = (int)$hoy->format('n');
	$finAnho = (int)$hoy->format('Y');

	// Estructura base de los ultimos 12 meses: [anio][mes] => null | datos de actividad.
	$actividadMensual = array();
	$cursor = clone $inicio;
	while ($cursor <= $hoy) {
		$anho = (int)$cursor->format('Y');
		$mes = (int)$cursor->format('n');
		if (!isset($actividadMensual[$anho])) {
			$actividadMensual[$anho] = array();
		}
		$actividadMensual[$anho][$mes] = null;
		$cursor->modify('+1 month');
	}

	$sql = "SELECT da_ano, da_mes,"
        ." da_diaslaborables as dias_laborables,"
        ." da_horaspresencia as horas_presencia,"
        ." da_horasfac as horas_facturadas,"
        ." da_horasimproductivas as horas_perdidas,"
        ." da_nofacturado as importe_no_facturado,"
        ." da_facturadomo as facturado_mo,"
        ." da_facturadorec as facturado_rec,"
        ." da_facturadootros as facturado_varios,"
        ." da_pagadoprovrec as pagado_prov_rec,"
        ." da_pagadoprovotros as pagado_otros,"
        ." da_costepersonal as coste_personal,"
        ." da_costeestructura as coste_estructura,"
        ." da_horasfichadasor as horas_fichadas_or,"
        ." da_horasasignadas as horas_asignadas,"
        ." da_entradastaller as entradas_taller,"
        ." da_objproductividad as objetivo_productividad,"
        ." da_objeficacia as objetivo_eficacia"
        ." FROM datos_actividad "
		. "WHERE da_idtipo=1 "
		. "AND da_idtaller=$idtaller "
		. "AND ((da_ano>$inicioAnho) OR (da_ano=$inicioAnho AND da_mes>=$inicioMes)) "
		. "AND ((da_ano<$finAnho) OR (da_ano=$finAnho AND da_mes<=$finMes)) "
		. "ORDER BY da_ano ASC, da_mes ASC";

	$datos = list_object($sql);
	foreach ($datos as $fila) {
		$anho = (int)$fila->da_ano;
		$mes = (int)$fila->da_mes;
		if (!isset($actividadMensual[$anho])) {
			$actividadMensual[$anho] = array();
		}
        $tiempo_medio_cliente        = $fila->entradas_taller==0 ? 0 : round($fila->horas_facturadas/$fila->entradas_taller);
		$actividadMensual[$anho][$mes] = $fila;
        $actividadMensual[$anho][$mes]->total_facturado             = $fila->facturado_mo + $fila->facturado_rec + $fila->facturado_varios;
        $actividadMensual[$anho][$mes]->total_gastos                = $fila->pagado_prov_rec + $fila->pagado_otros + $fila->coste_personal + $fila->coste_estructura;
        $actividadMensual[$anho][$mes]->ocupacion                   = $fila->horas_presencia > 0 ? round($fila->horas_fichadas_or*100/$fila->horas_presencia,2) : 0;
        $actividadMensual[$anho][$mes]->eficacia                    = $fila->horas_presencia > 0 ? round($fila->horas_facturadas*100/$fila->horas_presencia,2) : 0;
        $actividadMensual[$anho][$mes]->rendimiento                 = $fila->horas_fichadas_or > 0 ? round($fila->horas_facturadas*100/$fila->horas_fichadas_or,2) : 0;
        $actividadMensual[$anho][$mes]->margen_recambios            = $fila->facturado_rec > 0 ? round(($fila->facturado_rec-$fila->pagado_prov_rec)/$fila->facturado_rec*100,2) : 0;
        $actividadMensual[$anho][$mes]->entradas_dia                = round($fila->entradas_taller/$fila->dias_laborables);
        $actividadMensual[$anho][$mes]->horas_presencia_potenciales = horas_presencia_pot($idtaller);
        $actividadMensual[$anho][$mes]->horas_presencia_productivas = round($actividadMensual[$anho][$mes]->horas_presencia_potenciales*($fila->objetivo_productividad/100));
        $actividadMensual[$anho][$mes]->capacidad_teorica           = $tiempo_medio_cliente == 0 || $fila->dias_laborables == 0 ? 0 : round($fila->horas_facturadas/$tiempo_medio_cliente/$fila->dias_laborables);
        $actividadMensual[$anho][$mes]->tiempo_medio_entrada        = faltan2(($fila->entradas_taller==0?0:($actividadMensual[$anho][$mes]->horas_presencia_productivas/$fila->entradas_taller))*3600);
        $actividadMensual[$anho][$mes]->ticket_medio                = round($fila->entradas_taller==0?0:$actividadMensual[$anho][$mes]->total_facturado/$fila->entradas_taller,2);
        $actividadMensual[$anho][$mes]->ticket_medio_mo             = round($fila->entradas_taller==0?0:$actividadMensual[$anho][$mes]->facturado_mo/$fila->entradas_taller,2);
        $actividadMensual[$anho][$mes]->porcentaje_mo_or            = round($actividadMensual[$anho][$mes]->ticket_medio==0?0:$actividadMensual[$anho][$mes]->ticket_medio_mo*100/$actividadMensual[$anho][$mes]->ticket_medio,2);
        $actividadMensual[$anho][$mes]->ticket_medio_pr             = round($fila->entradas_taller==0?0:$fila->facturado_rec/$fila->entradas_taller,2);
        $actividadMensual[$anho][$mes]->porcentaje_mo_pr            = round($actividadMensual[$anho][$mes]->ticket_medio==0?0:$actividadMensual[$anho][$mes]->ticket_medio_pr*100/$actividadMensual[$anho][$mes]->ticket_medio,2);
        $actividadMensual[$anho][$mes]->ticket_medio_compra         = round($fila->entradas_taller==0?0:$fila->pagado_prov_rec/$fila->entradas_taller,2);
        $actividadMensual[$anho][$mes]->margen_operativo            = round($actividadMensual[$anho][$mes]->ticket_medio-$actividadMensual[$anho][$mes]->ticket_medio_compra,2);
	}

	return $actividadMensual;
}

function parse_taller_datos_acumulado($idtaller){
    $tallerInfo = array();
    for($anho = date('Y')-1; $anho <= date('Y'); $anho++){
        $acumulado = dame_acumulado($anho, $idtaller);
        foreach($acumulado as $clave => $valor){
            if (is_numeric($valor)) {
                $numero = (float)$valor;
                if (floor($numero) != $numero) {
                    $acumulado[$clave] = round($numero, 2);
                }
            }
        }
        $tallerInfo[$anho] = $acumulado;
        $tallerInfo[$anho]['tiempo_medio_cliente']  = $acumulado['entradastaller']==0?0:round($acumulado['hfacturadas']/$acumulado['entradastaller'],2);
        $tallerInfo[$anho]['horas_productivas']     = round($acumulado['sum_hprod']*0.9,2);
        $tallerInfo[$anho]['capacidad_teorica']     = $tallerInfo[$anho]['tiempo_medio_cliente']==0?0:round($tallerInfo[$anho]['horas_productivas']/$tallerInfo[$anho]['tiempo_medio_cliente'],2);
        $tallerInfo[$anho]['entradas_dia']          = $acumulado['diaslaborables']==0?0:round($acumulado['entradastaller']/$acumulado['diaslaborables'],2);
        $tallerInfo[$anho]['ticketmedioc']          = $acumulado['entradastaller']==0?0:round($acumulado['costepr']/$acumulado['entradastaller'],2);
    }
    return $tallerInfo;
}

function parse_taller_info($idtaller){
    $ti = fetch_assoc("SELECT * FROM info_taller WHERE 1 AND it_idtaller='$idtaller'");
    $tallerInfo = array();
    $tallerInfo['importe_mo'] = $ti['it_impmo']??'0';
    $tallerInfo['horas_convenio'] = $ti['hconvenio']??'0';
    $tallerInfo['valor_stock'] = $ti['it_valorstock']??'0';
    $tallerInfo['vehiculos_sustitucion'] = $ti['it_vehicsus']??'0';
    $tallerInfo['clientes_bbdd'] = $ti['it_totalclientes']??'0';
    $tallerInfo['clientes_visitas'] = $ti['it_clivisitas']??'0';
    $tallerInfo['clientes_nuevos'] = $ti['it_clinuevos']??'0';
    $tallerInfo['dms'] = $ti['it_tienedms']??'0';
    $tallerInfo['dms_proveedor'] = $ti['it_provdms']??'';
    $tallerInfo['fichan'] = $ti['it_fichan']??'0';
    $tallerInfo['fichan_sistema'] = $ti['it_comofichan']??'';
    $tallerInfo['maquinas_bebidas'] = $ti['it_maqcafe']??'0';
    $tallerInfo['ofertas_comerciales'] = $ti['it_ofrecep']??'0';
    return $tallerInfo;
}

function parse_taller_actividad($idtaller){
    $tallerActividad = array();
    $actividades=tipos_actividad();
    foreach($actividades as $key=>$actividad) {
        $activ_taller = dame_actividad($actividad->tac_idactiv, $idtaller);
        $tallerActividad[$actividad->tac_nombre] = array(
            'metros' => isset($activ_taller['at_metros']) ? $activ_taller['at_metros'] : 0.00,
            'puestos' => isset($activ_taller['at_puestos']) ? $activ_taller['at_puestos'] : 0,
            'elevadores' => isset($activ_taller['at_elevadores']) ? $activ_taller['at_elevadores'] : 0
        );
    }
    return $tallerActividad;
}

function parse_taller_personal($idtaller){
    $tallerPersonal = array();
    $porcentajes = personal_porcentaje($idtaller);
    $tallerPersonal['empleados_total'] = $porcentajes[0];
    $tallerPersonal['empleados_directos_cantidad'] = $porcentajes[4];
    $tallerPersonal['empleados_directos_porcentaje'] = $porcentajes[2];
    $tallerPersonal['empleados_indirectos_cantidad'] = $porcentajes[5];
    $tallerPersonal['empleados_indirectos_porcentaje'] = $porcentajes[3];
    $empleados = taller_personal_funciones($idtaller);
    foreach($empleados as $empleado) {
        $tallerPersonal[$empleado->pt_nombre] = array(
            'activo'    => $empleado->pt_activo,
            'jornada'   => $empleado->pt_jornada,
            'notas'     => $empleado->pt_notas,
            'funcion'   => $empleado->cp_nombre,
            'tipo'      => $empleado->tp_definicion,
        );
    }
    return $tallerPersonal;
}

function parse_taller_equipamiento($idtaller){
    $tallerEquipamiento = array();
    $equipamientos = taller_equipamientos($idtaller);
    foreach($equipamientos as $equipamiento) {
        $tallerEquipamiento[$equipamiento->te_nombre] = array(
            'cantidad'  => $equipamiento->et_cantidad,
            'notas'     => $equipamiento->et_notas
        );
    }
    return $tallerEquipamiento;
}

function parse_taller_gastos($idtaller){
    $gastos = dame_gastos($idtaller);
    $tallerGastos['coste_personal']             = $gastos[0]->nominas ?? 0;
    $tallerGastos['ss_trabajadores']            = $gastos[0]->seg_social ?? 0;
    $tallerGastos['alquileres']                 = $gastos[0]->alquileres ?? 0;
    $tallerGastos['suministros']                = $gastos[0]->suministros ?? 0;
    $tallerGastos['renting_equipos']            = $gastos[0]->renting ?? 0;
    $tallerGastos['servicios_profesionales']    = $gastos[0]->serv_prof ?? 0;
    $tallerGastos['cuotas']                     = $gastos[0]->cuotas ?? 0;
    $tallerGastos['amortizaciones']             = $gastos[0]->amortizaciones ?? 0;
    $tallerGastos['otros_gastos']               = $gastos[0]->otros ?? 0;
    return $tallerGastos;
}

function taller_equipamientos($idtaller){
    $sql = "SELECT et_cantidad, et_notas, te.te_nombre FROM equipamiento_taller et JOIN tipos_equipamiento te ON et_idtipo=te.te_idequip WHERE 1 AND et_idtaller='$idtaller'";
    return list_object($sql);
}

function taller_personal_funciones($idtaller){
    $sql = "SELECT pt_nombre, pt_jornada, pt_notas, pt_activo, cp_nombre, tp_definicion FROM personal_taller pt JOIN personal_funciones pf ON pt.pt_idpersonal=pf.pf_idpersonal JOIN cargos_personal cp ON cp.cp_idpersonal=pf.pf_idcargo JOIN tipos_personal tp ON tp.tp_idtipo=cp.cp_idpersonal WHERE 1 AND pt_idtaller='$idtaller'";
    return list_object($sql);
}

function dame_red_talleres(){
	return list_object('select ta_idtaller, ta_nombre from talleres where ta_idparent='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idred'].' and ta_idtaller!=1462 order by ta_nombre asc');
}

function dame_datos_usuario($idusuario=''){
	$idusuario==''?$idusuario=$_SESSION['datos_'._ID_PAG_]['idusuario']:'';
	return fetch_array('select * from usuarios where us_idusuario='.$idusuario.'');
}

function dame_nombre_contrato($idcont){
	return u8_(fetch_array('select tc_nombre from tipos_contrato where tc_idtipo='.$idcont.'','tc_nombre'));
}

function dame_ref_contrato($idcont){
	return fetch_array('select tc_ref from tipos_contrato where tc_idtipo='.$idcont.'','tc_ref');
}

function dame_dato_usuario($dato, $idusuario=''){
	$idusuario=$idusuario==''?$_SESSION['datos_'._ID_PAG_]['idusuario']:$idusuario;
	$res=fetch_array('select '.$dato.' from usuarios where us_idusuario='.$idusuario.'',$dato);
	$res=$dato=='us_nick'&&$res==''?fetch_array('select us_correo from usuarios where us_idusuario='.$idusuario.'','us_correo'):$res;
	return $res;
}

function dame_usuarios(){
	return list_object('select * from usuarios order by us_fecha_alta desc');
}

function dame_usuarios_activos($activos=1){
	return list_object('select * from usuarios where us_estado='.$activos.' order by us_fecha_alta desc');
}

function dame_talleres(){
	return list_object('select * from talleres order by ta_nombre asc');
}

function dame_talleres_tipo($tipo=1){
	return list_object('select * from talleres where ta_idtipo='.$tipo.' order by ta_nombre asc');
}

function dame_datos_taller($idtaller=''){
	$idtaller==''?$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:'';
	return list_object('select * from talleres where ta_idtaller='.$idtaller);
}

function dame_datos_facturacion($iddir){
	return list_object('select * from usuarios_facturacion where uf_iddir="'.$iddir.'"');
}

function dame_datos_promocion($idpromo){
	return list_object('select * from promociones where pr_idpromocion="'.$idpromo.'"');
}

function dato_taller($dato, $idtaller=''){
	$idtaller==''?$idtaller=($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==3?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']):null;
	return fetch_array('select '.$dato.' from talleres where ta_idtaller='.$idtaller.'',$dato);
}

function dame_info($idtaller){
	return list_object('select * from info_taller where it_idtaller='.$idtaller);
}
function dame_gastos($idtaller){
    return list_object('select * from gastos_taller where idtaller='.$idtaller);
}

function tipos_actividad(){
	return list_object('select * from tipos_actividad order by tac_orden asc');
}

function dame_actividad($idactiv, $idtaller){
	return fetch_array('select * from actividad_taller where at_idactividad='.$idactiv.' and at_idtaller='.$idtaller);
}

function dame_empleados($idtaller, $idtipo=''){//Devuelve el listado de empleados completo o sólo del tipo indicado
	if($idtipo==''){
		$empleados=list_object('select * from personal_taller where pt_idtaller='.$idtaller);
	}
	else{
		$empleados=list_object('select personal_taller.* from personal_taller, personal_funciones, cargos_personal where cp_idtipo='.$idtipo.' and pf_idcargo=cp_idpersonal and pt_idpersonal=pf_idpersonal and pt_idtaller='.$idtaller.' group by pt_idpersonal');
	}
	return $empleados;
}

function dame_equipamiento($idtaller){
	return list_object('select * from equipamiento_taller where et_idtaller='.$idtaller.'');
}

function dame_clientes($idtaller){
	return list_object('select * from clientes_taller where ct_idtaller='.$idtaller.'');
}

function datos_actividad($idtipo=0, $mes='', $ano=''){//Por defecto Km 0
	$dato=array();
	if($idtipo==0){//Km 0
		$ordenmes='asc';
		$dato=list_object('select * from datos_actividad where da_idtipo='.$idtipo.' and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_ano desc, da_mes '.$ordenmes.'');
	}
	else if($idtipo==1){//Datos mensuales
		$ordenmes='desc';
		if(nom_mes($mes)==''){//el mes no existe 
		}
		else if(!is_numeric($ano)||strlen($ano)!=4||$ano<2015){//el año no es correcto
		}
		else{
			$dato=list_object('select * from datos_actividad where da_idtipo='.$idtipo.' and da_mes='.$mes.' and da_ano='.$ano.' and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_ano desc, da_mes '.$ordenmes.'');
		}
	}
	else{}
	return $dato;
}

function datos_actividad_taller($idtaller, $idtipo=0, $mes='', $ano=''){//Por defecto Km 0
	$dato=array();
	if($idtipo==0){//Km 0
		$ordenmes='asc';
		$dato=list_object('select * from datos_actividad where da_idtipo='.$idtipo.' and da_idtaller='.$idtaller.' order by da_ano desc, da_mes '.$ordenmes.'');
	}
	else if($idtipo==1){//Datos mensuales
		$ordenmes='desc';
		if(nom_mes($mes)==''){//el mes no existe 
		}
		else if(!is_numeric($ano)||strlen($ano)!=4||$ano<2015){//el año no es correcto
		}
		else{
			$dato=list_object('select * from datos_actividad where da_idtipo='.$idtipo.' and da_mes='.$mes.' and da_ano='.$ano.' and da_idtaller='.$idtaller.' order by da_ano desc, da_mes '.$ordenmes.'');
		}
	}
	else{}
	return $dato;
}

function mes_anho_anterior(): array {
    $dt = new DateTime('first day of this month');
    $dt->modify('-1 month');
    return ['mes' => $dt->format('n'), 'anho' => $dt->format('Y')];
}

function hayKm0($idtaller){
    $datosKm0 = datos_actividad_taller($idtaller);
    return is_countable($datosKm0) && count($datosKm0) > 0;
}
function mesPasado($idtaller){
    $prev = mes_anho_anterior();
    $datosMesPasado = datos_actividad_taller($idtaller, 1, $prev['mes'], $prev['anho']);
    return is_countable($datosMesPasado) && count($datosMesPasado) > 0;
}

function datos_guardados(){
	return list_object('select * from datos_actividad where da_idtipo=1 and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_ano desc, da_mes desc');
}

function dame_ventas($idtaller=''){//Devuelve un array con el importe vendido el primer mes y la media de los últimos 3 meses
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	$ult_3mes=list_object('select (da_facturadomo+da_facturadorec) as FACTURADO from datos_actividad where da_idtaller='.$idtaller.' and da_idtipo=1 order by da_ano desc, da_mes desc limit 0,3');
	$tot_meses=count($ult_3mes);
	if($tot_meses>0){
		$suma=0;
		foreach($ult_3mes as $mes){
			$suma+=$mes->FACTURADO;
		}
		$media=$suma/$tot_meses;
		$datos=array($ult_3mes[0]->FACTURADO, $media);
	}
	else{
		$datos=array();
	}
	return $datos;
}

function dame_entradas($idtaller=''){//Devuelve un array con las entradas del primer mes y la media de los últimos 3 meses
    $idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
    $ult_3mes=list_object('select da_entradastaller from datos_actividad where da_idtaller='.$idtaller.' and da_idtipo=1 order by da_ano desc, da_mes desc limit 0,3');
    $tot_meses=count($ult_3mes);
    if($tot_meses>0){
        $suma=0;
        foreach($ult_3mes as $mes){
            $suma+=$mes->da_entradastaller;
        }
        $media=$suma/$tot_meses;
        $datos=array($ult_3mes[0]->da_entradastaller, $media);
    }
    else{
        $datos=array();
    }
    return $datos;
}

function dame_variacion($idtaller=''){//Devuelve un array con el porcentaje de incremento de ventas el último año entre el primer mes y la media de todo el año
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	$ventas_anho=list_object('select (da_facturadomo+da_facturadorec) as FACTURADO from datos_actividad where da_idtaller='.$idtaller.' and da_idtipo=1 order by da_ano desc, da_mes desc');
	$tot_meses=count($ventas_anho);
	if($tot_meses>0){
		$suma=0;
		foreach($ventas_anho as $mes){
			$suma+=$mes->FACTURADO;
		}
		$media=$suma/$tot_meses;
		$incremento=$ventas_anho[0]->FACTURADO>0?($ventas_anho[0]->FACTURADO-$media)/$ventas_anho[0]->FACTURADO*100:0;
	}
	else{
		$incremento=0;
	}
	return $incremento;
}

function margen_rec($idtaller=''){
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	$ult_3mes=list_object('select da_facturadorec, da_facturadootros, da_pagadoprovrec, da_pagadoprovotros from datos_actividad where da_idtaller='.$idtaller.' and da_idtipo=1 order by da_ano desc, da_mes desc limit 0,3','FACTURADO');
	if(count($ult_3mes)>0){
		//$ult_mes=margen_sobre_coste(($ult_3mes[0]->da_pagadoprovrec+$ult_3mes[0]->da_pagadoprovotros), ($ult_3mes[0]->da_facturadorec+$ult_3mes[0]->da_facturadootros));
		$ult_mes = $ult_3mes[0]->da_facturadorec+$ult_3mes[0]->da_facturadootros > 0 ? (($ult_3mes[0]->da_facturadorec+$ult_3mes[0]->da_facturadootros)-$ult_3mes[0]->da_pagadoprovrec)/($ult_3mes[0]->da_facturadorec+$ult_3mes[0]->da_facturadootros)*100 : 0;
		$sumapag=0;
		$sumafac=0;
		foreach($ult_3mes as $mes){
			$margen=$mes->da_pagadoprovrec>0?margen_sobre_coste(($mes->da_pagadoprovrec+$mes->da_pagadoprovotros), ($mes->da_facturadorec+$mes->da_facturadootros)):100;
			$sumapag+=$mes->da_pagadoprovrec;
			$sumafac+=$mes->da_facturadorec+$mes->da_facturadootros;
		}
		//$media=$sumapag>0?margen_sobre_coste($sumapag, $sumafac):100;
		$media = $sumafac>0 ? ($sumafac-$sumapag)/$sumafac*100 : 0;
		$datos=array($ult_mes, $media);
	}
	else{
		$datos=array();
	}
	return $datos;
}

function dame_anhos($idtaller=''){
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	return list_object('select distinct da_ano from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc');
}

function horas_diarias($idempleado){
	$datos_empleado=list_object('select pt_idpersonal, pt_jornada from personal_taller where pt_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' and pt_idpersonal='.$idempleado.'');
	$hprod=0;
	foreach($datos_empleado as $dato_empleado){
		$horas=fetch_array('select sum(pf_porcentaje) as PORCENT from personal_funciones, cargos_personal where pf_idpersonal='.$dato_empleado->pt_idpersonal.' and pf_idcargo=cp_idpersonal and cp_idtipo=1','PORCENT');
		$horas=$horas==''?0:$horas;
		$hprod+=$dato_empleado->pt_jornada*$horas/100;
	}
	return $hprod;
}

function dame_jornadas($tipo, $idempleado=''){//1=directo, 2=indirecto
	$nemp=0;
	$jornada=0;
	$porcentaje=0;
	$hprod=0;
	$filtro_empleado=$idempleado==''?'':' and pt_idpersonal='.$idempleado;
	$datos_empleado=list_object('select pt_idpersonal, pt_jornada from personal_taller where pt_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].''.$filtro_empleado.'');
	foreach($datos_empleado as $dato_empleado){
		$porcent=fetch_array('select sum(pf_porcentaje) as PORCENT from personal_funciones, cargos_personal where pf_idpersonal='.$dato_empleado->pt_idpersonal.' and pf_idcargo=cp_idpersonal and cp_idtipo='.$tipo.' group by pf_idpersonal','PORCENT');
		$porcent=$porcent==''||$porcent==NULL?0:$porcent;
		$porcent>0?$nemp++:'';
		$porcentaje+=$porcent;
		$hprod+=$dato_empleado->pt_jornada*$porcent/100;
		$jornada+=$dato_empleado->pt_jornada;
	}
	$nemp>0?$porcentaje=$porcentaje/$nemp:0;
	return array($jornada,$porcentaje,$hprod);
}

function dame_presencia($iddato, $idempleado){
	return fetch_array('select * from presencia_personal where pp_iddato='.$iddato.' and pp_idpersonal='.$idempleado.'');
}

function horas_presencia($iddato){
	$datospresencia=fetch_array('select da_tipopresencia, da_horaspresencia from datos_actividad where da_iddato='.$iddato.'');
	if($datospresencia['da_tipopresencia']==2){
		$hprod=$datospresencia['da_horaspresencia'];
	}
	else{
		$hprod=0;
		$diaslab=fetch_array('select da_diaslaborables from datos_actividad where da_iddato='.$iddato.'','da_diaslaborables');
		$personal=list_object('select pp_idpersonal from presencia_personal where pp_iddato='.$iddato.'');
		foreach($personal as $idempleado){
			$jornada=dame_jornadas(1, $idempleado->pp_idpersonal);
			$hprod+=$jornada[2]*$diaslab;
		}
	}
	return $hprod;
}

function dame_eficacia($meses='',$idtaller=''){//Devuelve un array con la eficacia del último mes y la de los últimos X meses, si no se indican tomará el último año
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	$limite=$meses!=''?' limit 0,'.$meses:'';
	$sum_hprod=0;
	$sum_hfac=0;
    $ef_ultmes=0;
	$datos=list_object('select da_ano, da_mes, da_iddato, da_facturadomo, da_impmo from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc');
	foreach ($datos as $key=>$dato){
		$sum_hprod+=horas_presencia($dato->da_iddato);
		$sum_hfac+=($dato->da_impmo>0?$dato->da_facturadomo/$dato->da_impmo:0);
		$key==0?$ef_ultmes=porcentaje_($sum_hfac,$sum_hprod):'';
	}
	$eficacia=porcentaje_($sum_hfac,$sum_hprod);
	return array($ef_ultmes, $eficacia);
}

function dame_productividad($meses='',$idtaller=''){//Devuelve un array con la productividad del último mes y la de los últimos X meses, si no se indican tomará el último año
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	$limite=$meses!=''?' limit 0,'.$meses:'';
	$sum_hprod=0;
	$sum_hfich=0;
    $pr_ultmes=0;
	$datos=list_object('select da_ano, da_mes, da_iddato, da_horasfichadasor from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc');
	foreach ($datos as $key=>$dato){
		$sum_hprod+=horas_presencia($dato->da_iddato);
		$sum_hfich+=$dato->da_horasfichadasor;
		$key==0?$pr_ultmes=porcentaje_($sum_hfich,$sum_hprod):'';
	}
	$productividad=porcentaje_($sum_hfich,$sum_hprod);
	return array($pr_ultmes, $productividad);
}

function dame_rendimiento($meses='',$idtaller=''){//Devuelve un array con la rendimiento del último mes y la de los últimos X meses, si no se indican tomará el último año
	$idtaller=$idtaller==''?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$idtaller;
	$limite=$meses!=''?' limit 0,'.$meses:'';
	$sum_hfac=0;
	$sum_hfich=0;
    $rd_ultmes=0;
	$datos=list_object('select da_ano, da_mes, da_iddato, da_horasfichadasor, da_facturadomo, da_impmo from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc');
	foreach ($datos as $key=>$dato){
		$sum_hfac+=($dato->da_impmo>0?$dato->da_facturadomo/$dato->da_impmo:0);
		$sum_hfich+=$dato->da_horasfichadasor;
		$key==0?$rd_ultmes=porcentaje_($sum_hfac,$sum_hfich):'';
	}
	$rendimiento=porcentaje_($sum_hfac,$sum_hfich);
	return array($rd_ultmes, $rendimiento);
}

function dame_acumulado($anho,$idtaller=''){
    $idtaller!=''?:$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];
	$total_facturado=0;
	$ventamo=0;
	$ventapr=0;
	$costepr=0;
	$costeotro=0;
	$costeprov=0;
	$costepers=0;
	$costeestr=0;
	$total_ingresos=0;
	$hpresencia=0;
	$fichadasor=0;
	$hfacturadas=0;
	$entradastaller=0;
	$objeficacia=0;
	$objproductividad=0;
	$objrendimiento=0;
	$objventas=0;
	$objmargenrec=0;
	$impmo=0;
	$diaslaborables=0;
	$sum_hprod=horas_presencia_pot($idtaller);

    $porcentajes=personal_porcentaje($idtaller);

	$datos=list_object('select * from datos_actividad where da_idtipo=1 and da_ano='.$anho.' and da_idtaller='.$idtaller);
	$nmeses=count($datos);
	foreach($datos as $dato){
		$total_facturado+=$dato->da_facturadomo+$dato->da_facturadorec+$dato->da_facturadootros;
		$ventamo+=$dato->da_facturadomo;
		$ventapr+=$dato->da_facturadorec+$dato->da_facturadootros;
		$costepr+=$dato->da_pagadoprovrec+$dato->da_pagadoprovotros;
		$costeprov+=$dato->da_pagadoprovrec;
		$costeotro+=$dato->da_pagadoprovotros;
		$costepers+=$dato->da_costepersonal;
		$costeestr+=$dato->da_costeestructura;
		$total_ingresos+=$dato->da_facturadomo+$dato->da_facturadorec+$dato->da_facturadootros;
		$hpresencia+=horas_presencia($dato->da_iddato);
		$fichadasor+=$dato->da_horasfichadasor;
		$hfacturadas+=($dato->da_impmo>0?$dato->da_facturadomo/$dato->da_impmo:0);
		$entradastaller+=$dato->da_entradastaller;
		$objeficacia+=$dato->da_objeficacia;
		$objproductividad+=$dato->da_objproductividad;
		$objrendimiento+=$dato->da_objrendimiento;
		$objventas+=$dato->da_objventas;
		$objmargenrec+=$dato->da_objmargenrec;
		$impmo+=$dato->da_impmo;
		$diaslaborables+=$dato->da_diaslaborables;
		//$sum_hprod+=horas_presencia($dato->da_iddato);
	}
	$margenpr=$ventapr-$costeprov;
	//$porcentpr=margen_sobre_coste($costeprov,$ventapr);
    $porcentpr = $ventapr>0?$margenpr/$ventapr*100:0;
	$total_gastos=$costepr+$costepers+$costeestr;
	$margenbruto=$total_ingresos-$total_gastos;
	//$porcmargenbruto=margen_sobre_coste($total_gastos,$total_ingresos);
	$porcmargenbruto = $total_ingresos>0?$margenbruto/$total_ingresos*100:0;
	$productividad=porcentaje_($fichadasor,$hpresencia);
	$eficacia=porcentaje_($hfacturadas,$hpresencia);
	$rendimiento=porcentaje_($hfacturadas,$fichadasor);
	$mediaor=$entradastaller==0?0:$total_facturado/$entradastaller;
	$mediamo=$entradastaller==0?0:$ventamo/$entradastaller;
	$mediapr=$entradastaller==0?0:$ventapr/$entradastaller;
	$infotaller=dame_info($idtaller);
	$totalbbdd=$infotaller[0]->it_totalclientes;
	$fidelizacion=porcentaje_($entradastaller,$totalbbdd);
	$objeficacia=$nmeses==0?0:$objeficacia/$nmeses;
	$objproductividad=$nmeses==0?0:$objproductividad/$nmeses;
	$objrendimiento=$nmeses==0?0:$objrendimiento/$nmeses;
	$objventas=$nmeses==0?0:$objventas/$nmeses;
	$objmargenrec=$nmeses==0?0:$objmargenrec/$nmeses;
	$horaspotenciales=$objeficacia==0?0:($hpresencia/$nmeses*12)*$objeficacia/100;
	$costehora=$horaspotenciales==0?0:(($costepers+$costeestr)/$nmeses*12)/$horaspotenciales;
	$impmo_media=$nmeses==0?0:$impmo/$nmeses;
	$coste_medio_mo=$nmeses==0||$hfacturadas==0?0:($ventamo/$hfacturadas)/$nmeses;
    $coste_hora_teorico=$nmeses==0?0:($porcentajes[4]==0?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*80/100));
    $coste_hora_real=$nmeses==0?0:(($porcentajes[4]==0||$eficacia==0)?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*$eficacia/100));
	
	return array('hpresencia'=>$hpresencia, 'total_facturado'=>$total_facturado, 'ventamo'=>$ventamo, 'ventapr'=>$ventapr, 'costepr'=>$costepr, 'costeprov'=>$costeprov, 'costeotro'=>$costeotro, 'margenpr'=>$margenpr, 'porcentpr'=>$porcentpr, 'costepers'=>$costepers, 'costeestr'=>$costeestr, 'total_ingresos'=>$total_ingresos, 'total_gastos'=>$total_gastos, 'margenbruto'=>$margenbruto, 'porcmargenbruto'=>$porcmargenbruto, 'productividad'=>$productividad, 'eficacia'=>$eficacia, 'rendimiento'=>$rendimiento, 'entradastaller'=>$entradastaller, 'mediaor'=>$mediaor, 'mediamo'=>$mediamo, 'mediapr'=>$mediapr, 'fidelizacion'=>$fidelizacion, 'objeficacia'=>$objeficacia, 'objproductividad'=>$objproductividad, 'objrendimiento'=>$objrendimiento, 'objventas'=>$objventas, 'objmargenrec'=>$objmargenrec, 'hfacturadas'=>$hfacturadas, 'horaspotenciales'=>$horaspotenciales, 'costehora'=>$costehora, 'impmo_media'=>$impmo_media, 'diaslaborables'=>$diaslaborables, 'sum_hprod'=>$sum_hprod, 'coste_medio_mo'=>$coste_medio_mo, 'nmeses'=>$nmeses, 'personal_directo'=>$porcentajes[4], 'coste_hora_real'=>$coste_hora_real, 'coste_hora_teorico'=>$coste_hora_teorico);
}

function dame_acumulado_ult($idtaller=''){
    $hpresencia=0;
    $total_facturado=0;
    $ventamo=0;
    $ventapr=0;
    $costepr=0;
    $costeprov=0;
    $margenpr=0;
    $porcentpr=0;
    $costepers=0;
    $costeestr=0;
    $total_ingresos=0;
    $total_gastos=0;
    $margenbruto=0;
    $porcmargenbruto=0;
    $productividad=0;
    $eficacia=0;
    $rendimiento=0;
    $entradastaller=0;
    $mediaor=0;
    $mediamo=0;
    $mediapr=0;
    $fidelizacion=0;
    $objeficacia=0;
    $objproductividad=0;
    $objrendimiento=0;
    $objventas=0;
    $objmargenrec=0;
    $hfacturadas=0;
    $horaspotenciales=0;
    $horasimproductivas=0;
    $costehora=0;
    $impmo_media=0;
    $diaslaborables=0;
    $nmeses=0;
    $porcentajes[4]=0;
    $coste_medio_mo=0;
    $coste_hora_real=0;
    $coste_hora_teorico=0;
    
    $idtaller==''?$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:null;
    $sum_hprod=horas_presencia_pot($idtaller);

    $porcentajes=personal_porcentaje($idtaller);

    $datos=fetch_assoc("SELECT 
da_ano, 
COUNT(da_iddato) AS nmeses, 
SUM(da_facturadomo) AS facturadomo, 
SUM(da_facturadomo/da_impmo) AS hfacturadas, 
SUM(da_facturadorec) AS facturadorec, 
SUM(da_facturadootros) AS facturadootros, 
SUM(da_horasimproductivas) AS horasimproductivas, 
SUM(da_pagadoprovrec) AS pagadoprovrec, 
SUM(da_pagadoprovotros) AS pagadoprovotros, 
SUM(da_costepersonal) AS costepersonal, 
SUM(da_costeestructura) AS costeestructura, 
SUM(da_horasfichadasor) AS horasfichadasor, 
SUM(da_impmo) AS impmo, 
SUM(da_entradastaller) AS entradastaller, 
SUM(da_objeficacia) AS objeficacia, 
SUM(da_objproductividad) AS objproductividad, 
SUM(da_objrendimiento) AS objrendimiento, 
SUM(da_objventas) AS objventas, 
SUM(da_objmargenrec) AS objmargenrec, 
SUM(da_diaslaborables) AS diaslaborables 
FROM datos_actividad 
WHERE da_idtaller='{$idtaller}' AND da_idtipo=1 
GROUP BY da_ano 
ORDER BY da_ano DESC 
LIMIT 0,1");

    //$datos=list_object('select * from datos_actividad where da_idtipo=1 and da_ano='.$anho.' and da_idtaller='.$idtaller);
    if($datos != null){
        $ultanho=$datos['da_ano'];
        $nmeses=$datos['nmeses'];
        $ventamo=$datos['facturadomo'];
        $ventapr=$datos['facturadorec']+$datos['facturadootros'];
        $total_facturado=$ventamo+$ventapr;
        $costepr=$datos['pagadoprovrec']+$datos['pagadoprovotros'];
        $costeprov=$datos['pagadoprovrec'];
        $costepers=$datos['costepersonal'];
        $costeestr=$datos['costeestructura'];
        $total_ingresos=$total_facturado;
        $fichadasor=$datos['horasfichadasor'];
        $hfacturadas=$datos['hfacturadas'];
        $entradastaller=$datos['entradastaller'];
        $objeficacia=$datos['objeficacia'];
        $objproductividad=$datos['objproductividad'];
        $objrendimiento=$datos['objrendimiento'];
        $horasimproductivas=$datos['horasimproductivas'];
        $objventas=$datos['objventas'];
        $objmargenrec=$datos['objmargenrec'];
        $impmo=$datos['impmo'];
        $diaslaborables=$datos['diaslaborables'];

        $lista_datos=list_object("SELECT da_iddato FROM datos_actividad WHERE da_idtaller='{$idtaller}' AND da_idtipo=1 AND da_ano='{$ultanho}'");
        foreach($lista_datos as $dato){
            $hpresencia+=horas_presencia($dato->da_iddato);
        }
        $margenpr=$ventapr-$costeprov;
        //$porcentpr=margen_sobre_coste($costeprov,$ventapr);
        $porcentpr=$ventapr>0?$margenpr/$ventapr*100:0;
        $total_gastos=$costepr+$costepers+$costeestr;
        $margenbruto=$total_ingresos-$total_gastos;
        //$porcmargenbruto=margen_sobre_coste($total_gastos,$total_ingresos);
        $porcmargenbruto=$total_ingresos>0?$margenbruto/$total_ingresos*100:0;
        $productividad=porcentaje_($fichadasor,$hpresencia);
        $eficacia=porcentaje_($hfacturadas,$hpresencia);
        $rendimiento=porcentaje_($hfacturadas,$fichadasor);
        $mediaor=$entradastaller==0?0:$total_facturado/$entradastaller;
        $mediamo=$entradastaller==0?0:$ventamo/$entradastaller;
        $mediapr=$entradastaller==0?0:$ventapr/$entradastaller;
        $infotaller=dame_info($idtaller);
        $totalbbdd=$infotaller[0]->it_totalclientes;
        $fidelizacion=porcentaje_($entradastaller,$totalbbdd);
        $objeficacia=$nmeses==0?0:$objeficacia/$nmeses;
        $objproductividad=$nmeses==0?0:$objproductividad/$nmeses;
        $objrendimiento=$nmeses==0?0:$objrendimiento/$nmeses;
        $objventas=$nmeses==0?0:$objventas/$nmeses;
        $objmargenrec=$nmeses==0?0:$objmargenrec/$nmeses;
        $horaspotenciales=$nmeses==0?0:($hpresencia/$nmeses*12)*$objeficacia/100;
        $costehora=$horaspotenciales==0?0:(($costepers+$costeestr)/$nmeses*12)/$horaspotenciales;
        $impmo_media=$nmeses==0?0:$impmo/$nmeses;
        $coste_medio_mo=$hfacturadas==0?0:$ventamo/$hfacturadas;
        $coste_hora_teorico=$nmeses==0?0:($porcentajes[4]==0?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*80/100));
        $coste_hora_real=$nmeses==0?0:(($porcentajes[4]==0||$eficacia==0)?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*$eficacia/100));
    }
    

    return array('hpresencia'=>$hpresencia, 'total_facturado'=>$total_facturado, 'ventamo'=>$ventamo, 'ventapr'=>$ventapr, 'costepr'=>$costepr, 'costeprov'=>$costeprov, 'margenpr'=>$margenpr, 'porcentpr'=>$porcentpr, 'costepers'=>$costepers, 'costeestr'=>$costeestr, 'total_ingresos'=>$total_ingresos, 'total_gastos'=>$total_gastos, 'margenbruto'=>$margenbruto, 'porcmargenbruto'=>$porcmargenbruto, 'productividad'=>$productividad, 'eficacia'=>$eficacia, 'rendimiento'=>$rendimiento, 'entradastaller'=>$entradastaller, 'mediaor'=>$mediaor, 'mediamo'=>$mediamo, 'mediapr'=>$mediapr, 'fidelizacion'=>$fidelizacion, 'objeficacia'=>$objeficacia, 'objproductividad'=>$objproductividad, 'objrendimiento'=>$objrendimiento, 'objventas'=>$objventas, 'objmargenrec'=>$objmargenrec, 'hfacturadas'=>$hfacturadas, 'horaspotenciales'=>$horaspotenciales, 'horasimproductivas'=>$horasimproductivas, 'costehora'=>$costehora, 'impmo_media'=>$impmo_media, 'diaslaborables'=>$diaslaborables, 'sum_hprod'=>$sum_hprod, 'nmeses'=>$nmeses, 'personal_directo'=>$porcentajes[4], 'coste_medio_mo'=>$coste_medio_mo, 'coste_hora_real'=>$coste_hora_real, 'coste_hora_teorico'=>$coste_hora_teorico);
}

function horas_presencia_pot($idtaller){
	$horas_pot_diarias=0;
	$horas_personal=list_object('select sum(pf_porcentaje) AS PORCENT, pt_jornada from personal_taller, personal_funciones, cargos_personal where pt_idpersonal=pf_idpersonal and pf_idcargo=cp_idpersonal and cp_idtipo=1 and pt_activo=1 and pt_idtaller='.$idtaller.' group by pt_idpersonal');
	foreach($horas_personal as $horas){
		$horas_pot_diarias+=($horas->PORCENT*$horas->pt_jornada/100);
	}
	return $horas_pot_diarias;
}

function personal_porcentaje($idtaller){
	$n_empleados=num_rows('SELECT pt_idpersonal from personal_taller where pt_idtaller='.$idtaller.' and pt_activo=1');
	$horas_totales=fetch_array('select sum(pf_porcentaje*pt_jornada/100) as DIRECTO, pt_idpersonal from personal_taller, personal_funciones, cargos_personal where pt_idpersonal=pf_idpersonal and pf_idcargo=cp_idpersonal and pt_activo=1 and pt_idtaller='.$idtaller.'','DIRECTO');

	$horas_directo=fetch_array('select sum(pf_porcentaje*pt_jornada/100) as DIRECTO, pt_idpersonal from personal_taller, personal_funciones, cargos_personal where pt_idpersonal=pf_idpersonal and pf_idcargo=cp_idpersonal and cp_idtipo=1 and pt_activo=1 and pt_idtaller='.$idtaller.'','DIRECTO');
	$horas_indirecto=fetch_array('select sum(pf_porcentaje*pt_jornada/100) as DIRECTO, pt_idpersonal from personal_taller, personal_funciones, cargos_personal where pt_idpersonal=pf_idpersonal and pf_idcargo=cp_idpersonal and cp_idtipo=2 and pt_activo=1 and pt_idtaller='.$idtaller.'','DIRECTO');

	$porc_directo=round(porcentaje_($horas_directo, $horas_totales),0);
	$emp_directo=round($n_empleados*$porc_directo/100,2);
	$porc_indirecto=round(porcentaje_($horas_indirecto, $horas_totales),0);
	$emp_indirecto=round($n_empleados*$porc_indirecto/100,2);

	return array($n_empleados, $horas_totales, $porc_directo, $porc_indirecto, $emp_directo, $emp_indirecto);
}

function dame_impmo_actual(){
	return fetch_array('select it_impmo from info_taller where it_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].'','it_impmo');
}

function ultimo_dato($idtaller = ''){
    $idtaller !== '' ?: $idtaller = $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];
	return list_object('select * from datos_actividad where da_idtaller='.$idtaller.' and da_idtipo=1 order by da_ano desc, da_mes desc limit 0,1');
}

function dame_abonados($idparent, $estado, $idcontrato='', $datmes='', $datanho=''){//$estado=activo/inactivo
    $datmes==''?$datmes=date('m'):null;
    $datanho==''?$datanho=date('Y'):null;
	$filtro=$idcontrato!=''?' and ta_contrato='.$idcontrato.'':'';
	$filtro2=$estado='activo'?' and us_estado!=3':($estado='inactivo'?' and us_estado=3':'');
	if($idparent==6){// Es veturilo
	    $r=list_object("select talleres.* from talleres INNER JOIN datos_actividad ON ta_idtaller=da_idtaller where ta_idparent='{$idparent}' AND da_ano='{$datanho}' AND da_mes='{$datmes}' GROUP BY ta_idtaller");
    }
	else{
	    $r=list_object('select * from talleres, usuarios where ta_idtaller=us_idtaller and ta_idparent='.$idparent.' and ta_idtaller!=1462'.$filtro.''.$filtro2.'');
    }
	return $r;

}

function valor_iva($tipoiva){
	return fetch_array('select ti_valor from tipos_iva where ti_idtipo='.$tipoiva.'','ti_valor');
}

function factura_pte($idtaller){
	return num_rows('select idfactura from facturas where idcli='.$idtaller.' and (estado=0 or estado=2)');
}

function dame_coste_personal($idtaller){
    $datos=fetch_array("SELECT (nominas+seg_social) AS PERSONAL, (alquileres+suministros+renting+serv_prof+cuotas+amortizaciones+otros) as ESTRUCTURA FROM gastos_taller WHERE idtaller={$idtaller}");
    if($datos==''||$datos==null){
        $datos['PERSONAL']=0.00;
        $datos['ESTRUCTURA']=0.00;
    }
    return $datos;
}

function updateUserWpToken($idUsuario)
{
    // Generamos un token y comprobamos que no exista ya, si no existe actualizamos la tabla
    $token = generate_token();
    $existe = fetch_array("SELECT COUNT(*) AS TOTAL FROM usuarios WHERE wp_token = '$token'", 'TOTAL');
    if ($existe === 0) {
        // Actualizamos el token en la tabla usuarios_wordpress
        $update = query("UPDATE usuarios SET wp_token = '$token' WHERE us_idusuario = '$idUsuario'");
        if ($update) {
            return $token;
        } else {
            return false;
        }
    }
    else{
        return updateUserWpToken($idUsuario);
    }
}
?>