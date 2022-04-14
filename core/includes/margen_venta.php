<?php
$est=number_format($ventasobj-$costepr,0,'.','');
$benef=number_format($ventapr-$costepr,0,'.','');
$noing=number_format($est-$benef,0,'.','');

$tope=dame_max_stat(array($est,$noing,$benef));

$valores=array($est,$noing,$benef);
$chd='t:'.implode(',',$valores).'';

// Add data, chart type, chart size, and scale to params.
$chart = array(
'cht' => 'bvs',//bvs=columnas, bvg=columnas agrupadas, lc=linear, p=quesitos
'chm' => 'N*f2,333333,0,-1,11,,e::-15',
'chs' => '300x200',
'chds' => '0,'.$tope.'',//escala (opcional)
'chbh' => 'r,1,1',
'chco' => '0000FF|FF0000|00FF00',
'chdl' => 'Estimado|No ingresado|Beneficio',
'chdlp' => 'b|l',
'chxt' => 'y',
'chxr' => '0,0,'.$tope.'',
'chma' => '0,0,0,0',
'chd' => $chd);
//chco=FFC6A5|FFFF42|DEF3BD|00A5C6|DEBDDE -> array de colores para cada serie

  
grafica($chart,'margenventa_'.$idtaller.'_'.$idmes.'_'.$idano);
?>

