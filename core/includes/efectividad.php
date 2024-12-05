<?php
/**
 * @var $hfacturadas
 * @var $hpresencia
 * @var $idtaller
 * @var $idmes
 * @var $idano
 */
$fact=number_format($hfacturadas,0,'.','');
$pres=number_format($hpresencia,0,'.','');
$dif=number_format($pres-$fact,0,'.','');

$tope=dame_max_stat(array($fact,$pres,$dif));

$valores=array($pres,$dif,$fact);
$chd='t:'.implode(',',$valores).'';

//echo $tope;exit();

// Add data, chart type, chart size, and scale to params.
$chart = array(
'cht' => 'bvs',//bvs=columnas, bvg=columnas agrupadas, lc=linear, p=quesitos
'chm' => 'N*f0,555555,0,-1,11,,e::-15',
'chs' => '300x200',
'chds' => '0,'.$tope.'',//escala (opcional)
'chbh' => 'r,1,1',
'chco' => '0000FF|FF0000|00FF00',
'chdl' => 'Presencia|No cobradas|Cobradas',
'chdlp' => 'b|l',
'chxt' => 'y',
'chxr' => '0,0,'.$tope.'',
'chma' => '0,0,0,0',
'chd' => $chd);
//chco=FFC6A5|FFFF42|DEF3BD|00A5C6|DEBDDE -> array de colores para cada serie

  
grafica($chart,'efectividad_'.$idtaller.'_'.$idmes.'_'.$idano);

?>

