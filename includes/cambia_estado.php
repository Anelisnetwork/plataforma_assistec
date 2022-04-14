<?php
$estado=clean_post('estado');
$idfactura=clean_post('idfactura');

if($estado==0){//Marcamos como pendiente
	$fpago=fetch_array('select forma_pago from facturas where idfactura='.$idfactura.'','forma_pago');
	if($fpago<3||$fpago>8){//Forma de pago distinta de Giro
		$idtaller=fetch_array('select idcli from facturas where idfactura='.$idfactura.'','idcli');
		$venc_ta=dato_taller('ta_vencimiento', $idtaller);
		$venc_fa=fetch_array('select fecha_vencimiento from facturas where idfactura='.$idfactura.'','fecha_vencimiento');
		$n_venc_fa=fetch_array('select fecha_vencimiento from facturas where idcli='.$idtaller.' and fecha_vencimiento<"'.$venc_fa.'" and estado=1 order by fecha_vencimiento desc limit 0,1','fecha_vencimiento');
		$tipo_taller=dato_taller('ta_idtipo', $idtaller);
		if($venc_ta==$venc_fa){
			$n_venc_fa==''||$n_venc_fa==NULL?$n_venc_fa='2016-01-01 00:00:00':'';
			query('update talleres set ta_vencimiento="'.$n_venc_fa.'" where ta_idtaller='.$idtaller.'');
			$tipo_taller==2?query('update talleres set ta_vencimiento="'.$n_venc_fa.'" where ta_idparent='.$idtaller.''):'';
		}
	}
}
else if($estado==1){//factura pagada
	$idtaller=fetch_array('select idcli from facturas where idfactura='.$idfactura.'','idcli');
	$venc_ta=dato_taller('ta_vencimiento', $idtaller);
	$venc_fa=fetch_array('select fecha_vencimiento from facturas where idfactura='.$idfactura.'','fecha_vencimiento');
	$tipo_taller=dato_taller('ta_idtipo', $idtaller);
	if($venc_ta<$venc_fa){
		query('update talleres set ta_vencimiento="'.$venc_fa.'" where ta_idtaller='.$idtaller.'');
		$tipo_taller==2?query('update talleres set ta_vencimiento="'.$venc_fa.'" where ta_idparent='.$idtaller.''):'';
	}
}
else{
}

query('update facturas set estado='.$estado.' where idfactura='.$idfactura.'');

include ('f_est_'.$estado.'.php');
?>