<?php
include_once('PDF.php');
include_once('myDBC.php');
	
	$mat = $_POST['matricula'];
	
	//Recibimos dentro de una cadena la fecha
	$fecha="M�xico D.F. a ".$_POST['dia']." de ". $_POST['mes']. " de ".$_POST['anio'];
	
	//Se crea un objeto de PDF
	//Para hacer uso de los m�todos
	$pdf = new PDF();
	$pdf->AddPage('P', 'Letter'); 
	$pdf->SetFont('Arial','B',12); 
	$pdf->Cell(0,10,$fecha,0,1,'R'); 
	
	$pdf->Cell(40,7,'P  R  E  S  E  N  T  E',0, 1 , ' L ');
	$pdf->Ln();
	
	$pdf->ImprimirTexto('textoFijo.txt'); //Texto fijo 
	
	//Creamos objeto de la clase myDBC
	//para hacer uso del m�todo seleccionar_persona()
	$consultaPersona = new myDBC();
	
	//En una variable guardamos el array que regresa el m�todo
	$datosPersona = $consultaPersona->seleccionar_persona($mat);
	
	//Array de cadenas para la cabecera
	$cabecera = array("Nombre","A Paterno","A Materno", "Matricula", "Puesto");
	$pdf->tabla($cabecera,$datosPersona); //M�todo que integra a cabecera y datos
	
	$pdf->Output(); //Salida al navegador del pdf
?>
