<?php
ob_start();
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

$estado=$_GET['estado'];

		if ($estado == 'Visualizar') 
		{
	
			$a=stripslashes($_GET['dato']);
			
			$_dato=urldecode($a);
			
			$_dato=unserialize($a);
			
			
			
			$PHPJasperXML = new PHPJasperXML ( "en", "TCPDF" );
			
			$PHPJasperXML->debugsql = false;
		
		    $PHPJasperXML->arrayParameter=$_dato;
		    
			$PHPJasperXML->load_xml_file( "AutoPagoVizualizarJURIDICOCREGARANTEReport.jrxml" );
			
			$PHPJasperXML->transferDBtoArray ( $server, $user, $pass, $db, $driver );
			
			$PHPJasperXML->outpage ( "I" );
		
		
	
		} else 
		{
			
	
				$id= $_GET['identificador'];
				$nombre=$_GET['nombre'];
				$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/AutoPagos/';
				
				$sql="SELECT juicios.juicio_referido_titulo_credito,
						juicios.creado,
						clientes.nombres_clientes,
						clientes.identificacion_clientes,
						clientes.nombre_garantes,
						clientes.identificacion_garantes,
						asignacion_secretarios_view.liquidador,
						asignacion_secretarios_view.secretarios,
						asignacion_secretarios_view.impulsores,
						titulo_credito.id_titulo_credito,
						titulo_credito.total_total_titulo_credito
					FROM public.asignacion_secretarios_view,
						public.clientes,
						public.auto_pagos,
						public.titulo_credito,
						public.juicios
					WHERE 
						 asignacion_secretarios_view.id_abogado = titulo_credito.id_usuarios 
						 AND clientes.id_clientes = titulo_credito.id_clientes 
						 AND titulo_credito.id_titulo_credito = auto_pagos.id_titulo_credito 
						 AND titulo_credito.id_titulo_credito = juicios.id_titulo_credito 
						 AND auto_pagos.identificador = '$id' ";
				
				$PHPJasperXML = new PHPJasperXML();
				
				$PHPJasperXML->debugsql = false;
				
				$PHPJasperXML->arrayParameter=array('sql' => $sql);
				
				$PHPJasperXML->load_xml_file("AutoPagoJURIDICOCREGARANTEReport.jrxml");
					
				$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);
					
				//$PHPJasperXML->outpage("F",$directorio.$nombre.'.pdf');
				$PHPJasperXML->outpage("I");
				
				
				echo "<script type='text/javascript'>";
				echo "window.close()";
				echo "</script>";
				exit();
				

		
		}

?>

