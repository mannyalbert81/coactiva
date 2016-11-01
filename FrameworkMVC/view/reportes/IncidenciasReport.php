
 <?php

$nombre = $datos['nombre'];

$host  = $_SERVER['HTTP_HOST'];

$ruta = 'http://'.$host.'/coactiva/incidencia/'.$nombre;

require_once('view/dompdf/dompdf_config.inc.php' );


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//$dato['fecha']=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
//$dato['hora']= date ("h:i:s");

$logo = '<img src="view/images/logo_fomento1.jpg" alt="Responsive image" width="200" height="80">';

$foto_incidencia = '<img src="'.$ruta.'" alt="Incidencia" width="300" height="200">';
 

$html =
  '<html>'.
  '<head>'.
  	'<meta charset="utf-8"/>'.
  	'<title> '.'' .' Incidencia</title>'.
  	
  '</head>'.
  '<body>'.
  
'<div style="position: absolute; margin-left: 3%;  margin-right:3%; top: -5%; height: 0px">'.
'<p style="text-align: right;">'.$logo.'</p><br>'.
'<p style="text-align: left;">'.
'<font face="arial, verdana" size="3">
<b>Datos Adjuntos</b></font></p>'
.'</div><br><br><br><br><br><br><br><br>'.
'<div style="width: 100%;">'.
$foto_incidencia.
'</div>'.

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
$pdf = $dompdf->output();
$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/incidencia/pdf/';
$filename = "Incidencia".$identificador.'.pdf';
file_put_contents($directorio.$filename,$pdf);


?>