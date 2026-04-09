<?php
$dato_mensual = ultimo_dato();
$iddato = isset($dato_mensual[0]->da_iddato) ? $dato_mensual[0]->da_iddato : '';
$datos_guardados = [];
$anhos = [];
$datos_acumulados = dame_acumulado(date('Y'));

if ($iddato == '' || $iddato == NULL) {
    ?>

    <div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">Todav&iacute;a no existen datos para elaborar un informe</span>
    </div>

<?php } else {
    $anhos = dame_anhos();

    $anho_acumulado = $dato_mensual[0]->da_ano;


    $datos_guardados = datos_guardados();

    if (isset($_GET['anho'])) {
        num_rows('select da_iddato from datos_actividad where da_ano=' . clean_get('anho') . ' and da_idtipo=1') <= 0 ? '' : $anho_acumulado = clean_get('anho');
    }

    $datos_acumulados = dame_acumulado($anho_acumulado);

    $alano = $anho_acumulado;
    $masget = $alano != '' ? '/' . $alano : '';

    $iddato = $dato_mensual[0]->da_iddato;

    $porcentajes = personal_porcentaje($_SESSION['datos_' . _ID_PAG_]['datos_user']['idtaller']);

    include('pages/secc_' . $seccion . '_data.php');

    ?>

    <div class="row g-3 mt-1">
        <div class="col">
            <div class="card shadow-custom rounded-custom">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="col-12 col-sm-6">
                            <h3 class="card-title d-flex align-items-center m-0">
                                <?=isset($anho_acumulado)?"Año ".$anho_acumulado : "No hay informe"?>
                            </h3>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <span class="fs_12 me-2 text-nowrap">Seleccione año</span>
                            <select class="form-select form-select-sm w-auto d-inline-block"
                                    onchange="window.location.href ='<?= _RAIZ_ ?>ratios_acumulados/<?= $seccion ?>/'+this.value+'/'">
                                <?php foreach ($anhos as $anho) { ?>
                                    <option value="<?= $anho->da_ano ?>"<?= $anho->da_ano == $anho_acumulado ? ' selected' : '' ?>>
                                       <?= $anho->da_ano ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-6 position-relative z-1">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-12 d-flex flex-column flex-md-row align-items-start justify-content-center mb-4">
                            <?php include('pages/secc_' . $seccion . '.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
