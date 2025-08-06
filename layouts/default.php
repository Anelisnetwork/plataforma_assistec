<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Expires" content="0">

    <meta http-equiv="Last-Modified" content="0">

    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

    <meta http-equiv="Pragma" content="no-cache">
	<noscript>
      <meta http-equiv="refresh" content="0;url=<?=_RAIZ_?>salir.php?error=noscript">
    </noscript>
    <?php include 'includes/metas.php';?>
	<title>Plataforma Assitec Online - <?=nom_modulo($m)?><?=$seccion!=''?' - '.nom_seccion($seccion):''?></title>
    <?php include 'includes/recursos.php';?>
    <script>
	$(document).ready(function() {
	 mueveReloj();
	})
	</script>
</head>
<?php
$img_logo=isset($_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']) && $_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']!='' && file_exists(_PATH_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo'])?_RAIZ_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']:'';
?>
<body id="panel">
	<div class="centrado">
    	<div class="cent_cont">
            <div class="menu">
                <a href="<?=_RAIZ_.'inicio/'?>" class="logo"<?=$img_logo!=''?' style="background-image: url(\''.$img_logo.'\'); background-size:cover"':''?>></a>
                <div id="dat_user">
                    <span class="texto_b ubuntu"><?=dame_dato_usuario('us_nick')?></span>
                    <a href="<?=_RAIZ_?>salir.php"><img src="<?=_RAIZ_?>imagenes/salir.png" title="Salir" alt="Salir" id="salir" /></a>
                </div>
                
                
                <div class="sep_menu"></div>
                
                <?php if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2){
				$red_talleres=dame_red_talleres();?>
				<select name="admin_taller" id="admin_taller" onchange="cambia_taller(this.value)">
				<?php foreach ($red_talleres as $red_taller){?>
                    <option value="<?=$red_taller->ta_idtaller?>"<?=$red_taller->ta_idtaller==$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?' selected="selected"':''?>><?=u8d_($red_taller->ta_nombre)?></option>
				<?php }?>
				</select>
                <div class="sep_menu"></div>
                <?php }?>
                
                <?php foreach($lista_pages as $npage){
					if(in_array($npage->mo_url, $inactivos)){
				?>
                    <span style="cursor:not-allowed" title="<strong>No disponible en este módulo</strong>" id="menunav_<?=str_replace('_','',$npage->mo_url)?>" class="fs_16 nav<?=$npage->mo_url==$m?' activo':''?> "><?=nom_modulo($npage->mo_url)?></span>
                <?php }
				else{?>
                	<a href="<?=_RAIZ_.$npage->mo_url.'/'?>" id="menunav_<?=str_replace('_','',$npage->mo_url)?>" class="fs_16 nav<?=$npage->mo_url==$m?' activo':''?> "><?=nom_modulo($npage->mo_url)?></a>
                <?php }
				}?>
                
                <?php if($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']!=''){?>
                <div class="sep_menu"></div>
                <div class="lin_menu">
                    <span class="texto_b ubuntu">M&oacute;dulo: <span class="texto_r oswald<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==1?' faq':''?>" style="float:right"<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==1?' title="Aproveche al máximo las funcionalidades de nuestra herramienta actualizando su módulo a una modalidad superior"':''?>><?=strtoupper(dame_nombre_contrato($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']))?></span></span>
                </div>
                <div class="sep_menu"></div>
                <div class="lin_menu">
                    <a href="<?=_RAIZ_?>documentos/GUIA_MODULO_BASICO.pdf" target="_blank" class="texto_b ubuntu" title="Gu&iacute;a del M&oacute;dulo B&aacute;sico">Gu&iacute;a del M&oacute;dulo B&aacute;sico<img src="<?=_RAIZ_?>imagenes/pdf.png" style="float:right" /></a>
                    <br clear="all" /><br clear="all" />
                    <a href="<?=_RAIZ_?>documentos/GUIA_CUMPLIMENTACION_DATOS_MES_E_INFORME_DE_MES.pdf" target="_blank" class="texto_b ubuntu" title="Gu&iacute;a de cumplimentaci&oacute;n de datos">Gu&iacute;a de cumplimentaci&oacute;n...<img src="<?=_RAIZ_?>imagenes/pdf.png" style="float:right" /></a>
                </div>


                <?php }
                if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2){?>

                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="excel_taller_ID" id="excel_taller_ID"></form>
                <input type="hidden" form="excel_taller_ID" name="tipo_archivo" id="tipo_archivo" value="listado_excel_talleres_ids" />
                <div class="sep_menu"></div>
                <div class="lin_menu" style="text-align: center;">
                    <span class="texto_n ubuntu_b" style="cursor: pointer; padding: 3px 10px; background-color: #f3f3f3;" onclick="$('#excel_taller_ID').submit()">Descargar listado de IDs</span>
                </div>
                <div class="sep_menu"></div>
                <?php }?>
                
            </div>
            <div class="bloque_der">
                <div class="contenido">
                    <?php include('pages/'.$m.'.php');?>
                </div>
            </div>
        </div>
        <div class="pie">
        	<span class="fs_12">Copyright &copy; Assitec 2015 - Todos los derechos reservados.</span>
            <span style="float:right" class="fs_12"><?=nom_dia(date('w'))?> <?=date('d')?> de <?=nom_mes(date('n'))?> de <?=date('Y')?> &nbsp;&nbsp;&nbsp;&nbsp; <span id="imp_hora"><?=date('H')?>:<?=date('i')?>:<?=date('s')?></span></span>
        </div>
    </div>
    <?php 
	$vencimiento=dato_taller('ta_vencimiento', ($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==3?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']));
	//echo $_SESSION['datos_'._ID_PAG_]['idusuario'];
	if($_SESSION['datos_'._ID_PAG_]['datos_user']['idred']!=6&&date('j')>5&&$vencimiento<date('Y-m-d H:i:s')&&$_SESSION['datos_'._ID_PAG_]['idusuario']!=5){?>
    <div id="warning">
    	<div class="centrado">
        	<img src="<?=_RAIZ_?>imagenes/warning.png" style="float:left; margin-top:-7px; margin-left:150px" />
        	<span class="fs_16 texto_b" style="float:left; margin-left:25px">&iexcl;ATENCI&Oacute;N! Su suscripci&oacute;n se encuentra vencida, por favor, <?=$_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==3&&$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']!=0?'contacte con el gestor de su cuenta para m&aacute;s detalles':'revise si tiene alguna factura pendiente de abono'?>.</span>
            <img src="<?=_RAIZ_?>imagenes/close.png" style="float:right; margin-top:-7px; cursor:pointer" title="Cerrar" onclick="$('#warning').slideUp('slow');" />
        </div>
    </div>
    <?php }?>

</body>
<?php //unset($_SESSION['datos_'._ID_PAG_]['idusuario']);?>
</html>