<?php
$parametros="100";

$comando='start "" /b "C:\Users\Masoft\git\coactiva\documentos\firmar\FirmadorElectronico.exe" 33 C:\Users\Masoft\Desktop\prueba.pdf C:\Users\Masoft\Desktop\avoco2.pdf 5 42';
 
$comando_esc = escapeshellcmd($comando);

exec($comando_esc,$resultadoSalida,$ejecucion);

echo "valor estatus de la aplicacion en C# ".$ejecucion."<br>(0=> la aplicacion se ejecuto exitosamente)<br> (1=>la aplicacion no se ejecuto correctamente ocurrio algun error)<br>";

if(count($resultadoSalida)>0)
{
	echo utf8_encode("<strong> ".$resultadoSalida[0]." </strong>");
}else{
	
}

?>

