<?php

$base_url = "http://localhost:4000/FrameworkMVC/";





$creado						                     = "";	  
$numero_oficios                                  = "";	
$id_juicios			                    		 = ""; 
$juicio_referido_titulo_credito                  = ""; 
$id_titulo_credito                               = ""; 
$nombres_clientes						         = "";
$identificacion_clientes                         = "";
$id_entidades			                         = "";
$nombre_entidades                             	 = "";
$juicio_referido_titulo_credito                  = "";
$creado                                       	 = "";
$total                                           = "";
$direccion_clientes                              = "";
$nombre_ciudad                                   = "";
$secretarios									 = "";
$impulsores										 = "";
$liquidador										 = "";
$numero_oficios									 = "";
$identificador                                   = "";

require_once('view/dompdf/dompdf_config.inc.php' );


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$dato['fecha']=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
$dato['hora']= date ("h:i:s");
	

foreach($resultSet as $res) 
{
	
	$creado						                      =$dias[date('w',strtotime($res->creado))]." ".date('d',strtotime($res->creado))." de ".$meses[date('n',strtotime($res->creado))-1]. " del ".date('Y',strtotime($res->creado)). " a las ".date("h:i:s",strtotime($res->creado)) ;
	$numero_oficios                                   =$res->numero_oficios;
	$id_juicios			                              =$res->id_juicios;
	$juicio_referido_titulo_credito                   =$res->juicio_referido_titulo_credito;
	$id_titulo_credito                        		  =$res->numero_titulo_credito;
	$nombres_clientes						          =$res->nombres_clientes;
	$identificacion_clientes                          =$res->identificacion_clientes;
	$id_entidades                                     =$res->nombres_clientes;
	$nombre_entidades                            	  =$res->nombre_entidades;
	$juicio_referido_titulo_credito                   =$res->juicio_referido_titulo_credito;
	$total                                            =$res->total_total_titulo_credito;   
	$direccion_clientes                               =$res->direccion_clientes;
	$nombre_ciudad                                    =$res->nombre_ciudad;
	$secretarios									  =$res->secretarios;
	$impulsores										  =$res->impulsores;
	$liquidador										  =$res->liquidador;
	$numero_oficios									  =$res->numero_oficios;
	$identificador                                       =$res->identificador;
	//=$dias[date('w',strtotime($res->fecha_citaciones))]." ".date('d',strtotime($res->fecha_citaciones))." de ".$meses[date('n',strtotime($res->fecha_citaciones))-1]. " del ".date('Y',strtotime($res->fecha_citaciones)). " a las ".date("h:i:s",strtotime($res->fecha_citaciones)) ;
	
	
	                                            
}

$logo  = '<img src="view/images/logo_fomento1.jpg" alt="Responsive image" width="200" height="80">';
 

$html =
  '<html>'.
  '<head>'.
  	'<meta charset="utf-8"/>'.
  	'<title> '.'' .' Oficios</title>'.
  	
  '</head>'.
  '<body>'.
  
'<div>'.


'<p style="text-align: right;">'.$logo.'</p><br>'.





'<p style="text-align: rigth;">'.
'<font face="arial, verdana" size="3">
<b>A:</b> '.$nombre_entidades.'<br>
<b>Oficio N°</b><b>Oficio N°</b> '.$numero_oficios.'<br>
<b>Se le hace saber que dentro del presente juicio coactivo se encuentra lo siguiente:</b><br>
<strong>'.$nombre_ciudad.',</strong><font color="#FFFFFF">a</font>'.$creado.'
<br>
</font>'
.'</p>'.  


