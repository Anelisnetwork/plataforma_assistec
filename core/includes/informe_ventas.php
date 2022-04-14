<?php
if(isset($_POST['st_ventas'])){
	$anho=clean_post('st_ventas');
}
else{
	fuera_de_aqui();
	exit();
}

$titulo='Informe_importes_facturados';

titulo_hoja($titulo);

$ventas=list_object('select da_mes, da_facturadomo, da_facturadorec, da_facturadootros from datos_actividad where da_ano='.$anho.' and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_mes asc');

$nventas=count($ventas);

if($nventas==0){//No hay ventas
	fuera_de_aqui();
	exit();
}

$cell++;
valor_celda($col.$cell,'Facturado MO');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Facturado REC');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Facturado OTROS');negrita($col.$cell);$cell++;
$cell='1';
$col++;
	
foreach($ventas as $key=>$venta){
	$key==0?$primcol=$col:'';
	$key==$nventas-1?$ultcol=$col:'';
	valor_celda($col.$cell,nom_mes($venta->da_mes).' '.$anho);
	negrita($col.$cell);
	centrado($col.$cell);$cell++;
	valor_celda($col.$cell,moneda($venta->da_facturadomo,2));f_euro($col.$cell);$cell_facmo=$cell;$cell++;
	valor_celda($col.$cell,moneda($venta->da_facturadorec,2));f_euro($col.$cell);$cell_facrec=$cell;$cell++;
	valor_celda($col.$cell,moneda($venta->da_facturadootros,2));f_euro($col.$cell);$cell_facotros=$cell;$cell++;
	valor_celda($col.$cell,'=SUM('.$col.$cell_facmo.':'.$col.$cell_facotros.')');f_euro($col.$cell);
	negrita($col.$cell);
	$cell='1';
	$col++;
}

valor_celda($col.$cell,'Total año');negrita($col.$cell);centrado($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);

$colfinal=$col;

ancho_auto('A',$colfinal);
?>