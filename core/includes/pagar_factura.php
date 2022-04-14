<?php

if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$datos[2].'')!=1||num_rows('select idfactura from facturas where idfactura='.$datos[1].' and idcli='.$datos[2].' and importe='.$datos[3].'')!=1){
	$hay_errores=1;
	$mensaje_error='Error en datos.';
}
else{
	$idfactura=$datos[1];
	$idcli=$datos[2];
	$importe=$datos[3];
	$nfactura=fetch_array('select nfactura from facturas where idfactura='.$idfactura.'','nfactura');
	$total=fetch_array('select importe from facturas where idfactura='.$idfactura.'','importe');
}
?>