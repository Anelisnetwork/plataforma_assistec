<?php
$dato=clean_post('dato');
$datos=explode('%%',$dato);
$dato=$datos[0];
$dato2=isset($datos[1])?$datos[1]:'';
$dato3=isset($datos[2])?$datos[2]:0;
//$dato='eficacia';
if($dato=='ventas_mo_rec'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Ventas";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	
	$datos=list_object('select da_mes, da_ano, da_idtipo, (da_facturadomo+da_facturadorec) AS FACTURADO from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc limit 0, 6');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=$dato->da_idtipo==0?'Mes '.$dato->da_mes:substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
			$cell1["v"]=$dato->FACTURADO;
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}

else if($dato=='margen_rec'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Margen REC (%)";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	
	$datos=list_object('select da_mes, da_ano, da_idtipo, da_facturadorec, da_pagadoprovrec from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc limit 0, 6');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=$dato->da_idtipo==0?'Mes '.$dato->da_mes:substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
			$margen=$dato->da_pagadoprovrec>0?margen_sobre_coste($dato->da_pagadoprovrec, $dato->da_facturadorec):100;
			$cell1["v"]=number_format($margen, 2);
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}

else if($dato=='pvpentrada'){
    $idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
    $col1=array();
    $col1["id"]="";
    $col1["label"]="Meses";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="€ por entrada";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $resultado=array();

    $anho=$dato3;

    $datos=list_object('select da_mes, da_ano, da_idtipo, ((da_facturadomo+da_facturadorec+da_facturadootros)/da_entradastaller) AS EUROXENT from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc limit 0, 6');
    $n1=count($datos);
    if($n1>0){
        $datos=array_reverse($datos);
        foreach($datos as $dato){
            $cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
            $cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
            $cell1["v"]=round($dato->EUROXENT,2);
            $row["c"]=array($cell0,$cell1);
            array_push($resultado,$row);
        }
    }
    else{
        $resultado='';
    }
}

else if($dato=='eficacia'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Eficacia (%)";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	$datos=list_object('select da_iddato, da_mes, da_ano, da_idtipo, da_facturadomo, da_impmo from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc limit 0, 6');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=$dato->da_idtipo==0?'Mes '.$dato->da_mes:substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
			$hprod=horas_presencia($dato->da_iddato);
			$hfacturadas=$dato->da_facturadomo/$dato->da_impmo;
			$eficacia=porcentaje_($hfacturadas,$hprod);
			$cell1["v"]=number_format($eficacia, 2);
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}

else if($dato=='productividad'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Productividad (%)";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	$datos=list_object('select da_iddato, da_mes, da_ano, da_idtipo, da_horasfichadasor from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc limit 0, 6');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=$dato->da_idtipo==0?'Mes '.$dato->da_mes:substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
			$hprod=horas_presencia($dato->da_iddato);
			$productividad=porcentaje_($dato->da_horasfichadasor,$hprod);
			$cell1["v"]=number_format($productividad, 2);
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}

