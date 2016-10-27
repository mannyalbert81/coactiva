
<?php 
#<?php 
#Importas la librer�a PhpJasperLibrary
ob_end_clean(); //add this line here

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
$PHPJasperXML->debugsql=false;
#aqu� va el reporte

$sql="SELECT juicios.id_juicios, ciudad.nombre_ciudad, juicios.juicio_referido_titulo_credito, 
		titulo_credito.numero_titulo_credito, titulo_credito.fecha_ultimo_abono_titulo_credito, 
		titulo_credito.total_total_titulo_credito, juicios.observaciones_juicios, 
		estados_procesales_juicios.nombre_estados_procesales_juicios, juicios.estrategia_juicios, 
		asignacion_secretarios_view.impulsores, clientes.identificacion_clientes, 
		clientes.nombres_clientes 
	FROM public.titulo_credito, public.juicios, 
		public.estados_procesales_juicios, 
		public.ciudad, public.clientes, 
		public.asignacion_secretarios_view 
	WHERE titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND 
		estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND 
		ciudad.id_ciudad = juicios.id_ciudad AND clientes.id_clientes = juicios.id_clientes AND 
		asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND 
		estados_procesales_juicios.id_estados_procesales_juicios='10'";

$PHPJasperXML = new PHPJasperXML("en","TCPDF");
$PHPJasperXML->debugsql=false;
$PHPJasperXML->arrayParameter=array("_sql"=>$sql);
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->load_xml_file("CordinadorReport.jrxml");

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);
$PHPJasperXML->outpage("I");


?>
