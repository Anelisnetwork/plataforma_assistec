<?php
if(!isset($_GET['token'])||$_GET['token']!=md5('laconcongrelos')){
	exit('Hola, ke ase?');
}

//require_once('../core.php');
require_once('/var/www/vhosts/assistec.es/httpdocs/plataforma/core/core.php');
//require_once('../clases/genpdf/html2pdf.class.php');
require_once('/var/www/vhosts/assistec.es/httpdocs/plataforma/core/clases/genpdf/html2pdf.class.php');

ini_set("display_errors", 1);	

open_bd();

$esdia=date('j');

$fil_vet=$esdia==28?' and ta_idtaller=6 AND ta_idtaller!=1':($esdia==1?' and ta_idtaller!=6':'');//Si es día 28 se emite a Veturilo; si es día 1 a todos excepto Veturilo

$hoy=date('Y-m-d').' 00:00:00';

//$hoy='2020-06-28 00:00:00';

$desde=mas_menos_tiempo($hoy,'-5','+0','+0','+0');
$anho=$esdia==1?(date('m')=='01'?date('Y')-1:date('Y')):date('Y');
$mes=$esdia==1?(date('m')=='01'?12:conceros(intval(date('m'))-1,2)):date('m');
$trimestre=dame_trimestre($mes);
$finmes=$anho.'-'.$mes.'-'.dias_mes($mes, $anho).' 23:59:59';

//Obtenemos string separado por comas de clientes con facturas pendientes excepto Veturilo
$con_ptes=array_comas('select distinct idcli from facturas where (estado=0 or estado=2) and idcli!=6');

//No tomamos los que ya tengan alguna factura pendiente
$fil_tall=$con_ptes==''?'':' and ta_idtaller not in ('.$con_ptes.')';
//Obtenemos talleres con fecha de vencimiento próxima para emitir la nueva factura.
$idtalleres=list_object("select talleres.* from talleres, usuarios where ta_idtaller=us_idtaller and us_estado=1 and ta_vencimiento>'".$desde."' and ta_vencimiento<='".$finmes."' and ta_idparent=0 AND ta_nofacturar=0".$fil_vet.$fil_tall." group by ta_idtaller");



//echo 'select talleres.* from talleres, usuarios where ta_idtaller=us_idtaller and us_estado=1 and ta_vencimiento>"'.$desde.'" and ta_vencimiento<="'.$finmes.'" and ta_idparent=0'.$fil_vet.$fil_tall.' group by ta_idtaller';exit;

$fpago=1;//Por defecto transferencia

$errores=array();
$exitos=array();

