<?php
$idfactura=$contenido_de[2];
$idcli=$contenido_de[3];



if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idcli.'')==0||num_rows('select idfactura from facturas where idfactura='.$idfactura.' and idcli='.$idcli.'')==0){
	//echo de__($contenido).'<br>';
	//echo $idfactura.'<br>';
	exit('Datos incorrectos');
}

$datos_fac=fetch_array('select * from facturas where idfactura='.$idfactura.' and idcli="'.$idcli.'"');

$lineas=list_object('select * from facturas_linea where fl_idfactura='.$idfactura.'');

$desglose_fecha=exp_fecha_hora($datos_fac['fecha_emision']);

$valor_iva=valor_iva($datos_fac['tipo_iva']);
$imp_iva=$datos_fac['base_imponible']*$valor_iva/100;
$imp_re=$datos_fac['retiene']!=0?$datos_fac['retiene']*5.2/100:0;

$nombre_archivo='Factura_Assistec_'.$datos_fac['idfactura']>11?'ACM-'.$datos_fac['nfactura']:$datos_fac['nfactura'];
?>

<style>

*{
	color:#555;
}
td {
   padding:0; margin:0;
}
tr {
   padding:0; margin:0;
}
</style>

<?php
$max_nlin=17;//Máximo de líneas de factura por página

$fac_nlin=count($lineas);//Número de líneas de la factura

$tot_nlin=0;//Total de líneas escritas

$npag=1;//Número de página

