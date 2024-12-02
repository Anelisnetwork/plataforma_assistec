<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Expires" content="0">

    <meta http-equiv="Last-Modified" content="0">

    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

    <meta http-equiv="Pragma" content="no-cache">
    <?php include 'includes/metas.php';?>
	<title>Acceso a plataforma Assistec Online</title>
    <?php include 'includes/recursos.php';?>
    
</head>

<body id="loging">
	<div class="centrado">
    	<div class="linea" id="titulo">
        	<span class="fs_28 texto_r"><strong>Acceso a Plataforma Assistec online</strong></span>
        </div>
        <?php 
		!isset($_SESSION['datos_'._ID_PAG_]['n_errores'])?$_SESSION['datos_'._ID_PAG_]['n_errores']=0:'';
		if(isset($_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores'])&&$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']==1){
			$_SESSION['datos_'._ID_PAG_]['n_errores']++;
			$msg_error_acceso='Han ocurrido errores al acceder. Por favor, inténtelo de nuevo o contacte con nosotros.';
			isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&(in_array('no_email',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])||in_array('no_pass',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores']))?$msg_error_acceso='Debe cumplimentar todos los datos de acceso':'';
			isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('astc_email2',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?$msg_error_acceso='Ha ocurrido un problema con su dirección de correo electrónico, por favor, contacte con nosotros.':'';
			isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('astc_email',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?$msg_error_acceso='La dirección de correo indicada es errónea.':'';
			isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('astc_pass',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?$msg_error_acceso='La contraseña indicada es errónea.':'';
			isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('activo',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?$msg_error_acceso='Su cuenta no ha sido activada, por favor, espere confirmación.':'';
			isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('res_captcha',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?$msg_error_acceso='Debe responder correctamente a la pregunta de seguridad':'';
		?>
		<script>
			alertify.error('<?=$msg_error_acceso?>');
		</script>
		<?php
		}
		if(isset($_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores'])){
			if($_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']==1){
				$_SESSION['datos_'._ID_PAG_]['n_errores']++;
				$msg_error_acceso='Han ocurrido errores al acceder. Por favor, inténtelo de nuevo o contacte con nosotros.';
				isset($_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])&&(in_array('no_email',$_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores']))?$msg_error_acceso='Debe indicar su correo electrónico o alias de acecso':'';
				isset($_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])&&in_array('np_correo2',$_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])?$msg_error_acceso='Ha ocurrido un problema con su dirección de correo electrónico, por favor, contacte con nosotros.':'';
				isset($_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])&&in_array('np_correo',$_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])?$msg_error_acceso='La dirección de correo indicada es errónea.':'';
				isset($_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])&&in_array('activo',$_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])?$msg_error_acceso='Su cuenta no ha sido activada, por favor, espere confirmación.':'';
				isset($_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])&&in_array('pruebas',$_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores'])?$msg_error_acceso='Este es un usuario de pruebas, solicite la contraseña a su gestor de Assistec.':'';
				?>
				<script>
                    alertify.error('<?=$msg_error_acceso?>');
                </script>
                <?php
			}
			else{
				$msg_error_acceso='Le hemos enviado un correo electrónico con su nueva contraseña';
				?>
				<script>
                    alertify.success('<?=$msg_error_acceso?>');
                </script>
                <?php
			}
		
		}
		$_SESSION['datos_'._ID_PAG_]['n_errores']>=3?genera_captcha():'';
		
		if(isset($_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores'])&&$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']==1){
			$_SESSION['datos_'._ID_PAG_]['n_errores']++;
			$msg_error_sl_acceso='Han ocurrido errores al acceder. Por favor, inténtelo de nuevo o contacte con nosotros.';
		?>
		<script>
			alertify.error('<?=$msg_error_sl_acceso?>');
		</script>
		<?php
		}
		?>
        <div class="linea">
            <div class="redondo borde_gris redondo" id="cont_logo">
                <div id="cont_form">
                	<form action="<?=_RAIZ_?>procesando.php" method="post" name="cuenta" id="cuenta" class="form_lg">
                        <span class="fs_12">E-mail:</span>
                        <input type="text" class="indent redondo borde_gris<?=isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('astc_email',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?' error':'';?>" id="astc_email" name="astc_email" />
                        <span class="fs_12">Contrase&ntilde;a:</span>
                        <input type="password" class="indent redondo borde_gris<?=isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('astc_pass',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?' error':'';?>" id="astc_pass" name="astc_pass" />
                        <?php if($_SESSION['datos_'._ID_PAG_]['n_errores']>=3){?>
                        <span class="fs_12">Pregunta de seguridad:</span><br clear="all" />
                        <span class="fs_14 suma_captcha"><?=$_SESSION['datos_'._ID_PAG_]['captcha1']?> + <?=$_SESSION['datos_'._ID_PAG_]['captcha2']?> =</span>
                        <input type="text" name="res_captcha" id="res_captcha" value="" class="indent redondo borde_gris<?=isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('res_captcha',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])?' error':'';?>" style="width:20px" autocomplete="off" />
                        <?php }?>
                        <input type="submit" class="indent redondo link" id="astc_submit" name="astc_submit" value="ENTRAR" />
                        <input type="hidden" id="idproceso" name="idproceso" value="acceso" />
                    </form>
                    <div class="texto_centrado" style="width:200px; float:left">
                    <form action="<?=_RAIZ_?>procesando.php" method="post" onsubmit="return nuevapass();" name="cuenta" id="cuenta" class="form_lg">
                    	<input type="hidden" id="idproceso" name="idproceso" value="nuevapass" />
                        <input type="hidden" id="np_correo" name="np_correo" value="" />
                    	<input type="submit" class="link" id="npass_submit" name="npass_submit" style="background-color:transparent; color:#555; padding:0px; font-size:12px" value="He olvidado mi contrase&ntilde;a" />
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="linea texto_centrado">
        	<a href="<?=_WEB_?>registro.php" class="texto_r no_registrado">No estoy registrado</a>
        </div>
        <?php if(isset($_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])&&in_array('noscript',$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'])){?>
        	<div class="linea texto_centrado">
                <span class="texto_r"><strong>Debe habilitar Javascript en su navegador para utilizar nuestro panel</strong></span>
            </div>
        <?php }?>
    </div>
    <?php unset($_SESSION['datos_'._ID_PAG_]['acceder']);
	unset($_SESSION['datos_'._ID_PAG_]['nuevapass']);
	unset($_SESSION['datos_'._ID_PAG_]['sl_acceder']);?>
</body>
</html>