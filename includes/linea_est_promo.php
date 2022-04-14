<span class="dato_hist" style="color:#<?=$pr_durpromo!=0?'C03':'3C0'?>" title="<?=$pr_durpromo==0?'Promoci&oacute;n aplicada':($pr_tipo==1?'Le quedan '.$pr_durpromo.' mesualidades gratis':'No se le ha enviado el obsequio')?>"><?=$pr_nombre?></span>
<?php if($pr_tipo==2){?>
<img src="<?=_RAIZ_?>imagenes/<?=$pr_durpromo==0?1:0?>.png" style="float:right; margin-top:5px; cursor:pointer" title="<?=$pr_durpromo==0?'Marcar como no enviado':'Marcar como enviado'?>" onclick="cambia_est_promo('<?=$pr_idtaller?>','<?=$pr_durpromo?>')" >
<?php }?>