while($fac_nlin-$tot_nlin>0){
$pag_nlin=0;
?>

<page backtop="116mm" backbottom="60mm" backleft="0mm" backright="0mm" backimg="<?=_PATH_?>imagenes/bg_pdf.jpg" backimgx="left" backimgy="bottom" backimgw="500px" style="font-family:Arial; font-size:14px;">

    <page_header backbottom="0mm">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
        	<tr>
            	<td>
                	<img src="<?=_PATH_?>imagenes/bg_top_fra.jpg" />
                </td>
            </tr>
        </table>
        <table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
            	<td width="300" valign="top">
                	<img src="<?=_PATH_?>imagenes/assistec_pdf.png" style="margin-top:25px" />
                </td>
                <td width="220">
                	<div style="line-height:130%;">
                        <strong><span style="color:#000"><?=$datos_fac['emisor_nombre']?></span></strong><br />
                        <strong>NIF: <?=$datos_fac['emisor_cif']?></strong>
                    </div>
                </td>
                <td width="200" valign="bottom">
                	<div style="line-height:150%; padding:0px 0px 0px 40px; float:right; border-left:1px solid #F00">
                        <?=$datos_fac['emisor_direccion']?><br />
                        <?=$datos_fac['emisor_cp']?> <?=$datos_fac['emisor_poblacion']?><br />
                        <?=$datos_fac['emisor_provincia']?><br /><br />
                        <strong><span style="color:#F00">T/</span></strong> <?=$datos_fac['emisor_telefono']?><br />
                        <strong><span style="color:#F00">E/</span></strong> <?=$datos_fac['emisor_correo']?><br />
                        <strong><span style="color:#F00">www.assistec.es</span></strong><br />
                    </div>
                </td>
            </tr>
        </table>
        
        <table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
            	<td colspan="3" style="height:50px">
                </td>
            </tr>
        	<tr>
            	<td width="320">
                </td>
                <td width="30">
                </td>
                <td width="320">
                	<strong><span style="color:#F00; font-size:16px">DATOS DEL CLIENTE</span></strong>
                </td>
            </tr>
            <tr>
            	<td colspan="3" style="height:10px">
                </td>
            </tr>
            <tr>
            	<td width="320">
                	<table width="320" border="0" cellspacing="0" cellpadding="0" align="left">
                    	<tr>
                        	<td width="100">
                            	<div style="text-align:center">
                                	<strong><span style="color:#F00; font-size:18px">FACTURA</span></strong>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="170">
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3" style="height:10px">
                            </td>
                        </tr>
                        <tr>
                        	<td width="100">
                            	<div style="padding:5px; border:1px solid #F00; text-align:right; height:14px">
                                	<span style="color:#F00">Nº Factura</span>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="170">
                            	<div style="padding:5px; border:1px solid #222; text-align:right; height:14px; -moz-border-radius: 0px 12px 12px 0px; -webkit-border-radius: 0px 12px 12px 0px; border-radius: 0px 12px 12px 0px;">
                                	<strong><span style="color:#222"><?=$datos_fac['idfactura']>11?'ACM-'.$datos_fac['nfactura']:$datos_fac['nfactura']?></span></strong>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3" style="height:3px">
                            </td>
                        </tr>
                        <tr>
                        	<td width="100">
                            	<div style="padding:5px; border:1px solid #F00; text-align:right; height:14px">
                                	<span style="color:#F00">Fecha</span>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="170">
                            	<div style="padding:5px; border:1px solid #222; text-align:right; height:14px; -moz-border-radius: 0px 12px 12px 0px; -webkit-border-radius: 0px 12px 12px 0px; border-radius: 0px 12px 12px 0px;">
                                	<span style="color:#222; font-size:12px"><?=$desglose_fecha['dia'].' de '.nom_mes(intval($desglose_fecha['mes'])).' de '.$desglose_fecha['anho']?></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="30">
                </td>
                <td width="320">
                	<table width="320" border="0" cellspacing="0" cellpadding="0" align="center">
                    	<tr>
                        	<td>
                            	<div style="line-height:150%; padding:10px; border:1px solid #333; -moz-border-radius: 0px 0px 20px 0px; -webkit-border-radius: 0px 0px 20px 0px; border-radius: 0px 0px 20px 0px;">
                                	<strong><?=$datos_fac['cliente_nombre']?><br />
                                    A/A <?=$datos_fac['cliente_contacto']?></strong><br />
                                    <?=$datos_fac['cliente_direccion']?><br />
                                    <?=$datos_fac['cliente_cp']?> <?=$datos_fac['cliente_poblacion']?> (<?=$datos_fac['cliente_provincia']?>)<br />
                                    CIF.: <?=$datos_fac['cliente_cif']?><br />
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
                <td colspan="6" style="height:15px">
                </td>
            </tr>
            <tr>
                <td width="65">
                    <div style="height:16px; width:53px; padding:5px; text-align:center; border:1px solid #555; border-right:1px dotted #333; -moz-border-radius: 10px 0px 0px 0px; -webkit-border-radius: 10px 0px 0px 0px; border-radius: 10px 0px 0px 0px;">
                        <span style="font-size:14px">Ref.</span>
                    </div>
                </td>
                <td width="340">
                    <div style="height:16px; width:328px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333">
                        <span style="font-size:14px">Concepto</span>
                    </div>
                </td>
                <td width="45">
                    <div style="height:16px; width:33px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333"">
                        <span style="font-size:14px">Cant.</span>
                    </div>
                </td>
                <td width="70">
                    <div style="height:16px; width:58px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333">
                        <span style="font-size:14px">Precio</span>
                    </div>
                </td>
                <td width="55">
                    <div style="height:16px; width:43px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333"">
                        <span style="font-size:14px">Dto.<span style="font-size:10px">(%)</span></span>
                    </div>
                </td>
                <td width="95">
                    <div style="height:16px; width:83px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; -moz-border-radius: 0px 10px 0px 0px; -webkit-border-radius: 0px 10px 0px 0px; border-radius: 0px 10px 0px 0px;">
                        <span style="font-size:14px">Importe</span>
                    </div>
                </td>
            </tr>
        </table>
    </page_header>
    
    <page_footer>
    	<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
            	<td width="400" align="left">
                	<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
                    	<tr>
                        	<td align="left">
                            	<div style="padding:5px 10px">
                            		<strong><span style="color:#F00; font-size:16px">Observaciones</span></strong>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        	<td align="left">
                            	<div style="line-height:150%; padding:10px; height:80px; border:1px solid #333; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;">
                                	<span style="font-size:12px"><?=nl2br(u8d_($datos_fac['observaciones']))?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        	<td style="height:15px">
                            </td>
                        </tr>
                        <tr>
                        	<td align="justify">
                            	<div style="line-height:120%; text-align:justify">
                                	<span style="color:#999; font-size:10px; text-align:justify">ASSISTEC en cumplimiento de la LOPD 15/1999 de 13 de Diciembre informa que los datos personales que constan en el presente documento han sido incorporados a un fichero de clientes/proveedores registrado en la Agencia Española de Protección de Datos, del que somos responsables y que tiene la finalidad de gestionar las relaciones comerciales. Tiene la posibilidad de ejercitar el derecho de acceso, recitificación, cancelación y oposición dirigiéndose a Gran Vía Corts Catalanes, 1099, Planta 2 – Puerta 1, 08020 Barcelona (Barcelona).</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50">
                </td>
                <td width="220" valign="top">
                <?php if($fac_nlin-$tot_nlin>$max_nlin){?>
                	<table width="220" border="0" cellspacing="0" cellpadding="0" align="center">
                    	<tr>
                            <td style="height:27px">
                            </td>
                        </tr>
                        <tr>
                            <td>
                            	<div style="line-height:120%; text-align:center">
                                    <span style="color:#444; font-size:16px;">SUMA Y SIGUE...</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                <?php }
				else{?>
                	<table width="220" border="0" cellspacing="0" cellpadding="0" align="center">
                    	<tr>
                            <td colspan="3" style="height:27px">
                            </td>
                        </tr>
                    	<tr>
                        	<td width="100">
                            	<div style="text-align:right; padding:5px 10px; width:78px; height:14px; border:1px solid #333">
                                	<span style="font-size:14px;">Base:</span>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="110">
                            	<div style="text-align:right; padding:5px 10px; width:88px; height:14px; border:1px solid #333; -moz-border-radius: 0px 12px 12px 0px; -webkit-border-radius: 0px 12px 12px 0px; border-radius: 0px 12px 12px 0px;">
                                	<span style="font-size:14px;"><?=moneda_puntocoma($datos_fac['base_imponible'])?> €</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="height:5px">
                            </td>
                        </tr>
                        <tr>
                        	<td width="100">
                            	<div style="text-align:right; padding:5px 10px; width:78px; height:14px; border:1px solid #333">
                                	<span style="font-size:14px;">IVA:</span>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="110">
                            	<div style="text-align:right; padding:5px 10px; width:88px; height:14px; border:1px solid #333; -moz-border-radius: 0px 12px 12px 0px; -webkit-border-radius: 0px 12px 12px 0px; border-radius: 0px 12px 12px 0px;">
                                	<span style="font-size:14px;"><?=moneda_puntocoma($imp_iva)?> €</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="height:5px">
                            </td>
                        </tr>
                        <?php if($datos_fac['retiene']!=0){?>
                        <tr>
                        	<td width="100">
                            	<div style="text-align:right; padding:5px 10px; width:78px; height:14px; border:1px solid #333">
                                	<span style="font-size:14px;">R.E.:</span>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="110">
                            	<div style="text-align:right; padding:5px 10px; width:88px; height:14px; border:1px solid #333; -moz-border-radius: 0px 12px 12px 0px; -webkit-border-radius: 0px 12px 12px 0px; border-radius: 0px 12px 12px 0px;">
                                	<span style="font-size:14px;"><?=moneda_puntocoma($imp_re)?> €</span>
                                </div>
                            </td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td colspan="3" style="height:10px">
                            </td>
                        </tr>
                        <tr>
                        	<td width="100">
                            	<div style="text-align:right; padding:5px 10px; width:78px; height:14px; border:1px solid #F00">
                                	<strong><span style="font-size:14px; color:#F00">TOTAL:</span></strong>
                                </div>
                            </td>
                            <td width="10">
                            </td>
                            <td width="110">
                            	<div style="text-align:right; padding:5px 10px; width:88px; height:14px; border:1px solid #F00; -moz-border-radius: 0px 12px 12px 0px; -webkit-border-radius: 0px 12px 12px 0px; border-radius: 0px 12px 12px 0px;">
                                	<strong><span style="font-size:14px; color:#F00"><?=moneda_puntocoma($datos_fac['importe'])?> €</span></strong>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="height:25px">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                            Cuenta de ingreso: (IBAN)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                            <strong>ES35 0081 0074 4300 0173 7181</strong>
                            </td>
                        </tr>
                    </table>
                <?php }?>
                </td>
            </tr>
        </table>
        
    	<table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr>
            	<td width="720" align="right">
                	[[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
    
    <table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
    <?php for($n=$tot_nlin; $n<$fac_nlin&&$n<$max_nlin*$npag; $n++){?>
        <tr<?=$n%2!=0?' style="background-color:#e5e5e5"':''?>>
            <td width="65">
                <div style="height:14px; width:53px; padding:5px; text-align:left; border:1px solid #555; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"><?=$lineas[$n]->fl_referencia?></span>
                </div>
            </td>
            <td width="340">
                <div style="height:14px; width:328px; padding:5px; text-align:left; border:1px solid #555; border-left:0px; border-right:1px dotted #333; overflow:hidden; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"><?=$lineas[$n]->fl_concepto?></span>
                </div>
            </td>
            <td width="45">
                <div style="height:14px; width:33px; padding:5px; text-align:right; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"><?=$lineas[$n]->fl_cantidad?></span>
                </div>
            </td>
            <td width="70">
                <div style="height:14px; width:58px; padding:5px; text-align:right; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"><?=moneda_puntocoma($lineas[$n]->fl_preciou)?></span>
                </div>
            </td>
            <td width="55">
                <div style="height:14px; width:43px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"><?=moneda_puntocoma($lineas[$n]->fl_dto)?></span>
                </div>
            </td>
            <td width="95">
                <div style="height:14px; width:83px; padding:5px; text-align:right; border:1px solid #555; border-left:0px; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"><?=moneda_puntocoma($lineas[$n]->fl_importe)?></span>
                </div>
            </td>
        </tr>
    <?php $pag_nlin++;}?>
    <?php while($pag_nlin<$max_nlin){?>
        <tr<?=$n%2!=0?' style="background-color:#e5e5e5"':''?>>
            <td width="65">
                <div style="height:14px; width:53px; padding:5px; text-align:left; border:1px solid #555; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"></span>
                </div>
            </td>
            <td width="340">
                <div style="height:14px; width:328px; padding:5px; text-align:left; border:1px solid #555; border-left:0px; border-right:1px dotted #333; overflow:hidden; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"></span>
                </div>
            </td>
            <td width="45">
                <div style="height:14px; width:33px; padding:5px; text-align:right; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"></span>
                </div>
            </td>
            <td width="70">
                <div style="height:14px; width:58px; padding:5px; text-align:right; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"></span>
                </div>
            </td>
            <td width="55">
                <div style="height:14px; width:43px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"></span>
                </div>
            </td>
            <td width="95">
                <div style="height:14px; width:83px; padding:5px; text-align:right; border:1px solid #555; border-left:0px; border-bottom:0px; border-top:0px">
                    <span style="font-size:12px"></span>
                </div>
            </td>
        </tr>
    <?php $pag_nlin++;$n++;}?>
        <tr>
            <td width="65">
                <div style="height:1px; width:53px; padding:5px; text-align:center; border:1px solid #555; border-right:1px dotted #333; -moz-border-radius: 0px 0px 0px 10px; -webkit-border-radius: 0px 0px 0px 10px; border-radius: 0px 0px 0px 10px; border-top:0px">
                </div>
            </td>
            <td width="340">
                <div style="height:1px; width:328px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-top:0px">
                </div>
            </td>
            <td width="45">
                <div style="height:1px; width:33px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-top:0px">
                </div>
            </td>
            <td width="70">
                <div style="height:1px; width:58px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-top:0px">
                </div>
            </td>
            <td width="55">
                <div style="height:1px; width:43px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; border-right:1px dotted #333; border-top:0px">
                </div>
            </td>
            <td width="95">
                <div style="height:1px; width:83px; padding:5px; text-align:center; border:1px solid #555; border-left:0px; -moz-border-radius: 0px 0px 10px 0px; -webkit-border-radius: 0px 0px 10px 0px; border-radius: 0px 0px 10px 0px; border-top:0px">
                </div>
            </td>
        </tr>
    </table>
</page>

<?php $tot_nlin+=$pag_nlin; $npag++;}
?>