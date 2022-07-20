<?php

$_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$idtaller=clean_post('idtaller');

//DATOS DE CONTRATO
$tipo=$_SESSION['datos_'._ID_PAG_]['edita_taller']['tipo_'.$idtaller]=clean_post('tipo_'.$idtaller);
$red=$_SESSION['datos_'._ID_PAG_]['edita_taller']['red_'.$idtaller]=clean_post('red_'.$idtaller);
$contrato=$_SESSION['datos_'._ID_PAG_]['edita_taller']['contrato_'.$idtaller]=clean_post('contrato_'.$idtaller);
$pago=$_SESSION['datos_'._ID_PAG_]['edita_taller']['pago_'.$idtaller]=clean_post('pago_'.$idtaller);
//DATOS DE CONTRATO

//OBJETIVOS
$objventas=$_SESSION['datos_'._ID_PAG_]['edita_taller']['objventas_'.$idtaller]=clean_post('objventas_'.$idtaller);
$objmargenrec=$_SESSION['datos_'._ID_PAG_]['edita_taller']['objmargenrec_'.$idtaller]=clean_post('objmargenrec_'.$idtaller);
$objeficacia=$_SESSION['datos_'._ID_PAG_]['edita_taller']['objeficacia_'.$idtaller]=clean_post('objeficacia_'.$idtaller);
$objproductividad=$_SESSION['datos_'._ID_PAG_]['edita_taller']['objproductividad_'.$idtaller]=clean_post('objproductividad_'.$idtaller);
$objrendimiento=$_SESSION['datos_'._ID_PAG_]['edita_taller']['objrendimiento_'.$idtaller]=clean_post('objrendimiento_'.$idtaller);
//OBJETIVOS

//DATOS DEL TALLER
$nomcom=$_SESSION['datos_'._ID_PAG_]['edita_taller']['nomcom_'.$idtaller]=clean_post('nomcom_'.$idtaller);
$contacto=$_SESSION['datos_'._ID_PAG_]['edita_taller']['contacto_'.$idtaller]=clean_post('contacto_'.$idtaller);
$socio=$_SESSION['datos_'._ID_PAG_]['edita_taller']['socio_'.$idtaller]=clean_post('socio_'.$idtaller);
$telefono=$_SESSION['datos_'._ID_PAG_]['edita_taller']['telefono_'.$idtaller]=clean_post('telefono_'.$idtaller);
$movil=$_SESSION['datos_'._ID_PAG_]['edita_taller']['telefono2_'.$idtaller]=clean_post('telefono2_'.$idtaller);
$correo=$_SESSION['datos_'._ID_PAG_]['edita_taller']['correo_'.$idtaller]=clean_post('correo_'.$idtaller);
$dirr=$_SESSION['datos_'._ID_PAG_]['edita_taller']['dirr_'.$idtaller]=clean_post('dirr_'.$idtaller);
$cp=$_SESSION['datos_'._ID_PAG_]['edita_taller']['cp_'.$idtaller]=clean_post('cp_'.$idtaller);
$loc=$_SESSION['datos_'._ID_PAG_]['edita_taller']['loc_'.$idtaller]=clean_post('loc_'.$idtaller);
$prov=$_SESSION['datos_'._ID_PAG_]['edita_taller']['prov_'.$idtaller]=clean_post('prov_'.$idtaller);
//DATOS DEL TALLER

