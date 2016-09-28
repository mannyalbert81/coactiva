<?php

$base_url = "http://localhost:4000/FrameworkMVC/";



$id_avoco_conocimiento						     = "";	  
$juicio_referido_titulo_credito                  = "";	
$nombres_clientes			                     = ""; 
$identificacion_clientes                         = ""; 
$nombre_ciudad                                   = ""; 

$secretarios						             = "";
$impulsores                                      = "";
$secretario_reemplazo			                 = "";
$nombre_garantes                                 = "";
$identificacion_garantes                         = "";
$impulsor_reemplazo                              = "";
$creado                                          ="";
$identificador                                   ="";



$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/FrameworkMVC';

$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';

require_once( $dom);


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$dato['fecha']=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
$dato['hora']= date ("h:i:s");
	


 $logo                                                 = '<img src="view/images/logo_fomento1.jpg" alt="Responsive image" width="200" height="80">';
 


$html =
  '<html>'.
  '<head>'.
  	'<meta charset="utf-8"/>'.
  	'<title> '.'' .' Avoco Secretario Impulsor Sin Garante</title>'.
  	
  '</head>'.
  '<body>'.
  
'<div style="position: absolute; margin-left: 3%;  margin-right:3%; top: -5%; height: 0px">'.


'<p style="text-align: right;">'.$logo.'</p>'.



'<p style="text-align: right;">'.
'<font face="arial, verdana" size="3">
<b>JUICIO COACTIVO N°</b><b>JUICIO COACTIVO N°</b> '.$juicio_referido_titulo_credito.'
</font>'.
'</p>'.

'<p style="text-align: justify;">'.
'<font face="arial, verdana" size="3">
		
<b>JUZGADO DE COACTIVA DEL BANCO NACIONAL DEL FOMENTO EN LIQUIDACIÓN.- '.$nombre_ciudad.'</b>, '.$creado.'.-
 VISTOS: Avoco conocimiento del presente proceso signado con el número<font color="#FFFFFF">a</font><strong>'.$juicio_referido_titulo_credito.'</strong>
 seguido en contra de<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong> con cedula de ciudadanía N°<font color="#FFFFFF">a</font><strong>'.$identificacion_clientes.'</strong> 
 en calidad de deudor (a) principal, en mi calidad de Liquidadora del Banco Nacional de Fomento en Liquidación conforme a la designación a mi extendida
 y fundada en la orden de cobro, contenidos ambos actos en la Resolución No. SB-2016-324, emitida por el Ec. Christian Cruz
 Rodríguez, en su calidad de Superintendente de Bancos del Ecuador, dada en Quito con fecha 08 de mayo del 2016, 
 inscrita en el Registro Mercantil del cantón Quito, el 12 de mayo de 2016, cuyo desglose ordeno dejando copias 
 certificadas en autos.- Déjese sin efecto el nombramiento del Abogado (a)<font color="#FFFFFF">a</font><strong>'.$secretario_reemplazo.'</strong>, en su calidad de
 Secretario (a) de Coactiva,y al Abogado (a) <font color="#FFFFFF">a</font><strong>'.$impulsor_reemplazo.'</strong>, en su calidad de Impulsor (a) en su reemplazo se designa como Secretario de Coactiva al Abogado (a)<font color="#FFFFFF">a</font><strong>'.$secretarios.'</strong>  
 y, como Abogado (a) Impulsor (a) se designa al Abogado (a)<font color="#FFFFFF">a</font><strong>'.$impulsores.'</strong> quienes hallándose presentes aceptan los cargos
 y juran desempeñarlos fiel y legalmente, firmando para constancia con la suscrita Jueza de Coactiva.-<font color="#FFFFFF">a</font><b>CUMPLASE Y NOTIFÍQUESE</b>.<br>
 <font color="#FFFFFF">MASOFTFIN</font> 		
</font>'.
'</p>'

.'</div>'.


'<div style=" width: 100%; bottom: 0; position:fixed; height: 10px;">'.
'<p style="text-align: center;">'.
'<font face="arial, verdana" size="3">
<b>Coactivas - Allcoercive 2016 - www.masoft.net - Copyright 2016</b>
</font>'.
'</p>'
.'</div>'.

'</body></html>';
 

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper("A4", "portrait");

$dompdf->render();
$dompdf->stream("mipdf.pdf", array("Attachment" => 0));

?>