foreach($idtalleres as $taller){
    $datmes=date('m');
    $datanho=date('Y');
    $hay_errores=0;
	$idtaller=$taller->ta_idtaller;
	
	$idpromocion=$taller->ta_idpromo;
	$durpromo=$taller->ta_durpromo;
	$tipo_promo=fetch_array('select pr_tipo from promociones where pr_idpromocion='.$idpromocion.'','pr_tipo');
	
	if($tipo_promo==1&&$durpromo>0){//es una suscripción activa
		//$anho=date('Y');
		//$trimestre=dame_trimestre(date('m'));
		$dia=date('d');
		
		$meses=1;
		
		$dia<16?$meses--:'';//Si es antes del día 16 se factura el mes en curso, si no se factura a partir del siguiente
	
		$mes_venc=suma_mes($mes, $meses);//Calculamos el mes de vencimiento
		$anho_venc=$mes_venc<=$mes?$anho+1:$anho;//Calculamos el año de vencimiento
		$ult_dia=dias_mes($mes_venc, $anho_venc);//Obtenemos el último día del mes de vencimiento
		
		$vencimiento=$anho_venc.'-'.conceros($mes_venc,2).'-'.$ult_dia.' 23:59:59';
		
		$fpago==0;
		query('update talleres set ta_durpromo=ta_durpromo-1 where ta_idtaller='.$idtaller.'');
		query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
	}
	else{
		$venc_ta=$taller->ta_vencimiento;
		$tipo_taller=$taller->ta_idtipo;
		
		$dirfac=$taller->ta_iddirfac;
		$contrato=$taller->ta_contrato;
		$abono=$taller->ta_abono;
		$datos_fac=fetch_array('select * from usuarios_facturacion where uf_iddir='.$dirfac.'');
		//$datos_taller=fetch_array('select * from talleres where ta_idtaller='.$idtaller.'');
		$datos_emisor=fetch_array("select * from usuarios_facturacion where uf_cifnif='B05345368'");
		
		$tipoiva=$datos_fac['uf_tipoiva'];
		$iva=$tipoiva==1?1.21:1;
		
		$retiene=$datos_fac['uf_retiene'];
		$re=$tipoiva==1&&$retiene==1?0.052:0;
		
		$fpago=$datos_fac['uf_fpago'];
		
		$meses=3;
		$conc='trimestral';
		switch($abono){
			case '1':
				$meses=1;
				$conc='mensual';
				break;
			case '2':
				$meses=3;
				$conc='trimestral';
				break;
			case '3':
				$meses=6;
				$conc='semestral';
				break;
			case '4':
				$meses=12;
				$conc='anual';
				break;
		}
		
		$mes_venc=suma_mes($mes, $meses);//Calculamos el mes de vencimiento
		$anho_venc=$mes_venc<=$mes?$anho+1:$anho;//Calculamos el año de vencimiento
		$ult_dia=dias_mes($mes_venc, $anho_venc);//Obtenemos el último día del mes de vencimiento
		$vencimiento=$anho_venc.'-'.conceros($mes_venc,2).'-'.$ult_dia.' 23:59:59';
	
		$datos_cont=fetch_array('select * from tipos_contrato where tc_idtipo='.$contrato.'');
		$base=$datos_cont['tc_'.$taller->ta_idtipo.substr($conc, 0, 1)];
		$total=number_format($base*$iva,2);
		//$total+=number_format($base*$re,2);
		$observaciones='';
		
		$basetot=0;
		
		$nfactura=dame_num_fra($anho);

        if($total > 0 || $total < 0){
            if(!query('insert into facturas (nfactura, idcli, fecha_emision, fecha_vencimiento, anho_factura, trimestre_factura, forma_pago, base_imponible, tipo_iva, retiene, importe, emisor_nombre, emisor_cif, emisor_direccion, emisor_cp, emisor_poblacion, emisor_provincia, emisor_idpais, emisor_correo, emisor_telefono, cliente_nombre, cliente_cif, cliente_contacto, cliente_direccion, cliente_cp, cliente_poblacion, cliente_provincia, cliente_idpais, cliente_correo, cliente_telefono, observaciones) values ('.$nfactura.', '.$idtaller.', "'.$hoy.'", "'.$vencimiento.'", '.$anho.', '.$trimestre.', "'.$fpago.'", '.$base.', '.$tipoiva.', '.$retiene.', '.$total.', "'.$datos_emisor['uf_denomsoc'].'", "'.$datos_emisor['uf_cifnif'].'", "'.$datos_emisor['uf_direccion'].'", "'.$datos_emisor['uf_cp'].'", "'.$datos_emisor['uf_localidad'].'", "'.$datos_emisor['uf_provincia'].'", "'.$datos_emisor['uf_pais'].'", "'.$datos_emisor['uf_email'].'", "'.$datos_emisor['uf_telefono1'].'", "'.$datos_fac['uf_denomsoc'].'", "'.$datos_fac['uf_cifnif'].'", "'.$datos_fac['uf_contacto'].'", "'.$datos_fac['uf_direccion'].'", "'.$datos_fac['uf_cp'].'", "'.$datos_fac['uf_localidad'].'", "'.$datos_fac['uf_provincia'].'", "'.$datos_fac['uf_pais'].'", "'.$datos_fac['uf_email'].'", "'.$datos_fac['uf_telefono1'].'", "'.$observaciones.'")')){
                $errores[]=array($taller->ta_nombre, $total);
                $hay_errores=1;
            }
            else{
                $idfactura=insertado();
                if($fpago>=3&&$fpago<=8){//Forma de pago Giro
                    if($venc_ta<$vencimiento){
                        query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idtaller='.$idtaller.'');
                        $tipo_taller==2?query('update talleres set ta_vencimiento="'.$vencimiento.'" where ta_idparent='.$idtaller.''):'';
                    }
                }
                //GUARDAMOS LINEAS DE FACTURA
                if($taller->ta_idtipo==1){//Taller independiente
                    $ref=$datos_cont['tc_ref'];
                    $concep=u8_('Cuota '.$conc.' Assistec Online');
                    $cant=1;
                    $preu=$base;
                    $dto=0;
                    $imp=$cant*$preu;
                    if($cant!=0&&$cant!=''){
                        if(!query('insert into facturas_linea (fl_idfactura, fl_referencia, fl_concepto, fl_preciou, fl_dto, fl_cantidad, fl_importe) values ("'.$idfactura.'", "'.$ref.'", "'.$concep.'", "'.$preu.'", "'.$dto.'", "'.$cant.'", "'.$imp.'")')){
                            $errores[]=array($taller->ta_nombre, $total);
                            $hay_errores=1;
                        }
                    }
                    $basetot+=$imp;
                }//Taller independiente
                else{//Red de distribución
                    foreach ($l_contratos as $contrato){//Para cada tipo de contrato
                        if($idtaller==6){// Es veturilo
                            if($datmes=='01'){
                                $datmes='12';
                                $datanho=$datanho-1;
                            }
                            else{
                                $datmes=conceros($datmes-1,2);
                            }
                        }
                        $cuantos=count(dame_abonados($idtaller, 'activo', $contrato->tc_idtipo, $datmes, $datanho));
                        $datos_cont=fetch_array('select * from tipos_contrato where tc_idtipo='.$contrato->tc_idtipo.'');
                        $base=$idtaller==6?3.00:$datos_cont['tc_'.$taller->ta_idtipo.substr($conc, 0, 1)];//Veturilo 3.00 €
                        $ref=$datos_cont['tc_ref'];
                        $concep=u8_('Cuota '.$conc.' Assistec Online');
                        $cant=$cuantos;
                        $preu=$base;
                        $dto=0;
                        $imp=$cant*$preu;
                        if($cant!=0&&$cant!=''){
                            if(!query('insert into facturas_linea (fl_idfactura, fl_referencia, fl_concepto, fl_preciou, fl_dto, fl_cantidad, fl_importe) values ("'.$idfactura.'", "'.$ref.'", "'.$concep.'", "'.$preu.'", "'.$dto.'", "'.$cant.'", "'.$imp.'")')){
                                $errores[]=array($taller->ta_nombre, $total);
                                $hay_errores=1;
                            }
                        }
                        $basetot+=$imp;
                        if($idtaller==6){
                            break;
                        }
                    }//Para cada tipo de contrato
                }//Red de distribución
            }

            $imptot=number_format($basetot*$iva,2);
            $imptot+=number_format($basetot*$re,2);

            if($imptot == 0){
                query("DELETE FROM facturas WHERE idfactura='$idfactura'");
                query("DELETE FROM facturas_linea WHERE fl_idfactura='$idfactura'");
                continue;
            }
            if(!query('update facturas set base_imponible='.$basetot.', importe='.$imptot.' where idfactura='.$idfactura.'')){
                $errores[]=array($taller->ta_nombre, $imptot);
                $hay_errores=1;
            }

            if($hay_errores==0){
                $contenido=en__('pdf_factura%%guardar%%'.$idfactura.'%%'.$idtaller.'');
                $contenido_de=explode('%%',(de__($contenido)));
                $accion=$contenido_de[1];
                ob_start();
                include('/var/www/vhosts/assistec.es/httpdocs/plataforma/includes/pdf_factura.php');
                $content = ob_get_clean();

                try{
                    $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 5));//mL, mT, mR, mB
                    //$html2pdf->pdf->IncludeJS(_RAIZ_.'includes/recursos.php');
                    //isset($script1)?$html2pdf->pdf->IncludeJS($script1):'';
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

                    $accion=='imprimir'?$content_PDF=$html2pdf->Output():($accion=='guardar'?$content_PDF=$html2pdf->Output('/var/www/vhosts/assistec.es/httpdocs/plataforma/archivos/tmp/'.$nombre_archivo.'.pdf', 'F'):'');
                }
                catch(HTML2PDF_exception $e) {
                    echo 'Error al generar archivo PDF. Por favor, env&iacute;e el siguiente mensaje de error al departamento de soporte:<br><br>'.$e.'<br><br>';
                }

                $adjunto='/var/www/vhosts/assistec.es/httpdocs/plataforma/archivos/tmp/'.$nombre_archivo.'.pdf';
                $nadjunto=$nombre_archivo.".pdf";

                $mail_destino=$datos_fac['cliente_correo'];
                $nombre=u8d_($datos_fac['cliente_nombre']);
                $asunto='Adjuntando factura '.$datos_fac['idfactura']>11?'ACM-'.$datos_fac['nfactura']:$datos_fac['nfactura'];

                $nombre_com='Assistec Asesores';

                $cuerpo = '<html><head><title>Adjuntando factura '.$datos_fac['idfactura']>11?'ACM-'.$datos_fac['nfactura']:$datos_fac['nfactura'].'<br></title></head><body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">';
                $cuerpo .= 'Estimado cliente:<br><br>Le adjuntamos la factura n&ordm; '.$datos_fac['idfactura']>11?'ACM-'.$datos_fac['nfactura']:$datos_fac['nfactura'].'<br/><br/>';
                $cuerpo .= 'Puede realizar el pago mediante transferencia bancaria al n&uacute;mero de cuenta indicado en la factura o a trav&eacute;s del TPV virtual accediendo desde su panel de control.<br/><br/>';
                $cuerpo .= 'En caso de realizar el pago mediante transferencia bancaria y para agilizar el proceso de actualizaci&oacute;n de sus datos de acceso, no olvide indicar en el campo de concepto o similar el n&uacute;mero de la factura y remitir el justificante de pago por correo electr&oacute;nico a web@assistec.es.<br/><br/>';
                $cuerpo .= '<br><br>Muchas gracias por utilizar nuestros servicios.<br>Reciba un cordial saludo.<br><br>
				<span  style="color:#F00"><strong>Assistec Asesores</strong></span><br>
				<strong>Tel:</strong> (+34) 628 478 051<br>
				<strong>E-mail:</strong> '. _RECEPTOR_ .'<br>
				<strong>Web:</strong> www.assistec.es<br><br>';

                $cuerpo .= '<span style="color:#666; font-size:11px">AVISO LEGAL<br>
				En cumplimiento de lo establecido en la LOPD, le informamos que sus datos ser&aacute;n tratados en nuestros ficheros, con la finalidad del mantenimiento y cumplimiento de la relaci&oacute;n con nuestra entidad, incluyendo el env&iacute;o de comunicaciones en el marco de la citada relaci&oacute;n. Asimismo, sus datos ser&aacute;n cedidos en todos aquellos casos en que sea necesario para el desarrollo, cumplimiento y control de la relaci&oacute;n con nuestra entidad o en los supuestos en que lo autorice una norma con rango de ley. En cumplimiento de la LOPD puede ejercitar sus derechos ARCO ante '. strtoupper($nombre_com) .' adjuntando fotocopia de su DNI. El contenido de esta comunicaci&oacute;n, as&iacute; como el de toda la documentaci&oacute;n anexa, est&aacute; sujeta al deber de secreto y va dirigida &uacute;nicamente a su destinatario. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucci&oacute;n.</span>';
                $cuerpo .= "</body></html>";

                if(!enviar_email($mail_destino, $nombre, '', '', $asunto, $cuerpo, $nombre_com, _RECEPTOR_, '', '', '', $adjunto, $nadjunto, '', '', '')){
                    $errores[]=array($taller->ta_nombre, $basetot);
                    $hay_errores=1;
                }

                @unlink('/var/www/vhosts/assistec.es/httpdocs/plataforma/archivos/tmp/'.$nombre_archivo.'.pdf');

            }
        }
	}
	
	if($hay_errores==1){
		query('delete from facturas where idfactura='.$idfactura.'');
		query('delete from facturas_linea where fl_idfactura='.$idfactura.'');
	}
	else{
		$exitos[]=array($taller->ta_nombre, ($tipo_promo==1&&$durpromo>0?'---':$imptot), ($tipo_promo==1&&$durpromo>0?'Suscripcion':($idfactura>11?'ACM-'.$nfactura:$nfactura)));
	}
}


