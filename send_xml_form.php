<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar XML</title>
</head>

<body>

<?php $prexml=file_get_contents("plantilla_xml.xml");?>

<form action="http://www.assistec.es/plataforma/take_xml_test.php" enctype="application/x-www-form-urlencoded" id="xml_assistec" method="post" name="xml_assistec">

    <textarea name="dato"><?=$prexml?></textarea>
    <input type="hidden" name="envio_form" value="1" />
    
    <input type="submit" />
    
</form>

</body>
</html>