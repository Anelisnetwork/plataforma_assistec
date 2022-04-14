<?php
$l_redes=list_object('select * from talleres where ta_idtipo=2 order by ta_nombre asc');
$l_talleres=list_object('select talleres.*, uf_nomcom from talleres, usuarios_facturacion where ta_idtaller=uf_idtaller and ta_idtipo=1 order by uf_nomcom asc');

if($seccion=='listado_usuarios'){
	
	if(isset($_GET['pagina'])){//Si se define pagina
		$pagina=(int)clean_get('pagina');
	}
	else {//si no se define pagina
		if(isset($_SESSION['usuarios_pagina'])){//Si ya estaba definida
			$pagina=$_SESSION['usuarios_pagina'];
		}
		else {
			$pagina=1;
		}
	}
	
	$filtro_busq='';

	if(isset($_POST['usu_busq'])){
		$pagina=$_SESSION['usuarios_pagina']=1;
		
		$_SESSION['usu_busq']=$usu_busq=u8_(clean_post('usu_busq'));
		$_SESSION['usu_est']=$usu_est=clean_post('usu_est');
	}
	else{
		if(isset($_GET['usu_est'])){
			$pagina=$_SESSION['usuarios_pagina']=1;
			
			$_SESSION['usu_est']=$usu_est=clean_get('usu_est');
		}
		else{
			if(!isset($_SESSION['usu_busq'])){
				$_SESSION['usu_busq']='';
			}
			if(!isset($_SESSION['usu_est'])){
				$_SESSION['usu_est']='';
			}
		}
	}

	$usu_busq=$_SESSION['usu_busq'];
	$usu_est=$_SESSION['usu_est'];
	
	$filtro_estado=$usu_est==1||$usu_est==2||$usu_est==3?' and us_estado='.$usu_est.'':'';
	
	$filtro_busq.=$usu_busq==''?'':' and (us_nick like "%'.$usu_busq.'%" or us_correo like "%'.$usu_busq.'%" or ta_nombre like "%'.$usu_busq.'%" or ta_contacto like "%'.$usu_busq.'%" or ta_email like "%'.$usu_busq.'%" or ta_socio like "%'.$usu_busq.'%" or ta_localidad like "%'.$usu_busq.'%" or ta_provincia like "%'.$usu_busq.'%")';
	$lista_ids=array_comas('select distinct us_idusuario from usuarios, talleres where 1 and us_idtaller=ta_idtaller'.$filtro_busq.''.$filtro_estado.' order by us_fecha_alta desc');
	$ids_usuarios=explode(',',$lista_ids);
	
	$total_filtrado=count($ids_usuarios);
	
	$porpagina=25;

	$url=_RAIZ_.'usuarios/listado_usuarios/';
	
	if($total_filtrado==0||$lista_ids==''){
		$npaginas=1;
		$usuarios=array();
	}
	else{
		if($total_filtrado>$porpagina){
			$lista_ids=damearraypag($ids_usuarios,$pagina,$porpagina);
			$npaginas=ceil($total_filtrado/$porpagina);
		}
		else {
			$npaginas=1;
		}
		
		$usuarios=list_object('select * from usuarios where us_idusuario in ('.$lista_ids.') order by us_fecha_alta desc');
	}
	$pagina>$npaginas?$pagina=1:'';
	$_SESSION['usuarios_pagina']=$pagina;
	
	$pagsiguiente=$_SESSION['usuarios_pagina']+1;
	$paganterior=$_SESSION['usuarios_pagina']-1;
}
else if($seccion=='nuevo_usuario'){
}
else if($seccion=='editar_usuario'){
	$idusuario=clean_get('idusuario');
	$d_user=dame_datos_usuario($idusuario);
	$d_user==''||$d_user==NULL?fuera_de_aqui(_RAIZ_.'usuarios'):'';
}
else{}

?>