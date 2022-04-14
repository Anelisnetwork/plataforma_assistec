<?php
$filtro_estado=$_SESSION['usu_est']==1||$_SESSION['usu_est']==2||$_SESSION['usu_est']==3?" and us_estado='{$_SESSION['usu_est']}'":'';
	
$filtro_busq=$_SESSION['usu_busq']==''?'':" and (us_nick like '%{$_SESSION['usu_busq']}%' or us_correo like '%{$_SESSION['usu_busq']}%' or ta_nombre like '%{$_SESSION['usu_busq']}%' or ta_contacto like '%{$_SESSION['usu_busq']}%' or ta_email like '%{$_SESSION['usu_busq']}%' or ta_socio like '%{$_SESSION['usu_busq']}%' or ta_localidad like '%{$_SESSION['usu_busq']}%' or ta_provincia like '%{$_SESSION['usu_busq']}%')";
	
//$lista_ids=array_comas('select distinct us_idusuario from usuarios, talleres where 1 and us_idtaller=ta_idtaller'.$filtro_busq.''.$filtro_estado.' order by us_fecha_alta desc');
	
	//echo 'select distinct ta_idtaller from talleres, usuarios_facturacion where 1 and ta_idtaller=uf_idtaller'.$filtro_busq.''.$filtro_tipo.''.$filtro_datos.' order by ta_nombre asc';exit;
	
/*if(count(explode(',',$lista_ids))==0){
	echo 'No hay resultados';
	exit();
}*/

$usuarios=list_object("SELECT u.us_idusuario, u.us_nick, u.us_correo, u.us_estado, u.us_fecha_alta, t.ta_nombre AS taller, IF(t.ta_idparent=0,'',IFNULL(t2.ta_nombre,'')) AS MATRIZ FROM usuarios u INNER JOIN talleres t ON u.us_idtaller=t.ta_idtaller LEFT JOIN talleres t2 ON t.ta_idparent=t2.ta_idtaller WHERE 1{$filtro_busq}{$filtro_estado} GROUP BY u.us_idusuario ORDER BY u.us_fecha_alta DESC");

if(count($usuarios)==0){
	echo 'No hay resultados';
	exit();
}

$titulo='Listado_usuarios';

titulo_hoja($titulo);

valor_celda($col.$cell,'Nick');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Correo acceso');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Taller');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Matriz');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Estado');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Fecha alta');negrita($col.$cell);centrado($col.$cell);$col++;
$cell++;

foreach ($usuarios as $usuario){
	$col='A';
	valor_celda($col.$cell,u8d_($usuario->us_nick));$col++;
	valor_celda($col.$cell,u8d_($usuario->us_correo));$col++;
	valor_celda($col.$cell,u8d_($usuario->taller));$col++;
	valor_celda($col.$cell,u8d_($usuario->MATRIZ));$col++;
	valor_celda($col.$cell,($usuario->us_estado==3?'Inactivo':($usuario->us_estado==1?'Activo':'Pte. datos')));$col++;
	valor_celda($col.$cell,fecha_esp($usuario->us_fecha_alta));
	$cell++;
}

$colfinal=$col;

ancho_auto('A',$colfinal);
?>