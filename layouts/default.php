<!DOCTYPE html>
<html lang="es">
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
$jsSession = json_encode($_SESSION['datos_'._ID_PAG_]['datos_user']);
$img_logo=isset($_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']) && $_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']!='' && file_exists(_PATH_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo'])?_RAIZ_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']:_RAIZ_.'imagenes/assistec.png';
//var_dump($_SESSION['datos_'._ID_PAG_]['datos_user']);exit();
?>
<body id="panel">
<button id="menuToggle" class="btn btn-dark menu-hamburger d-lg-none" type="button" aria-expanded="false" aria-controls="menu-izq" title="Abrir menú">
    <i class="fa-solid fa-bars"></i>
</button>

<div id="menuBackdrop"></div>
<div class="d-flex flex-row min-vh-100">
    <div class="menu-izq col col-12 col-sm-6 col-lg-3 d-md-flex flex-column align-items-center justify-content-start bg-black m-0 p-0" style="border-right: 1px solid black;">
        <div class="bg-white w-100 d-flex justify-content-center align-items-center p-3">
            <a href="<?=_RAIZ_.'inicio/'?>" class="d-flex justify-content-center align-items-center w-100">
                <?php if($img_logo!=''){?>
                    <img src="<?=$img_logo?>" alt="Logo Taller" title="Logo Taller" style="width: 90%; max-width: 200px;" />
                <?php } else {?>
                    <span class="fs_24 texto_b oswald">ASSISTEC ONLINE</span>
                <?php }?>
            </a>
        </div>
        <div class="p-3 d-flex flex-column justify-content-center align-items-center w-100">
            <div class="w-100 d-flex align-items-center justify-content-between">
                <span class="texto_b ubuntu"><?=dame_dato_usuario('us_nick')?></span>
                <a href="<?=_RAIZ_?>salir.php">
                    <i class="fa-solid fa-arrow-right-from-bracket text-secondary fs_22"></i>
                </a>
            </div>


                    <hr class="w-100 bg-white border-1 border-white my-3">

            <?php if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2){
                $red_talleres=dame_red_talleres();?>
                <select name="admin_taller" id="admin_taller" class="w-100 form-control-sm" onchange="cambia_taller(this.value)">
                    <?php foreach ($red_talleres as $red_taller){?>
                        <option value="<?=$red_taller->ta_idtaller?>"<?=$red_taller->ta_idtaller==$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?' selected="selected"':''?>><?=u8d_($red_taller->ta_nombre)?></option>
                    <?php }?>
                </select>
                <hr class="w-100 bg-white border-1 border-white my-3">
            <?php }?>

            <?php foreach($lista_pages as $npage){
            $seccpage = dame_secciones($npage->mo_url);
                if(in_array($npage->mo_url, $inactivos)){?>
                    <span style="cursor:not-allowed" title="No disponible en este módulo" id="menunav_<?=str_replace('_','',$npage->mo_url)?>" class="text-grey bg-dark inactive fs_16 d-flex flex-row align-items-center justify-content-start w-100 mb-1 p-1<?=$npage->mo_url==$m?' activo':''?> ">
                        <i class="<?=modulo_ico($npage->mo_url)?> me-2"></i>
                        <?=nom_modulo($npage->mo_url)?>
                    </span>
                <?php }
                else{?>
                    <a href="<?=_RAIZ_.$npage->mo_url.'/'?>" id="menunav_<?=str_replace('_','',$npage->mo_url)?>" class=" fs_16 d-flex flex-row align-items-center justify-content-start w-100 mb-1 p-1 <?=$npage->mo_url==$m?' bg-white text-secondary':' bg-light'?> ">
                        <i class="<?=modulo_ico($npage->mo_url)?> me-2"></i>
                        <?=nom_modulo($npage->mo_url)?>
                    </a>
                    <?php
                    foreach($secciones as $seccp){
                        if(in_array($seccp->sc_url, $seccNoMenu)){continue;}?>
                        <a href="<?=_RAIZ_.$npage->mo_url.'/'.$seccp->sc_url.'/'?>" id="menunav_<?=str_replace('_','',$npage->mo_url).'_'.str_replace('_','',$seccp->sc_url)?>" class=" <?=$seccp->sc_url==$seccion?' active':''?> bg-dark fs_14 d-flex flex-row align-items-center justify-content-start w-75 mb-1 p-1 ms-4 <?=$npage->mo_url!=$m?' d-none':''?> ">
                            <i class="fa-solid fa-caret-right me-2"></i>
                            <?=nom_seccion($seccp->sc_url)?>
                        </a>
                    <?php }
                        }
            }?>

            <?php if($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']!=''){?>
                <hr class="w-100 bg-white border-1 border-white my-3">
                <div class="d-flex flex-row align-items-center justify-content-around w-100 ubuntu text-white">
                    M&oacute;dulo: <span class="texto_r ms-3 oswald<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==1?' faq':''?>" style="float:right"<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']==1?' title="Aproveche al máximo las funcionalidades de nuestra herramienta actualizando su módulo a una modalidad superior"':''?>><?=strtoupper(dame_nombre_contrato($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']))?></span>
                </div>
                <hr class="w-100 bg-white border-1 border-white my-3">
                <div class="d-flex flex-column align-items-center justify-content-around w-100 ubuntu text-white">
                    <a href="<?=_RAIZ_?>documentos/Guia alta Assistec_v2.pdf" target="_blank" class="text-white mb-2" title="Gu&iacute;a de alta">Guía de alta<i class=" fa-solid fa-download ms-2"></i></a>
                    <a href="<?=_RAIZ_?>documentos/Guía interpretación KPISCuadro Mando Assistec.pdf" target="_blank" class="text-white mb-2" title="Gu&iacute;a de interpretación">Guía de interpretación<i class=" fa-solid fa-download ms-2"></i></a>
                    <a href="<?=_RAIZ_?>documentos/Guía entrada manual de datos_v2.pdf" target="_blank" class="text-white mb-2" title="Gu&iacute;a de entrada de datos">Gu&iacute;a de entrada de datos<i class=" fa-solid fa-download ms-2"></i></a>
                </div>


            <?php }
            if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==2){?>

                <form action="<?=_RAIZ_?>descarga_excel/" method="post" name="excel_taller_ID" id="excel_taller_ID"></form>
                <input type="hidden" form="excel_taller_ID" name="tipo_archivo" id="tipo_archivo" value="listado_excel_talleres_ids" />
                <hr class="w-100 bg-white border-1 border-white my-3">
                <div class="d-flex flex-row align-items-center justify-content-center w-100 ubuntu btn btn-light" onclick="$('#excel_taller_ID').submit()">
                    Descargar listado de IDs
                </div>
            <?php }?>
        </div>


    </div>
    <div class="col col-12 col-lg-9 d-flex bg-white">
            <?php include('pages/'.$m.'.php');?>
    </div>