//DATOS DE FACTURACIÓN
$nofacturar=$_SESSION['datos_'._ID_PAG_]['edita_taller']['nofacturar_'.$idtaller]=clean_post('nofacturar_'.$idtaller);
$tipoiva=$_SESSION['datos_'._ID_PAG_]['edita_taller']['tipoiva_'.$idtaller]=clean_post('tipoiva_'.$idtaller);
$retiene=$_SESSION['datos_'._ID_PAG_]['edita_taller']['retiene_'.$idtaller]=isset($_POST['retiene_'.$idtaller])?clean_post('retiene_'.$idtaller):0;
$razsoc=$_SESSION['datos_'._ID_PAG_]['edita_taller']['razsoc_'.$idtaller]=clean_post('razsoc_'.$idtaller);
$cif=$_SESSION['datos_'._ID_PAG_]['edita_taller']['cif_'.$idtaller]=clean_post('cif_'.$idtaller);
$nomcomf=$_SESSION['datos_'._ID_PAG_]['edita_taller']['nomcomf_'.$idtaller]=clean_post('nomcomf_'.$idtaller);
$contactof=$_SESSION['datos_'._ID_PAG_]['edita_taller']['contactof_'.$idtaller]=clean_post('contactof_'.$idtaller);
$telefonof=$_SESSION['datos_'._ID_PAG_]['edita_taller']['telefonof_'.$idtaller]=clean_post('telefonof_'.$idtaller);
$movilf=$_SESSION['datos_'._ID_PAG_]['edita_taller']['telefono2f_'.$idtaller]=clean_post('telefono2f_'.$idtaller);
$correof=$_SESSION['datos_'._ID_PAG_]['edita_taller']['correof_'.$idtaller]=clean_post('correof_'.$idtaller);
$dirrf=$_SESSION['datos_'._ID_PAG_]['edita_taller']['dirrf_'.$idtaller]=clean_post('dirrf_'.$idtaller);
$cpf=$_SESSION['datos_'._ID_PAG_]['edita_taller']['cpf_'.$idtaller]=clean_post('cpf_'.$idtaller);
$locf=$_SESSION['datos_'._ID_PAG_]['edita_taller']['locf_'.$idtaller]=clean_post('locf_'.$idtaller);
$provf=$_SESSION['datos_'._ID_PAG_]['edita_taller']['provf_'.$idtaller]=clean_post('provf_'.$idtaller);
$observ=$_SESSION['datos_'._ID_PAG_]['edita_taller']['observ_'.$idtaller]=clean_post('observ_'.$idtaller);
//DATOS DE FACTURACIÓN

if($tipo==1){//Taller
    if($red!=0){//pertenece a una red
        $datosred=list_object('select * from talleres where ta_idtaller="'.$red.'" and ta_idtipo=2');
        if(count($datosred)==0){
            $_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']=1;
            $_SESSION['datos_'._ID_PAG_]['edita_taller']['mensaje']='La red seleccionada no es correcta';
        }
        else{
            if($pago==5){//abonado
                $contrato=$datosred[0]->ta_contrato;
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
    $_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']=1;
}

if($nomcom==''||$razsoc==''||$cif==''||$telefono==''||$correo==''||!VerificarDireccionCorreo($correo)||$dirr==''||$cp==''||$loc==''||$prov==''||$telefonof==''||$correof==''||!VerificarDireccionCorreo($correof)||$dirrf==''||$cpf==''||$locf==''||$provf==''){
    $_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']=1;
    $_SESSION['datos_'._ID_PAG_]['edita_taller']['mensaje']='Faltan datos imprescindibles';
}


if($_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']==0){
    if(!query('update talleres set ta_idtipo='.$tipo.', ta_idparent='.$red.', ta_nombre="'.u8_($nomcom).'", ta_contacto="'.u8_($contacto).'", ta_socio="'.u8_($socio).'", ta_telefono1="'.$telefono.'", ta_telefono2="'.$movil.'", ta_email="'.$correo.'", ta_direccion="'.u8_($dirr).'", ta_cp="'.$cp.'", ta_localidad="'.u8_($loc).'", ta_provincia="'.u8_($prov).'", ta_contrato='.$contrato.', ta_abono='.$pago.', ta_objventas='.$objventas.', ta_objmargenrec='.$objmargenrec.', ta_objeficacia='.$objeficacia.', ta_objproductividad='.$objproductividad.', ta_objrendimiento='.$objrendimiento.', ta_nofacturar='.$nofacturar.' where ta_idtaller='.$idtaller.'')){
        $_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']=1;
    }
    else{
        $dirfac=fetch_array('select ta_iddirfac from talleres where ta_idtaller='.$idtaller.'','ta_iddirfac');
        if(!query('update usuarios_facturacion set uf_denomsoc="'.u8_($razsoc).'", uf_cifnif="'.$cif.'", uf_nomcom="'.u8_($nomcomf).'", uf_contacto="'.u8_($contactof).'", uf_telefono1="'.$telefonof.'", uf_telefono2="'.$movilf.'", uf_email="'.$correof.'", uf_direccion="'.u8_($dirrf).'", uf_cp="'.$cpf.'", uf_localidad="'.u8_($locf).'", uf_provincia="'.u8_($provf).'", uf_observaciones="'.u8_($observ).'", uf_tipoiva="'.$tipoiva.'", uf_retiene="'.$retiene.'" where uf_iddir='.$dirfac.'')){
            $_SESSION['datos_'._ID_PAG_]['edita_taller']['hayerrores']=1;
        }
    }
}

fuera_de_aqui($url_dest);

?>