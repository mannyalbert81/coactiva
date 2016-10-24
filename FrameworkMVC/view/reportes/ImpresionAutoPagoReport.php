<?php

$base_url = "http://localhost:4000/FrameworkMVC/";

$nombre_ciudad						     = "";	  
$juicio_referido_titulo_credito          = "";	
$creado			   						 = ""; 
$nombres_clientes                        = ""; 
$nombre_garantes       					 = ""; 
$identificacion_garantes     			 = "";
$identificacion_clientes   				 = "";
$total_total_titulo_credito   			 = "";
$secretarios  							 = "";
$impulsores  							 = "";
$liquidador  						     = "";
$identificador                           = "";

require_once('view/dompdf/dompdf_config.inc.php' );


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$dato['fecha']=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
$dato['hora']= date ("h:i:s");
	

foreach($resultSet as $res) 
{
	
	$nombre_ciudad						            =$res->nombre_ciudad;
	$juicio_referido_titulo_credito                 =$res->juicio_referido_titulo_credito;
	$creado			            					=$dias[date('w',strtotime($res->creado))]." ".date('d',strtotime($res->creado))." de ".$meses[date('n',strtotime($res->creado))-1]. " del ".date('Y',strtotime($res->creado)). " a las ".date("h:i:s",strtotime($res->creado)) ;
	$nombres_clientes                   			=$res->nombres_clientes;
	$nombre_garantes                        		=$res->nombre_garantes;
	$identificacion_garantes						=$res->identificacion_garantes;
	$identificacion_clientes                        =$res->identificacion_clientes;
	$total_total_titulo_credito                     =$res->total_total_titulo_credito;
	$secretarios                            		=$res->secretarios;
	$impulsores                                 	=$res->impulsores;
	$liquidador                                     =$res->liquidador;
	$identificador                                  =$res->identificador;
	                                            
}

$logo                                                 = '<img src="view/images/logo_fomento1.jpg" alt="Responsive image" width="200" height="80">';
 


$html =

  '<html>'.
  
   '<head>'.
   
  	'<meta charset="utf-8"/>'.
  	'JUICIO COACTIVO Nº'.
  	'<title> '.'' .' BANCO DEL FOMENTO</title>'.
  '</head>'.
  '<body>'.
  '<div style="border:1px solid;">'.
  '<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
  '<strong>'.'<font size=2>'.  'JUZGADO DE COACTIVA'. '</font>' . '</strong>'.
  '</div>'.
  
  '<div style="margin-top:0px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
  '<strong>'.'<font size=2>'. 'CIUDAD  '.$nombre_ciudad . '</font>'. '</strong>'.
  '</div>'.
  
  '<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
  '<strong>'.'<font size=2>'.  'JUICIO COACTIVO Nº  '.$juicio_referido_titulo_credito. '</font>'. '</strong>'.
  '</div>'.
  
  
  '<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
  '<strong>'.'<font size=2>'.  'CUERPO: 1ER CUERPO'. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'ACTOR: BANCO DEL FOMENTO EN LIQUIDACIÓN'. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'FECHA DE INICIO: ' .$creado. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'FECHA DE CITACIÓN: '. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'FORMA DE CITACIÓN: '. '<font>'. '</strong>'.
  '</div>'.
  
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
  '<strong>'.'<font size=2>'.  '_______ PERSONAL    _______ POR TRES BOLETAS    ________ POR LA PRENSA '. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'DEMANDADO '. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'DEUDOR: '.$nombres_clientes. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'CI - RUC: '.$identificacion_clientes. '<font>'. '</strong>'.
  '</div>'.
  
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'GARANTE '. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'CI - RUC: '. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'CASILLA JUDICIAL:'. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'DEFENSOR: '. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'DE: '. '<font>'. '</strong>'.
  '</div>'.
  
 
  '<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
  '<strong>'.'<font size=2>'.  'CUANTIA INICIAL: USD$  '.$total_total_titulo_credito. '<font>'. '</strong>'.
  '</div>'.
  
  '<br>'.
  '<div align="center" style= "margin-top:60px">'.
  '<center>'.
  '<table border="0"  width="100"  align="center">'.
  '<br>'.
  '<br>'.
  '<br>'.
  '<br>'.
  '<tr>'.
  
  '<td align="center">'. '<strong>'.'<font size=2>'.  'IMPULSOR '. '<font>'. '</strong>'.'</td>'.
  '<td align="center" style="color:#ffffff">'.'......'.'</td>'.
  '<td align="center">'. '<strong>'.'<font size=2>'.  'LIQUIDADOR '. '<font>'. '</strong>'.'</td>'.
  '<td align="center" style="color:#ffffff">'.'......'.'</td>'.
  '<td align="center">'. '<strong>'.'<font size=2>'.  'SECRETARIO '. '<font>'. '</strong>'.'</td>'.
  '</tr>'.
  '<tr>'.
  '<td align="center">'. '<strong>'.'<font size=2>'.'Ab. '. $impulsores. '<font>'. '</strong>'.'</td>'.
  '<td align="center" style="color:#ffffff">'.'......'.'</td>'.
  '<td align="center">'. '<strong>'.'<font size=2>'.'Dr. '. $liquidador . '<font>'. '</strong>'.'</td>'.
  '<td align="center" style="color:#ffffff">'.'......'.'</td>'.
  '<td align="center">'. '<strong>'.'<font size=2>'.'Ab. '. $secretarios . '<font>'. '</strong>'.'</td>'.
  '</tr>'.
  
  '</table>'.
  '</center>'.
  '</div>'.
  
  
  
  
