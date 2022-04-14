<?php
//ini_set("display_errors", 1);
require_once('../core/core.php');

//$contenido=en__('pdf_factura%%imprimir%%8%%6');
//$contenido=en__('pdf_infome_mensual%%imprimir%%1%%10%%2015');

$contenido=clean_get('contenido');
$contenido_de=explode('%%',(de__($contenido)));

require_once('../core/clases/genpdf/html2pdf.class.php');

$nombre_archivo='archivo_assistec';

$accion=$contenido_de[1];



open_bd();

ob_start();

include('../includes/'.$contenido_de[0].'.php');
	
$content = ob_get_clean();

close_bd();


try{
	$html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 5));//mL, mT, mR, mB
	//$html2pdf->pdf->IncludeJS(_RAIZ_.'includes/recursos.php');
	//isset($script1)?$html2pdf->pdf->IncludeJS($script1):'';
	$html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	
	$accion=='imprimir'?$content_PDF=$html2pdf->Output():($accion=='guardar'?$content_PDF=$html2pdf->Output('../archivos/tmp/'.$nombre_archivo.'.pdf', 'F'):'');
}
catch(HTML2PDF_exception $e) { echo 'Error al generar archivo PDF. Por favor, env&iacute;e el siguiente mensaje de error al departamento de soporte:<br><br>'.$e; }

if($contenido_de[0]=='pdf_infome_mensual'&&$accion=='guardar'){
	open_bd();
	$adjunto='../archivos/tmp/'.$nombre_archivo.'.pdf';
	$nadjunto=$nombre_archivo.".pdf";
	
	$mail_destino=dato_taller('ta_email',$contenido_de[2]);
	$nombre=u8d_(dato_taller('ta_nombre',$contenido_de[2]));
	$asunto='Informe mensual de su taller - '.nom_mes($contenido_de[3]).' de '.$contenido_de[4];
	
	$nombre_com='Assistec Asesores';
	
	$cuerpo = '<html><head><title>Informe mensual de su taller - '.nom_mes($datos['da_mes']).' de '.$datos['da_ano'].'<br></title></head><body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">';
	$cuerpo .= 'Estimado cliente:<br><br>Le adjuntamos el informe mensual correspondiente a '.nom_mes($contenido_de[3]).' de '.$contenido_de[4].'<br/><br/>';
	$cuerpo .= '<br><br>Muchas gracias por utilizar nuestros servicios.<br>Reciba un cordial saludo.<br><br>
		<span  style="color:#F00"><strong>Assistec Asesores</strong></span><br>
		<strong>Tel:</strong> (+34) 628 478 051<br>
		<strong>E-mail:</strong> '. _RECEPTOR_ .'<br>
		<strong>Web:</strong> www.assistec.es<br><br>';
		
	$cuerpo .= '<span style="color:#666; font-size:11px">AVISO LEGAL<br>
		En cumplimiento de lo establecido en la LOPD, le informamos que sus datos ser&aacute;n tratados en nuestros ficheros, con la finalidad del mantenimiento y cumplimiento de la relaci&oacute;n con nuestra entidad, incluyendo el env&iacute;o de comunicaciones en el marco de la citada relaci&oacute;n. Asimismo, sus datos ser&aacute;n cedidos en todos aquellos casos en que sea necesario para el desarrollo, cumplimiento y control de la relaci&oacute;n con nuestra entidad o en los supuestos en que lo autorice una norma con rango de ley. En cumplimiento de la LOPD puede ejercitar sus derechos ARCO ante '. strtoupper($nombre_com) .' adjuntando fotocopia de su DNI. El contenido de esta comunicaci&oacute;n, as&iacute; como el de toda la documentaci&oacute;n anexa, est&aacute; sujeta al deber de secreto y va dirigida &uacute;nicamente a su destinatario. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucci&oacute;n.</span>';
	$cuerpo .= "</body></html>"; 
	
	
	$msg_pantalla='Le hemos enviado a su correo electr&oacute;nico '.$mail_destino.' el informe del mes indicado<br><br>Estamos a su disposici&oacute;n para cualquier consulta que desee realizar.';
	if(!enviar_email($mail_destino, $nombre, '', '', $asunto, $cuerpo, $nombre_com, _RECEPTOR_, '', '', '', $adjunto, $nadjunto, '', '', '')){
		$msg_pantalla='No hemos podido realizar el env&iacute;o a su correo electr&oacute;nico '.$mail_destino.' del informe del mes indicado<br><br>Por favor, int&eacute;ntelo de nuevo m&aacute;s tarde o contacte con nosotros en el correo web@assistec.es o llamando al (+34) 628 478 051.';
	}
?>
    <div style="width:600px; text-align:center; margin:0px auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
    <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
    <?=$msg_pantalla?>
    <br /><br />
    Atentamente:<br />
    El equipo de Assistec Asesores.<br /><br />
    <span style="font-size:11px">(Puede cerrar esta ventana)</span>
    </div>
    <?php
    @unlink('../archivos/tmp/'.$nombre_archivo.'.pdf');
}
if($contenido_de[0]=='pdf_infome_mensual'){
	@unlink('../archivos/tmp/efectividad_'.$contenido_de[2].'_'.$contenido_de[3].'_'.$contenido_de[4].'.png');
	@unlink('../archivos/tmp/rendimiento_'.$contenido_de[2].'_'.$contenido_de[3].'_'.$contenido_de[4].'.png');
	@unlink('../archivos/tmp/margenventa_'.$contenido_de[2].'_'.$contenido_de[3].'_'.$contenido_de[4].'.png');
}

