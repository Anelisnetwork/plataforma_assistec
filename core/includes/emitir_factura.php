<?php

$_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']=0;
$_SESSION['datos_'._ID_PAG_]['emitir_factura']['mensaje']='Factura guardada';

$hayerrores=0;//Indica si hay errores al guardar las líneas de la factura

$url_dest=clean_post('url_dest');

$idtaller=clean_post('idtaller');

if($idtaller==''||num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.'')!=1){
	$_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['emitir_factura']['mensaje']='El taller indicado no existe';
	fuera_de_aqui(_RAIZ_.'facturacion');
}

$dirfac=dato_taller('ta_iddirfac', $idtaller);
$datos_fac=fetch_array('select * from usuarios_facturacion where uf_iddir='.$dirfac.'');
$datos_taller=fetch_array('select * from talleres where ta_idtaller='.$idtaller.'');
$datos_emisor=fetch_array("select * from usuarios_facturacion where uf_cifnif='B05345368' AND uf_idtaller='0'");

$tipoiva=$datos_fac['uf_tipoiva'];

$retiene=$datos_fac['uf_retiene'];

$anho=date('Y');
$trimestre=dame_trimestre(date('m'));
$hoy=date('Y-m-d H:i:s');

$nlineas=clean_post('nlineas');
$nfactura=clean_post('nfactura');

$vencimiento=clean_post('vencimiento').' 23:59:59';

$base=clean_post('base');
$total=clean_post('total');
$observaciones=u8_(clean_post('observaciones'));

$nfactura==''?$nfactura=dame_num_fra($anho):'';


if($_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']==0){
	//GUARDAMOS FACTURA
	if(!query('insert into facturas (nfactura, idcli, fecha_emision, fecha_vencimiento, anho_factura, trimestre_factura, base_imponible, tipo_iva, retiene, importe, emisor_nombre, emisor_cif, emisor_direccion, emisor_cp, emisor_poblacion, emisor_provincia, emisor_idpais, emisor_correo, emisor_telefono, cliente_nombre, cliente_cif, cliente_contacto, cliente_direccion, cliente_cp, cliente_poblacion, cliente_provincia, cliente_idpais, cliente_correo, cliente_telefono, observaciones) values ('.$nfactura.', '.$idtaller.', "'.$hoy.'", "'.$vencimiento.'", '.$anho.', '.$trimestre.', '.$base.', '.$tipoiva.', '.$retiene.', '.$total.', "'.$datos_emisor['uf_denomsoc'].'", "'.$datos_emisor['uf_cifnif'].'", "'.$datos_emisor['uf_direccion'].'", "'.$datos_emisor['uf_cp'].'", "'.$datos_emisor['uf_localidad'].'", "'.$datos_emisor['uf_provincia'].'", "'.$datos_emisor['uf_pais'].'", "'.$datos_emisor['uf_email'].'", "'.$datos_emisor['uf_telefono1'].'", "'.$datos_fac['uf_denomsoc'].'", "'.$datos_fac['uf_cifnif'].'", "'.$datos_fac['uf_contacto'].'", "'.$datos_fac['uf_direccion'].'", "'.$datos_fac['uf_cp'].'", "'.$datos_fac['uf_localidad'].'", "'.$datos_fac['uf_provincia'].'", "'.$datos_fac['uf_pais'].'", "'.$datos_fac['uf_email'].'", "'.$datos_fac['uf_telefono1'].'", "'.$observaciones.'")')){
		$_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['emitir_factura']['mensaje']='Han ocurrido errores al guardar la factura';
		$url_dest=_RAIZ_.'facturacion';
	}
	else{
		$nuevafac=insertado();
		//GUARDAMOS LINEAS DE FACTURA
		for($n=0;$n<=$nlineas;$n++){
			$ref=u8_(trim(addslashes(strip_tags($_POST['ref'][$n]))));
			$conc=u8_(trim(addslashes(strip_tags($_POST['conc'][$n]))));
			$cant=trim(addslashes(strip_tags($_POST['cant'][$n])));
			$preu=trim(addslashes(strip_tags($_POST['preu'][$n])));
			$dto=trim(addslashes(strip_tags($_POST['dto'][$n])));
			$imp=trim(addslashes(strip_tags($_POST['imp'][$n])));
			if($cant!=0&&$cant!=''){
				if(!query('insert into facturas_linea (fl_idfactura, fl_referencia, fl_concepto, fl_preciou, fl_dto, fl_cantidad, fl_importe) values ("'.$nuevafac.'", "'.$ref.'", "'.$conc.'", "'.$preu.'", "'.$dto.'", "'.$cant.'", "'.$imp.'")')){
					$hayerrores=1;
					$_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']=1;
					$_SESSION['datos_'._ID_PAG_]['emitir_factura']['mensaje']='Ha habido errores al guardar las líneas de la factura.<br>Vuelva a intentarlo y revise los datos antes de guardar';
					$url_dest=_RAIZ_.'facturacion';
				}
			}
		}
	}
	if($hayerrores==1){
		query('delete from facturas where idfactura='.$nuevafac.'');
		query('delete from facturas_linea where fl_idfactura='.$nuevafac.'');
		$_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']=1;
		$url_dest=_RAIZ_.'facturacion';
	}
}

fuera_de_aqui($url_dest);

?>