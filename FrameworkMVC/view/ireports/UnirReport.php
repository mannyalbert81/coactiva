<?php
include 'PDFMerger/PDFMerger.php';

$pdf = new PDFMerger;
$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonDocumentos/';
$directoriofinal = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/RazonUnida/';

$pdf->addPDF($directorio.'RazonDocumentos1005.pdf', 'all')
	->addPDF($directorio.'RazonDocumentos1004.pdf', 'all')
	
	->merge('download','');
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
?>
