<?php
$fact=number_format($hfacturadas,0,'.','');
$nofact=number_format($datos['da_horasfichadasor']-$fact,0,'.','');

$tope=dame_max_stat(array($fact,$nofact));

$valores=array($fact,$nofact);
$chd='t:'.implode(',',$valores).'';

// Add data, chart type, chart size, and scale to params.
$chart = array(
'cht' => 'bhs',//bvs=columnas, bvg=columnas agrupadas, lc=linear, p=quesitos
'chm' => 'N*f0,555555,0,-1,11,,r:-15:0',
'chs' => '300x200',
'chds' => '0,'.$tope.'',//escala (opcional)
'chbh' => 'r,1,1',
'chco' => '00FF00|FF0000',
'chdl' => 'Facturadas|Perdidas',
'chdlp' => 'b|l',
'chxt' => 'x',
'chxr' => '0,0,'.$tope.'',
'chma' => '0,0,0,0',
'chd' => $chd);
//chco=FFC6A5|FFFF42|DEF3BD|00A5C6|DEBDDE -> array de colores para cada serie

grafica($chart,'rendimiento_'.$idtaller.'_'.$idmes.'_'.$idano);
?>

