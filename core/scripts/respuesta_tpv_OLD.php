<?php
$timestamp = $_POST['TIMESTAMP'];
$result = $_POST['RESULT'];//00=realizada, cualquier otro valor=error
$orderid = $_POST['ORDER_ID'];//idfactura-nfactura
$message = $_POST['MESSAGE'];//Mensaje en caso de error
$authcode = $_POST['AUTHCODE'];//C�digo de autorizaci�n
$pasref = $_POST['PASREF'];//Referencia de transacci�n
$realexsha1 = $_POST['SHA1HASH'];//Firma

// -------------------------------------------------------------
//  Reemplaza esto con los valores que recibi� de TPV Virtual de Santander Elavon.
//  Si no tienes estos valores por favor contacta con TPV Virtual de Santander Elavon.
$merchantid = "assistec";
$secret = "KbmJ22xLl8";

//---------------------------------------------------------------
// A continuaci�n se muestra el c�digo para crear la firma digital usando
// el algoritmo SHA1. Esta firma digital deber�a corresponderse con la devuelta 
// mediante POST por el TPV Virtual de Santander Elavon a este script y poder as� 
// ser usada para verificar el mensaje que el TPV Virtual de Santander Elavon env�a 
// de vuelta.

$tmp = "$timestamp.$merchantid.$orderid.$result.$message.$pasref.$authcode";
$sha1hash = sha1($tmp);
$tmp = "$sha1hash.$secret";
$sha1hash = sha1($tmp);

//Comprueba si las firmas coinciden o no
if ($sha1hash != $realexsha1) {
	$hay_errores=1;
	$mensaje_error='Las firmas no coinciden!';
}
else{
	$datos_fac=explode('-', $orderid);
	$nfactura=$datos_fac[0];
	$idfactura=$datos_fac[1];
	$idtaller=fetch_array('select idcli from facturas where idfactura='.$idfactura.'','idcli');
	if ($result == "00") {//Transacci�n realizada
		query('update facturas set estado=1, fecha_pago="'.date('Y-m-d H:i:s').'", cod_aut="'.$authcode.'", tpv_ref="'.$pasref.'" where idfactura='.$idfactura.'');
		$vencimiento=fetch_array('select fecha_vencimiento from facturas where idfactura='.$idfactura.'','fecha_vencimiento');
		$tipo_taller=fetch_array('select ta_idtipo from talleres where ta_idtaller='.$idtaller.'','ta_idtipo');
		query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
		$tipo_taller==2?query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idparent='.$idtaller.''):'';
	}//Transacci�n realizada
	else{//Transacci�n fallida
		$hay_errores=1;
		$mensaje_error='Error al realizar la transacci&oacute;n.<br>C&oacute;d. error: '.$result.' - '.$message.'.';
		query('update facturas set tpv_msg="'.$message.'" where idfactura='.$idfactura.'');
	}//Transacci�n fallida
}

/* --------------------------------------------------------------
 Env�a un email a ti mismo o al cliente o actualiza la base de datos o cualquier 
 otra cosa que necesites hacer aqu�.
 
 La siguiente parte es importante que sea entendida correctamente. El campo

 resultado enviado de vuelta a este script indicar� si la transacci�n
 con tarjeta se realiz� correctamente o no.
 El c�digo de respuesta 00 indica que s� y cualquier otra respuesta indica 
 un fallo. Consulta la documentaci�n del TPV Virtual de Santander Elavon 
 para obtener una lista completa de c�digos de respuesta.

 Este es el caso en el el que desde la perspectiva del cliente, �ste no se 
 encuentra de repente fuera de un sitio seguro en uno no seguro. Esto quiere 
 decir que a pesar de que TPV Virtual de Santander Elavon llama a este script 
 de respuesta, el cliente se encuentra aun dentro del TPV Virtual de Santander 
 Elavon y por tanto es recomendable que se imprima un v�nculo HTML para 
 redirigir al cliente de vuelta al sitio del comerciante.
*/

?>
