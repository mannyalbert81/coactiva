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

//require('view/fpdf/fpdf.php');

require_once('view/dompdf/dompdf_config.inc.php' );;

foreach($resultCliente as $res) 
{
	
	$identificacion_clientes						   =$res->identificacion_clientes;
	$total                               			   =$res->total;
	$juicio_referido_titulo_credito			           =$res->juicio_referido_titulo_credito;
	$nombres_clientes			                       =$res->nombres_clientes;
	$nombre_ciudad                                     =$res->nombre_ciudad;
	$creado                                            = date('Y-m-d ',strtotime($res->creado));

}



foreach($resultSecretario as $res)
{
	$id_impulsor				=$res->id_abogado;
	$nombre_impulsor			=$res->impulsadores;
	$id_secretario				=$res->id_secretario;
	$nombre_secretario			=$res->secretarios;
	
}


$logo_impulsore ="";
foreach($resultFirma_abogado as $res)
{
	$id_firma_abogado			=$res->id_firmas_digitales;
	$firma_abogado				=$res->imagen_firmas_digitales;
	
	$logo_impulsores 			="";// '<img src="'. $base_url.'view/DevuelveImagen.php?id_valor='.$id_firma_abogado.'&id_nombre=id_firmas_digitales&tabla=firmas_digitales&campo=imagen_firmas_digitales" width="120" height="80" />';
	
}

$logo_secretarios="";
foreach($resultFirma_secretario as $res)
{
	$id_firma_secretario			=$res->id_firmas_digitales;
	$firma_secretario				=$res->imagen_firmas_digitales;
	
	$logo_secretarios 				= '<img src="'. $base_url.'view/DevuelveImagen.php?id_valor='.$id_firma_secretario.'&id_nombre=id_firmas_digitales&tabla=firmas_digitales&campo=imagen_firmas_digitales" width="120" height="80" />';
	
}

$logo_liquidador ="";
foreach($resultLiquidador as $res)
{
	$id_usuarios                   =$res->id_usuarios;
	$nombre_liquidador             =$res->nombre_usuarios;
	$firma_liquidador             =$res->imagen_firmas_digitales;
	
	$logo_liquidador 				= '<img src="'. $base_url.'view/DevuelveImagen.php?id_valor='.$id_usuarios.'&id_nombre=id_usuarios&tabla=firmas_digitales&campo=imagen_firmas_digitales" width="120" height="80" />';
	
}
    
$nombre_liquidador="";


$html =
  '<html>'.
  '<head>'.
  	'<meta charset="utf-8"/>'.
  	'<title> '.'' .' BANCO DEL FOMENTO</title>'.
  	
  '</head>'.
  '<body>'.
  
'<div style=" position: absolute;  margin-left: 10%; width:80%;">'.
'<div style="border:1px solid;">'.

'<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
'<strong>'.'<font size=4>'. 'BANCO DEL FOMENTO EN LIQUIDACIÓN'. '<font>'.'</strong>'.
'</div>'.
'</div>'.

'<br>'.


'<div style="border:1px solid;">'.
'<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
'<strong>'.'<font size=2>'.  'JUZGADO DE COACTIVA'. '<font>' . '</strong>'.
'</div>'.

'<div style="margin-top:0px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
'<strong>'.'<font size=2>'. $nombre_ciudad . '<<font color="Gray"></font>>'. '</strong>'.
'</div>'.

'<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
'<strong>'.'<font size=2>'.  'JUICIO COACTIVO Nº  '.$juicio_referido_titulo_credito. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
'<strong>'.'<font size=2>'.  'CUERPO: 1ER CUERPO'. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'ACTOR: BANCO DEL FOMENTO EN LIQUIDACIÓN'. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'FECHA DE INICIO: ' .$creado. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'FECHA DE CITACIÓN: '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'FORMA DE CITACIÓN: '. '<font>'. '</strong>'.
'</div>'.


'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: center;">'.
'<strong>'.'<font size=2>'.  '_______ PERSONAL    _______ POR TRES BOLETAS    ________ POR LA PRENSA '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'DEMANDADO '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'DEUDOR: '.$nombres_clientes. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'CI - RUC: '.$identificacion_clientes. '<font>'. '</strong>'.
'</div>'.


