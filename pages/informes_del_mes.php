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

    include('pages/secc_' . $seccion . '_data.php');

?>
    <div class="row g-3 mt-1">
        <div class="col">
            <div class="card shadow-custom rounded-custom">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-7">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="col-12 col-sm-6">
                            <h3 class="card-title d-flex align-items-center m-0">
                                <?=isset($dato_mensual[0])?nom_mes($dato_mensual[0]->da_mes)." de ".$dato_mensual[0]->da_ano : "No hay informe"?>
                            </h3>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-between justify-content-sm-end">
                            <span class="fs_12 me-2 text-nowrap">Seleccione mes</span>
                            <select class="form-select form-select-sm w-auto d-inline-block"
                                    onchange="window.location.href ='<?= _RAIZ_ ?>informes_del_mes/<?= $seccion ?>/'+this.value+'/'">
                                <?php foreach ($datos_guardados as $dato_guardado) { ?>
                                    <option value="<?= $dato_guardado->da_mes . '/' . $dato_guardado->da_ano ?>"<?= (nom_mes($dato_mensual[0]->da_mes) . ' ' . $dato_mensual[0]->da_ano) == (nom_mes($dato_guardado->da_mes) . ' ' . $dato_guardado->da_ano) ? ' selected' : '' ?>><?= nom_mes($dato_guardado->da_mes) . ' ' . $dato_guardado->da_ano ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-6 position-relative z-1">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-12 d-flex align-items-start justify-content-center mb-4">
                            <?php include('pages/secc_' . $seccion . '.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>