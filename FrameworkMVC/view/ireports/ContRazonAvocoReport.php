 <?php

#<?php
#Importas la librer�a PhpJasperLibrary
include_once('PhpJasperLibrary/class/tcpdf/tcpdf.php');
include_once("PhpJasperLibrary/class/PHPJasperXML.inc.php");
include_once ('conexion.php');
include_once("library/tcpdf/examples/lang/eng.php");
include_once("library/fpdi.php");
#Conectas a la base de datos
$server  = server;
$user    = user;
$pass    = pass;
$db      = db;
$driver  = driver;
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Pdf_concat extends FPDI {
	var $files = array();

	function setFiles($files) {
		$this->files = $files;

			
		function concat() {
			foreach($this->files AS $file) {
				$pagecount = $this->setSourceFile($file);
				for ($i = 1; $i <= $pagecount; $i++) {
					$tplidx = $this->ImportPage($i);
					$s = $this->getTemplatesize($tplidx);
					$this->AddPage('P', array($s['w'], $s['h']));
					$this->useTemplate($tplidx);
				}
			}
		}
	}
}


$estado=$_GET['estado'];

		if ($estado == 'Visualizar') 
		{
			ob_clean();
			
			$a=stripslashes($_GET['dato']);
			
			$_dato=urldecode($a);
			
			$_dato=unserialize($a);
			
			
			$PHPJasperXML = new PHPJasperXML ( "en", "TCPDF" );
			
			$PHPJasperXML->debugsql = false;
		
		    $PHPJasperXML->arrayParameter=$_dato;
		    
			$PHPJasperXML->load_xml_file( "RazonAvocoVisualizarReport.jrxml" );
			
			$PHPJasperXML->transferDBtoArray ( $server, $user, $pass, $db, $driver );
			
			$PHPJasperXML->outpage ( "I" );
			
		

	
		} else 
		{
		
				$id= $_GET['identificador'];
				$nombre=$_GET['nombre'];
				$nombre_avoco_conocimiento=$_GET['nombre_avoco_conocimiento'];
				$identificador_avoco_unido=$_GET['identificador_avoco_unido'];
				//aqui va la consulta
				$sql="SELECT
				razon_avoco_conocimiento.cuerpo_razon_avoco_conocimiento
				FROM
				public.razon_avoco_conocimiento,
				public.avoco_conocimiento
				WHERE
				avoco_conocimiento.id_avoco_conocimiento = razon_avoco_conocimiento.id_avoco_conocimiento AND
				razon_avoco_conocimiento.identificador= '$id'";
				
				
				$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonAvoco/';
				$directorio1 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/Avoco/';
				$directorio3 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonAvocoUnida/';
				
				$PHPJasperXML = new PHPJasperXML();
				$PHPJasperXML->arrayParameter=array("_sql" => $sql);
				$PHPJasperXML->load_xml_file("RazonAvocoGuardarReport.jrxml");
				$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);
				$PHPJasperXML->outpage("F",$directorio.$nombre.'.pdf');
		}			
				
		
		
		$file2merge=array($directorio1.'Avoco1073.pdf', $directorio.'RazonAvoco1090.pdf');
		$pdf = new Pdf_concat();
		$pdf->setFiles($file2merge);
		$pdf->concat();
		$pdf->Output($directorio3.'RazonAvocoUnida.pdf', "F");

		echo "<script type='text/javascript'>";
		echo "window.close()";
		echo "</script>";
		exit();
			
?>


