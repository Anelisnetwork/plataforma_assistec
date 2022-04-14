<?php
if($seccion=='listado_promociones'){
	
	if(isset($_GET['pagina'])){//Si se define pagina
		$pagina=(int)clean_get('pagina');
	}
	else {//si no se define pagina
		if(isset($_SESSION['promociones_pagina'])){//Si ya estaba definida
			$pagina=$_SESSION['promociones_pagina'];
		}
		else {
			$pagina=1;
		}
	}
	
	$filtro_busq='';
	$prom_busq='';
	if(isset($_POST['prom_busq'])){
		if($_POST['prom_busq']==''){
			$_SESSION['prom_busq']='';
			$_SESSION['promociones_pagina']=1;
			$pagina=$_SESSION['promociones_pagina'];
		}
		else{
			$prom_busq=u8_(clean_post('prom_busq'));
			$_SESSION['prom_busq']=$prom_busq;
			$_SESSION['promociones_pagina']=1;
			$pagina=$_SESSION['promociones_pagina'];
		}
	}
	else{
		if(isset($_SESSION['prom_busq'])){
			$prom_busq=$_SESSION['prom_busq'];
		}
	}
	
	$filtro_busq.=$prom_busq==''?'':' and pr_titulo like "%'.$prom_busq.'%"';
	$lista_ids=array_comas('select distinct pr_idpromocion from promociones where 1'.$filtro_busq.' order by pr_desde desc');
	$ids_promociones=explode(',',$lista_ids);
	
	$total_filtrado=count($ids_promociones);
	
	$porpagina=25;

	$url=_RAIZ_.'promociones/listado_promociones/';
	
	if($total_filtrado==0||$lista_ids==''){
		$npaginas=1;
		$promociones=array();
	}
	else{
		if($total_filtrado>$porpagina){
			$lista_ids=damearraypag($ids_promociones,$pagina,$porpagina);
			$npaginas=ceil($total_filtrado/$porpagina);
		}
		else {
			$npaginas=1;
		}
		
		$promociones=list_object('select * from promociones where pr_idpromocion in ('.$lista_ids.') order by pr_desde desc');
	}
	$pagina>$npaginas?$pagina=1:'';
	$_SESSION['promociones_pagina']=$pagina;
	
	$pagsiguiente=$_SESSION['promociones_pagina']+1;
	$paganterior=$_SESSION['promociones_pagina']-1;
}
else if($seccion=='nueva_promocion'){
	$idpromo='NEW';
}
else if($seccion=='editar_promocion'){
	$idpromo=clean_get('idpromocion');
	$d_promo=dame_datos_promocion($idpromo);
	$d_promo==''||$d_promo==NULL?fuera_de_aqui(_RAIZ_.'promociones'):'';
	
	$pendientes=list_object('select ta_nombre, ta_durpromo, ta_idtaller from talleres where ta_idpromo='.$idpromo.'');
	
	//ALTER TABLE `talleres` ADD `ta_idpromo` INT(25) NOT NULL DEFAULT '0' AFTER `ta_testing`, ADD `ta_durpromo` TINYINT(2) NOT NULL DEFAULT '0' AFTER `ta_idpromo`;
}
else{}

?>