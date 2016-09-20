
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


#aqu� va el reporte

//parametros 

		$a=stripslashes($_GET['dato']);			
		$_dato=urldecode($a);			
		$_dato=unserialize($a);
		

		$id_ciudad=$_dato['id_ciudad'];
		$id_impulsor=$_dato['id_impulsor'];
		$identificacion_cliente=$_dato['identificacion'];
		$numero_juicio=$_dato['numero_juicio'];
		$fechadesde=$_dato['fecha_desde'];
		$fechahasta=$_dato['fecha_hasta'];
		$id_usuario=$_dato['id_usuario'];
		
		
		$columnas = " ciudad.nombre_ciudad,
							clientes.nombres_clientes,
							clientes.identificacion_clientes,
							juicios.observaciones_juicios,
							juicios.estrategia_juicios,
							juicios.juicio_referido_titulo_credito,
							juicios.creado,
							estados_procesales_juicios.nombre_estados_procesales_juicios,
							juicios.id_juicios,
							juicios.fecha_emision_juicios,
							juicios.numero_juicios,
							asignacion_secretarios_view.secretarios,
							asignacion_secretarios_view.liquidador,
							asignacion_secretarios_view.impulsores";
		
		$tablas   = "public.ciudad,
							public.juicios,
							public.clientes,
							public.estados_procesales_juicios,
							public.asignacion_secretarios_view";
		
		$where    = "ciudad.id_ciudad = juicios.id_ciudad AND
							clientes.id_clientes = juicios.id_clientes AND
							estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND
							asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND juicios.revisado_juicios = TRUE";
	
		
		$where_0 = "";
		$where_1 = "";
		$where_2 = "";
		$where_3 = "";
		$where_4 = "";
		$Where_5 = " AND asignacion_secretarios_view.id_secretario = '$id_usuario'";
		
		
		if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
		
		if($id_impulsor!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_impulsor'";}
		
		if($identificacion_cliente!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion_cliente'";}
		
		if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
		
		if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
		
		
		
		$where_to  = $where .$where_0. $where_1 . $where_2.$where_3.$where_4.$Where_5;
		
		
		$sql='SELECT '.$columnas.' FROM '.$tablas.' WHERE '.$where_to;
		
			

			$PHPJasperXML = new PHPJasperXML("en","TCPDF");
			
			$PHPJasperXML->debugsql = false;
		
		    $PHPJasperXML->arrayParameter=array('_sql'=>$sql);
		    
			$PHPJasperXML->load_xml_file( "FichaGeneralVisualizarReport.jrxml" );
			
			$PHPJasperXML->transferDBtoArray ( $server, $user, $pass, $db, $driver );
			
			$PHPJasperXML->outpage ( "I" );
		
?>