'</div>'.
'<p style="text-align: justify;">'.
'<font face="arial, verdana" size="3">

		
		
<strong>VISTOS:</strong> Del (los) título (s) de crédito No. (s)<font color="#FFFFFF">a</font><strong>'.$juicio_referido_titulo_credito.'</strong>
que ha (n) sido expedido (s) por el Banco Fomento en Liquidación, y emitido (s) en fecha,<font color="#FFFFFF">a
</font><strong>'.$creado.'</strong> de conformidad con la (s) liquidación (es) que se manda (n) agregar a los autos aparece que
<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>con<font color="#FFFFFF">a</font><strong>'.$identificacion_clientes.'
</strong>y<font color="#FFFFFF">a</font><strong>'.$nombre_garantes.'</strong>con<font color="#FFFFFF">a</font><strong>'.$identificacion_garantes.'
</strong>, adeuda (n) a esta Institución Bancaria en Liquidación la suma de USD$<font color="#FFFFFF">a</font>
<strong>'.$total_total_titulo_credito.'</strong>DOLARES DE LOS ESTADOS UNIDOS DE AMÉRICA, más los intereses y costas y
gastos judiciales que se generen hasta la fecha de pago total. Y siendo la obligación líquida, determinada y de plazo vencido,
en mi calidad de Liquidador del Banco del Fomento en Liquidación, conforme a la designación a mi extendida y fundado en la
orden de cobro contenidos ambos actos en la Resolución No. JB-2013-2438, emitida por el Ab. Pedro Solines Chacón, en su calidad 
de Presidente de la Junta Bancaria, dada en la Superintendencia de Bancos y Seguros en Guayaquil con fecha 26 de marzo de 2013,
inscrita en el Registro Mercantil del cantón Guayaquil el 27 de marzo de 2013, en la que se dispone la liquidación forzosa del
Banco del Fomento, y de conformidad con lo dispuesto en los Arts. 941, 945, 946. 948 y 951 del Código de Procedimiento Civil, 
INICIO el presente juicio coactivo contra<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>, registrado con 
R.U.C. No.<font color="#FFFFFF">a</font><strong>'.$identificacion_clientes.'</strong>y<font color="#FFFFFF">a</font>
<strong>'.$nombre_garantes.'</strong>con<font color="#FFFFFF">a</font><strong>'.$identificacion_garantes.'</strong>y en
consecuencia ORDENO que el (los) deudor (es) pague (n) al Banco del Fomento en Liquidación la cantidad adeudada, más 
los intereses generados hasta la fecha y los que se generen hasta la total cancelación de la deuda, intereses de mora, 
comisión, gastos judiciales, costas procesales, honorarios y otros accesorios legales, o dimita bienes en el término 
perentorio de tres días, contados desde que se cite con el auto de pago, apercibiéndole (s) que de no hacerlo se 
le embargará bienes que aseguren la recuperación de todo lo adeudado, de conformidad con lo dispuesto en el Art. 
962 del Código de Procedimiento Civil, actúen en el presente juicio, como secretario e impulsor respectivamente, 
los abogados y, quienes estando presentes aceptan los cargos conferidos y juran desempeñarlos 
fiel y legalmente, firmando para constancia con el suscrito Juez de Coactiva. Desglósese el (los) título (s) de crédito 
aparejado (s) a la coactiva, así como el documento habilitante que acredita la calidad invocada, dejándose las copias 
certificadas en autos, remitiéndose el original al departamento correspondiente para su respectiva custodia. En lo principal, 
por disposición de lo prescrito en la parte final del inciso primero del Art. 942 del Código de Procedimiento Civil, en 
concordancia con los Arts. 421 y 426 del Código Adjetivo Civil, díctanse las siguientes medidas cautelares: UNO) 
Al tenor de lo dispuesto en los Arts. 6, 9 y 18 de la Ley del Sistema Nacional de Registro de Datos Públicos, 
Notifíquese a los señores Registradores de la Propiedad CANTONES para que remitan a este Juzgado un certificado 
actualizado de bienes inmuebles que consten inscritos a nombre del (los) coactivado (s) debiéndose señalar linderos, 
medidas, superficie, historia de dominio; y, se inscriba la Prohibición de gravar y/o enajenar sobre los bienes inmuebles 
que el (los) coactivado (s) tenga inscritos a su nombre en dichos Registros.  Hecho, remítase a la Secretaría de este 
Juzgado ubicado en la ciudad de OFICINA;  DOS)  Prohibición de gravar y/o enajenar los vehículos del (los) coactivado 
(s), para cuyo efecto notifíquese a la Comisión de Tránsito del Ecuador, a fin de que tome nota en sus registros de 
la medida cautelar dispuesta, hecho lo cual, emita un certificado donde consten las características de los vehículos 
sobre los cuales se ha registrado la medida cautelar ordenada; TRES) Se ordena la retención de valores de conformidad 
con lo dispuesto en el Art. 425 del Código de Procedimiento Civil, hasta por la cantidad de USD$<font color="#FFFFFF">a
</font><strong>'.$total_total_titulo_credito.'</strong>DOLARES DE LOS ESTADOS UNIDOS DE AMÉRICA, retención que 
se verificará en las inversiones que mantenga el (los) coactivado (s) en las instituciones bancarias y financieras
que operan en el país, sean éstas cuentas corrientes, de ahorros, inversiones, depósitos a plazo, pólizas de acumulación
y de cualquier otra operación en dicha institución, para lo cual deberá oficiarse a la Superintendencia de Bancos y
Seguros. De conformidad con lo dispuesto en el Art. 428 del Código de Procedimiento Civil, las entidades bancarias
sujetas al control de la Superintendencia de Bancos y Seguros, deberán informar a éste Juzgado en el término 
improrrogable de 72 horas el cumplimiento de la retención ordenada. Sin perjuicio de que el secretario de 
la causa notifique directamente a las instituciones que conforman el Sistema Financiero Nacional. CUATRO) 
Ofíciese a la Superintendencia de Compañías, a fin de que remita un certificado de la situación actual legal 
de la coactivada,<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>la nómina de socios y/o accionistas, y se inscriba la prohibición 
de transferir las acciones y/o participaciones de la referida compañía coactivada. CINCO) Ofíciese al Registro
Mercantil del cantón, a fin de que emita un certificado actualizado en el que conste 
el (los) nombre (s) de quien (es) ejerce (n) la representación legal, judicial y extrajudicial de la coactivada
<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>.-  De conformidad con lo dispuesto en el 
Art. 952 del Código de Procedimiento Civil, en el Art. 952 del Código de Procedimiento Civil, una vez 
cumplida la notificación de las medidas cautelares ordenadas en este auto de pago, cítese al (los) coactivado 
(s) en legal y debida forma en el domicilio señalado en el título de crédito o en el lugar donde se lo encuentre,
previniéndole de la obligación que tiene de señalar casilla judicial para recibir futuras notificaciones 
de conformidad con lo dispuesto en el Art. 75 del Código de Procedimiento Civil. Se ofrece reconocer los 
abonos o cancelaciones que legalmente se comprobaren haberse realizado.<font color="#FFFFFF">a</font><b>- 
CUMPLACE, CITECE y OFICIECE.-</b>.<br>
<font color="#FFFFFF">MASOFTFIN</font>		
 </font>'.
'</p>'

.'</div>'.
'<div aling ="center" style ="margin-top:120px" >'.
'</div>'.

'<div style=" width: 100%; bottom: 0; position:fixed; height: 10px;">'.
		'<p style="text-align: center;">'.
		'<font face="arial, verdana" size="3">
<b>Coactivas - Allcoercive 2016 - www.masoft.net - Copyright 2016</b>
</font>'.
'</p>'
.'</div>'.
		
 '</div>'.

'</body></html>';

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper("A4", "portrait");

$dompdf->render();
$pdf = $dompdf->output();
$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/AutoPagos/';
$filename = "Autopago".$identificador.'.pdf';
file_put_contents($directorio.$filename,$pdf);

?>