else if($dato=='rendimiento'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Rendimiento (%)";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	$datos=list_object('select da_iddato, da_mes, da_ano, da_idtipo, da_horasfichadasor, da_facturadomo, da_impmo from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' order by da_ano desc, da_mes desc limit 0, 6');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=$dato->da_idtipo==0?'Mes '.$dato->da_mes:substr(nom_mes($dato->da_mes), 0, 3).' '.$dato->da_ano;
			$hfacturadas=$dato->da_facturadomo/$dato->da_impmo;
			$rendimiento=porcentaje_($hfacturadas,$dato->da_horasfichadasor);
			$cell1["v"]=number_format($rendimiento, 2);
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}
else if($dato=='acum_econ_1'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Ingresos";
	$col2["pattern"]="";
	$col2["type"]="number";
	$col3=array();
	$col3["id"]="";
	$col3["label"]="Costes";
	$col3["pattern"]="";
	$col3["type"]="number";
	
	$cols = array($col1,$col2,$col3);
	
	$resultado=array();
	
	$anho=$dato3;
	
	$datos=list_object('select da_mes, (da_facturadomo+da_facturadorec+da_facturadootros) AS FACTURADO, (da_pagadoprovrec+da_pagadoprovotros+da_costepersonal+da_costeestructura) AS COSTES from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell1["v"]=$dato->FACTURADO;
			$cell2["v"]=$dato->COSTES;
			$row["c"]=array($cell0,$cell1,$cell2);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}
else if($dato=='acum_econ_2'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Venta MO";
	$col2["pattern"]="";
	$col2["type"]="number";
	$col3=array();
	$col3["id"]="";
	$col3["label"]="Venta MATERIALES";
	$col3["pattern"]="";
	$col3["type"]="number";
	$col4=array();
	$col4["id"]="";
	$col4["label"]="Coste MATERIALES";
	$col4["pattern"]="";
	$col4["type"]="number";
	
	$cols = array($col1,$col2,$col3,$col4);
	
	$resultado=array();
	
	$anho=$dato3;
	
	$datos=list_object('select da_mes, da_facturadomo, (da_facturadorec+da_facturadootros) AS FACTURADOPR, (da_pagadoprovrec+da_pagadoprovotros) AS COSTESPR from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell1["v"]=$dato->da_facturadomo;
			$cell2["v"]=$dato->FACTURADOPR;
			$cell3["v"]=$dato->COSTESPR;
			$row["c"]=array($cell0,$cell1,$cell2,$cell3);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}
else if($dato=='acum_gest_1'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Ocupación";
	$col2["pattern"]="";
	$col2["type"]="number";
	$col3=array();
	$col3["id"]="";
	$col3["label"]="Eficacia";
	$col3["pattern"]="";
	$col3["type"]="number";
	$col4=array();
	$col4["id"]="";
	$col4["label"]="Rendimiento";
	$col4["pattern"]="";
	$col4["type"]="number";
	
	$cols = array($col1,$col2,$col3,$col4);
	
	$resultado=array();
	
	$anho=$dato3;
	
	$datos=list_object('select da_mes, da_iddato, da_horasfichadasor, da_facturadomo, da_impmo from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$hpresencia=horas_presencia($dato->da_iddato);
			$productividad=porcentaje_($dato->da_horasfichadasor,$hpresencia);
			$hfacturadas=$dato->da_facturadomo/$dato->da_impmo;
			$eficacia=porcentaje_($hfacturadas,$hpresencia);
			$rendimiento=porcentaje_($hfacturadas,$dato->da_horasfichadasor);
			$cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell1["v"]=number_format($productividad,2);
			$cell2["v"]=number_format($eficacia,2);
			$cell3["v"]=number_format($rendimiento,2);
			$row["c"]=array($cell0,$cell1,$cell2,$cell3);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}

else if($dato=='acum_gest_2'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Margen venta PR";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	
	$anho=$dato3;
	
	$datos=list_object('select da_mes, da_iddato, da_facturadorec, da_facturadootros, da_pagadoprovrec, da_pagadoprovotros from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$ventapr=$dato->da_facturadorec+$dato->da_facturadootros;
			$costepr=$dato->da_pagadoprovrec+$dato->da_pagadoprovotros;
			$porcentpr=margen_sobre_coste($costepr,$ventapr);
			
			$cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell1["v"]=number_format($porcentpr,2);
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}
else if($dato=='acum_gest_3'){
	$idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
	$col1=array();
	$col1["id"]="";
	$col1["label"]="Meses";
	$col1["pattern"]="";
	$col1["type"]="string";
	
	$col2=array();
	$col2["id"]="";
	$col2["label"]="Entradas al taller";
	$col2["pattern"]="";
	$col2["type"]="number";
	
	$cols = array($col1,$col2);
	
	$resultado=array();
	
	$anho=$dato3;
	
	$datos=list_object('select da_mes, da_entradastaller from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
	$n1=count($datos);
	if($n1>0){
		$datos=array_reverse($datos);
		foreach($datos as $dato){
			$cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
			$cell1["v"]=$dato->da_entradastaller;
			$row["c"]=array($cell0,$cell1);
			array_push($resultado,$row);
		}
	}
	else{
		$resultado='';
	}
}
else if($dato=='acum_evol_1'){
    $idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
    $col1=array();
    $col1["id"]="";
    $col1["label"]="Meses";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="Importe medio por OR";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $resultado=array();

    $anho=$dato3;

    $datos=list_object('select da_mes, ((da_facturadomo+da_facturadorec+da_facturadootros)/da_entradastaller) AS MEDIAOR from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
    $n1=count($datos);
    if($n1>0){
        $datos=array_reverse($datos);
        foreach($datos as $dato){
            $cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell1["v"]=round($dato->MEDIAOR,2);
            $row["c"]=array($cell0,$cell1);
            array_push($resultado,$row);
        }
    }
    else{
        $resultado='';
    }
}
else if($dato=='acum_evol_2'){
    $idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
    $col1=array();
    $col1["id"]="";
    $col1["label"]="Meses";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="Facturado por operario";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $resultado=array();

    $anho=$dato3;

    $porcentajes=personal_porcentaje($idtaller);

    $datos=list_object('select da_mes, (da_facturadomo+da_facturadorec+da_facturadootros) AS TOTALFAC from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
    $n1=count($datos);
    if($n1>0){
        $datos=array_reverse($datos);
        foreach($datos as $dato){
            $cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell1["v"]=round($dato->TOTALFAC/$porcentajes[4],2);
            $row["c"]=array($cell0,$cell1);
            array_push($resultado,$row);
        }
    }
    else{
        $resultado='';
    }
}
else if($dato=='acum_evol_2'){
    $idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
    $col1=array();
    $col1["id"]="";
    $col1["label"]="Meses";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="€ facturados por operario";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $resultado=array();

    $anho=$dato3;

    $porcentajes=personal_porcentaje($idtaller);

    $datos=list_object('select da_mes, (da_facturadomo+da_facturadorec+da_facturadootros) AS TOTALFAC from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
    $n1=count($datos);
    if($n1>0){
        $datos=array_reverse($datos);
        foreach($datos as $dato){
            $cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell1["v"]=round($dato->TOTALFAC/$porcentajes[4],2);
            $row["c"]=array($cell0,$cell1);
            array_push($resultado,$row);
        }
    }
    else{
        $resultado='';
    }
}
else if($dato=='acum_evol_4'){
    $idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
    $col1=array();
    $col1["id"]="";
    $col1["label"]="Meses";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="Horas facturadas por operario";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $resultado=array();

    $anho=$dato3;

    $porcentajes=personal_porcentaje($idtaller);

    $datos=list_object('select da_mes, (da_facturadomo/da_impmo) AS HORASFAC from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
    $n1=count($datos);
    if($n1>0){
        $datos=array_reverse($datos);
        foreach($datos as $dato){
            $cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell1["v"]=round($dato->HORASFAC/$porcentajes[4],2);
            $row["c"]=array($cell0,$cell1);
            array_push($resultado,$row);
        }
    }
    else{
        $resultado='';
    }
}
else if($dato=='acum_evol_3'){
    $idtaller=$dato2==0?$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']:$dato2;
    $col1=array();
    $col1["id"]="";
    $col1["label"]="Meses";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="Horas facturadas por OR";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $resultado=array();

    $anho=$dato3;

    $datos=list_object('select da_mes, ((da_facturadomo/da_impmo)/da_entradastaller) AS HORASXOR from datos_actividad where da_idtipo=1 and da_idtaller='.$idtaller.' and da_ano='.$anho.' order by da_mes desc');
    $n1=count($datos);
    if($n1>0){
        $datos=array_reverse($datos);
        foreach($datos as $dato){
            $cell0["v"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell0["f"]=substr(nom_mes($dato->da_mes), 0, 3).' '.$anho;
            $cell1["v"]=round($dato->HORASXOR,2);
            $row["c"]=array($cell0,$cell1);
            array_push($resultado,$row);
        }
    }
    else{
        $resultado='';
    }
}


else{
	$resultado='';
}

$data=array("cols"=>$cols,"rows"=>$resultado);

echo $resultado==''?'':json_encode($data);
?>