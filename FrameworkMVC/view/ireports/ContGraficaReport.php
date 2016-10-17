<?php

#<?php
#Importas la librer�a PhpJasperLibrary
include('PhpJasperLibrary/class/tcpdf/tcpdf.php');
include("PhpJasperLibrary/class/PHPJasperXML.inc.php");
include('conexion.php');
include("PhpJasperLibrary/class/pChart2/class/pData.class.php");
include("PhpJasperLibrary/class/pChart2/class/pDraw.class.php");
include("PhpJasperLibrary/class/pChart2/class/pImage.class.php");


#Conectas a la base de datos
$server  = server;
$user    = user;
$pass    = pass;
$db      = db;
$driver  = driver;
ini_set('display_errors', 0);

#aqu� va el reporte.

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->load_xml_file("GraficaReport.jrxml");
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);

$PHPJasperXML->outpage("I") 
?>
