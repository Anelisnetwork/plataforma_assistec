<?php
include_once('core/clases/apiRedsys.php');


if (!isset($_POST['Ds_SignatureVersion'])&&!isset($_POST['Ds_MerchantParameters'])&&!isset($_POST['Ds_Signature'])) {exit();}

$miObj=new RedsysAPI;

$version=$_POST['Ds_SignatureVersion'];
$params=$_POST['Ds_MerchantParameters'];
$signatureRecibida=$_POST['Ds_Signature'];

$decodec=$miObj->decodeMerchantParameters($params);
$miObj->stringToArray($decodec);

//$decodec=json_decode($params);

$codigoRespuesta=$miObj->getParameter('Ds_Response');

$cod_verifica=$miObj->getParameter('Ds_AuthorisationCode');

$idfactura=ltrim($miObj->getParameter('Ds_Order'),'0');


//REAL
$clave='JpDBLiqEKtmPkG9rw9b8xVVo09zLtD/b';//LOWCOST
//REAL


	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	////////////								PRUEBAS								  ////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////

//$clave='sq7HjrUOBfKmC576ILgskD5srU870gJ7';//PRUEBAS

	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	////////////								PRUEBAS								  ////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////


$signatureCalculada=$miObj->createMerchantSignatureNotif($clave,$params);

if($signatureCalculada===$signatureRecibida){}
else{
	exit();
}

$datos_fac=fetch_array('select * from facturas where idfactura='.$idfactura.'');

if($datos_fac==''||$datos_fac==NULL){//No existe la factura
	$hay_errores=1;
	$mensaje_error='No existe el ID de referencia';
	exit;
}

if ($codigoRespuesta>=0 && $codigoRespuesta<=99) {//PAGO REALIZADO 
	$nfactura=$datos_fac['nfactura'];
	$idtaller=$datos_fac['idcli'];

	query('update facturas set estado=1, fecha_pago="'.date('Y-m-d H:i:s').'", cod_aut="'.$cod_verifica.'", tpv_msg="Pago realizado" where idfactura='.$idfactura.'');
	//echo 'update facturas set estado=1, fecha_pago="'.date('Y-m-d H:i:s').'", cod_aut="'.$authcode.'", tpv_msg="Pago realizado"  where idfactura='.$idfactura.'<br><br>';
	$vencimiento=fetch_array('select fecha_vencimiento from facturas where idfactura='.$idfactura.'','fecha_vencimiento');
	$tipo_taller=fetch_array('select ta_idtipo from talleres where ta_idtaller='.$idtaller.'','ta_idtipo');
	query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
	//echo 'update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'<br><br>';
	$tipo_taller==2?query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idparent='.$idtaller.''):'';
}
else{
	$error_pago=dame_error_redsys($codigoRespuesta);
	$hay_errores=1;
	$mensaje_error='Error al realizar la transacci&oacute;n.<br>C&oacute;d. error: '.$codigoRespuesta.' - '.$error_pago.'.';
	query('update facturas set tpv_msg="'.$error_pago.'" where idfactura='.$idfactura.'');
}


/*
$result = $_POST['Ds_Response'];//00=realizada, cualquier otro valor=error
$orderid = $_POST['Ds_Order'];//idfactura-nfactura
$authcode = $_POST['Ds_AuthorisationCode'];//C�digo de autorizaci�n
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
		if ($result<100) {//Transacci�n realizada
			//query('update facturas set estado=1, fecha_pago="'.date('Y-m-d H:i:s').'", cod_aut="'.$authcode.'" where idfactura='.$idfactura.'');
			echo 'update facturas set estado=1, fecha_pago="'.date('Y-m-d H:i:s').'", cod_aut="'.$authcode.'" where idfactura='.$idfactura.'<br><br>';
			$vencimiento=fetch_array('select fecha_vencimiento from facturas where idfactura='.$idfactura.'','fecha_vencimiento');
			$tipo_taller=fetch_array('select ta_idtipo from talleres where ta_idtaller='.$idtaller.'','ta_idtipo');
			//query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
			echo 'update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'<br><br>';
			//$tipo_taller==2?query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idparent='.$idtaller.''):'';
		}//Transacci�n realizada
		else{//Transacci�n fallida
			$hay_errores=1;
			$mensaje_error='Error al realizar la transacci&oacute;n.<br>C&oacute;d. error: '.$result.'.';
			//query('update facturas set tpv_msg="'.$result.'" where idfactura='.$idfactura.'');
		}//Transacci�n fallida
	}
}
*/
?>