'<p style="text-align: justify;">'.
'<font face="arial, verdana" size="3">
 VISTOS: Del (los) título (s) de crédito No. (s)<font color="#FFFFFF">a</font><strong>'.$id_titulo_credito.'</strong> 
 , que ha (n) sido expedido (s) por el Banco Nacional del Fomento S.A. en Liquidación, y emitido (s) en fecha<font 
 color="#FFFFFF">a</font><strong>'.$creado.'</strong>, de conformidad con liquidación (es) que se manda(n) agregar
 a los autos aparece que<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'</strong> con CI.<font color="#FFFFFF">
 a</font><strong>'.$identificacion_clientes.'</strong> adeuda (n) a esta Institución Bancaria en Liquidación la suma de USD$
 <font color="#FFFFFF">a</font><strong>'.$total.'</strong> DOLARES DE LOS ESTADOS UNIDOS DE AMÉRICA), más los intereses y costas
 y gastos judiciales que se generen hasta la fecha de pago total. Y siendo la obligación líquida, determinada y de plazo vencido,
 en mi calidad de Liquidador del Banco Nacional del Fomento en Liquidación, conforme a la designación a mi extendida y fundado en la
 orden de cobro contenidos ambos actos en la Resolución No. JB-2013-2438, emitida por el Ab. Pedro Solines Chacón, en su calidad 
 de Presidente de la Junta Bancaria, dada en la Superintendencia de Bancos y Seguros en Guayaquil con fecha 26 de marzo de 2013, 
 inscrita en el Registro Mercantil del cantón Guayaquil el 27 de marzo de 2013, en la que se dispone la liquidación forzosa del 
 Banco Nacional del Fomento S.A., y de conformidad con lo dispuesto en los Arts. 941, 945, 946. 948 y 951 del Código de 
 Procedimiento Civil, INICIO el presente juicio coactivo contra<font color="#FFFFFF">a</font><strong>'.$nombres_clientes.'
 </strong>, registrado con C.I. No.<font color="#FFFFFF">a</font><strong>'.$identificacion_clientes.'</strong>  y en 
 consecuencia ORDENO que el (los) deudor (es) pague (n) al Banco Nacional del Fomento en Liquidación la cantidad adeudada,
 más los intereses generados hasta la fecha y los que se generen hasta la total cancelación de la deuda, intereses de mora, 
 comisión, gastos judiciales, costas procesales, honorarios y otros accesorios legales, o dimita bienes en el término perentorio
 de tres días, contados desde que se cite con el auto de pago, apercibiéndole (s) que de no hacerlo se le embargará bienes que 
 aseguren la recuperación de todo lo adeudado, de conformidad con lo dispuesto en el Art. 962 del Código de Procedimiento Civil,
 actúen en el presente juicio, como secretario e impulsor respectivamente, el Ab.<font color="#FFFFFF">a</font><strong>'.$secretarios.'
 </strong>y el(la) Ab.<font color="#FFFFFF">a</font><strong>'.$impulsores.'</strong> quienes estando presentes aceptan los cargos 
 conferidos y juran desempeñarlos fiel y legalmente, firmando para constancia con el suscrito Juez de Coactiva. Desglósese el 
 (los) título (s) de crédito aparejado (s) a la coactiva, así como el documento habilitante que acredita la calidad invocada, 
 dejándose las copias certificadas en autos, remitiéndose el original al departamento correspondiente para su respectiva custodia. 
 En lo principal, por disposición de lo prescrito en la parte final del inciso primero del Art. 942 del Código de Procedimiento Civil, 
 en concordancia con los Arts. 421 y 426 del Código Adjetivo Civil, díctanse las siguientes medidas cautelares: UNO) Al tenor de lo 
 dispuesto en los Arts. 6, 9 y 18 de la Ley del Sistema Nacional de Registro de Datos Públicos, notifíquese a los señores Registradores 
 de la Propiedad del (los) cantón (es) Guayaquil, Duran, Samborondón, Salinas, General Villamil (Playas), Daule, Santa Elena, para que 
 remitan a este Juzgado un certificado actualizado de bienes inmuebles que consten inscritos a nombre del (los) coactivado (s) 
 debiéndose señalar linderos, medidas, superficie, historia de dominio; y, se inscriba la Prohibición de gravar y/o enajenar 
 sobre los bienes inmuebles que el (los) coactivado (s) tenga inscritos a su nombre en dichos Registros. Hecho, remítase a la 
 Secretaría de este Juzgado ubicado en la ciudad de Guayaquil, calles P. Ycaza 115 y Pichincha planta baja; DOS) Prohibición 
 de gravar y/o enajenar los vehículos del (los) coactivado (s), para cuyo efecto notifíquese a la<font color="#FFFFFF">a</font>
 <strong>'.$nombre_entidades.'</strong>, fin de que tome nota en sus registros de la medida cautelar dispuesta, hecho lo cual,
 emita un certificado donde consten las características de los vehículos sobre los cuales se ha registrado la medida cautelar 
 ordenada; TRES) Se ordena la retención de valores de conformidad con lo dispuesto en el Art. 425 del Código de Procedimiento 
 Civil, hasta por la cantidad de USD$<font color="#FFFFFF">a</font><strong>'.$total.'</strong> DOLARES DE LOS ESTADOS UNIDOS DE 
 AMÉRICA), retención que se verificará en las inversiones que mantenga el (los) coactivado (s) en las instituciones bancarias y financieras que operan en el país, sean éstas cuentas corrientes, de ahorros, inversiones, depósitos a plazo, pólizas de acumulación y de cualquier otra operación en dicha institución, para lo cual deberá oficiarse a la Superintendencia de Bancos 
 y Seguros. De conformidad con lo dispuesto en el Art. 428 del Código de Procedimiento Civil, las entidades bancarias sujetas 
 al control de la Superintendencia de Bancos y Seguros, deberán informar a éste Juzgado en el término improrrogable de 72 horas 
 el cumplimiento de la retención ordenada, sin perjuicio de que el secretario de la causa notifique directamente a las 
 instituciones que conforman el Sistema Financiero Nacional. Notifíquese a la Dirección General de Registro Civil, Identificación
 y Cedulación, para que remitan a este Juzgado la tarjeta índice, datos de filiación, dirección domiciliaria y demás información
 que registre en sus archivos físicos y/o electrónicos referente al (los) coactivado (s). De conformidad con lo dispuesto en el Art.
 952 del Código de Procedimiento Civil, una vez cumplida la notificación de las medidas cautelares ordenadas en este auto de pago,
 cítese al (los) coactivado (s) en legal y debida forma en el domicilio señalado en el título de crédito o en el lugar donde se 
 lo encuentre, previniéndole de la obligación que tiene de señalar casilla judicial para recibir futuras notificaciones de 
 conformidad con lo dispuesto en el Art. 75 del Código de Procedimiento Civil. Se ofrece reconocer los abonos o cancelaciones 
 que legalmente se comprobaren haberse realizado.- Cúmplase, cítese y ofíciese.- f.) Ab.<font color="#FFFFFF">a</font>
 <strong>'.$liquidador.'</strong>- Liquidador - Juez de Coactiva - Banco S.A., en Liquidación.- f.) Ab.<font color="#FFFFFF">a</font>
 <strong>'.$secretarios.'</strong>- Secretario de Coactiva.- f.) Ab. <font color="#FFFFFF">a</font><strong>'.$impulsores.'</strong>
 -Abogado(a) Impulsor(a).<font color="#FFFFFF">a</font><b>Lo certifíco.-</b>.<br>
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

'</body></html>';


 		
 		

	

 

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper("A4", "portrait");

$dompdf->render();
$pdf = $dompdf->output();
$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/Oficios/';
$filename = "Oficios".$identificador.'.pdf';
file_put_contents($directorio.$filename,$pdf);




?>