<?php

$base_url = "http://localhost:4000/FrameworkMVC/";


$juicio_referido_titulo_credito		="";
$nombre_clientes			        ="";
$fecha_providencias 			    ="";
$hora_providencia     		        ="";
$texto_providencias					="";
$ciudad                             ="";


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

/*
 * $dato['ciudad']=$resultCiudad[0]->nombre_ciudad;
			$dato['juicio_referido']=$resultJuicio[0]->juicio_referido_titulo_credito;
			$dato['cliente']=$resultJuicio[0]->nombres_clientes;
			$dato['fecha_emision_documentos']=$_fecha_emision_documentos;
			$dato['hora_emision_documentos']=$_hora_emision_documentos;
			$dato['texto_providencia']=$avoco.$_texto_providencia;
 */

$juicio_referido_titulo_credito		=$_dato['juicio_referido'];
$nombre_clientes			        =$_dato['cliente'];
$fecha_providencias 			    =$_dato['fecha_emision_documentos'];
$hora_providencia     		        =$_dato['hora_emision_documentos'];
$texto_providencias					=$_dato['texto_providencia'];
$ciudad                             =$_dato['ciudad'];



$domLogo=$directorio.'/view/images/logo_fomento1.jpg';

$logo         = '<img src="'.$domLogo.'" alt="Responsive image" width="200" height="80">';



$html =
  '<html>'.
  '<head>'.
  	'<meta charset="utf-8"/>'.
  	'<title> '.'' .' Providencias</title>'.
  	
  '</head>'.
  '<body>'.
  
'<div>'.


'<p style="text-align: right;">'.$logo.'</p><br>'.


'<p style="text-align: left;">'.
'<font face="arial, verdana" size="3">
<b>JUICIO COACTIVO N° </b><strong>'.$juicio_referido_titulo_credito.'</strong><br>
<strong>'.$nombre_clientes.'</strong><br>
<b>JUZGADO COACTIVA.-</b><br>
<strong>'.$ciudad.'<font color="#FFFFFF">a</font>'.$fecha_providencias.'</strong>
</font>'
.'</p>'.


'<p style="text-align: justify;">'.
'<font face="arial, verdana" size="3">
'.$texto_providencias.'<br>
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


?>