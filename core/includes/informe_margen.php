<?php
if(isset($_POST['st_margen'])){
	$anho=clean_post('st_margen');
}
else{
	fuera_de_aqui();
	exit();
}

$titulo='Informe_margen_REC';

titulo_hoja($titulo);

$ventas=list_object('select da_mes, da_facturadorec, da_pagadoprovrec from datos_actividad where da_ano='.$anho.' and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_mes asc');

$nventas=count($ventas);

if($nventas==0){//No hay ventas
	fuera_de_aqui();
	exit();
}

$cell++;
valor_celda($col.$cell,'Facturado REC');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Pagado REC');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Margen');negrita($col.$cell);
$cell='1';
$col++;

$sumafac=0;
$sumapag=0;

foreach($ventas as $key=>$venta){
	$key==0?$primcol=$col:'';
	$key==$nventas-1?$ultcol=$col:'';
	valor_celda($col.$cell,nom_mes($venta->da_mes).' '.$anho);
	negrita($col.$cell);
	centrado($col.$cell);$cell++;
	valor_celda($col.$cell,moneda($venta->da_facturadorec,2));f_euro($col.$cell);$cellfac=$cell;$cell++;
	valor_celda($col.$cell,moneda($venta->da_pagadoprovrec,2));f_euro($col.$cell);$cellpag=$cell;$cell++;
	valor_celda($col.$cell,'=(('.$col.$cellfac.'-'.$col.$cellpag.')/'.$col.$cellpag.')');f_percent($col.$cell);
	negrita($col.$cell);
	$cell='1';
	$col++;
}

valor_celda($col.$cell,'Total año');negrita($col.$cell);centrado($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);$cellfac=$cell;$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);$cellpag=$cell;$cell++;
valor_celda($col.$cell,'=(('.$col.$cellfac.'-'.$col.$cellpag.')/'.$col.$cellpag.')');f_percent($col.$cell);
negrita($col.$cell);

$colfinal=$col;

ancho_auto('A',$colfinal);
?>