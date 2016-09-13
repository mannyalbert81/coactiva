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
			}
		
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
		$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonAvoco/';
		$directorio1 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/Avoco/';
		$directorio3 = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonAvocoUnida/';
		
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

