<?php
$l_redes=list_object('select * from talleres where ta_idtipo=2 order by ta_nombre asc');
$l_talleres=list_object('select * from talleres where ta_idtipo=1 order by ta_nombre asc');




if($seccion=='listado_talleres'){
    $mes=$_SESSION['tall_mes']=date('n')==1?12:date('n')-1;
    $anho=$_SESSION['tall_anho']=date('n')==1?date('Y')-1:date('Y');
	
	if(isset($_GET['pagina'])){//Si se define pagina
		$pagina=(int)clean_get('pagina');
	}
	else {//si no se define pagina
		if(isset($_SESSION['talleres_pagina'])){//Si ya estaba definida
			$pagina=$_SESSION['talleres_pagina'];
		}
		else {
			$pagina=1;
		}
	}
	
	$filtro_busq='';
	
	if(isset($_POST['tall_busq'])){
		$_SESSION['talleres_pagina']=1;
		$pagina=$_SESSION['talleres_pagina'];
			
		if(isset($_POST['tall_nodatos'])&&clean_post('tall_nodatos')!='99'){
            $mes=$_SESSION['tall_mes']=clean_post('tall_mes');
            $anho=$_SESSION['tall_anho']=clean_post('tall_anho');
            //echo 'select distinct ta_idtaller from talleres, datos_actividad where ta_idtaller=da_idtaller and da_mes='.$mes.' and da_ano='.$anho;
            //echo '<br>';
			$ids_sidato=array_comas('select distinct ta_idtaller from talleres, datos_actividad where ta_idtaller=da_idtaller and da_mes='.$mes.' and da_ano='.$anho);
			$_SESSION['tall_nodatos']=$ids_sidato;
			$_SESSION['tall_bsqdat']=clean_post('tall_nodatos');
		}
		else{
			$ids_sidato='';
			$_SESSION['tall_nodatos']='';
			$_SESSION['tall_bsqdat']='99';
            $_SESSION['tall_mes']=date('n')==1?12:date('n')-1;
            $_SESSION['tall_anho']=date('n')==1?date('Y')-1:date('Y');
		}

		$_SESSION['tall_busq']=$tall_busq=u8_(clean_post('tall_busq'));
		$_SESSION['tall_tipo']=$tall_tipo=clean_post('tall_tipo');
		
	}
	else{
		if(isset($_GET['tall_tipo'])){
			$pagina=$_SESSION['talleres_pagina']=1;
			
			$_SESSION['tall_tipo']=$tall_tipo=clean_get('tall_tipo');
		}
		else{
			if(!isset($_SESSION['tall_busq'])){
				$_SESSION['tall_busq']='';
			}
			if(!isset($_SESSION['tall_nodatos'])){
				$_SESSION['tall_nodatos']='';
				$_SESSION['tall_bsqdat']='';
			}
			if(!isset($_SESSION['tall_tipo'])){
				$_SESSION['tall_tipo']='';
			}
		}
	}
	
	$tall_busq=$_SESSION['tall_busq'];

    $_SESSION['tall_nodatos']==''||$_SESSION['tall_nodatos']==null?$_SESSION['tall_nodatos']=0:null;

	$ids_sidato=$_SESSION['tall_nodatos'];
	$tall_tipo=$_SESSION['tall_tipo'];

	$filtro_tipo=$tall_tipo==1||$tall_tipo==2?' and ta_idtipo='.$tall_tipo.'':'';
	
	//$filtro_datos=($ids_sidato==''?'':($_SESSION['tall_bsqdat']==0?' and ta_idtaller not in ('.$ids_sidato.')':($_SESSION['tall_bsqdat']==1?' and ta_idtaller in ('.$ids_sidato.')':'')));

	$filtro_datos='';
	if($ids_sidato!==''){
	    if($_SESSION['tall_bsqdat']==0){
            $filtro_datos=' and ta_idtaller not in ('.$ids_sidato.')';
        }
        elseif($_SESSION['tall_bsqdat']==1){
            $filtro_datos=' and ta_idtaller in ('.$ids_sidato.')';
        }
    }

	//$filtro_busq.=$tall_busq==''?'':' and (ta_nombre like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or ta_contacto like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or ta_socio like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or ta_email like "%'.$tall_busq.'%" or ta_localidad like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or ta_provincia like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or uf_denomsoc like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or uf_cifnif like _utf8 "%'.$tall_busq.'%" or uf_nomcom like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or uf_contacto like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or uf_email like "%'.$tall_busq.'%" or uf_localidad like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci or uf_provincia like _utf8 "%'.$tall_busq.'%" COLLATE utf8_general_ci)';

	$filtro_busq.=$tall_busq==''?'':' and (ta_nombre like "%'.$tall_busq.'%" or ta_contacto like "%'.$tall_busq.'%" or ta_socio like "%'.$tall_busq.'%" or ta_email like "%'.$tall_busq.'%" or ta_localidad like "%'.$tall_busq.'%" or ta_provincia like "%'.$tall_busq.'%" or uf_denomsoc like "%'.$tall_busq.'%" or uf_cifnif like "%'.$tall_busq.'%" or uf_nomcom like "%'.$tall_busq.'%" or uf_contacto like "%'.$tall_busq.'%" or uf_email like "%'.$tall_busq.'%" or uf_localidad like "%'.$tall_busq.'%" or uf_provincia like "%'.$tall_busq.'%")';

	//echo 'select distinct ta_idtaller from talleres, usuarios_facturacion where 1 and ta_idtaller=uf_idtaller'.$filtro_busq.$filtro_tipo.$filtro_datos.' order by ta_nombre asc';
	$lista_ids=array_comas('select distinct ta_idtaller from talleres, usuarios_facturacion where 1 and ta_idtaller=uf_idtaller'.$filtro_busq.$filtro_tipo.$filtro_datos.' order by ta_nombre asc');

	$ids_talleres=explode(',',$lista_ids);
	
	$total_filtrado=count($ids_talleres);
	
	$porpagina=25;

	$url=_RAIZ_.'talleres/listado_talleres/';
	
	
	if($total_filtrado==0||$lista_ids==''){
		$npaginas=1;
		$talleres=array();
	}
	else{
		if($total_filtrado>$porpagina){
			$lista_ids=damearraypag($ids_talleres,$pagina,$porpagina);
			$npaginas=ceil($total_filtrado/$porpagina);
		}
		else {
			$npaginas=1;
		}
		
		$talleres=list_object('select * from talleres where ta_idtaller in ('.$lista_ids.') order by ta_nombre asc');
	}
	$pagina>$npaginas?$pagina=1:null;
	$_SESSION['talleres_pagina']=$pagina;
	
	$pagsiguiente=$_SESSION['talleres_pagina']+1;
	$paganterior=$_SESSION['talleres_pagina']-1;
}
else if($seccion=='nuevo_taller'){
}
else if($seccion=='editar_taller'){
	$idtaller=clean_get('idtaller');
	$d_tall=dame_datos_taller($idtaller);
	count($d_tall)==0||$d_tall==''||$d_tall==NULL?fuera_de_aqui(_RAIZ_.'talleres'):null;
	$d_tall_fac=dame_datos_facturacion($d_tall[0]->ta_iddirfac);
	count($d_tall_fac)==0||$d_tall_fac==''||$d_tall_fac==NULL?fuera_de_aqui(_RAIZ_.'talleres'):null;
	$token=$d_tall[0]->ta_log_token==''?md5('idtaller='.$d_tall[0]->ta_idtaller.' momento='.time()):$d_tall[0]->ta_log_token;
	$d_tall[0]->ta_log_token==''?query("update talleres set ta_log_token='".$token."' where ta_idtaller=".$idtaller):null;
}