
<div class="col col-12 d-flex flex-column align-items-start justify-content-between">
    <div class="col col-12 d-flex flex-row flex-wrap align-items-start justify-content-center">
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
            <a href="<?=_RAIZ_.'talleres/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-dark-subtle" >
                <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">TALLERES<br>REGISTRADOS</span>
                <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                    <?php
                    $total_talleres=count(dame_talleres_tipo());
                    $fs=in_array($total_talleres, range(0, 9999))?50:(in_array($total_talleres, range(10000, 99999))?36:(in_array($total_talleres, range(100000, 999999))?30:28))
                    ?>
                    <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_talleres?>" data-speed="1000"></span>
                </div>
            </a>
        </div>
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
        <a href="<?=_RAIZ_.'talleres/tipo/red_de_talleres/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-dark-subtle">
            <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">RED DE<br />TALLERES</span>
            <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                <?php
                $total_talleres=count(dame_talleres_tipo(2));
                $fs=in_array($total_talleres, range(0, 9999))?50:(in_array($total_talleres, range(10000, 99999))?36:(in_array($total_talleres, range(100000, 999999))?30:28))
                ?>
                <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_talleres?>" data-speed="1000"></span>
            </div>
        </a>
        </div>
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
        <a href="<?=_RAIZ_.'usuarios/estado/activos/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-dark-subtle">
            <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">USUARIOS<br />ACTIVOS</span>
            <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                <?php
                $total_usuarios=count(dame_usuarios_activos());
                $fs=in_array($total_usuarios, range(0, 9999))?50:(in_array($total_usuarios, range(10000, 99999))?36:(in_array($total_usuarios, range(100000, 999999))?30:28))
                ?>
                <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_usuarios?>" data-speed="1000"></span>
            </div>
        </a>
        </div>
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
        <a href="<?=_RAIZ_.'usuarios/estado/inactivos/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-dark-subtle">
            <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">USUARIOS<br />INACTIVOS</span>
            <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                <?php
                $total_usuarios=count(dame_usuarios_activos(3));
                $fs=in_array($total_usuarios, range(0, 9999))?50:(in_array($total_usuarios, range(10000, 99999))?36:(in_array($total_usuarios, range(100000, 999999))?30:28))
                ?>
                <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_usuarios?>" data-speed="1000"></span>
            </div>
        </a>
        </div>
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
        <a href="<?=_RAIZ_.'usuarios/estado/pendientes_de_datos/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-dark-subtle">
            <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">USUARIOS<br />PTE. DATOS</span>
            <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                <?php
                $total_usuarios=count(dame_usuarios_activos(2));
                $fs=in_array($total_usuarios, range(0, 9999))?50:(in_array($total_usuarios, range(10000, 99999))?36:(in_array($total_usuarios, range(100000, 999999))?30:28))
                ?>
                <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_usuarios?>" data-speed="1000"></span>
            </div>
        </a>
        </div>
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
        <a href="<?=_RAIZ_.'facturacion/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-secondary" style="background-color:#EF7F1F; margin-left:0px">
            <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">PAGOS<br />VENCIDOS</span>
            <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                <?php
                $total_pagos=2;
                $fs=in_array($total_pagos, range(0, 9999))?50:(in_array($total_pagos, range(10000, 99999))?36:(in_array($total_pagos, range(100000, 999999))?30:28))
                ?>
                <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_pagos?>" data-speed="1000"></span>
            </div>
        </a>
        </div>
        <div class="col col-12 col-sm-6 col-lg-4 d-flex flex-column align-items-center justify-content-center my-4">
        <a href="<?=_RAIZ_.'facturacion/'?>" class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 bg-secondary" style="background-color:#EF7F1F">
            <span class="fs_16 ubuntu d-flex flex-column align-items-center justify-content-center text-white text-center">PENDIENTE<br />COBRO</span>
            <div class="bg-white rounded-3 p-2 mt-3 d-flex flex-column align-items-center justify-content-center totales" style="width: 150px">
                <?php
                $total_pagos=2;
                $fs=in_array($total_pagos, range(0, 9999))?50:(in_array($total_pagos, range(10000, 99999))?36:(in_array($total_pagos, range(100000, 999999))?30:28))
                ?>
                <span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_pagos?>" data-speed="1000"></span>
            </div>
        </a>
        </div>
    </div>
</div>





<script>
$(document).ready(function() {
	$('.timer').countTo();
});
</script>