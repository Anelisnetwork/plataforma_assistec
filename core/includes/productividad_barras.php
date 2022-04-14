<?php
require_once('../core.php');

	function barras($chart){
		header('content-type: image/png');
  		$url = 'https://chart.googleapis.com/chart';
		$context = stream_context_create(
		array('http' => array(
		  'method' => 'POST',
		  'content' => http_build_query($chart))));
		  
	    fpassthru(fopen($url, 'r', false, $context));
	}
 // Create some random text-encoded data for a line chart.
  $chd = 't:';
  for ($i = 0; $i < 5; ++$i) {
    $data = rand(0, 100000);
    $chd .= $data . ',';
  }
  $chd = substr($chd, 0, -1);

  // Add data, chart type, chart size, and scale to params.
  $chart = array(
    'cht' => 'bvg',//bvs=columnas, bvg=columnas agrupadas, lc=linear, p=quesitos
    'chs' => '300x200',
    'chds' => '0,100000',//escala (opcional)
	'chbh' => 'a,5,15',
    'chd' => $chd);
	//chco=FFC6A5|FFFF42|DEF3BD|00A5C6|DEBDDE -> array de colores para cada serie

  
  barras($chart);
?>

