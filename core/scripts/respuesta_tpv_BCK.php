<?
$result = $_POST['Ds_Response'];//00=realizada, cualquier otro valor=error
$orderid = $_POST['Ds_Order'];//idfactura-nfactura
$authcode = $_POST['Ds_AuthorisationCode'];//Código de autorización
$realexsha1 = $_POST['Ds_Signature'];//Firma

$merchantid = "031022312";
$secret = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";

$curr = "978";

$datos_fac=fetch_array('select * from facturas where idfactura='.$orderid.'');

if($datos_fac==''||$datos_fac==NULL){//No existe la factura
	$hay_errores=1;
	$mensaje_error='No existe el ID de referencia';
}
else{
	$importe=$datos_fac['importe']*100;
	
	$firma=sha1($importe+$orderid+$merchantid+$curr+$result+$secret);
	
	//Comprueba si las firmas coinciden o no
	if ($firma != $realexsha1) {
		$hay_errores=1;
		$mensaje_error='Las firmas no coinciden!';
	}
	else{
		//$datos_fac=explode('-', $orderid);
		$nfactura=$datos_fac['nfactura'];
		$idfactura=$datos_fac['idfactura'];
		$idtaller=$datos_fac['idcli'];
		if ($result<100) {//Transacción realizada
			query('update facturas set estado=1, fecha_pago="'.date('Y-m-d H:i:s').'", cod_aut="'.$authcode.'" where idfactura='.$idfactura.'');
			$vencimiento=fetch_array('select fecha_vencimiento from facturas where idfactura='.$idfactura.'','fecha_vencimiento');
			$tipo_taller=fetch_array('select ta_idtipo from talleres where ta_idtaller='.$idtaller.'','ta_idtipo');
			query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
			$tipo_taller==2?query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idparent='.$idtaller.''):'';
		}//Transacción realizada
		else{//Transacción fallida
			$hay_errores=1;
			$mensaje_error='Error al realizar la transacci&oacute;n.<br>C&oacute;d. error: '.$result.'.';
			query('update facturas set tpv_msg="'.$result.'" where idfactura='.$idfactura.'');
		}//Transacción fallida
	}
}
?>
