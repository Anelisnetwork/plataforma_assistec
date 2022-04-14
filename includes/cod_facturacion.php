<?php
if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']!=1){//USUARIO
	$fac_idcli=$_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2?$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']:$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];
	if($seccion=='facturas'){
		$lista_ids=array_comas('select idfactura from facturas where idcli='.$fac_idcli.' order by fecha_emision desc');
		$ids_facturas=explode(',',$lista_ids);
		
		$total_filtrado=count($ids_facturas);
		
		$porpagina=25;
	
		$url=_RAIZ_.'facturacion/facturas/';
		
		if(isset($_GET['pagina'])){//Si se define pagina
			$pagina=(int)clean_get('pagina');
		}
		else {//si no se define pagina
			if(isset($_SESSION['facturas_pagina'])){//Si ya estaba definida
				$pagina=$_SESSION['facturas_pagina'];
			}
			else {
				$pagina=1;
			}
		}
		
		if($total_filtrado>$porpagina){
			$lista_ids=damearraypag($ids_facturas,$pagina,$porpagina);
			$npaginas=ceil($total_filtrado/$porpagina);
		}
		else {
			$npaginas=1;
		}
	
		if($total_filtrado==0||$lista_ids==''){
			$npaginas=1;
			$facturas=array();
		}
		else{
			$facturas=list_object('select * from facturas where idfactura in ('.$lista_ids.') and idcli='.$fac_idcli.' order by fecha_emision desc');
		}
		
		$pagina>$npaginas?$pagina=1:'';
		$_SESSION['facturas_pagina']=$pagina;
		
		$pagsiguiente=$_SESSION['facturas_pagina']+1;
		$paganterior=$_SESSION['facturas_pagina']-1;
	}
	else{}
}//USUARIO
else{//SUPERADMIN
	if($seccion=='vencimientos'){
		
		$lista_ids=array_comas('select ta_idtaller from talleres, usuarios where ta_idtaller=us_idtaller and ta_idparent=0 and us_estado!=3');
		$ids_talleres=explode(',',$lista_ids);
		
		$total_filtrado=count($ids_talleres);
		
		$porpagina=25;
	
		$url=_RAIZ_.'facturacion/vencimientos/';
		
		if(isset($_GET['pagina'])){//Si se define pagina
			$pagina=(int)clean_get('pagina');
		}
		else {//si no se define pagina
			if(isset($_SESSION['vencimientos_pagina'])){//Si ya estaba definida
				$pagina=$_SESSION['vencimientos_pagina'];
			}
			else {
				$pagina=1;
			}
		}
		
		if($total_filtrado>$porpagina){
			$lista_ids=damearraypag($ids_talleres,$pagina,$porpagina);
			$npaginas=ceil($total_filtrado/$porpagina);
		}
		else {
			$npaginas=1;
		}
			
		if($total_filtrado==0){
			$talleres='';
		}
		else{
			$talleres=list_object('select * from talleres where ta_idtaller in ('.$lista_ids.') order by ta_vencimiento asc');
		}
		
		$pagina>$npaginas?$pagina=1:'';
		$_SESSION['vencimientos_pagina']=$pagina;
		
		$pagsiguiente=$_SESSION['vencimientos_pagina']+1;
		$paganterior=$_SESSION['vencimientos_pagina']-1;
	}
	else if($seccion=='facturas'){
		$lista_ids=array_comas('select idfactura from facturas order by fecha_emision desc');
		$ids_facturas=explode(',',$lista_ids);
		
		$total_filtrado=count($ids_facturas);
		
		$porpagina=25;
	
		$url=_RAIZ_.'facturacion/facturas/';
		
		if(isset($_GET['pagina'])){//Si se define pagina
			$pagina=(int)clean_get('pagina');
		}
		else {//si no se define pagina
			if(isset($_SESSION['facturas_pagina'])){//Si ya estaba definida
				$pagina=$_SESSION['facturas_pagina'];
			}
			else {
				$pagina=1;
			}
		}
		
		if($total_filtrado>$porpagina){
			$lista_ids=damearraypag($ids_facturas,$pagina,$porpagina);
			$npaginas=ceil($total_filtrado/$porpagina);
		}
		else {
			$npaginas=1;
		}
	
		if($total_filtrado==0||$lista_ids==''){
			$npaginas=1;
			$facturas=array();
		}
		else{
			$facturas=list_object('select * from facturas where idfactura in ('.$lista_ids.') order by fecha_emision desc');
		}
		
		$pagina>$npaginas?$pagina=1:'';
		$_SESSION['facturas_pagina']=$pagina;
		
		$pagsiguiente=$_SESSION['facturas_pagina']+1;
		$paganterior=$_SESSION['facturas_pagina']-1;
	}
	else if($seccion=='emitir_factura'){
		$idtaller=clean_get('idtaller');
		if($idtaller!=''&&num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.'')==1){
			$dirfac=dato_taller('ta_iddirfac', $idtaller);
			$datos_fac=fetch_array('select * from usuarios_facturacion where uf_iddir='.$dirfac.'');
			$datos_taller=fetch_array('select * from talleres where ta_idtaller='.$idtaller.'');
			$tipo_abono=fetch_array('Select ta_nombre from tipos_abono where ta_idtipo='.$datos_taller['ta_abono'].'','ta_nombre');
			$sigla_ta=strtolower(substr($tipo_abono,0,1));
			$tipo_tarifa=$datos_taller['ta_idtipo'].$sigla_ta;
			$anho=date('Y');
			$nfactura=dame_num_fra($anho);
		}
		else{
			$idtaller='';
		}
	}
	else if($seccion=='editar_factura'){
		$idfactura=clean_get('idfactura');
		if($idfactura!=''&&num_rows('select idfactura from facturas where idfactura='.$idfactura.'')==1){
			$factura=fetch_array('select * from facturas where idfactura='.$idfactura.'');
			$lineas=list_object('select * from facturas_linea where fl_idfactura='.$idfactura.'');
		}
		else{
			$idfactura='';
		}
	}
	else{}
}//SUPERADMIN
?>