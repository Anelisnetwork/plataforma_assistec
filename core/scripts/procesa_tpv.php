<?php

include('core/clases/apiRedsys.php');



	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	////////////								  REAL								  ////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
$url = 'https://sis.redsys.es/sis/realizarPago';
$urlnot='http://www.plataforma.assistec.es/proceso_de_pago/';
$urlsi='http://www.plataforma.assistec.es/pago_realizado/'.en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idtaller.'').'/';
$urlno='http://www.plataforma.assistec.es/error_pago/'.en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idtaller.'').'/';
$clave='JpDBLiqEKtmPkG9rw9b8xVVo09zLtD/b';
$code = '031022312';
	//////////////////////////////////////////////////////////////////////////////////////////////
	////////////								  REAL								  ////////////
	//////////////////////////////////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	////////////								PRUEBAS								  ////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
/*
$url = 'https://sis-t.redsys.es:25443/sis/realizarPago';
$urlnot='http://www.plataforma.assistec.es/proceso_de_pago_test/assistech_test/';
$urlsi='http://www.plataforma.assistec.es/pago_realizado/'.en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idcli.'').'/';
$urlno='http://www.plataforma.assistec.es/error_pago/'.en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idcli.'').'/';
$clave='sq7HjrUOBfKmC576ILgskD5srU870gJ7';
$code = '031022312';
*/
	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	////////////								PRUEBAS								  ////////////
	//////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////


$Terminal='001';
$currency = '978';
$transactionType='0';//0=Autorización, O=Autorización en diferido, P=Confirma autor. dif., Q=Anula autor. dif. 
$Language='001';
$ProductDescription='Cuota servicio Assistec';
$Name='Assistec';

$importe = $total*100;


$miObj=new RedsysAPI;

$miObj->setParameter('DS_MERCHANT_MERCHANTCODE', $code);
$miObj->setParameter('DS_MERCHANT_TERMINAL', $Terminal);
$miObj->setParameter('DS_MERCHANT_TRANSACTIONTYPE', $transactionType);
$miObj->setParameter('DS_MERCHANT_AMOUNT', $importe);
$miObj->setParameter('DS_MERCHANT_CURRENCY', $currency);
$miObj->setParameter('DS_MERCHANT_ORDER', conceros($idfactura, 12));
$miObj->setParameter('DS_MERCHANT_MERCHANTURL', $urlnot);
$miObj->setParameter('DS_MERCHANT_URLOK', $urlsi);
$miObj->setParameter('DS_MERCHANT_URLKO', $urlno);



$miObj->setParameter('DS_MERCHANT_CONSUMERLANGUAGE', $Language);
$miObj->setParameter('DS_MERCHANT_MERCHANTNAME', $Name);
$miObj->setParameter('DS_MERCHANT_PRODUCTDESCRIPTION', $ProductDescription);


$params=$miObj->createMerchantParameters();

$signature=$miObj->createMerchantSignature($clave);

/*
$merchantid = "031022312";
$secret = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";

$orderid = conceros($idfactura,12);

$curr = "978";
$amount = $total*100;

$trans_type=0;

$url_comercio='http://www.plataforma.assistec.es/proceso_de_pago_test/assistech_test/';

$firma=sha1($amount.$orderid.$merchantid.$curr.$trans_type.$url_comercio.$secret);
*/
?>
<script>
$(document).ready(function() {
	//setTimeout('$("#pago_tpv" ).submit()',3000);
});
</script>

<form action="<?=$url?>" id="pago_tpv" name="pago_tpv" method=post>
	<input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
    <input type="hidden" name="Ds_MerchantParameters" value="<?=$params?>" />
    <input type="hidden" name="Ds_Signature" value="<?=$signature?>" />
</form>

    <div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
        <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
        Ser&aacute; redirigido a un servidor seguro para realizar el pago; si el navegador no le redirige autom&aacute;ticamente en 10 segundos, pulse el bot&oacute;n de abajo.
        <br /><br /><br /><br /><br /><br />
        <input form="pago_tpv" type=submit value="Ir a un servidor seguro" class=" indent redondo link" style="width:300px; background-color:#EF7F1F; color:#FFF">
    </div>