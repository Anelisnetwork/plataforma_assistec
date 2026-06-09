<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Assitec Online - <?=nom_modulo($m)?><?=$seccion!=''?' - '.nom_seccion($seccion):''?></title>
    <noscript>
        <meta http-equiv="refresh" content="0;url=<?=_RAIZ_?>salir.php?error=noscript">
    </noscript>
    <!-- global style sheet for all pages -->
    <link id="bootstrap-css" rel="stylesheet" type="text/css" href="<?=_RAIZ_?>theme/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=_RAIZ_?>theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?=_RAIZ_?>theme/assets/css/conca.css">

    <?php include 'includes/metas.php';?>
    <?php include 'includes/recursos.php';?>
</head>
<?php
$img_logo=isset($_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']) && $_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']!='' && file_exists(_PATH_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo'])?_RAIZ_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']:_RAIZ_.'imagenes/assistec.png';
$img_logo_w=isset($_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']) && $_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']!='' && file_exists(_PATH_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo'])?_RAIZ_.'imagenes/talleres/logotipos/'.$_SESSION['datos_'._ID_PAG_]['datos_user']['logotipo']:_RAIZ_.'imagenes/assistec_wh.png';
$nick_usuario = dame_dato_usuario('us_nick');
//var_dump($_SESSION['datos_'._ID_PAG_]['datos_user']);exit();
$nombreModulo = nom_modulo($m) === 'Inicio' ? 'Dashboard' : nom_modulo($m)
?>
<body>



<div class="app-main">

    <!-- app wrapper start -->
    <div id="app-wrapper" class="app-wrapper d-flex flex-column align-items-stretch min-vh-100">

        <!-- app sidebar start -->
        <div id="app-sidebar" class="app-sidebar overflow-hidden noprint">

            <div class="app-sidebar-wrapper">
                <!-- app sidebar header -->
                <div class="app-sidebar-header d-flex align-items-center justify-content-center w-100">
                    <a href="<?=_RAIZ_.'inicio/'?>" class="app-sidebar-logo">
                        <img class="app-main-logo logo-black" width="105" src="<?=$img_logo?>" alt="<?=$nick_usuario?>">
                        <img class="app-main-logo logo-white d-none" width="105" src="<?=$img_logo_w?>" alt="<?=$nick_usuario?>">
                    </a>

                    <button type="button" class="app-sidebar-close-btn app-sidebar-mobile-close d-xl-none" style="position: absolute; right: 0; margin-right: 15px">
                        <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6923 10.2857L6.53846 6M6.53846 6L10.6923 1.71429M6.53846 6L19 6M1 11L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <!-- app sidebar menu -->
                <div id="app-sidebar-menu" class="app-sidebar-menu">
                    <ul>
                        <?php foreach($lista_pages as $npage){
                        $seccpage = dame_secciones($npage->mo_url);
                        if(!in_array($npage->mo_url, $inactivos)){?>
                        <li class="app-sidebar-menu-item<?=count($seccpage) > 0 ? ' has-dropdown' : '' ?>">
                            <a href="<?=count($seccpage) > 0 ? 'javascript:void(0);' : _RAIZ_.$npage->mo_url.'/' ?>" class="menu-link d-flex align-items-center">
                                <span class="menu-icon fs_20 flex-shrink-0 <?=modulo_ico($npage->mo_url)?>"></span>
                                <span class="menu-title flex-grow-1"><?=nom_modulo($npage->mo_url) === 'Inicio' ? 'Dashboard' : nom_modulo($npage->mo_url)?></span>
                                <?php if(count($seccpage)>0){?>
                                    <span class="menu-arrow flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 9L5 5L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                <?php }?>
                            </a>
                            <?php if(count($seccpage)>0){?>
                                <ul class="app-sidebar-submenu">
                                    <?php
                                    foreach($seccpage as $seccp){
                                    if(in_array($seccp->sc_url, $seccNoMenu)){continue;}?>
                                        <li class="app-sidebar-menu-item">
                                            <a href="<?=_RAIZ_.$npage->mo_url.'/'.$seccp->sc_url.'/'?>" class="menu-link d-flex align-items-center">
                                                <span class="menu-title flex-grow-1"><?=nom_seccion($seccp->sc_url)?></span>
                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                            <?php }?>
                        </li>
                        <?php }
                        }?>

                        <!-- Sección de documentación -->
                        <li class="app-sidebar-menu-item has-dropdown">
                            <a href="javascript:void(0);" class="menu-link d-flex align-items-center">
                                <span class="menu-icon fs_20 flex-shrink-0 fa fa-file-circle-question"></span>
                                <span class="menu-title flex-grow-1">Guías y documentos</span>
                                <span class="menu-arrow flex-shrink-0 d-flex align-items-center justify-content-center">
                                    <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 9L5 5L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </a>
                            <ul class="app-sidebar-submenu">
                                <li class="app-sidebar-menu-item">
                                    <a href="<?=_RAIZ_?>documentos/Guia alta Assistec_v3.pdf" target="_blank" rel="nofollow" class="menu-link d-flex align-items-center">
                                        <span class="menu-title flex-grow-1">Guía de alta</span>
                                    </a>
                                </li>
                                <li class="app-sidebar-menu-item">
                                    <a href="<?=_RAIZ_?>documentos/Guía interpretación KPISCuadro Mando Assistec_2026.pdf" target="_blank" rel="nofollow" class="menu-link d-flex align-items-center">
                                        <span class="menu-title flex-grow-1">Guía de interpretación</span>
                                    </a>
                                </li>
                                <li class="app-sidebar-menu-item">
                                    <a href="<?=_RAIZ_?>documentos/Guía entrada manual de datos.pdf" target="_blank" rel="nofollow" class="menu-link d-flex align-items-center">
                                        <span class="menu-title flex-grow-1">Guía de entrada de datos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <a href="https://assistec.es/club-re-evolution/" class="btn btn-sm btn-secondary w-100">Volver a Assitec</a>
                </div>
                <!-- app sidebar menu end -->
            </div>

        </div>
        <!-- app sidebar end -->

        <!-- app header start -->
        <div class="app-header bg-card py-2 px-4 px-md-6 d-flex align-items-center noprint">
            <div class="row align-items-center w-100 gx-0">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-4 col-3">
                    <div class="app-header-left d-flex align-items-center">
                        <button type="button" class="app-header-bar-btn app-sidebar-open-btn me-4 d-none d-xl-inline-block">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <button type="button" class="app-header-bar-btn app-sidebar-mobile-open d-xl-none me-4">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-8 col-9">
                    <ul class="navbar-nav flex-row align-items-center justify-content-end">
                        <!-- Style switcher -->
                        <li class="header-nav-item header-style-switcher me-2">
                            <a class="header-nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <span class="d-flex align-items-center justify-content-center theme-icon light-icon">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.75 0.75V1.98077M8.75 15.5192V16.75M16.75 8.75H15.5192M1.98077 8.75H0.75M14.4115 3.08846L13.5377 3.96231M3.96231 13.5377L3.08846 14.4115M14.4115 14.4115L13.5377 13.5377M3.96231 3.96231L3.08846 3.08846M12.75 8.75C12.75 10.9591 10.9591 12.75 8.75 12.75C6.54086 12.75 4.75 10.9591 4.75 8.75C4.75 6.54086 6.54086 4.75 8.75 4.75C10.9591 4.75 12.75 6.54086 12.75 8.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                <span class="d-flex align-items-center justify-content-center theme-icon dark-icon">
                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.7075 10.73C10.5458 10.7229 9.40692 10.407 8.4076 9.81463C7.40829 9.22228 6.58449 8.37482 6.02067 7.35913C5.45685 6.34345 5.17331 5.19609 5.1991 4.03469C5.22489 2.8733 5.5591 1.73965 6.16745 0.75C4.56463 1.03138 3.12395 1.89934 2.12605 3.1848C1.12815 4.47026 0.644493 6.08116 0.769304 7.7037C0.894115 9.32624 1.61845 10.8442 2.80121 11.9619C3.98397 13.0797 5.54045 13.7171 7.16745 13.75C8.28058 13.7528 9.37555 13.468 10.3462 12.9231C11.3168 12.3782 12.1302 11.5918 12.7075 10.64C12.3768 10.6946 12.0425 10.7247 11.7075 10.73V10.73Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                <span class="d-flex align-items-center justify-content-center theme-icon auto-icon">
                                        <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.25 9.75L5.25 12.25M8.25 9.75L9.25 12.25M4.25 12.25H10.25M1.25 0.75H13.25C13.5261 0.75 13.75 0.973858 13.75 1.25V9.25C13.75 9.52614 13.5261 9.75 13.25 9.75H1.25C0.973858 9.75 0.75 9.52614 0.75 9.25V1.25C0.75 0.973858 0.973858 0.75 1.25 0.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0);" data-bs-theme-value="light">
                                            <span>
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.25 0.75V1.75M7.25 12.75V13.75M13.75 7.25H12.75M1.75 7.25H0.75M11.85 2.65L11.14 3.36M3.36 11.14L2.65 11.85M11.85 11.85L11.14 11.14M3.36 3.36L2.65 2.65M10.5 7.25C10.5 9.04493 9.04493 10.5 7.25 10.5C5.45507 10.5 4 9.04493 4 7.25C4 5.45507 5.45507 4 7.25 4C9.04493 4 10.5 5.45507 10.5 7.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        Light
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0);" data-bs-theme-value="dark">
                                            <span>
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.7075 10.73C10.5458 10.7229 9.40692 10.407 8.4076 9.81463C7.40829 9.22228 6.58449 8.37482 6.02067 7.35913C5.45685 6.34345 5.17331 5.19609 5.1991 4.03469C5.22489 2.8733 5.5591 1.73965 6.16745 0.75C4.56463 1.03138 3.12395 1.89934 2.12605 3.1848C1.12815 4.47026 0.644493 6.08116 0.769304 7.7037C0.894115 9.32624 1.61845 10.8442 2.80121 11.9619C3.98397 13.0797 5.54045 13.7171 7.16745 13.75C8.28058 13.7528 9.37555 13.468 10.3462 12.9231C11.3168 12.3782 12.1302 11.5918 12.7075 10.64C12.3768 10.6946 12.0425 10.7247 11.7075 10.73V10.73Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        Dark
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0);" data-bs-theme-value="auto">
                                            <span>
                                                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.25 9.75L5.25 12.25M8.25 9.75L9.25 12.25M4.25 12.25H10.25M1.25 0.75H13.25C13.5261 0.75 13.75 0.973858 13.75 1.25V9.25C13.75 9.52614 13.5261 9.75 13.25 9.75H1.25C0.973858 9.75 0.75 9.52614 0.75 9.25V1.25C0.75 0.973858 0.973858 0.75 1.25 0.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        System
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Style switcher -->

                        <!-- User Options -->
                        <li class="header-nav-item header-user me-2">
                            <a class="header-nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg py-0">
                                <div class="dropdown-header d-flex align-items-center border-bottom py-4">
                                    <div class="flex-grow-1 text-start">
                                        <h6 class="mb-0"><?=dato_taller('ta_nombre', $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'])?></h6>
                                    </div>
                                </div>
                                <div class="dropdown-body py-1">
                                    <ul class="list-unstyled dropdown-list">
                                        <li>
                                            <a class="dropdown-item fz-14px d-flex align-items-center gap-2 px-5" href="https://assistec.es/mi-cuenta/">
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.92999 7.25C8.72492 7.25 10.18 5.79493 10.18 4C10.18 2.20507 8.72492 0.75 6.92999 0.75C5.13507 0.75 3.67999 2.20507 3.67999 4C3.67999 5.79493 5.13507 7.25 6.92999 7.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M13.11 13.75C12.6902 12.4408 11.8655 11.2988 10.7548 10.4886C9.64409 9.6784 8.3048 9.24182 6.93 9.24182C5.5552 9.24182 4.21591 9.6784 3.10522 10.4886C1.99453 11.2988 1.16982 12.4408 0.75 13.75H13.11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Mi cuenta
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item fz-14px d-flex align-items-center gap-2 px-5" href="https://assistec.es/mi-cuenta/subscriptions/">
                                                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.75 7.55C0.75 4.54314 0.75 3.03971 1.64488 2.03596C1.78801 1.87542 1.94576 1.72695 2.11634 1.59224C3.18281 0.75 4.78021 0.75 7.975 0.75H10.525C13.7198 0.75 15.3172 0.75 16.3837 1.59224C16.5542 1.72695 16.712 1.87542 16.8551 2.03596C17.75 3.03971 17.75 4.54314 17.75 7.55C17.75 10.5569 17.75 12.0603 16.8551 13.064C16.712 13.2246 16.5542 13.373 16.3837 13.5078C15.3172 14.35 13.7198 14.35 10.525 14.35H7.975C4.78021 14.35 3.18281 14.35 2.11634 13.5078C1.94576 13.373 1.78801 13.2246 1.64488 13.064C0.75 12.0603 0.75 10.5569 0.75 7.55Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M7.54993 10.9501H8.82493" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M11.375 10.9501L14.35 10.9501" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M0.75 5H17.75" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                                </svg>
                                                Mi suscripción
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item fz-14px d-flex align-items-center gap-2 px-5" href="https://assistec.es/club-re-evolution/">
                                                <i class="bi bi-speedometer2"></i>
                                                Club Re-Evolution
                                            </a>
                                        </li>
                                        <li class=" dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item fz-14px d-flex align-items-center gap-2 px-5" href="<?=_RAIZ_?>salir.php">
                                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.75 12.9375C10.6887 14.4808 9.40258 15.7912 7.6797 15.749C7.27887 15.7392 6.78344 15.5995 5.7926 15.32C3.40801 14.6474 1.33796 13.517 0.841296 10.9846C0.75 10.5191 0.75 9.99532 0.75 8.94771L0.75 7.55229C0.75 6.50468 0.75 5.98087 0.841296 5.51538C1.33796 2.98304 3.40801 1.85263 5.7926 1.18002C6.78345 0.900537 7.27887 0.760795 7.6797 0.750989C9.40257 0.708841 10.6887 2.01923 10.75 3.56251" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                    <path d="M15.7499 8.25008H6.58325M15.7499 8.25008C15.7499 7.66656 14.088 6.57636 13.6666 6.16675M15.7499 8.25008C15.7499 8.8336 14.088 9.92381 13.6666 10.3334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Salir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- User Options -->

                    </ul>
                </div>
            </div>
        </div>
        <!-- app header end -->

        <!-- app content start -->
        <div class="app-content-wrapper pt-6 pb-6 px-1 px-md-5 keep-with-next">

            <div class="container-fluid">

                <div class="page-header pb-7 noprint">
                    <h2 class="fw-semibold fs-5">
                        <i class="<?=modulo_ico($m)?>"></i>
                        <?=$nombreModulo?>
                        <?=$seccion !== '' ? ' - ' . nom_seccion($seccion) : ''?>
                    </h2>
                    <?php if($nombreModulo == 'Dashboard'){?>
                    <button type="button" id="btn-open-print" class="btn btn-secondary btn-sm noprint w-auto" onclick="window.print();">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        Imprimir
                    </button>
                    <?php }?>
                </div> <!-- breadcrumb end -->

                <div class="page-content" style="max-width: 1300px; margin-left: auto; margin-right: auto;">
                    <?php include('pages/'.$m.'.php');?>
                </div><!-- page content end -->

            </div>
        </div><!-- app content end -->
        <footer class="app-footer mt-auto py-3 text-center noprint">
            <div class="container">
                    <span class="text-muted">Assistec Copyright ©
                        <span id="footer-year"></span> Todos los derechos reservados
                    </span>
            </div>
        </footer>

        <div class="app-backdrop"></div>
        <!-- app content end -->
    </div>
    <!-- app wrapper end -->
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://kit.fontawesome.com/32bd572711.js" crossorigin="anonymous"></script>

<!-- global js scripts for all pages -->
<script src="<?=_RAIZ_?>theme/assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?=_RAIZ_?>js/jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>
<script src="<?=_RAIZ_?>js/alertify/alertify.js" type="text/javascript"></script>
<script src="<?=_RAIZ_?>theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?=_RAIZ_?>theme/assets/js/bootstrap.js"></script>

<!-- app js -->
<script src="<?=_RAIZ_?>theme/assets/js/conca-sidebar.js"></script>
<script src="<?=_RAIZ_?>theme/assets/js/conca.js?v=<?=time()?>"></script>

<script src="<?=_RAIZ_?>js/funciones.js?v=<?=time()?>" type="text/javascript"></script>

<?php
$jsSession                      = json_encode($_SESSION['datos_'._ID_PAG_]['datos_user']);
$tallerSessionInfo              = json_encode($_SESSION['datos_'._ID_PAG_]['tallerSessionInfo']);
$tallerSessionActividad         = json_encode($_SESSION['datos_'._ID_PAG_]['tallerSessionActividad']);
$tallerSessionPersonal          = json_encode($_SESSION['datos_'._ID_PAG_]['tallerSessionPersonal']);
$tallerSessionEquipamientos     = json_encode($_SESSION['datos_'._ID_PAG_]['tallerSessionEquipamientos']);
$tallerSessionGastos            = json_encode($_SESSION['datos_'._ID_PAG_]['tallerSessionGastos']);
$tallerSessionDatosMes          = json_encode($_SESSION['datos_'._ID_PAG_]['tallerSessionDatosMes']);
?>
<script>
    (function(){
        // JSON seguro generado por PHP
        const sessionData = <?= $jsSession ?>;
        const tallerSessionInfo = <?= $tallerSessionInfo ?>;
        const tallerSessionActividad = <?= $tallerSessionActividad ?>;
        const tallerSessionPersonal = <?= $tallerSessionPersonal ?>;
        const tallerSessionEquipamientos = <?= $tallerSessionEquipamientos ?>;
        const tallerSessionGastos = <?= $tallerSessionGastos ?>;
        const tallerSessionDatosMes = <?= $tallerSessionDatosMes ?>;
        // Guardar en sessionStorage como string
        sessionStorage.setItem('appSession', JSON.stringify(sessionData));
        sessionStorage.setItem('tallerSessionInfo', JSON.stringify(tallerSessionInfo));
        sessionStorage.setItem('tallerSessionActividad', JSON.stringify(tallerSessionActividad));
        sessionStorage.setItem('tallerSessionPersonal', JSON.stringify(tallerSessionPersonal));
        sessionStorage.setItem('tallerSessionEquipamientos', JSON.stringify(tallerSessionEquipamientos));
        sessionStorage.setItem('tallerSessionGastos', JSON.stringify(tallerSessionGastos));
        sessionStorage.setItem('tallerSessionDatosMes', JSON.stringify(tallerSessionDatosMes));
    })();
</script>
<?php include_javascript();?>

<?php if(file_exists(_PATH_.'includes/js_'.$m.'.php')){
    include_once(_PATH_.'includes/js_'.$m.'.php');
}

// Mostramos alertify de errores
if (isset($jsHayerrores)) {
    if($jsHayerrores === 1) {
        ?>
        <script>
            $(document).ready(function() {
                alertify.error("<?=empty($jsMensaje) ? "No se ha podido guardar" : $jsMensaje?>");
            });
        </script>
    <?php }
 else {
        ?>
        <script>
            $(document).ready(function() {
                alertify.success("<?=$jsMensaje?>");
            });
        </script>
    <?php }
    }?>

</body>
</html>