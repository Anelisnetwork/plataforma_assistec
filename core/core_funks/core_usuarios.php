<?php
	
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
        $_SESSION['datos_'._ID_PAG_]['datos_user']['hayKm0'] = hayKm0($idtaller);
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

function dame_empleados($idtipo=''){//Devuelve el listado de empleados completo o sólo del tipo indicado
	if($idtipo==''){
		$empleados=list_object('select * from personal_taller where pt_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
	}
	else{
		$empleados=list_object('select personal_taller.* from personal_taller, personal_funciones, cargos_personal where cp_idtipo='.$idtipo.' and pf_idcargo=cp_idpersonal and pt_idpersonal=pf_idpersonal and pt_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' group by pt_idpersonal');
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
    return ['mes' => $dt->format('m'), 'anho' => $dt->format('Y')];
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
		$incremento=($ventas_anho[0]->FACTURADO-$media)/$ventas_anho[0]->FACTURADO*100;
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
		$sum_hfac+=($dato->da_facturadomo/$dato->da_impmo);
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
		$sum_hfac+=($dato->da_facturadomo/$dato->da_impmo);
		$sum_hfich+=$dato->da_horasfichadasor;
		$key==0?$rd_ultmes=porcentaje_($sum_hfac,$sum_hfich):'';
	}
	$rendimiento=porcentaje_($sum_hfac,$sum_hfich);
	return array($rd_ultmes, $rendimiento);
}

function dame_acumulado($anho,$idtaller=''){
    $idtaller==''?$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:null;
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
		$hfacturadas+=($dato->da_facturadomo/$dato->da_impmo);
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
	$coste_medio_mo=$nmeses==0?0:($ventamo/$hfacturadas)/$nmeses;
    $coste_hora_teorico=$nmeses==0?0:($porcentajes[4]==0?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*80/100));
    $coste_hora_real=$nmeses==0?0:($porcentajes[4]==0?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*$eficacia/100));
	
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
        $porcentpr=$margenpr/$ventapr*100;
        $total_gastos=$costepr+$costepers+$costeestr;
        $margenbruto=$total_ingresos-$total_gastos;
        //$porcmargenbruto=margen_sobre_coste($total_gastos,$total_ingresos);
        $porcmargenbruto=$margenbruto/$total_ingresos*100;
        $productividad=porcentaje_($fichadasor,$hpresencia);
        $eficacia=porcentaje_($hfacturadas,$hpresencia);
        $rendimiento=porcentaje_($hfacturadas,$fichadasor);
        $mediaor=$entradastaller==0?0:$total_facturado/$entradastaller;
        $mediamo=$entradastaller==0?0:$ventamo/$entradastaller;
        $mediapr=$entradastaller==0?0:$ventapr/$entradastaller;
        $infotaller=dame_info($idtaller);
        $totalbbdd=$infotaller[0]->it_totalclientes;
        $fidelizacion=porcentaje_($entradastaller,$totalbbdd);
        $objeficacia=$objeficacia/$nmeses;
        $objproductividad=$objproductividad/$nmeses;
        $objrendimiento=$objrendimiento/$nmeses;
        $objventas=$objventas/$nmeses;
        $objmargenrec=$objmargenrec/$nmeses;
        $horaspotenciales=($hpresencia/$nmeses*12)*$objeficacia/100;
        $costehora=$horaspotenciales==0?0:(($costepers+$costeestr)/$nmeses*12)/$horaspotenciales;
        $impmo_media=$impmo/$nmeses;
        $coste_medio_mo=$ventamo/$hfacturadas;
        $coste_hora_teorico=$porcentajes[4]==0?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*80/100);
        $coste_hora_real=$porcentajes[4]==0?0:(($costepers/$nmeses*12)+($costeestr/$nmeses*12))/($porcentajes[4]*1750*$eficacia/100);
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