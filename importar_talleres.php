<?php
header('Content-Type: text/html; charset=UTF-8');
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");
setlocale(LC_ALL,"es_ES.UTF-8");
date_default_timezone_set('Europe/Madrid');

ini_set('display_errors', '1'); 
error_reporting(E_ALL|E_STRICT);

include('core/core.php');
open_bd();

$fp = fopen ( "talleres_spg.csv" , "r" ); 
$c=0;

while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...
$c++;
	$i = 0; 
	foreach($data as $row) {
		if ( $i == 0 ) {
			$parent = iconv( "Windows-1252", "UTF-8", $row );	
		}
		else if ( $i == 1 ) {
			$nick = iconv( "Windows-1252", "UTF-8", $row );	
		}
		else if ( $i == 2 ) {
			$correo = strtolower(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 3 ) {
			$pass = secure_md5(strtolower(iconv( "Windows-1252", "UTF-8", $row )));	
		}
		else if ( $i == 4 ) {
			$razsoc = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 5 ) {
			$cif = limpia_nifcif(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 6 ) {
			$nomcom = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 7 ) {
			$contacto = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 8 ) {
			$tlf1 = limpia_tlf(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 9 ) {
			$tlf2 = limpia_tlf(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 10 ) {
			$direccion = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 11 ) {
			$cp = iconv( "Windows-1252", "UTF-8", $row );	
		}
		else if ( $i == 12 ) {
			$localidad = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 13 ) {
			$provincia = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 14 ) {
			$modulo = iconv( "Windows-1252", "UTF-8", $row );	
		}
		else if ( $i == 15 ) {
			$abono = iconv( "Windows-1252", "UTF-8", $row );	
		}
		else if ( $i == 16 ) {
			$activo = iconv( "Windows-1252", "UTF-8", $row );	
		}
		else if ( $i == 17 ) {
			$socio = u8_(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		else if ( $i == 18 ) {
			$mailfac = strtolower(iconv( "Windows-1252", "UTF-8", $row ));	
		}
		$i++;
	}
		
	$fecha_alta=fetch_array('select us_fecha_alta from usuarios where us_idtaller='.$parent.'','us_fecha_alta');
	$fecha_alta==''||$fecha_alta==NULL?$fecha_alta=date('Y-m-d H:i:s'):'';
	
	$fecha_venc=fetch_array('select ta_vencimiento from talleres where ta_idtaller='.$parent.'','ta_vencimiento');
	$fecha_venc==''||$fecha_venc==NULL?$fecha_venc=date('Y-m-d').' 00:00:00':'';
	
	
	query('insert into talleres (ta_idtipo, ta_idparent, ta_nombre, ta_contacto, ta_telefono1, ta_email, ta_direccion, ta_cp, ta_localidad, ta_provincia, ta_contrato, ta_abono, ta_vencimiento, ta_socio) values (1, '.$parent.', "'.$nomcom.'", "'.$contacto.'", "'.$tlf1.'", "'.$correo.'", "'.$direccion.'", "'.$cp.'", "'.$localidad.'", "'.$provincia.'", '.$modulo.', '.$abono.', "'.$fecha_venc.'", "'.$socio.'")');
	$nuevotaller=insertado();
	
	query('insert into usuarios_facturacion (uf_idtaller, uf_denomsoc, uf_cifnif, uf_nomcom, uf_contacto, uf_telefono1, uf_email, uf_direccion, uf_cp, uf_localidad, uf_provincia) values ('.$nuevotaller.', "'.$razsoc.'", "'.$cif.'", "'.$nomcom.'", "'.$contacto.'", "'.$tlf1.'", "'.$mailfac.'", "'.$direccion.'", "'.$cp.'", "'.$localidad.'", "'.$provincia.'")');
	$nuevadirfac=insertado();
	
	query('update talleres set ta_iddirfac='.$nuevadirfac.' where ta_idtaller='.$nuevotaller.'' );
	query('INSERT into info_taller (it_idtaller) VALUES ("'.$nuevotaller.'")');
	query('INSERT into datos_actividad (da_mes, da_idtaller, da_idtipo) VALUES (1, "'.$nuevotaller.'", 0)');

    $token_silent=encriptar($correo.'%%'.$pass);
	query('INSERT into usuarios (us_idtaller, us_correo, us_pass, us_fecha_alta, us_estado, us_accesosilent) VALUES ("'.$nuevotaller.'", "'.$correo.'", "'.$pass.'", "'.$fecha_alta.'", "'.$activo.'", "'.$token_silent.'")');
	
	echo '<br/>';
	
	/* FIN CONSULTA UPDATE */
} 
fclose ( $fp ); 

?>