</div>
<div class="row">
    <div class="pie">
        <span class="fs_12">Copyright &copy; Assitec 2015 - Todos los derechos reservados.</span>
        <span style="float:right" class="fs_12"><?=nom_dia(date('w'))?> <?=date('d')?> de <?=nom_mes(date('n'))?> de <?=date('Y')?> &nbsp;&nbsp;&nbsp;&nbsp; <span id="imp_hora"><?=date('H')?>:<?=date('i')?>:<?=date('s')?></span></span>
    </div>
</div>
    <?php
	$vencimiento=dato_taller('ta_vencimiento', ($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==3?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']));
	//echo $_SESSION['datos_'._ID_PAG_]['idusuario'];
	if($_SESSION['datos_'._ID_PAG_]['datos_user']['idred']!=6&&date('j')>5&&$vencimiento<date('Y-m-d H:i:s')&&$_SESSION['datos_'._ID_PAG_]['idusuario']!=5){?>
    <div class="warning-badge bg-warning text-dark w-100 d-flex justify-content-center align-items-center p-2 mb-3" style="position:fixed; bottom:0; left:0; margin-bottom: 25px; z-index:1000; opacity: .8">
    	<div class="d-flex justify-content-center align-items-center w-100">
        	<img src="<?=_RAIZ_?>imagenes/warning.png" />
        	<span class="fs_16">&iexcl;ATENCI&Oacute;N! Su suscripci&oacute;n se encuentra vencida, por favor, <?=$_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==3&&$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']!=0?'contacte con el gestor de su cuenta para m&aacute;s detalles':'revise si tiene alguna factura pendiente de abono'?>.</span>
            <img src="<?=_RAIZ_?>imagenes/close.png" style="margin-top:-7px; cursor:pointer" title="Cerrar" onclick="$('.warning-badge').removeClass('d-flex').addClass('d-none');" />
        </div>
    </div>
    <?php }?>
<script>
    (function(){
        // JSON seguro generado por PHP
        const sessionData = <?= $jsSession ?>;
        // Guardar en sessionStorage como string
        sessionStorage.setItem('appSession', JSON.stringify(sessionData));
    })();
</script>
<?php include_javascript();?>
</body>
<?php //unset($_SESSION['datos_'._ID_PAG_]['idusuario']);?>
</html>