<?php

	$cadenacertificado="serialNumber=0000151005 cn=EDISON IVAN MANTILLA TAPIA,l=QUITO,ou=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE,o=BANCO CENTRAL DEL ECUADOR,c=EC Verification Certificate";
	
	$array_certificado=datosCertificado($cadenacertificado);
	
	 function datosCertificado($cadenacertificado)
	{
		$arrayCertificado=array();
		
		if ($cadenacertificado!=null || $cadenacertificado!="")
		{
			$arraydatosCertificado = explode(",", $cadenacertificado, 5);
			
			$arrayEmitidoPara=explode(" ", $arraydatosCertificado[0], 2);
				
			$emitidopara=substr($arrayEmitidoPara[1],strpos($arrayEmitidoPara[1],"=")+1);
			$emitidopor=substr($arraydatosCertificado[3],strpos($arraydatosCertificado[3],"=")+1);
			
			$arrayCertificado=array('emitidoPara'=>$emitidopara,'emitidoPor'=>$emitidopor);
			
		}
		
		return $arrayCertificado;
		
	}
	
	//print_r($array_certificado);
	
	$_id_documentos="466,456,789";
	
	$array_documento = explode(",", $_id_documentos);
	
	print_r($array_documento);
	
?>