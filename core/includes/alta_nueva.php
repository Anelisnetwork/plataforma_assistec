<?php
/**
 * @var $datos
 */
if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$datos[1].'')!=1||num_rows('select tc_idtipo from tipos_contrato where tc_idtipo='.$datos[2].' and (tc_1t="'.$datos[4].'" OR tc_1s="'.$datos[4].'" OR tc_1a="'.$datos[4].'")')!=1){
	$hay_errores=1;
	$mensaje_error='Error en datos.';
}
else{
	$idtaller=$datos[1];
	$fpago=$datos[5];
	$dirfac=dato_taller('ta_iddirfac', $idtaller);
	$datos_fac=fetch_array('select * from usuarios_facturacion where uf_iddir='.$dirfac.'');
	$datos_taller=fetch_array('select * from talleres where ta_idtaller='.$idtaller.'');
	$datos_emisor=fetch_array("select * from usuarios_facturacion where uf_cifnif='B05345368'");
	
	$idpromocion=$datos_taller['ta_idpromo'];
	$durpromo=$datos_taller['ta_durpromo'];
	$tipo_promo=fetch_array('select pr_tipo from promociones where pr_idpromocion='.$idpromocion.'','pr_tipo');
	
	if($tipo_promo==1&&$durpromo>0){//es una suscripción activa
		$anho=date('Y');
		$trimestre=dame_trimestre(date('m'));
		$dia=date('d');
		
		$meses=1;
		
		$dia<16?$meses--:'';//Si es antes del día 16 se factura el mes en curso, si no se factura a partir del siguiente
	
		$mes_venc=suma_mes(date('m'), $meses);//Calculamos el mes de vencimiento
		$anho_venc=$mes_venc<=date('m')?$anho+1:$anho;//Calculamos el año de vencimiento
		$ult_dia=dias_mes($mes_venc, $anho_venc);//Obtenemos el último día del mes de vencimiento
		
		$vencimiento=$anho_venc.'-'.conceros($mes_venc,2).'-'.$ult_dia.' 23:59:59';
		
		$fpago=0;
		query('update talleres set ta_durpromo=ta_durpromo-1 where ta_idtaller='.$idtaller.'');
		query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
	}
	else{//alta sin promocion o con obsequio
		$tipoiva=$datos_fac['uf_tipoiva'];
		
		$retiene=$datos_fac['uf_retiene'];
		
		$anho=date('Y');
		$trimestre=dame_trimestre(date('m'));
		$dia=date('d');
		$hoy=date('Y-m-d H:i:s');
		
		$meses=3;
		switch($datos[3]){
			case '1':
				$meses=1;
				$conc='mensual';
				break;
			case '2':
				$meses=3;
				$conc='trimestral';
				break;
			case '3':
				$meses=6;
				$conc='semestral';
				break;
			case '4':
				$meses=12;
				$conc='anual';
				break;
		}
		
		$dia<16?$meses--:'';//Si es antes del día 16 se factura el mes en curso, si no se factura a partir del siguiente
	
		$mes_venc=suma_mes(date('m'), $meses);//Calculamos el mes de vencimiento
		$anho_venc=$mes_venc<=date('m')?$anho+1:$anho;//Calculamos el año de vencimiento
		$ult_dia=dias_mes($mes_venc, $anho_venc);//Obtenemos el último día del mes de vencimiento
		
		$vencimiento=$anho_venc.'-'.conceros($mes_venc,2).'-'.$ult_dia.' 23:59:59';
	
		$base=$datos[4];
		$total=number_format($base*1.21,2);
		$observaciones='';
		
		$nfactura=dame_num_fra($anho);
		
		if(!query('insert into facturas (nfactura, idcli, fecha_emision, fecha_vencimiento, anho_factura, trimestre_factura, forma_pago, base_imponible, tipo_iva, retiene, importe, emisor_nombre, emisor_cif, emisor_direccion, emisor_cp, emisor_poblacion, emisor_provincia, emisor_idpais, emisor_correo, emisor_telefono, cliente_nombre, cliente_cif, cliente_contacto, cliente_direccion, cliente_cp, cliente_poblacion, cliente_provincia, cliente_idpais, cliente_correo, cliente_telefono, observaciones) values ('.$nfactura.', '.$idtaller.', "'.$hoy.'", "'.$vencimiento.'", '.$anho.', '.$trimestre.', "'.$fpago.'", '.$base.', '.$tipoiva.', '.$retiene.', '.$total.', "'.$datos_emisor['uf_denomsoc'].'", "'.$datos_emisor['uf_cifnif'].'", "'.$datos_emisor['uf_direccion'].'", "'.$datos_emisor['uf_cp'].'", "'.$datos_emisor['uf_localidad'].'", "'.$datos_emisor['uf_provincia'].'", "'.$datos_emisor['uf_pais'].'", "'.$datos_emisor['uf_email'].'", "'.$datos_emisor['uf_telefono1'].'", "'.$datos_fac['uf_denomsoc'].'", "'.$datos_fac['uf_cifnif'].'", "'.$datos_fac['uf_contacto'].'", "'.$datos_fac['uf_direccion'].'", "'.$datos_fac['uf_cp'].'", "'.$datos_fac['uf_localidad'].'", "'.$datos_fac['uf_provincia'].'", "'.$datos_fac['uf_pais'].'", "'.$datos_fac['uf_email'].'", "'.$datos_fac['uf_telefono1'].'", "'.$observaciones.'")')){
			$hay_errores=1;
			$mensaje_error='Han ocurrido errores al generar la factura; por favor, contacte con nosotros.';
		}
		else{
			$idfactura=insertado();
			//GUARDAMOS LINEAS DE FACTURA
			$ref=fetch_array('select tc_ref from tipos_contrato where tc_idtipo='.$datos[2].'','tc_ref');
			$conc=u8_('Cuota '.$conc.' Assistec Online');
			$cant=1;
			$preu=$base;
			$dto=0;
			$imp=$cant*$preu;
			if($cant!=0&&$cant!=''){
				if(!query('insert into facturas_linea (fl_idfactura, fl_referencia, fl_concepto, fl_preciou, fl_dto, fl_cantidad, fl_importe) values ("'.$idfactura.'", "'.$ref.'", "'.$conc.'", "'.$preu.'", "'.$dto.'", "'.$cant.'", "'.$imp.'")')){
					$hay_errores=1;
					$mensaje_error='Han ocurrido errores al generar la factura; por favor, contacte con nosotros.';
				}
			}
		}
		if($hay_errores==1){
			query('delete from facturas where idfactura='.$idfactura.'');
			query('delete from facturas_linea where fl_idfactura='.$idfactura.'');
		}
	}
}

?>