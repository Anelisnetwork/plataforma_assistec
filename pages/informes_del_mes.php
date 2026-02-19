<?php
$dato_mensual = ultimo_dato();
$iddato = isset($dato_mensual[0]->da_iddato) ? $dato_mensual[0]->da_iddato : '';
$datos_guardados = [];

if ($iddato == '' || $iddato == NULL){
    ?>

    <div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">Todav&iacute;a no existen datos para elaborar un informe</span>
    </div>

<?php }
else{
$almes = $dato_mensual[0]->da_mes;
$alano = $dato_mensual[0]->da_ano;
$masget = $almes != '' && $alano != '' ? '/' . $almes . '/' . $alano : '';

$datos_guardados = datos_guardados();

if (isset($_GET['mes']) && isset($_GET['anho'])) {
    $dato_mes = datos_actividad(1, clean_get('mes'), clean_get('anho'));
    if (count($dato_mes) == 1) {
        $dato_mensual = $dato_mes;
        $almes = clean_get('mes');
        $alano = clean_get('anho');
        $masget = $almes != '' && $alano != '' ? '/' . $almes . '/' . $alano : '';
    }
}

$iddato = $dato_mensual[0]->da_iddato;

?>
<div class="d-flex flex-column align-items-center justify-content-start w-100 p-2 p-sm-5">
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between w-100">
        <?php
        if (count($secciones) > 0 && isset($masget)) {
            ?>
            <div class="col col-12 col-sm-6 d-flex flex-row align-items-center justify-content-center justify-content-sm-start">
                <?php foreach ($secciones as $secc) { ?>
                    <a href="<?= _RAIZ_ . $m . '/' . $secc->sc_url . $masget . '/' ?>"
                       title="<?= nom_seccion($secc->sc_url) ?>"
                       class="fs_16 px-3 py-1 m-1 btn btn-outline-secondary <?= $secc->sc_url == $seccion ? ' active' : '' ?>"><?= nom_seccion($secc->sc_url) ?></a>
                <?php } ?>
            </div>
            <?php
        } ?>

        <div class="col col-12 col-sm-6 d-flex flex-column align-items-center justify-content-start align-items-sm-end">
            <?php if (count($datos_guardados) == 0) { ?>
                <span class="dato_hist">NO HAY MÁS DATOS</span>
            <?php } else {
                ?>
                <span class="oswald">Seleccione mes</span>
                <select class="form-control form-control-sm w-auto d-inline-block"
                        onchange="window.location.href ='<?= _RAIZ_ ?>informes_del_mes/<?= $seccion ?>/'+this.value+'/'">
                    <?php foreach ($datos_guardados as $dato_guardado) { ?>
                        <option value="<?= $dato_guardado->da_mes . '/' . $dato_guardado->da_ano ?>"<?= (nom_mes($dato_mensual[0]->da_mes) . ' ' . $dato_mensual[0]->da_ano) == (nom_mes($dato_guardado->da_mes) . ' ' . $dato_guardado->da_ano) ? ' selected' : '' ?>><?= nom_mes($dato_guardado->da_mes) . ' ' . $dato_guardado->da_ano ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
    </div>

    <br clear="all"/>

    <div class="col col-12 d-flex flex-column align-items-center align-items-sm-center" id="secc-<?= $seccion ?>">
        <?php include('pages/secc_' . $seccion . '.php'); ?>
    </div>
    <?php


    } ?>
</div>

