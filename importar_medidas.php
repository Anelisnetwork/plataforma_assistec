<?php
date_default_timezone_set('Europe/Madrid');

ini_set('display_errors', '1'); 
error_reporting(E_ALL|E_STRICT);

include('core/core.php');
open_bd();

query('truncate table medidas');

$fp = fopen ( "medidas_at.csv" , "r" ); 
$c=0;

while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...
$c++;
	$i = 0; 
	foreach($data as $row) {
		if ( $i == 0 ) {
			$idmedida = $row;	
		}
		else if ( $i == 1 ) {
			$nom_medida = utf8_encode($row);	
		}
		$i++;
	}
		if (query('INSERT INTO  medidas (m_idcorto, m_nombre) VALUES ("'.$idmedida.'",  "'.$nom_medida.'")')){
			echo 'Guardada medida '.$idmedida.' - '.$nom_medida;
		}
		else {echo 'Error en medida '.$idmedida.' - '.$nom_medida;}
	echo '<br/>';
	
	/* FIN CONSULTA UPDATE */
} 
fclose ( $fp ); 
close_bd();
?>