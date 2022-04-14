<?php
if(isset($_POST['st_productividad'])){
	$anho=clean_post('st_productividad');
}
else{
	fuera_de_aqui();
	exit();
}

$titulo='Informe_productividad';

titulo_hoja($titulo);

$datos=list_object('select da_ano, da_mes, da_iddato, da_horasfichadasor, da_facturadomo, da_impmo from datos_actividad where da_ano='.$anho.' and da_idtaller='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'].' order by da_mes asc');

$ndatos=count($datos);

if($ndatos==0){//No hay datos
	fuera_de_aqui();
	exit();
}

$cell++;
valor_celda($col.$cell,'Horas fichadas OR');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Horas presencia');negrita($col.$cell);$cell++;
valor_celda($col.$cell,'Productividad');negrita($col.$cell);
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
	valor_celda($col.$cell,$dato->da_horasfichadasor);no_dec($col.$cell);$cellhfic=$cell;$cell++;
	valor_celda($col.$cell,horas_presencia($dato->da_iddato));$cellhpre=$cell;$cell++;
	valor_celda($col.$cell,'='.$col.$cellhfic.'/'.$col.$cellhpre.'');f_percent($col.$cell);
	negrita($col.$cell);
	$cell='1';
	$col++;
}

valor_celda($col.$cell,'Total año');negrita($col.$cell);centrado($col.$cell);$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);no_dec($col.$cell);$cellhfic=$cell;$cell++;
valor_celda($col.$cell,'=SUM('.$primcol.$cell.':'.$ultcol.$cell.')');negrita($col.$cell);$cellhpre=$cell;$cell++;
valor_celda($col.$cell,'='.$col.$cellhfic.'/'.$col.$cellhpre.'');f_percent($col.$cell);
negrita($col.$cell);

$colfinal=$col;

ancho_auto('A',$colfinal);
?>