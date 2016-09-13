<?php

class TipoNotificacionController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
     	$tipoNotificacion = new TipoNotificacionModel(); 
		
	   //Conseguimos todos los usuarios
		$resultSet=$tipoNotificacion->getAll("id_tipo_notificacion");
				
		$resultEdit = "";

		
		session_start();

	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			
			$tipoNotificacion = new TipoNotificacionModel();
			//Notificaciones
			$tipoNotificacion->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			
			$permisos_rol=new PermisosRolesModel();
			$nombre_controladores = "TipoNotificacion";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $permisos_rol->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_tipo_notificacion"])   )
				{

					$nombre_controladores = "Controladores";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_tipo_notificacion = $_GET["id_tipo_notificacion"];
						$columnas = " id_tipo_notificacion, descripcion_notificacion";
						$tablas   = "tipo_notificacion";
						$where    = "id_tipo_notificacion = '$_id_tipo_notificacion' "; 
						$id       = "descripcion_notificacion";
							
						$resultEdit = $tipoNotificacion->getCondiciones($columnas ,$tablas ,$where, $id);
						
						$traza=new TrazasModel();
						$_nombre_controlador = "Tipo Notificacion";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_tipo_notificacion;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Tipo Notificacion"
					
						));
					
					
					}
					
				}
		
				
				$this->view("TipoNotificacion",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Tipo Notificacion"
				
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
	
	public function InsertaTipoNotificacion(){
			
		session_start();

		$permisos_rol=new PermisosRolesModel();
		$tipoNotificacion=new TipoNotificacionModel();

		$nombre_controladores = "TipoNotificacion";
		$id_rol= $_SESSION['id_rol'];

		
		$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
		
			$resultado = null;

		
			//_nombre_tipoNotificacion
			
			if (isset ($_POST["descripcion_notificacion"]) )
				
			{
				
				$_descripcion_notificacion = $_POST["descripcion_notificacion"];
				
				if( isset ($_POST["id_tipo_notificacion"])) 
				{
					
					
					$_id_tipoNotificacion = $_POST["id_tipo_notificacion"];
					
					$colval = "descripcion_notificacion = '$_descripcion_notificacion'   ";
					$tabla = "tipo_notificacion";
					$where = "id_tipo_notificacion = '$_id_tipoNotificacion' ";
					
					$resultado=$tipoNotificacion->UpdateBy($colval, $tabla, $where);
					
					
					
				}else {
					
			
				
				$funcion = "ins_tipo_notificacion";
				
				$parametros = " '$_descripcion_notificacion'  ";
					
				$tipoNotificacion->setFuncion($funcion);
		
				$tipoNotificacion->setParametros($parametros);
		
		
				$resultado=$tipoNotificacion->Insert();
			 
				$traza=new TrazasModel();
				$_nombre_controlador = "Tipo Notificacion";
				$_accion_trazas  = "Guardar";
				$_parametros_trazas = $_nombre_tipoNotificacion;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
				
				}
		
			}
			$this->redirect("TipoNotificacion", "index");

		}
		else
		{
			$this->view("Error",array(
					
					"resultado"=>"No tiene Permisos de Insertar Tipo Notificaciones"
		
			));
		
		
		}
		
	}
	
	public function borrarId()
	{

		session_start();
		
		$permisos_rol=new PermisosRolesModel();
		$nombre_controladores = "Roles";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
			if(isset($_GET["id_tipo_notificacion"]))
			{
				$id_tipoNotificacion=(int)$_GET["id_tipo_notificacion"];
				
				$tipoNotificacion=new TipoNotificacionModel();
				
				$tipoNotificacion->deleteBy("id_tipo_notificacion",$id_tipoNotificacion);
				
				$traza=new TrazasModel();
				$_nombre_controlador = "Tipo Notificacion";
				$_accion_trazas  = "Borrar";
				$_parametros_trazas = $id_tipoNotificacion;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
				
			}
			
			$this->redirect("TipoNotificacion", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Controladores"
			
			));
		}
				
	}
	
	
	public function Reporte(){
	
		//Creamos el objeto usuario
		$roles=new RolesModel();
		//Conseguimos todos los usuarios
		
	
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $roles->getByPDF("id_rol, nombre_rol", " nombre_rol != '' ");
			$this->report("Roles",array(	"resultRep"=>$resultRep));
	
		}
					
	
	}
	
	public function pruebaFirmarOld()
	{
		$documentos = new DocumentosModel();
		
		$destino="C:/Users/Masoft/Desktop/pdf_pruebas/";
		$nombrePdf="Avoco1078.pdf";
		$id_firma="33";
		$id_rol="3";
		$id_usuario="42";
		
		/*$resultado = $documentos->FirmarPDFs($destino, $nombrePdf, $id_firma, $id_rol,$id_usuario);
		
		$this->view("Error", array("resultado"=>$resultado));*/
		
		
		//para metodos dentro del framework
		//$id_usuario=$_SESSION['id_usuarios'];
		 
		/*$ruta_ejecutable = $_SERVER['DOCUMENT_ROOT'].'/documentos/firmar/FirmadorElectronico.exe';
		$tmp = $_SERVER['DOCUMENT_ROOT'].'/documentos/tmp_documentos/';
		 
		$moveTo = $tmp.$nombrePdf;
		$moveOf = $destino.$nombrePdf;
		 
		rename($moveOf,$moveTo);
		 
		$origen=$moveTo;
		$destino=$moveOf;
		$tipo_pdf="";
		$add_page="false";
		$total_espacio=0;
		//error en la conversion
		$nombre_pdf_bd = $origen;
		
		//$this->view("Error", array("resultado"=>$total_espacio.' pagina agregada-->'.$add_page.' consulta-->'.$nombre_pdf_bd));
		 
		/*$conAddPage=$documentos->getCondiciones("nombre_pdf,tipo_pdf", "pdf", "nombre_pdf='C:/Users/Masoft/git/coactiva/documentos/tmp_documentos/Avoco1078.pdf'", "id_pdf");
		 
		if(!empty($conAddPage)){
			$add_page="true";
			$total_espacio=$this->extraerEspacio($origen, $add_page);
		}else {
			$total_espacio=$this->extraerEspacio($origen, $add_page);
				
		}*/
		
		//$this->view("Error", array("resultado"=>$total_espacio.' pagina agregada-->'.$add_page.' consulta-->'.print_r($conAddPage)));
		/*
		$comando = 'start "" /b "' . $ruta_ejecutable . '" ' . $id_firma . ' ' . $origen . ' ' . $destino . ' '.$id_rol.
		' '.$id_usuario.' '.$total_espacio.' '.$add_page.' ';
		
		$comando_esc = escapeshellcmd ( $comando );
		
		exec ( $comando_esc, $resultadoSalida, $ejecucion );
		
		$this->view("Error", array("resultado"=>print_r($resultadoSalida)));*/
		//return $resultadoSalida;
		
	}
	
	public function pruebaFirmar()
	{
		$documentos = new DocumentosModel();
		
		$destino="C:/Users/Masoft/Desktop/pdf_pruebas/";
		$nombrePdf="Avoco1091.pdf";
		$id_firma="33";
		$id_rol="6";
		$id_usuario="42";
		
		$resultado = $documentos->FirmarPDFs($destino, $nombrePdf, $id_firma, $id_rol,$id_usuario);
		
		$this->view("Error", array("resultado"=>print_r($resultado)));
		
	}
	
	
	public function extraerEspacio($filePath,$addpage)
	{
		$ruta_exec_extract_line = $_SERVER['DOCUMENT_ROOT'].'/documentos/extraer/VerEspacioPdf.exe';
		 
		$comando_extraer = 'start "" /b "' . $ruta_exec_extract_line . '" ' . $filePath . ' '. $addpage . ' ';
	
		$comando_esc_extraer = escapeshellcmd ( $comando_extraer );
	
		exec ( $comando_esc_extraer, $resultadoExtraer, $ejecucion_extraer );
	
		$total_espacio=$resultadoExtraer[0];
		 
		return $total_espacio;
	}
	
	public function pruebaverlineas()
	{
		$documentos = new DocumentosModel();
		
		$str_origen="C:/Users/Masoft/Desktop/Avoco1091.pdf";
		
		$addpage="false";
		
		$resultado = $documentos->extraerEspacio($str_origen, $addpage);
		
		$this->view("Error", array("resultado"=>$resultado));
	}
	
	
}
?>