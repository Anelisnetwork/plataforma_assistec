
<div class="cont_seccion">
	<a href="<?=_RAIZ_.'talleres/'?>" class="ini_cuad_datos" style="margin-left:0px;">
        <span class="texto_b fs_16 ubuntu">TALLERES<br />REGISTRADOS</span>
        <div class="totales">
        	<?php
			$total_talleres=count(dame_talleres_tipo());
			$fs=in_array($total_talleres, range(0, 9999))?50:(in_array($total_talleres, range(10000, 99999))?36:(in_array($total_talleres, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_talleres?>" data-speed="1000"></span>
        </div>
    </a>
    
    <a href="<?=_RAIZ_.'talleres/tipo/red_de_talleres/'?>" class="ini_cuad_datos">
        <span class="texto_b fs_16 ubuntu">RED DE<br />TALLERES</span>
        <div class="totales">
        	<?php
			$total_talleres=count(dame_talleres_tipo(2));
			$fs=in_array($total_talleres, range(0, 9999))?50:(in_array($total_talleres, range(10000, 99999))?36:(in_array($total_talleres, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_talleres?>" data-speed="1000"></span>
        </div>
    </a>
    
    <a href="<?=_RAIZ_.'usuarios/estado/activos/'?>" class="ini_cuad_datos">
        <span class="texto_b fs_16 ubuntu">USUARIOS<br />ACTIVOS</span>
        <div class="totales">
        	<?php
			$total_usuarios=count(dame_usuarios_activos());
			$fs=in_array($total_usuarios, range(0, 9999))?50:(in_array($total_usuarios, range(10000, 99999))?36:(in_array($total_usuarios, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_usuarios?>" data-speed="1000"></span>
        </div>
    </a>
    
    <a href="<?=_RAIZ_.'usuarios/estado/inactivos/'?>" class="ini_cuad_datos">
        <span class="texto_b fs_16 ubuntu">USUARIOS<br />INACTIVOS</span>
        <div class="totales">
        	<?php
			$total_usuarios=count(dame_usuarios_activos(3));
			$fs=in_array($total_usuarios, range(0, 9999))?50:(in_array($total_usuarios, range(10000, 99999))?36:(in_array($total_usuarios, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_usuarios?>" data-speed="1000"></span>
        </div>
    </a>
    
    <a href="<?=_RAIZ_.'usuarios/estado/pendientes_de_datos/'?>" class="ini_cuad_datos">
        <span class="texto_b fs_16 ubuntu">USUARIOS<br />PTE. DATOS</span>
        <div class="totales">
        	<?php
			$total_usuarios=count(dame_usuarios_activos(2));
			$fs=in_array($total_usuarios, range(0, 9999))?50:(in_array($total_usuarios, range(10000, 99999))?36:(in_array($total_usuarios, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_usuarios?>" data-speed="1000"></span>
        </div>
    </a>
    
    <a href="<?=_RAIZ_.'facturacion/'?>" class="ini_cuad_datos" style="background-color:#EF7F1F; margin-left:0px">
        <span class="texto_b fs_16 ubuntu">PAGOS<br />VENCIDOS</span>
        <div class="totales">
        	<?php
			$total_pagos=2;
			$fs=in_array($total_pagos, range(0, 9999))?50:(in_array($total_pagos, range(10000, 99999))?36:(in_array($total_pagos, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_pagos?>" data-speed="1000"></span>
        </div>
    </a>
    
    <a href="<?=_RAIZ_.'facturacion/'?>" class="ini_cuad_datos" style="background-color:#EF7F1F">
        <span class="texto_b fs_16 ubuntu">PENDIENTE<br />COBRO</span>
        <div class="totales">
        	<?php
			$total_pagos=2;
			$fs=in_array($total_pagos, range(0, 9999))?50:(in_array($total_pagos, range(10000, 99999))?36:(in_array($total_pagos, range(100000, 999999))?30:28))
			?>
        	<span class="timer texto_r fs_50" style="font-size:<?=$fs?>px" data-from="0" data-to="<?=$total_pagos?>" data-speed="1000"></span>
        </div>
    </a>
</div>





<script>
$(document).ready(function() {
	$('.timer').countTo();
});
</script>