'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'GARANTE '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'CI - RUC: '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'CASILLA JUDICIAL:'. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'DEFENSOR: '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'DE: '. '<font>'. '</strong>'.
'</div>'.

'<div style="margin-left:20px; margin-top:20px; color:#000000; font-family: sans-serif; font-size:75%; width:100%; text-align: left;">'.
'<strong>'.'<font size=2>'.  'CUANTIA INICIAL: USD$  '.$total. '<font>'. '</strong>'.
'</div>'.


'<div align="center" style= "margin-top:60px">'.
'<center>'.
'<table border="0"  width="100"  align="center">'.


'<tr>'.
'<td align="center">'.'logo impulsores
		'. '</td>'.
'<td align="center" style="color:#ffffff">'.'......'.'</td>'.
'<td align="center">'.$logo_liquidador . '</td>'.
'<td align="center" style="color:#ffffff">'.'......'.'</td>'.
'<td align="center">'.$logo_secretarios .'</td>'.
'</tr>'.
'<tr>'.
'<td align="center">'. '<strong>'.'<font size=2>'.  'IMPULSOR '. '<font>'. '</strong>'.'</td>'.
'<td align="center" style="color:#ffffff">'.'......'.'</td>'.
'<td align="center">'. '<strong>'.'<font size=2>'.  'LIQUIDADOR '. '<font>'. '</strong>'.'</td>'.
'<td align="center" style="color:#ffffff">'.'......'.'</td>'.
'<td align="center">'. '<strong>'.'<font size=2>'.  'SECRETARIO '. '<font>'. '</strong>'.'</td>'.
'</tr>'.
'<tr>'.
'<td align="center">'. '<strong>'.'<font size=2>'.'Ab. '. $nombre_impulsor. '<font>'. '</strong>'.'</td>'.
'<td align="center" style="color:#ffffff">'.'......'.'</td>'.
'<td align="center">'. '<strong>'.'<font size=2>'.'Dr. '. $nombre_liquidador . '<font>'. '</strong>'.'</td>'.
'<td align="center" style="color:#ffffff">'.'......'.'</td>'.
'<td align="center">'. '<strong>'.'<font size=2>'.'Ab. '. $nombre_secretario . '<font>'. '</strong>'.'</td>'.
'</tr>'.

'</table>'.
'</center>'.
'</div>'.

'<div align="center" style= "margin-top:120px">'.
'</div>'.


'</div>'.
'</div>'.
		

  '</body></html>' .
 
'<html>'.
'<head>'.
'<meta charset="utf-8"/>'.
'<title> '.'' .' BANCO DEL FOMENTO</title>'.
 
'</head>'.
'<body>'.


