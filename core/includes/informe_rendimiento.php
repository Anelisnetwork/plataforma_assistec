<?php
if(isset($_POST['st_rendimiento'])){
	$anho=clean_post('st_rendimiento');
}
else{
	fuera_de_aqui();
	exit();
}

$titulo='Informe_rendimiento';

titulo_hoja($titulo);

$datos=list_object('select da_ano, da_mes, da_iddato, da_horasfichadasor, da_facturadomo, da_impmo from datos_actividad where da_ano='.$anho.' and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_mes asc');

$ndatos=count($datos);

if($ndatos==0){//No hay datos
	fuera_de_aqui();
	exit();
}

$cell++;
valor_celda($col.$cell,'Importe MO');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Facturado MO');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Horas facturadas');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Horas fichadas OR');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Rendimiento');negrita($col.$cell);
$cell='1';
$col++;

$sumafac=0;
$sumapag=0;

foreach($datos as $key=>$dato){
	$key==0?$primcol=$col:'';
	$key==$ndatos-1?$ultcol=$col:'';
	valor_celda($col.$cell,nom_mes($dato->da_mes).' '.$anho);
	negrita($col.$cell);
	centrado($col.$cell);$cell++;
	valor_celda($col.$cell,moneda($dato->da_impmo,2));f_euro($col.$cell);$cellimp=$cell;$cell++;
	valor_celda($col.$cell,moneda($dato->da_facturadomo,2));f_euro($col.$cell);$cellfac=$cell;$cell++;
	valor_celda($col.$cell,'=('.$col.$cellfac.'/'.$col.$cellimp.')');no_dec($col.$cell);$cellhfac=$cell;$cell++;
	valor_celda($col.$cell,$dato->da_horasfichadasor);$cellfic=$cell;$cell++;
	valor_celda($col.$cell,'='.$col.$cellhfac.'/'.$col.$cellfic.'');f_percent($col.$cell);
	negrita($col.$cell);
	$cell='1';
	$col++;
}

valor_celda($col.$cell,'Total año');negrita($col.$cell);centrado($col.$cell);$cell++;
valor_celda($col.$cell,'---');centrado($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);f_euro($col.$cell);$cellfac=$cell;$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);no_dec($col.$cell);$cellhfac=$cell;$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);$cellfic=$cell;$cell++;
valor_celda($col.$cell,'='.$col.$cellhfac.'/'.$col.$cellfic.'');f_percent($col.$cell);
negrita($col.$cell);

$colfinal=$col;

ancho_auto('A',$colfinal);
?>