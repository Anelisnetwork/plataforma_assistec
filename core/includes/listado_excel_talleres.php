<?php
$filtro_tipo=$_SESSION['tall_tipo']==1||$_SESSION['tall_tipo']==2?' and ta_idtipo='.$_SESSION['tall_tipo'].'':'';
	
$filtro_datos=$_SESSION['tall_nodatos']==''?'':($_SESSION['tall_bsqdat']==0?' and ta_idtaller not in ('.$_SESSION['tall_nodatos'].')':($_SESSION['tall_bsqdat']==1?' and ta_idtaller in ('.$_SESSION['tall_nodatos'].')':''));
	
$filtro_busq=$_SESSION['tall_busq']==''?'':' and (ta_nombre like "%'.$_SESSION['tall_busq'].'%" or ta_contacto like "%'.$_SESSION['tall_busq'].'%" or ta_socio like "%'.$_SESSION['tall_busq'].'%" or ta_email like "%'.$_SESSION['tall_busq'].'%" or ta_localidad like "%'.$_SESSION['tall_busq'].'%" or ta_provincia like "%'.$_SESSION['tall_busq'].'%" or uf_denomsoc like "%'.$_SESSION['tall_busq'].'%" or uf_cifnif like "%'.$_SESSION['tall_busq'].'%" or uf_nomcom like "%'.$_SESSION['tall_busq'].'%" or uf_contacto like "%'.$_SESSION['tall_busq'].'%" or uf_email like "%'.$_SESSION['tall_busq'].'%" or uf_localidad like "%'.$_SESSION['tall_busq'].'%" or uf_provincia like "%'.$_SESSION['tall_busq'].'%")';
	
$lista_ids=array_comas('select distinct ta_idtaller from talleres, usuarios_facturacion where 1 and ta_idtaller=uf_idtaller'.$filtro_busq.''.$filtro_tipo.''.$filtro_datos.' order by ta_nombre asc');
	
	//echo 'select distinct ta_idtaller from talleres, usuarios_facturacion where 1 and ta_idtaller=uf_idtaller'.$filtro_busq.''.$filtro_tipo.''.$filtro_datos.' order by ta_nombre asc';exit;
	
if(count(explode(',',$lista_ids))==0){
	echo 'No hay resultados';
	exit();
}

$talleres=list_object("select t.*, u.us_correo AS MAIL_ACCESO, IFNULL(t2.ta_nombre,'---') AS MATRIZ from talleres t INNER JOIN usuarios u on t.ta_idtaller = u.us_idtaller LEFT JOIN talleres t2 ON t.ta_idparent=t2.ta_idtaller where t.ta_idtaller in ({$lista_ids}) order by t.ta_nombre asc");

if(count($talleres)==0){
	echo 'No hay resultados';
	exit();
}

$titulo='Listado_talleres';

titulo_hoja($titulo);

valor_celda($col.$cell,'Nombre taller');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Tipo');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Matriz');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Mail acceso');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Contacto');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Socio');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Telefono 1');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Telefono 2');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Correo');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Dirección');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'C.P.');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Localidad');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Provincia');negrita($col.$cell);centrado($col.$cell);$col++;
valor_celda($col.$cell,'Vencimiento');negrita($col.$cell);centrado($col.$cell);
valor_celda($col.$cell,'Ult. conexion');negrita($col.$cell);centrado($col.$cell);
$cell++;

foreach ($talleres as $taller){
	$col='A';
	valor_celda($col.$cell,u8d_($taller->ta_nombre));$col++;
	valor_celda($col.$cell,($taller->ta_idtipo==1?'Independiente':'Red'));$col++;
	valor_celda($col.$cell,u8d_($taller->MATRIZ));$col++;
    valor_celda($col.$cell,$taller->MAIL_ACCESO);$col++;
	valor_celda($col.$cell,u8d_($taller->ta_contacto));$col++;
	valor_celda($col.$cell,u8d_($taller->ta_socio));$col++;
	valor_celda($col.$cell,$taller->ta_telefono1);$col++;
	valor_celda($col.$cell,$taller->ta_telefono2);$col++;
	valor_celda($col.$cell,$taller->ta_email);$col++;
	valor_celda($col.$cell,u8d_($taller->ta_direccion));$col++;
	valor_celda($col.$cell,$taller->ta_cp);$col++;
	valor_celda($col.$cell,u8d_($taller->ta_localidad));$col++;
	valor_celda($col.$cell,u8d_($taller->ta_provincia));$col++;
	valor_celda($col.$cell,$taller->ta_vencimiento==''?'---':fecha_esp($taller->ta_vencimiento));
	valor_celda($col.$cell,$taller->ta_ultacceso==''?'---':fecha_esp($taller->ta_ultacceso));
	$cell++;
}

$colfinal=$col;

ancho_auto('A',$colfinal);
?>