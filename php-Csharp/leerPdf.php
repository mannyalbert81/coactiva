<?php 

$comando='start "" /b "C:\Users\Masoft\git\coactiva\documentos\extraer\VerEspacioPdf.exe" C:\Users\Masoft\Desktop\Avoco1320.pdf false';
 
 
$comando_esc = escapeshellcmd($comando);


exec($comando_esc,$resultadoSalida,$ejecucion);


exec($comando_esc,$resultadoSalida);

echo "valor estatus de la aplicacion en C# ".$ejecucion."<br>(0=> la aplicacion se ejecuto exitosamente)<br> (1=>la aplicacion no se ejecuto correctamente ocurrio algun error)<br>";

$espacio=0;

if(!empty($resultadoSalida))
{ 
 $int_i = 0;
	foreach($resultadoSalida as $res)
	{
		$int_i=$int_i+1;
		echo utf8_encode("<strong> ".$res."-->".$int_i." </strong> <br>");
		
	}
	
	$espacio=$espacio+(float)str_replace(',', '.', $resultadoSalida[0]);
	
}else{
	
	echo utf8_encode("<strong> no hay datos de regreso </strong>");
}

echo "<br>".$espacio;

?>