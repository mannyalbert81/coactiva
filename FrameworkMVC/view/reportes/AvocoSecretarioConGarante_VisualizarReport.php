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

$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/FrameworkMVC';
//echo $directorio;
//die();
$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';

require_once( $dom);


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$dato['fecha']=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
$dato['hora']= date ("h:i:s");
	

$a=stripslashes($_GET['dato']);

$_dato=urldecode($a);

$_dato=unserialize($a);

//print_r($_dato);
//die();
/*
 * Array (
 * [ciudad] => QUITO
 * [juicio_referido] => UIO-1-2016-19
 * [cliente] => REYES CARRERA PATRICIA ELIZABETH
 * [identificacion] => 1753859913001
 * [secretario_reemplazar] =>
 * [impulsor_reemplazar] => OSCAR ALFREDO CORO
 * [secretario] => SECRETARIO
 * [abogado] => ABOGADO
 * [garante] =>
 * [garante_1] =>
 * [identificacion_garante] =>
 * [identificacion_garante_1] =>
 * [fecha] => Miercoles 28 de Septiembre del 2016 [hora] => 06:32:36
 * 		)
 */

$juicio_referido_titulo_credito		=$_dato['juicio_referido'];
$nombres_clientes			        =$_dato['cliente'];
$identificacion_clientes            =$_dato['identificacion'];
$nombre_ciudad                      =$_dato['ciudad'];
$secretarios						=$_dato['secretario'];
$impulsores                         =$_dato['abogado'];
$impulsor_reemplazo			        =$_dato['impulsor_reemplazar'];
$nombre_garantes                    =$_dato['garante'];
$identificacion_garantes            =$_dato['identificacion_garante'];
$nombre_garantes_1                    =$_dato['garante_1'];
$identificacion_garantes_1            =$_dato['identificacion_garante_1'];
$secretario_reemplazo            =$_dato['secretario_reemplazar'];

$creado                             =$_dato['fecha'];

$domLogo=$directorio.'/view/images/logo_fomento1.jpg';

$logo                                                 = '<img src="'.$domLogo.'" alt="Responsive image" width="200" height="80">';


$html =
  '<html>'.
  '<head>'.
  	'<meta charset="utf-8"/>'.
  	'<title> '.'' .' Avoco Secretario Con Garante</title>'.
  	
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
 en calidad de deudor (a) principal y <font color="#FFFFFF">a</font><strong>'.$nombre_garantes.'</strong> con cedula de ciudadanía N°<font color="#FFFFFF">a</font><strong>'.$identificacion_garantes.'</strong> en calidad de
 garante  solidario (a), en mi calidad de Liquidadora del Banco Nacional de Fomento en Liquidación conforme a la designación a mi extendida
 y fundada en la orden de cobro, contenidos ambos actos en la Resolución No. SB-2016-324, emitida por el Ec. Christian Cruz
 Rodríguez, en su calidad de Superintendente de Bancos del Ecuador, dada en Quito con fecha 08 de mayo del 2016, 
 inscrita en el Registro Mercantil del cantón Quito, el 12 de mayo de 2016, cuyo desglose ordeno dejando copias 
 certificadas en autos.- Déjese sin efecto el nombramiento del Abogado (a)<font color="#FFFFFF">a</font><strong>'.$secretario_reemplazo.'</strong>, en su calidad de
 Secretario (a) de Coactiva, en su reemplazo se designa como Secretario de Coactiva al Abogado (a)<font color="#FFFFFF">a</font><strong>'.$secretarios.'</strong>  
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