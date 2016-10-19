
<?php 
#<?php 
#Importas la librer�a PhpJasperLibrary
ob_end_clean(); //add this line here

include_once('PhpJasperLibrary/class/tcpdf/tcpdf.php');
include_once("PhpJasperLibrary/class/PHPJasperXML.inc.php");

include_once ('conexion.php');

//$array_consulta=isset($sql)?$sql:array("documento"=>'',"sql"=>'');

#Conectas a la base de datos 
$server  = server;
$user    = user;
$pass    = pass;
$db      = db;
$driver  = driver;

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

	
	$PHPJasperXML = new PHPJasperXML();

	//$PHPJasperXML->arrayParameter=array("_sql"=>$array_consulta['sql']);

	$PHPJasperXML->load_xml_file("CordinadorReport.jrxml");

	$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);

	$PHPJasperXML->outpage("I");


?>