'<div >'.
'<p>'.
'
VISTOS: Del (los) título (s) de crédito No. (s)<font color="#FFFFFF">a</font><strong>'.$juicio_referido_titulo_credito.'</strong>
que ha (n) sido expedido (s) por el Banco Fomento S.A. en Liquidación, y emitido (s) en fecha <font color="#FFFFFF">a
</font><strong>'.$creado.'</strong>, de conformidad con la (s) liquidación (es) que se manda (n) agregar a los autos aparece que
<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>con<font color="#FFFFFF">a</font><strong>'.$identificacion_clientes.'
</strong>y<font color="#FFFFFF">a</font><strong>'.$nombre_garantes.'</strong>con<font color="#FFFFFF">a</font><strong>'.$identificacion_garantes.'
</strong>, adeuda (n) a esta Institución Bancaria en Liquidación la suma de USD$<font color="#FFFFFF">a</font>
<strong>'.$total_total_titulo_credito.'</strong>DOLARES DE LOS ESTADOS UNIDOS DE AMÉRICA), más los intereses y costas y
gastos judiciales que se generen hasta la fecha de pago total. Y siendo la obligación líquida, determinada y de plazo vencido,
en mi calidad de Liquidador del Banco Territorial S.A. en Liquidación, conforme a la designación a mi extendida y fundado en la
orden de cobro contenidos ambos actos en la Resolución No. JB-2013-2438, emitida por el Ab. Pedro Solines Chacón, en su calidad 
de Presidente de la Junta Bancaria, dada en la Superintendencia de Bancos y Seguros en Guayaquil con fecha 26 de marzo de 2013,
inscrita en el Registro Mercantil del cantón Guayaquil el 27 de marzo de 2013, en la que se dispone la liquidación forzosa del
Banco del Fomento, y de conformidad con lo dispuesto en los Arts. 941, 945, 946. 948 y 951 del Código de Procedimiento Civil, 
INICIO el presente juicio coactivo contra<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>, registrado con 
R.U.C. No.<font color="#FFFFFF">a</font><strong>'.$identificacion_clientes.'</strong>y<font color="#FFFFFF">a</font>
<strong>'.$nombre_garantes.'</strong>con<font color="#FFFFFF">a</font><strong>'.$identificacion_garantes.'</strong>y en
consecuencia ORDENO que el (los) deudor (es) pague (n) al Banco Territorial S.A. en Liquidación la cantidad adeudada, más 
los intereses generados hasta la fecha y los que se generen hasta la total cancelación de la deuda, intereses de mora, 
comisión, gastos judiciales, costas procesales, honorarios y otros accesorios legales, o dimita bienes en el término 
perentorio de tres días, contados desde que se cite con el auto de pago, apercibiéndole (s) que de no hacerlo se 
le embargará bienes que aseguren la recuperación de todo lo adeudado, de conformidad con lo dispuesto en el Art. 
962 del Código de Procedimiento Civil, actúen en el presente juicio, como secretario e impulsor respectivamente, 
los abogados SECOAC y "+$F{impulsores}+", quienes estando presentes aceptan los cargos conferidos y juran desempeñarlos 
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
</font><strong>'.$total_total_titulo_credito.'</strong>DOLARES DE LOS ESTADOS UNIDOS DE AMÉRICA), retención que 
se verificará en las inversiones que mantenga el (los) coactivado (s) en las instituciones bancarias y financieras
que operan en el país, sean éstas cuentas corrientes, de ahorros, inversiones, depósitos a plazo, pólizas de acumulación
y de cualquier otra operación en dicha institución, para lo cual deberá oficiarse a la Superintendencia de Bancos y
Seguros. De conformidad con lo dispuesto en el Art. 428 del Código de Procedimiento Civil, las entidades bancarias
sujetas al control de la Superintendencia de Bancos y Seguros, deberán informar a éste Juzgado en el término 
improrrogable de 72 horas el cumplimiento de la retención ordenada. Sin perjuicio de que el secretario de 
la causa notifique directamente a las instituciones que conforman el Sistema Financiero Nacional. CUATRO) 
Ofíciese a la Superintendencia de Compañías, a fin de que remita un certificado de la situación actual legal 
de la coactivada "+$F{nombres_clientes}+" , la nómina de socios y/o accionistas, y se inscriba la prohibición 
de transferir las acciones y/o participaciones de la referida compañía coactivada. CINCO) Ofíciese al Registro
Mercantil del cantón "+" INGRESE CANTONES "+", a fin de que emita un certificado actualizado en el que conste 
el (los) nombre (s) de quien (es) ejerce (n) la representación legal, judicial y extrajudicial de la coactivada
<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong>.-  De conformidad con lo dispuesto en el 
Art. 952 del Código de Procedimiento Civil, en el Art. 952 del Código de Procedimiento Civil, una vez 
cumplida la notificación de las medidas cautelares ordenadas en este auto de pago, cítese al (los) coactivado 
(s) en legal y debida forma en el domicilio señalado en el título de crédito o en el lugar donde se lo encuentre,
previniéndole de la obligación que tiene de señalar casilla judicial para recibir futuras notificaciones 
de conformidad con lo dispuesto en el Art. 75 del Código de Procedimiento Civil. Se ofrece reconocer los 
abonos o cancelaciones que legalmente se comprobaren haberse realizado.<font color="#FFFFFF">a</font><b>- 
Cúmplase, cítese y ofíciese.-</b>.<br>
 <font color="#FFFFFF">MASOFTFIN</font>		
'.
'</p>'

.		
 '</div>'.

'</body></html>';

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper("A4", "portrait");

$dompdf->render();
$pdf = $dompdf->output();
$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/AutoPagos/';
$filename = "Autopago".'.pdf';
file_put_contents($directorio.$filename,$pdf);

?>