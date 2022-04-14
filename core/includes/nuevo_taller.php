<?php

$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$idtaller=clean_post('idtaller');

$tipo=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['tipo_'.$idtaller]=clean_post('tipo_'.$idtaller);
$red=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['red_'.$idtaller]=clean_post('red_'.$idtaller);
$contrato=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['contrato_'.$idtaller]=clean_post('contrato_'.$idtaller);
$pago=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['pago_'.$idtaller]=clean_post('pago_'.$idtaller);
$razsoc=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['razsoc_'.$idtaller]=clean_post('razsoc_'.$idtaller);
$cif=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['cif_'.$idtaller]=clean_post('cif_'.$idtaller);
$nomcom=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['nomcom_'.$idtaller]=clean_post('nomcom_'.$idtaller);
$contacto=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['contacto_'.$idtaller]=clean_post('contacto_'.$idtaller);
$socio=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['socio_'.$idtaller]=clean_post('socio_'.$idtaller);
$telefono=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['telefono_'.$idtaller]=clean_post('telefono_'.$idtaller);
$correo=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['correo_'.$idtaller]=clean_post('correo_'.$idtaller);
$dirr=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['dirr_'.$idtaller]=clean_post('dirr_'.$idtaller);
$cp=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['cp_'.$idtaller]=clean_post('cp_'.$idtaller);
$loc=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['loc_'.$idtaller]=clean_post('loc_'.$idtaller);
$prov=$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['prov_'.$idtaller]=clean_post('prov_'.$idtaller);

$vencimiento=date('Y-m-d').' 00:00:00';

if($tipo==1){//Taller
	if($red!=0){//pertenece a una red
		$datosred=list_object('select * from talleres where ta_idtaller="'.$red.'" and ta_idtipo=2');
		if(count($datosred)==0){
			$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']=1;
			$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['mensaje']='La red seleccionada no es correcta';
		}
		else{
			if($pago==5){//abonado
				$contrato=$datosred[0]->ta_contrato;
				$vencimiento=$datosred[0]->ta_vencimiento;
			}
		}
	}
	else{//Taller independiente
		if($pago==5){//abonado
			$pago=2;//trimestral
		}
	}
}
else if($tipo==2){//Red
	$red=0;
	if($pago==5){//abonado
		$pago=2;//trimestral
	}
}
else{
	$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']=1;
}

if($razsoc==''||$cif==''||$telefono==''||$correo==''||!VerificarDireccionCorreo($correo)||$dirr==''||$cp==''||$loc==''||$prov==''){
	$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']=1;
}


if($_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']==0){
	if(!query('insert into talleres (ta_idtipo, ta_idparent, ta_nombre, ta_contacto, ta_socio, ta_telefono1, ta_email, ta_direccion, ta_cp, ta_localidad, ta_provincia, ta_contrato, ta_abono, ta_vencimiento) values ('.$tipo.', '.$red.', "'.u8_($razsoc).'", "'.u8_($contacto).'", "'.u8_($socio).'", "'.$telefono.'", "'.$correo.'", "'.u8_($dirr).'", "'.$cp.'", "'.u8_($loc).'", "'.u8_($prov).'", '.$contrato.', '.$pago.', "'.$vencimiento.'")')){
		$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']=1;
	}
	else{
		$nuevotaller=insertado();
		if(!query('insert into usuarios_facturacion (uf_idtaller, uf_denomsoc, uf_cifnif, uf_nomcom, uf_contacto, uf_telefono1, uf_email, uf_direccion, uf_cp, uf_localidad, uf_provincia) values ("'.$nuevotaller.'", "'.u8_($razsoc).'", "'.$cif.'", "'.u8_($nomcom).'", "'.u8_($contacto).'", "'.$telefono.'", "'.$correo.'", "'.u8_($dirr).'", "'.$cp.'", "'.u8_($loc).'", "'.u8_($prov).'")')){
			$_SESSION['datos_'._ID_PAG_]['nuevo_taller']['hayerrores']=1;
		}
		else{
			$nuevadirfac=insertado();
			query('update talleres set ta_iddirfac='.$nuevadirfac.' where ta_idtaller='.$nuevotaller.'' );
			query('INSERT into info_taller (it_idtaller) VALUES ("'.$nuevotaller.'")');
			query('INSERT into datos_actividad (da_mes, da_idtaller, da_idtipo) VALUES (1, "'.$nuevotaller.'", 0)');
		}
	}
}

fuera_de_aqui($url_dest);

?>