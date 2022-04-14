<?php

$_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores']=0;
$_SESSION['datos_'._ID_PAG_]['editar_factura']['mensaje']='Factura guardada';

$hayerrores=0;//Indica si hay errores al guardar las líneas de la factura

$url_dest=clean_post('url_dest');

$idfactura=clean_post('idfactura');

if($idfactura==''||num_rows('select idfactura from facturas where idfactura='.$idfactura.'')!=1){
	$_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['editar_factura']['mensaje']='La factura indicada no existe';
	fuera_de_aqui(_RAIZ_.'facturacion');
}

$nlineas=clean_post('nlineas');
$nfactura=clean_post('nfactura');

$vencimiento=clean_post('vencimiento').' 23:59:59';

$base=clean_post('base');
$total=clean_post('total');
$observaciones=u8_(clean_post('observaciones'));

$nfactura==''?$nfactura=dame_num_fra($anho):'';


if($_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores']==0){
	//GUARDAMOS FACTURA
	if(!query('update facturas set nfactura="'.$nfactura.'", fecha_vencimiento="'.$vencimiento.'", base_imponible='.$base.', importe='.$total.', observaciones="'.$observaciones.'" where idfactura='.$idfactura.'')){
		$_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['editar_factura']['mensaje']='Han ocurrido errores al guardar la factura';
		$url_dest=_RAIZ_.'facturacion';
	}
	else{
		$lineas_ex=array_comas('select fl_idlinea from facturas_linea where fl_idfactura='.$idfactura.'');
		$lineas_n=array();
		//GUARDAMOS LINEAS DE FACTURA
		for($n=0;$n<=$nlineas;$n++){
			$ref=u8_(trim(addslashes(strip_tags($_POST['ref'][$n]))));
			$conc=u8_(trim(addslashes(strip_tags($_POST['conc'][$n]))));
			$cant=trim(addslashes(strip_tags($_POST['cant'][$n])));
			$preu=trim(addslashes(strip_tags($_POST['preu'][$n])));
			$dto=trim(addslashes(strip_tags($_POST['dto'][$n])));
			$imp=trim(addslashes(strip_tags($_POST['imp'][$n])));
			if($cant!=0&&$cant!=''){
				if(!query('insert into facturas_linea (fl_idfactura, fl_referencia, fl_concepto, fl_preciou, fl_dto, fl_cantidad, fl_importe) values ("'.$idfactura.'", "'.$ref.'", "'.$conc.'", "'.$preu.'", "'.$dto.'", "'.$cant.'", "'.$imp.'")')){
					$hayerrores=1;
					$_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores']=1;
					$_SESSION['datos_'._ID_PAG_]['editar_factura']['mensaje']='Ha habido errores al guardar las líneas de la factura.<br>Vuelva a intentarlo y revise los datos antes de guardar';
					$url_dest=_RAIZ_.'facturacion';
					count($lineas_n>0)&&$lineas_n!=''?query('delete from facturas_linea where fl_idfactura='.$idfactura.' and fl_idlinea in ('.explode(',',$lineas_n).')'):'';//Si hay errores y se han guardado líneas nuevas las eliminamos y dejamos las antiguas
					break;
				}
				else{
					$lineas_n[]=insertado();
				}
			}
		}
		$hayerrores==0?query('delete from facturas_linea where fl_idfactura='.$idfactura.' and fl_idlinea in ('.$lineas_ex.')'):'';
	}
}

fuera_de_aqui($url_dest);

?>