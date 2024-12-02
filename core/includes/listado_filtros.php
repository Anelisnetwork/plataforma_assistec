<?php
$tipo_informes=array('Productividad', 'Eficacia', 'Rendimiento', 'Margen vta. PR', 'Nº de entradas', 'Tiempo por entrada', 'Importe medio por OR', 'Importe de MO por OR', 'Importe PR por OR', 'Coste personal');

$prov_todas='ALL';
$filtro_prov='';

$filtro_taller='';

$tipo=clean_post('f_tipo_taller');
$idtaller=clean_post('f_id_taller');

$tipo==2?$prov_todas=clean_post('f_prov_todas'):'';

$filtro_taller=$idtaller==''?'':($tipo==1?' and ta_idtaller='.$idtaller.'':' and ta_idparent='.$idtaller.'');

if($tipo==2&&$prov_todas!='ALL'&&isset($_POST['f_prov_sel'])){
	$ind=0;
	foreach($_POST['f_prov_sel'] as $sel_prov){
		$filtro_prov.=($ind==0?' and (':' OR ').'ta_cp like "'.$sel_prov.'%"';
		$ind++;
	}
	$filtro_prov.=')';
}

$nombre_taller=$filtro_taller==''?'TODOS':quitar_acentos(strtoupper(u8d_(fetch_array('SELECT ta_nombre from talleres where ta_idtaller='.$idtaller.'','ta_nombre'))));
$nombre_taller=str_replace(' ', '_', $nombre_taller);

$anho=clean_post('f_anho');

$titulo='Informe_talleres';

titulo_hoja($titulo);

$talleres_c='SELECT ta_idtaller, ta_nombre from talleres where 1'.$filtro_taller.''.$filtro_prov.'';

$talleres=list_object($talleres_c);