$asunto=u8_('Facturación automática Assistec.es');
$contenido='Se ha procedido a la generaci&oacute;n y env&iacute;o de las facturas correspondientes al presente per&iacute;odo con el siguiente resultado:<br><br>';
if(count($errores)>0){
	$contenido.='<strong>ERRORES</strong>:<br>';
	foreach($errores as $error){
		$contenido.='Taller: '.$error[0].'; importe: '.$error[1].'<br>';
	}
}
if(count($exitos)>0){
	$contenido.='<strong>EXITOS</strong>:<br>';
	foreach($exitos as $exito){
		$contenido.='Taller: '.$exito[0].'; importe: '.$exito[1].'; N&ordm; factura: '.$exito[2].'<br>';
	}
}


ob_start(); # apertura de bufer
include( '/var/www/vhosts/assistec.es/httpdocs/plataforma/core/templates/mail_template_def.php' );
$cuerpo = ob_get_clean();
$altbody='';

enviar_email('web@assistec.es', 'Assitec', 'g.barrasa@grupoanelis.com', 'Assitec', u8d_($asunto), $cuerpo, 'Sistema de facturas', 'web@assistec.es', '', '', '', '', '', u8d_($altbody));
//enviar_email('g.barrasa@grupoanelis.com', 'Assitec', '', '', u8d_($asunto), $cuerpo, 'Sistema de facturas', 'web@assistec.es', '', '', '', '', '', u8d_($altbody));

close_bd();
?>