<?php


#<?php
#Importas la librer�a PhpJasperLibrary
include_once('PhpJasperLibrary/class/tcpdf/tcpdf.php');
include_once("PhpJasperLibrary/class/PHPJasperXML.inc.php");
include_once ('conexion.php');
#Conectas a la base de datos
$server  = server;
$user    = user;
$pass    = pass;
$db      = db;
$driver  = driver;
ini_set('display_errors', 0);


$array_datos=$_SERVER['data_ireport'];

$sql="SELECT avoco_conocimiento.id_avoco_conocimiento,
 juicios.juicio_referido_titulo_credito,
  clientes.nombres_clientes,
   clientes.identificacion_clientes, 
   ciudad.nombre_ciudad, 
   asignacion_secretarios_view.secretarios, 
   asignacion_secretarios_view.impulsores,
    juicios.creado
    
 FROM public.avoco_conocimiento,
  public.juicios, public.ciudad, 
  public.asignacion_secretarios_view, 
  public.clientes 
  
  WHERE avoco_conocimiento.id_impulsor = asignacion_secretarios_view.id_abogado 
  AND juicios.id_juicios = avoco_conocimiento.id_juicios 
  AND ciudad.id_ciudad = juicios.id_ciudad 
  AND clientes.id_clientes = juicios.id_clientes ";


#aqu� va el reporte

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->sql=$sql;
$PHPJasperXML->load_xml_file("CordinadorDocumentosReport.jrxml");

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);
$PHPJasperXML->outpage("I");
?>
