<?php
$prexml=file_get_contents("plantilla_xml.xml");//URL del XML generado

$ch=curl_init("http://www.assistec.es/plataforma/take_xml_test.php");//URL de destino donde se enviará el XML
//$ch=curl_init("https://localhost/proyectos/Assistec/plataforma/take_xml_test.php");//URL de destino donde se enviará el XML

curl_setopt($ch, CURLOPT_POSTFIELDS, array('dato'=>$prexml));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$res=curl_exec($ch);//XML de respuesta

curl_close($ch);

//echo $res;exit;

//var_dump($res);exit;

///////////////////       INTERPRETAMOS LA RESPUESTA        //////////////////////////

try{
	$respuesta=new SimpleXMLElement($res);
}
catch(Exception $e){
    echo $e.'<br>';
	exit('El archivo XML no tiene el formato adecuado');
}

$resultado_envio=$respuesta->rs_resultado->resultado;
echo $respuesta->rs_resultado->mensaje.'<br>';
if($resultado_envio=='KO'){//Ha habido errores el enviar el archivo
	exit;
}

echo '<br>';

$resultado_conexion=$respuesta->rs_datos_acceso->resultado;
echo $respuesta->rs_datos_acceso->mensaje.'<br>';
if($resultado_conexion=='KO'){//Ha habido errores con los datos de acceso
	exit;
}

echo '<br>';

if(isset($respuesta->rs_datos_actividad)){//Hay respuesta de datos de actividad
	foreach($respuesta->rs_datos_actividad as $rs_datos_actividad){
		echo '<strong>Guardando datos de actividad:</strong><br>';
		if(isset($rs_datos_actividad->rs_empleado)){//Hay datos de empleados
			foreach($rs_datos_actividad->rs_empleado as $rs_empleado){
				$resultado_empleado=$rs_empleado->resultado;
				echo $rs_empleado->mensaje.'<br>';
				if($resultado_empleado=='KO'){//Ha habido errores al cargar los datos del empleado
					continue;
				}
			}
		}
		$resultado_datos_act=$rs_datos_actividad->resultado;
		echo $rs_datos_actividad->mensaje.'<br>';
		if($resultado_datos_act=='KO'){//Ha habido errores al cargar los datos de actividad
			continue;
		}
		echo '<br>';
	}
}

if(isset($respuesta->rs_nuevo_taller)){//Hay respuesta de nuevo taller
	foreach($respuesta->rs_nuevo_taller as $rs_nuevo_taller){
		echo '<strong>Dando de alta nuevo taller:</strong><br>';
		$resultado_nuevo_taller=$rs_nuevo_taller->resultado;
		echo $rs_nuevo_taller->mensaje.'<br>';
		if($rs_nuevo_taller=='KO'){//Ha habido errores al crear el nuevo taller
			continue;
		}
		echo '<br>';
	}
}

///////////////////       INTERPRETAMOS LA RESPUESTA        //////////////////////////
?>