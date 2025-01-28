<?php
if(!isset($_GET['token'])||$_GET['token']!=md5('laconcongrelos')){
    exit('Hola, ke ase?');
}

require_once('../core/core.php');

//require_once(_PATH_.'core/clases/genpdf/html2pdf.class.php');
require _PATH_.'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

open_bd();

$datosact=list_object('select * from envios_pendientes');

foreach($datosact as $datoact){
	$idtaller=$datoact->ep_idtaller;
	$idmes=$datoact->ep_mes;
	$idano=$datoact->ep_ano;
    $accion=$datoact->ep_accion;
    $idenvio=$datoact->ep_idenvio;

    $contenido=en__('pdf_infome_mensual%%guardar%%'.$idtaller.'%%'.$idmes.'%%'.$idano.'');

    if($accion=='0'){//Generamos las imágenes y programamos envío
        include(_PATH_.'core/includes/generar_informe.php');
    }//Generamos las imágenes y programamos envío
    else {//Enviamos el informe

        $datos = fetch_array("SELECT * FROM datos_actividad WHERE da_mes='" . $idmes . "' AND da_ano='" . $idano . "' AND da_idtaller=" . $idtaller);

        $hpresencia = horas_presencia($datos['da_iddato']);
        $hfacturadas = $datos['da_facturadomo'] / $datos['da_impmo'];

        $productividad = porcentaje_($datos['da_horasfichadasor'], $hpresencia);
        $eficacia = porcentaje_($hfacturadas, $hpresencia);
        $rendimiento = porcentaje_($hfacturadas, $datos['da_horasfichadasor']);

        $ventapr = $datos['da_facturadorec'] + $datos['da_facturadootros'];
        $costepr = $datos['da_pagadoprovrec'] + $datos['da_pagadoprovotros'];
        $porcentpr = number_format(margen_sobre_coste($costepr, $ventapr), 2);
        $ventasobj = $costepr + ($costepr * $datos['da_objmargenrec'] / 100);

        //echo $ventapr.' - '.$costepr.' - '.$porcentpr.' - '.$datos['da_objmargenrec'].' - '.$ventasobj;exit();

        ob_start();

        include(_PATH_ . 'includes/pdf_infome_mensual.php');

        $content = ob_get_clean();

        $nombre_archivo = 'Informe_mensual_' . $idtaller . '_' . nom_mes($idmes) . '_' . $idano;

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 5));//mL, mT, mR, mB
            //$html2pdf->pdf->IncludeJS(_RAIZ_.'includes/recursos.php');
            //isset($script1)?$html2pdf->pdf->IncludeJS($script1):'';
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

            $content_PDF = $html2pdf->Output(_PATH_ . 'archivos/tmp/' . $nombre_archivo . '.pdf', 'F');
        } catch (HTML2PDF_exception $e) {
            echo 'Error al generar archivo PDF. Por favor, env&iacute;e el siguiente mensaje de error al departamento de soporte:<br><br>' . $e;
            exit;
        }

        $adjunto = _PATH_ . 'archivos/tmp/' . $nombre_archivo . '.pdf';
        $nadjunto = $nombre_archivo . ".pdf";

        $mail_destino = dato_taller('ta_email', $idtaller);
        $nombre = u8d_(dato_taller('ta_nombre', $idtaller));
        $asunto = 'Informe mensual de su taller - ' . nom_mes($idmes) . ' de ' . $idano;

        $nombre_com = 'Assistec Asesores';

        $cuerpo = '<html><head><title>Informe mensual de su taller - ' . nom_mes($datos['da_mes']) . ' de ' . $datos['da_ano'] . '<br></title></head><body>';
        $cuerpo .= 'Estimado cliente:<br><br>Le adjuntamos el informe mensual correspondiente a ' . nom_mes($idmes) . ' de ' . $idano . '<br/><br/>';
        $cuerpo .= '<br><br>Muchas gracias por utilizar nuestros servicios.<br>Reciba un cordial saludo.<br><br>
		Assistec Asesores<br>
		Tel. (+34) 628 478 051<br>
		E-mail: ' . _RECEPTOR_ . '<br>
		Web: www.assistec.es<br><br>';

        $cuerpo .= '<span style="color:#666; font-size:11px">AVISO LEGAL<br>
		En cumplimiento de lo establecido en la LOPD, le informamos que sus datos ser&aacute;n tratados en nuestros ficheros, con la finalidad del mantenimiento y cumplimiento de la relaci&oacute;n con nuestra entidad, incluyendo el env&iacute;o de comunicaciones en el marco de la citada relaci&oacute;n. Asimismo, sus datos ser&aacute;n cedidos en todos aquellos casos en que sea necesario para el desarrollo, cumplimiento y control de la relaci&oacute;n con nuestra entidad o en los supuestos en que lo autorice una norma con rango de ley. En cumplimiento de la LOPD puede ejercitar sus derechos ARCO ante ' . strtoupper($nombre_com) . ' adjuntando fotocopia de su DNI. El contenido de esta comunicaci&oacute;n, as&iacute; como el de toda la documentaci&oacute;n anexa, est&aacute; sujeta al deber de secreto y va dirigida &uacute;nicamente a su destinatario. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucci&oacute;n.</span>';
        $cuerpo .= "</body></html>";


        $msg_pantalla = 'Le hemos enviado a su correo electr&oacute;nico ' . $mail_destino . ' el informe del mes indicado<br><br>Estamos a su disposici&oacute;n para cualquier consulta que desee realizar.';
        if (!enviar_email($mail_destino, $nombre, '', '', $asunto, $cuerpo, $nombre_com, _RECEPTOR_, '', '', '', $adjunto, $nadjunto, '', '', '')) {
            $msg_pantalla = 'No hemos podido realizar el env&iacute;o a su correo electr&oacute;nico ' . $mail_destino . ' del informe del mes indicado<br><br>Por favor, int&eacute;ntelo de nuevo m&aacute;s tarde o contacte con nosotros en el correo web@assistec.es o llamando al (+34) 628 478 051.';
        }
        @unlink(_PATH_ . 'archivos/tmp/' . $nombre_archivo . '.pdf');
        @unlink(_PATH_ . 'archivos/tmp/efectividad_' . $idtaller . '_' . $idmes . '_' . $idano . '.png');
        @unlink(_PATH_ . 'archivos/tmp/rendimiento_' . $idtaller . '_' . $idmes . '_' . $idano . '.png');
        @unlink(_PATH_ . 'archivos/tmp/margenventa_' . $idtaller . '_' . $idmes . '_' . $idano . '.png');
        query("DELETE FROM envios_pendientes WHERE ep_idenvio=" . $idenvio);
    }//Enviamos el informe

}

close_bd();
?>