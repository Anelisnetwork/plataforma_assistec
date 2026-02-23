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

    ?>
    <div class="d-flex flex-column align-items-center justify-content-start w-100 p-2 p-sm-5">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100">
            <?php
            if (count($secciones) > 0 && isset($masget)) {
            ?>
            <div class="col col-12 col-sm-8 d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-start">
                <?php foreach ($secciones as $secc) {
                    ?>
                    <a href="<?= _RAIZ_ . $m . '/' . $secc->sc_url . $masget . '/' ?>"
                       title="<?= nom_seccion($secc->sc_url) ?>"
                       class="fs_16 w-100 w-sm-auto px-3 py-1 m-1 btn btn-outline-secondary <?= $secc->sc_url == $seccion ? ' active' : '' ?>"><?= nom_seccion($secc->sc_url) ?></a>
                <?php } ?>
            </div>
                <?php
            } ?>

            <div class="col col-12 col-sm-4 d-flex flex-column align-items-center justify-content-start align-items-sm-end">
                <?php if (count($anhos) == 0) { ?>
                    <span class="dato_hist">NO HAY MÁS DATOS</span>
                <?php } else {
                    ?>
                    <span class="oswald" style="float: left; margin-right: 10px">Seleccione período</span>
                    <select class="form-select w-auto form-select-sm d-inline-block"
                            onchange="window.location.href ='<?= _RAIZ_ ?>ratios_acumulados/<?= $seccion ?>/'+this.value+'/'">
                        <?php foreach ($anhos as $anho) { ?>
                            <option value="<?= $anho->da_ano ?>"<?= $anho->da_ano == $anho_acumulado ? ' selected' : '' ?>>
                                A&ntilde;o <?= $anho->da_ano ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </div>
        </div>
        <br clear="all"/>

        <div class="col col-12 d-flex flex-column flex-md-row align-items-center align-items-md-start" id="secc-<?= $seccion ?>">
            <?php include('pages/secc_' . $seccion . '.php'); ?>
        </div>
    </div>
<?php }
