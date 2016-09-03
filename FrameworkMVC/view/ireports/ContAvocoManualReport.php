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
			
			$PHPJasperXML->load_xml_file( "AvocoVisualizarManualReport.jrxml" );
				
			$PHPJasperXML->transferDBtoArray ( $server, $user, $pass, $db, $driver );
				
			$PHPJasperXML->outpage ( "I" );
				

		} else 
		{
			
				
			 $id= $_GET['identificador'];
			 $nombre=$_GET['nombre'];
			 //aqui va la consulta
			 $sql="SELECT 
					  avoco_conocimiento.cuerpo_avoco
					  
					FROM 
					  public.avoco_conocimiento, 
                      public.juicios
					WHERE 
					  juicios.id_juicios = avoco_conocimiento.id_juicios AND
					  avoco_conocimiento.identificador= '$id' ";
			
			 $directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/Avoco/';
			
			 $PHPJasperXML = new PHPJasperXML();
			
			 $PHPJasperXML->arrayParameter=array("_sql" => $sql);
			
			 $PHPJasperXML->load_xml_file("AvocoGuardarManualReport.jrxml");
			
			
			 $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);
			
			 $PHPJasperXML->outpage("F",$directorio.$nombre.'.pdf');
		
	
           }
           
           echo "<script type='text/javascript'>";	
           echo "window.close()";
           echo "</script>";
           exit();

?>

