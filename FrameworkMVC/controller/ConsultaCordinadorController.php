<?php
class ConsultaCordinadorController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	public function consulta_cordinador(){

		session_start();
		
		//eliminar variable de seesion para pasar sql al irepot
		if(isset($_SESSION['data_ireport'])){unset($_SESSION['data_ireport']);}
		
		//Creamos el objeto usuario
		$resultCita=array();
		$resultProv=array();
		$resultOfi=array();
		$resultAvoCono=array();
		$resultAutoPago=array();
		
		/*
		$array=$_SESSION['tu_array_de_cualquier_dimension'];
		// Y si no quieres la variable de sesión creada:
		unset($_SESSION['tu_array_de_cualquier_dimension']);
		// Y si realmente no usas sesiones en tu aplicación para nada ..
		// Destruyes tu sesión.
		session_destroy();
		
		// en $array vuelves a tener en este punto tu array tal cual .. sin más proceso que aplicar.
		*/
		
		$documentos_impulsores=new DocumentosModel();
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getBy("nombre_ciudad='QUITO' OR nombre_ciudad='GUAYAQUIL' ");
		
            if (isset(  $_SESSION['usuario_usuarios']) )
		    {
			//notificaciones
			$documentos_impulsores->MostrarNotificaciones($_SESSION['id_usuarios']);
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaCordinador";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $documentos_impulsores->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );

			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){

					$tipo_documento=$_POST['tipo_documento'];
					
					//inicializar variables
					$id_ciudad        = (isset($_POST['id_ciudad']))?$_POST['id_ciudad']:0;
					$id_secretario    = (isset($_POST['id_secretario']))?$_POST['id_secretario']:0;
					$id_impulsor      = (isset($_POST['id_impulsor']))?$_POST['id_impulsor']:0;
					$identificacion   = (isset($_POST['identificacion']))?$_POST['identificacion']:'';
					$numero_juicio    = (isset($_POST['numero_juicio']))?$_POST['numero_juicio']:'';
					$estado_documento = (isset($_POST['estado_documento']))?$_POST['estado_documento']:0;
					$fechadesde       = (isset($_POST['fecha_desde']))?$_POST['fecha_desde']:'';
					$fechahasta       = (isset($_POST['fecha_hasta']))?$_POST['fecha_hasta']:'';
					
					
					//buscar por citaciones
					if($tipo_documento == "citaciones")
					{
						
					    
						
					$citaciones= new CitacionesModel();


					$columnas = "citaciones.id_citaciones, 
								  juicios.id_juicios, 
								  juicios.juicio_referido_titulo_credito, 
								  clientes.identificacion_clientes, 
								  clientes.nombres_clientes, 
								  citaciones.fecha_citaciones, 
								  ciudad.nombre_ciudad, 
								  citaciones.nombre_persona_recibe_citaciones, 
								  citaciones.relacion_cliente_citaciones, 
								  usuarios.nombre_usuarios";

					$tablas=" public.citaciones, 
							  public.ciudad, 
							  public.clientes, 
							  public.juicios, 
							  public.usuarios";

					$where="ciudad.id_ciudad = juicios.id_ciudad AND
						  clientes.id_clientes = juicios.id_clientes AND
						  juicios.id_juicios = citaciones.id_juicios AND
						  usuarios.id_usuarios = citaciones.id_usuarios";

					$id="citaciones.id_citaciones";
						
						
						$where_0 = "";
						$where_1 = "";
						$where_2 = "";
						$where_3 = "";
						$where_4 = "";
						$where_5 = "";
						
						
						if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
							
						if($id_secretario!=0){$where_1=" AND usuarios.id_usuarios='$id_secretario'";}
						
						if($id_impulsor!=0){$where_2=" AND usuarios.id_usuarios='$id_impulsor'";}
						
						if($identificacion!=""){$where_3=" AND clientes.identificacion_clientes='$identificacion'";}
							
						if($numero_juicio!=""){$where_4=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
						if($fechadesde!="" && $fechahasta!=""){$where_5=" AND  citaciones.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
						
						
						$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4 . $where_5;
						
						
						$resultCita=$citaciones->getCondiciones($columnas ,$tablas , $where_to, $id);
						
					}
					
					//buscar por providencias
					if($tipo_documento == "providencias")
					{
						
						$documentos=new DocumentosModel();
						
						
						$columnas = "documentos.id_documentos,
						ciudad.nombre_ciudad,
						juicios.juicio_referido_titulo_credito,
						clientes.nombres_clientes,
						clientes.identificacion_clientes,
						documentos.nombre_documento,
						asignacion_secretarios_view.impulsores,
						asignacion_secretarios_view.secretarios,
						documentos.fecha_emision_documentos,
						documentos.hora_emision_documentos";
						
						$tablas=" public.ciudad, 
								  public.clientes, 
								  public.juicios, 
								  public.asignacion_secretarios_view, 
								  public.documentos";
														
						$where="clientes.id_clientes = juicios.id_clientes AND
							  juicios.id_juicios = documentos.id_juicio AND
							  asignacion_secretarios_view.id_abogado = documentos.id_usuario_registra_documentos AND
							  documentos.id_ciudad = ciudad.id_ciudad";
						
						$id="documentos.id_documentos";
						
						
						$where_0 = "";
						$where_1 = "";
						$where_2 = "";
						$where_3 = "";
						$where_4 = "";
						$where_5 = "";
						
						
						if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
							
						if($id_secretario!=0){$where_1=" AND asignacion_secretarios_view.id_secretario='$id_secretario'";}
						
						if($id_impulsor!=0){$where_2=" AND asignacion_secretarios_view.id_abogado='$id_impulsor'";}
						
						if($identificacion!=""){$where_3=" AND clientes.identificacion_clientes='$identificacion'";}
							
						if($numero_juicio!=""){$where_4=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
						if($fechadesde!="" && $fechahasta!=""){$where_5=" AND  documentos.fecha_emision_documentos BETWEEN '$fechadesde' AND '$fechahasta'";}
						
						
						$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4 . $where_5;
						
						
						$resultProv=$documentos->getCondiciones($columnas ,$tablas , $where_to, $id);
						
						
					}
					
					//buscar por oficios
					if($tipo_documento == "oficios")
					{
						
	
					$oficios= new OficiosModel();
					
					$columnas = "oficios.id_oficios,
					oficios.creado,
					oficios.numero_oficios,
					juicios.id_juicios,
					juicios.juicio_referido_titulo_credito,
					juicios.id_titulo_credito,
					clientes.nombres_clientes,
					clientes.identificacion_clientes,
					entidades.id_entidades,
					entidades.nombre_entidades";
	
					$tablas="public.oficios,
					public.juicios,
					public.entidades,
					public.clientes,
					public.usuarios";
	
					$where="juicios.id_juicios = oficios.id_juicios AND
					entidades.id_entidades = oficios.id_entidades AND
					clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios";
	
					$id="oficios.id_oficios";
						
						$where_0 = "";
						$where_1 = "";
						$where_2 = "";
						$where_3 = "";
						$where_4 = "";
						$where_5 = "";
						
						
						if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
							
						if($id_secretario!=0){$where_1=" AND usuarios.id_usuarios='$id_secretario'";}
						
						if($id_impulsor!=0){$where_2=" AND usuarios.id_usuarios='$id_impulsor'";}
						
						if($identificacion!=""){$where_3=" AND clientes.identificacion_clientes='$identificacion'";}
							
						if($numero_juicio!=""){$where_4=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
						if($fechadesde!="" && $fechahasta!=""){$where_5=" AND  documentos.fecha_emision_documentos BETWEEN '$fechadesde' AND '$fechahasta'";}
						
						
						$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4 . $where_5;
						
						
						$resultOfi=$oficios->getCondiciones($columnas ,$tablas , $where_to, $id);
						
						
					
					}
					
					//buscar por avoco conocimiento
					if($tipo_documento == "avoco_conocimiento")
					{
						
						
				$avoco_conocimiento =new AvocoConocimientoModel();						
						
					$columnas = "avoco_conocimiento.id_avoco_conocimiento, 
							  juicios.juicio_referido_titulo_credito, 
							  clientes.nombres_clientes, 
							  clientes.identificacion_clientes, 
							  ciudad.nombre_ciudad, 
							  asignacion_secretarios_view.secretarios, 
							  asignacion_secretarios_view.impulsores,
							  juicios.creado";

					$tablas=" public.avoco_conocimiento, 
							  public.juicios, 
							  public.ciudad, 
							  public.asignacion_secretarios_view, 
							  public.clientes";

					$where="avoco_conocimiento.id_impulsor = asignacion_secretarios_view.id_abogado AND
						  juicios.id_juicios = avoco_conocimiento.id_juicios AND
						  ciudad.id_ciudad = juicios.id_ciudad AND
						  clientes.id_clientes = juicios.id_clientes";

					$id="avoco_conocimiento.id_avoco_conocimiento";
						
						
						$where_0 = "";
						$where_1 = "";
						$where_2 = "";
						$where_3 = "";
						$where_4 = "";
						$where_5 = "";
						
						
						if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
							
						if($id_secretario!=0){$where_1=" AND asignacion_secretarios_view.id_secretario='$id_secretario'";}
						
						if($id_impulsor!=0){$where_2=" AND asignacion_secretarios_view.id_abogado='$id_impulsor'";}
						
						if($identificacion!=""){$where_3=" AND clientes.identificacion_clientes='$identificacion'";}
							
						if($numero_juicio!=""){$where_4=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
						if($fechadesde!="" && $fechahasta!=""){$where_5=" AND  avoco_conocimiento.fecha_emision_documentos BETWEEN '$fechadesde' AND '$fechahasta'";}
						
						$where_6="";
						
						if($estado_documento=='true'||$estado_documento=='false')
						{
							
							if($id_secretario!=0&&$id_impulsor!=0)
							{
								$where_6=" AND avoco_conocimiento.firma_impulsor='$estado_documento' AND avoco_conocimiento.firma_secretario = '$estado_documento' ";
							}else if($id_secretario!=0)
							{
								$where_6=" AND avoco_conocimiento.firma_secretario = '$estado_documento' ";
							}else if($id_impulsor!=0)
							{
								$where_6=" AND avoco_conocimiento.firma_impulsor = '$estado_documento' ";
							}
						
						}
						
						$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4 . $where_5.$where_6;
						
						//echo $where_to;
						//die();
						
						$resultAvoCono=$avoco_conocimiento->getCondiciones($columnas ,$tablas , $where_to, $id);
						
						$_SESSION['data_ireport']=array("documento"=>'avoco',"sql"=>'SELECT '.trim($columnas).' FROM '.trim($tablas).' WHERE '.trim($where).' ORDER BY '.$id);
						
					}
					
					//buscar por auto pago
					if($tipo_documento == "auto_pago")
					{
											
						$auto_pago =new AutoPagosModel();
					
					
						$columnas = " auto_pagos.id_auto_pagos, 
						  auto_pagos.id_titulo_credito, 
						  clientes.identificacion_clientes, 
						  clientes.nombres_clientes, 
						  usuarios.nombre_usuarios, 
						  auto_pagos.fecha_asiganacion_auto_pagos, 
						  estado.nombre_estado";
					
						$tablas   = "public.auto_pagos, 
								  public.usuarios, 
								  public.titulo_credito, 
								  public.estado, 
								  public.clientes";
					
						$where    = "usuarios.id_usuarios = auto_pagos.id_usuario_impulsor AND
								  titulo_credito.id_titulo_credito = auto_pagos.id_titulo_credito AND
								  estado.id_estado = auto_pagos.id_estado AND
								  clientes.id_clientes = titulo_credito.id_clientes ";
					
						$id       = "auto_pagos.id_auto_pagos";
					
					
						$where_0 = "";
						$where_1 = "";
						$where_2 = "";
						$where_3 = "";
						$where_4 = "";
						$where_5 = "";
					
					
						if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
							
						if($id_secretario!=0){$where_1=" AND usuarios.id_usuarios='$id_secretario'";}
					
						if($id_impulsor!=0){$where_2=" AND usuarios.id_usuarios='$id_impulsor'";}
					
						if($identificacion!=""){$where_3=" AND clientes.identificacion_clientes='$identificacion'";}
							
						if($numero_juicio!=""){$where_4=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
					
						if($fechadesde!="" && $fechahasta!=""){$where_5=" AND  documentos.fecha_emision_documentos BETWEEN '$fechadesde' AND '$fechahasta'";}
					
					
						$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4 . $where_5;
					
					
						$resultAutoPago=$auto_pago->getCondiciones($columnas ,$tablas , $where_to, $id);
					
					
							
					}
					
				
				
				}
				
				

				$this->view("ConsultaCordinador",array(
						"resultCita"=>$resultCita, "resultProv"=>$resultProv,"resultCiu"=>$resultCiu,"resultOfi"=>$resultOfi,
						"resultAvoCono"=>$resultAvoCono,"resultAutoPago"=>$resultAutoPago
							
				));

			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Consulta Cordinador"

				));

				exit();
			}

		}
		else
		{
			$this->view("ErrorSesion",array(
					"resultSet"=>""

			));

		}

	}

	
	
	  public function abrirPdf_citaciones()
	  {
		$citaciones = new CitacionesModel();
	
		if(isset($_GET['id']))
		{
				
			$id_citacion = $_GET ['id'];
				
			$resultCitacion= $citaciones->getBy ( "id_citaciones='$id_citacion'" );
				
			if (! empty ( $resultCitacion )) {
	
				$nombrePdf = $resultCitacion [0]->nombre_citacion;
	
				$nombrePdf .= ".pdf";
	
				$ruta = $resultCitacion [0]->ruta_citacion;
	
				$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="'.$directorio.'"');
				readfile($directorio);
			}
	
	
		}
		
	
	  }
	  
	  
	  public function abrirPdf_oficios()
	  {
	  	$oficios = new OficiosModel();
	  
	  	if(isset($_GET['id']))
	  	{
	  
	  		$id_oficios = $_GET ['id'];
	  
	  		$resultOficios = $oficios->getBy ( "id_oficios='$id_oficios'" );
	  
	  		if (! empty ( $resultOficios )) {
	  
	  			$nombrePdf = $resultOficios [0]->nombre_oficio;
	  
	  			$nombrePdf .= ".pdf";
	  
	  			$ruta = $resultOficios [0]->ruta_oficio;
	  
	  			$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	  
	  			header('Content-type: application/pdf');
	  			header('Content-Disposition: inline; filename="'.$directorio.'"');
	  			readfile($directorio);
	  		}
	  
	  
	  	}
	  
	  }
	  
	  public function abrirPdf_providencias()
	  {
	  	$documentos = new DocumentosModel();
	  
	  	if(isset($_GET['id']))
	  	{
	  
	  		$id_documento = $_GET ['id'];
	  
	  		$resultDocumento = $documentos->getBy ( "id_documentos='$id_documento'" );
	  
	  		if (! empty ( $resultDocumento )) {
	  
	  			$nombrePdf = $resultDocumento [0]->nombre_documento;
	  
	  			$nombrePdf .= ".pdf";
	  
	  			$ruta = $resultDocumento [0]->ruta_documento;
	  
	  			$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	  
	  			header('Content-type: application/pdf');
	  			header('Content-Disposition: inline; filename="'.$directorio.'"');
	  			readfile($directorio);
	  		}
	  
	  
	  	}
	  
	  }
	  
	  public function abrirPdf_avoco_conocimiento()
	  {
	  	$avoco_conocimiento = new AvocoConocimientoModel();
	  
	  	if(isset($_GET['id']))
	  	{
	  
	  		$id_avoco_conocimiento = $_GET ['id'];
	  
	  		$resultAvoco= $avoco_conocimiento->getBy ( "id_avoco_conocimiento='$id_avoco_conocimiento'" );
	  
	  		if (! empty ( $resultAvoco )) {
	  
	  			$nombrePdf = $resultAvoco [0]->nombre_documento;
	  
	  			$nombrePdf .= ".pdf";
	  
	  			$ruta = $resultAvoco [0]->ruta_documento;
	  
	  			$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	  
	  			header('Content-type: application/pdf');
	  			header('Content-Disposition: inline; filename="'.$directorio.'"');
	  			readfile($directorio);
	  		}
	  
	  
	  	}
	  
	  }
	  
	  
	  public function abrirPdf_auto_pago()
	  {
	  	$auto_pago = new AutoPagosModel();
	  	 
	  	if(isset($_GET['id']))
	  	{
	  		 
	  		$id_auto_pagos= $_GET ['id'];
	  		 
	  		$resultAuto_Pago = $auto_pago->getBy ( "id_auto_pagos='$id_auto_pagos'" );
	  		 
	  		if (! empty ( $resultAuto_Pago )) {
	  			 
	  			$nombrePdf = $resultAuto_Pago [0]->nombre_auto_pagos;
	  			 
	  			$nombrePdf .= ".pdf";
	  			 
	  			$ruta = $resultAuto_Pago [0]->ruta_auto_pagos;
	  			 
	  			$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	  			 
	  			header('Content-type: application/pdf');
	  			header('Content-Disposition: inline; filename="'.$directorio.'"');
	  			readfile($directorio);
	  		}
	  		 
	  		 
	  	}
	  	 
	  }
	  
	
	public function Secrtetarios()
	{
	
		//CONSULTA DE USUARIOS POR SU ROL
		$idciudad=(int)$_POST["ciudad"];
		$usuarios=new UsuariosModel();
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios,ciudad,rol";
		$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
		AND rol.nombre_rol='SECRETARIO' AND ciudad.id_ciudad='$idciudad'";
		$id="usuarios.nombre_usuarios";
		
		$resultSecretario=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
		
		echo json_encode($resultSecretario);
	}
	
	public function Impulsor()
	{
		if(isset($_POST["id_ciudad"]))
		{
			//CONSULTA DE USUARIOS POR SU ROL
			$id_ciudad=(int)$_POST["id_ciudad"];
			$usuarios=new UsuariosModel();
			$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
			$tablas="usuarios,ciudad,rol";
			$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
			AND rol.nombre_rol='ABOGADO IMPULSOR' AND ciudad.id_ciudad='$id_ciudad'";
			$id="usuarios.nombre_usuarios";
			
			$resultado=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
			
			echo json_encode($resultado);
			
		}else if(isset($_POST["usuarios"]))
		{
			//CONSULTA DE USUARIOS POR SU ROL
			$idusuarios=(int)$_POST["usuarios"];
			$usuarios=new UsuariosModel();
			$columnas = "asignacion_secretarios_view.id_abogado,
					  asignacion_secretarios_view.impulsores";
			$tablas="public.asignacion_secretarios_view";
			$id="asignacion_secretarios_view.id_abogado";
			
			$where="public.asignacion_secretarios_view.id_secretario = '$idusuarios'";
			
			$resultImpulsor=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
			
			echo json_encode($resultImpulsor);
		}
		
	}
	
	public function pruebamerge()
	{
		
		$array1 = array("fila1"=>1,"fila2"=>2);
		$array2 = array("fila1"=>3,"fila2"=>4);
		//muestro los arrays
		var_export ($array1);
		echo '<br><br><br>';
		var_export ($array2);
		echo '<br><br><br>';
		//uno los arrays y muestro el array resultante
		$array_resultante= array_merge($array1,$array2);
		$array_prueba=$array1+$array2;
		var_export ($array_resultante);
		echo '<br><br><br>';
		var_export($array_prueba);
		
		echo '<br><br><br>';
		$array1 = array("id1" => "value1");
		
		$array2 = array("id2" => "value2", "id3" => "value3", "id4" => "value4");
		
		$array3 = array_merge($array1, $array2/*, $arrayN, $arrayN*/);
		$array4 = $array1 + $array2;
		
		echo '<pre>';
		var_dump($array3);
		var_dump($array4);
		echo '</pre>';
		
	}
	
	public function Reporte()
	{
		session_start();
		$sql=array();
		$sql=$_SESSION['data_ireport'];
		
		require_once './core/AyudaVistas.php';
		$helper=new AyudaVistas();
		
		header("Location:view/ireports/ContCordinadorDocumentosReport.php");
		
		
	}	
	
}
?> 