if($contenido_de[0]=='pdf_factura'&&$accion=='guardar'){
	open_bd();
	$adjunto='../archivos/tmp/'.$nombre_archivo.'.pdf';
	$nadjunto=$nombre_archivo.".pdf";
	
	$mail_destino=$datos_fac['cliente_correo'];
	$nombre=u8d_($datos_fac['cliente_nombre']);
	$asunto='Adjuntando factura '.$datos_fac['nfactura'];
	
	$nombre_com='Assistec Asesores';
	
	$cuerpo = '<html><head><title>Adjuntando factura '.$datos_fac['nfactura'].'<br></title></head><body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">';
	$cuerpo .= 'Estimado cliente:<br><br>Le adjuntamos la factura n&ordm; '.$datos_fac['nfactura'].'<br/><br/>';
	$cuerpo .= '<br><br>Muchas gracias por utilizar nuestros servicios.<br>Reciba un cordial saludo.<br><br>
		<span  style="color:#F00"><strong>Assistec Asesores</strong></span><br>
		<strong>Tel:</strong> (+34) 628 478 051<br>
		<strong>E-mail:</strong> '. _RECEPTOR_ .'<br>
		<strong>Web:</strong> www.assistec.es<br><br>';
		
	$cuerpo .= '<span style="color:#666; font-size:11px">AVISO LEGAL<br>
		En cumplimiento de lo establecido en la LOPD, le informamos que sus datos ser&aacute;n tratados en nuestros ficheros, con la finalidad del mantenimiento y cumplimiento de la relaci&oacute;n con nuestra entidad, incluyendo el env&iacute;o de comunicaciones en el marco de la citada relaci&oacute;n. Asimismo, sus datos ser&aacute;n cedidos en todos aquellos casos en que sea necesario para el desarrollo, cumplimiento y control de la relaci&oacute;n con nuestra entidad o en los supuestos en que lo autorice una norma con rango de ley. En cumplimiento de la LOPD puede ejercitar sus derechos ARCO ante '. strtoupper($nombre_com) .' adjuntando fotocopia de su DNI. El contenido de esta comunicaci&oacute;n, as&iacute; como el de toda la documentaci&oacute;n anexa, est&aacute; sujeta al deber de secreto y va dirigida &uacute;nicamente a su destinatario. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucci&oacute;n.</span>';
	$cuerpo .= "</body></html>"; 
	
	
	$msg_pantalla='Le hemos enviado a su correo electr&oacute;nico '.$mail_destino.' la factura solicitada.<br><br>Estamos a su disposici&oacute;n para cualquier consulta que desee realizar.';
	if(!enviar_email($mail_destino, $nombre, '', '', $asunto, $cuerpo, $nombre_com, _RECEPTOR_, '', '', '', $adjunto, $nadjunto, '', '', '')){
		$msg_pantalla='No hemos podido realizar el env&iacute;o a su correo electr&oacute;nico '.$mail_destino.' de la factura solicitada.<br><br>Por favor, int&eacute;ntelo de nuevo m&aacute;s tarde o contacte con nosotros en el correo web@assistec.es o llamando al (+34) 628 478 051.';
	}
?>
    <div style="width:600px; text-align:center; margin:0px auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
    <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
    <?=$msg_pantalla?>
    <br /><br />
    Atentamente:<br />
    El equipo de Assistec Asesores.<br /><br />
    <span style="font-size:11px">(Puede cerrar esta ventana)</span>
    </div>
    <?php
    @unlink('../archivos/tmp/'.$nombre_archivo.'.pdf');
}


close_bd();
?>