foreach ($talleres as $key => $taller) {
	if($key==0){//Es el primero, tenemos que crear las cabeceras
		foreach($_POST['f_mes_sel'] as $idm=>$cada_mes){
			$color_bg=$idm%2==0?'FFFFFF':'EEEEEE';
			$cell=1;
			$col++;
			$mes=conceros($cada_mes,2);
			$nombre_mes_anho=strtoupper(nombremes(($anho.'-'.$mes.'-01'),'ES')).' '.$anho;
			valor_celda_txt($col.$cell,$nombre_mes_anho);negrita($col.$cell);color_bg($col.$cell,$color_bg);
			$comb_1=$col;
			$cell++;
			foreach($_POST['f_tipoinf_sel'] as $idn=>$t_inf){
			$idn==0?'':$col++;
				valor_celda($col.$cell,$tipo_informes[$t_inf]);centrado($col.$cell);negrita($col.$cell);ancho_col_auto($col);color_bg($col.$cell,$color_bg);
			}
			$comb_2=$col;
			combinar($comb_1.'1:'.$comb_2.'1');
			centrado($comb_1.'1');
			borde_fino($comb_1.'1:'.$comb_2.$cell.'','all');
			$cell++;
		}
	}//Es el primero, tenemos que crear las cabeceras
	$col='A';
	valor_celda($col.$cell,u8d_($taller->ta_nombre));ancho_col_auto($col);
	foreach($_POST['f_mes_sel'] as $idm=>$cada_mes){
		$color_bg=$idm%2==0?'FFFFFF':'EEEEEE';
		$col++;
		$mes=$cada_mes;

		$dato_mes=datos_actividad_taller($taller->ta_idtaller, 1, $mes, $anho);
		if(count($dato_mes)==1){
			$iddato=$dato_mes[0]->da_iddato;

			$hpresencia=horas_presencia($iddato);
			$productividad=porcentaje_($dato_mes[0]->da_horasfichadasor,$hpresencia);
			$obj_prod=$dato_mes[0]->da_objproductividad;

			$hfacturadas=$dato_mes[0]->da_facturadomo/$dato_mes[0]->da_impmo;
			$eficacia=porcentaje_($hfacturadas,$hpresencia);
			$obj_efic=$dato_mes[0]->da_objeficacia;

			$rendimiento=porcentaje_($hfacturadas,$dato_mes[0]->da_horasfichadasor);
			$obj_rendi=$dato_mes[0]->da_objrendimiento;

			$ventapr=$dato_mes[0]->da_facturadorec+$dato_mes[0]->da_facturadootros;
			$costepr=$dato_mes[0]->da_pagadoprovrec+$dato_mes[0]->da_pagadoprovotros;
			$porcentpr=margen_sobre_coste($costepr,$ventapr);
			$obj_ventapr=$dato_mes[0]->da_objmargenrec;

			$total_facturado=$dato_mes[0]->da_facturadomo+$dato_mes[0]->da_facturadorec+$dato_mes[0]->da_facturadootros;
			$mediaor=$dato_mes[0]->da_entradastaller==0?'':$total_facturado/$dato_mes[0]->da_entradastaller;

			$ventamo=$dato_mes[0]->da_facturadomo;
			$mediamo=$dato_mes[0]->da_entradastaller==0?'':$ventamo/$dato_mes[0]->da_entradastaller;

			$mediapr=$dato_mes[0]->da_entradastaller==0?'':$ventapr/$dato_mes[0]->da_entradastaller;

			$infotaller=dame_info($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
			$totalbbdd=$infotaller[0]->it_totalclientes;
			$fidelizacion=porcentaje_($dato_mes[0]->da_entradastaller,$totalbbdd);;



			$horas_productivas=horas_presencia_pot($taller->ta_idtaller)*($obj_prod/100);//Un 10% de tiempo no productivo
            $tiempo_medio_cliente=$dato_mes[0]->da_entradastaller==0?0:$horas_productivas/$dato_mes[0]->da_entradastaller;//21.6
			$capacidad_teorica=$dato_mes[0]->da_entradastaller==0?'':$horas_productivas/$tiempo_medio_cliente;
			$entradas_dia=$dato_mes[0]->da_entradastaller/$dato_mes[0]->da_diaslaborables;

			$dato_0=round($productividad,2).'%';
			$res_0=$productividad<$obj_prod?'r':'v';
			$dato_1=round($eficacia,2).'%';
			$res_1=$eficacia<$obj_efic?'r':'v';
			$dato_2=round($rendimiento,2).'%';
			$res_2=$rendimiento<$obj_rendi?'r':'v';
			$dato_3=round($porcentpr,2).'%';
			$res_3=$porcentpr<$obj_ventapr?'r':'v';
			$dato_4=$dato_mes[0]->da_entradastaller;
			$res_4='';
			$dato_5=faltan2($tiempo_medio_cliente*3600);
			$res_5='';
			$dato_6=round($mediaor,2);
			$res_6='';
			$dato_7=round($mediamo,2);
			$res_7='';
			$dato_8=round($mediapr,2);
			$res_8='';
			$dato_9=round($dato_mes[0]->da_costepersonal,2);
			$res_9='';
		}
		else{
			$dato_0='';
			$res_0='';
			$dato_1='';
			$res_1='';
			$dato_2='';
			$res_2='';
			$dato_3='';
			$res_3='';
			$dato_4='';
			$res_4='';
			$dato_5='';
			$res_5='';
			$dato_6='';
			$res_6='';
			$dato_7='';
			$res_7='';
			$dato_8='';
			$res_8='';
			$dato_9='';
			$res_9='';
		}

		foreach($_POST['f_tipoinf_sel'] as $idn=>$t_inf){
			$idn==0?'':$col++;
			//echo $t_inf.'<br>';
			valor_celda($col.$cell,${'dato_'.$t_inf});
			$t_inf==6||$t_inf==7||$t_inf==8?f_euro($col.$cell):'';
			centrado($col.$cell);
			ancho_col_auto($col);
			color_bg($col.$cell,$color_bg);
			${'res_'.$t_inf}=='v'?color_text($col.$cell,'2DB200'):(${'res_'.$t_inf}=='r'?color_text($col.$cell,'EF7F1F'):'');
		}
	}
	borde_fino('A'.$cell.':'.$col.$cell.'','all');
	$cell++;
}
$col++;
$colfinal=$col;

//exit;

set_celda('A1');

$titulo='Informe_talleres_'.$nombre_taller;
?>