

<?php 
#<?php 
#Importas la librer�a PhpJasperLibrary
//add this line here

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
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

#aqu� va el reporte


$id=$_GET['id_juicios'];


			$PHPJasperXML = new PHPJasperXML ();
			
			$PHPJasperXML->debugsql = false;
		
		    $PHPJasperXML->arrayParameter=array('_id_juicios'=>19);
		    
			$PHPJasperXML->load_xml_file( "FichaVisualizarReport.jrxml" );
			
			$PHPJasperXML->transferDBtoArray ( $server, $user, $pass, $db, $driver );
			
			$PHPJasperXML->outpage ( "I" );
			
			/*$xml = simplexml_load_file("FichaVisualizarReport.jrxml"); // Leemos nuestro reporte de ireport
			
			
			$PHPJasperXML = new PHPJasperXML("en", "TCPDF"); // instanciamos el obj
			$PHPJasperXML->debugsql=false; // Si deseas ver la setencia del sql del reporte lo pones en true
			$PHPJasperXML->arrayParameter=array("_id_juicios"=>$id); // el paramentro que enviamos a nuestro reporte
			$PHPJasperXML->xml_dismantle($xml);
			$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db); // las opciones de conexion de base de datos
			$PHPJasperXML->outpage("I"); // I: muetsra en el browser D: descarga el pdf
*/

?>
