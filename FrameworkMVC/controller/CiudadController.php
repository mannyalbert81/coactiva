<?php

class CiudadController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
     	
		$resultSet=$ciudad->getAll("id_ciudad");
				
		$resultEdit = "";

		
		session_start();

	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$ciudad= new CiudadModel();
			//NOTIFICACIONES
			$ciudad->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "Ciudad";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $ciudad->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_ciudad"])   )
				{

					$nombre_controladores = "Ciudad";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $ciudad->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_ciudad = $_GET["id_ciudad"];
						$columnas = " id_ciudad, nombre_ciudad";
						$tablas   = "ciudad";
						$where    = "id_ciudad = '$_id_ciudad' "; 
						$id       = "nombre_ciudad";
							
						$resultEdit = $ciudad->getCondiciones($columnas ,$tablas ,$where, $id);

						$traza=new TrazasModel();
						$_nombre_controlador = "Ciudad";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_ciudad;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Ciudades"
					
						));
					
					
					}
					
				}
		
				
				$this->view("Ciudad",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Ciudades"
				
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
	
	public function InsertaCiudad(){
			
		session_start();

		
		$ciudad=new CiudadModel();
		$nombre_controladores = "Ciudad";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $ciudad->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$ciudad=new CiudadModel();
		
			//_nombre_tipo_identificacion
			
			if (isset ($_POST["nombre_ciudad"]) )
				
			{
				
				
				
				$_nombre_ciudad = $_POST["nombre_ciudad"];
				
				if(isset($_POST["id_ciudad"])) 
				{
					
					$_id_ciudad = $_POST["id_ciudad"];
					$colval = " nombre_ciudad = '$_nombre_ciudad'   ";
					$tabla = "ciudad";
					$where = "id_ciudad = '$_id_ciudad'    ";
					
					$resultado=$ciudad->UpdateBy($colval, $tabla, $where);
					
				}else {
					
			

				
				$funcion = "ins_ciudad";
				
				$parametros = " '$_nombre_ciudad'  ";
					
				$ciudad->setFuncion($funcion);
		
				$ciudad->setParametros($parametros);
		
		
				$resultado=$ciudad->Insert();
			 
				$traza=new TrazasModel();
				$_nombre_controlador = "Ciudad";
				$_accion_trazas  = "Guardar";
				$_parametros_trazas = $_nombre_ciudad;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
				
				}
			 
			 
		
			}
			$this->redirect("Ciudad", "index");

		}
		else
		{
			$this->view("Error",array(
					
					"resultado"=>"No tiene Permisos de Insertar Ciudades"
		
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
			if(isset($_GET["id_ciudad"]))
			{
				$id_ciudad=(int)$_GET["id_ciudad"];
				
				$ciudad=new CiudadModel();
				
				$ciudad->deleteBy(" id_ciudad",$id_ciudad);
				
				$traza=new TrazasModel();
				$_nombre_controlador = "Ciudad";
				$_accion_trazas  = "Borrar";
				$_parametros_trazas = $id_ciudad;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
			}
			
			$this->redirect("Ciudad", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Ciudades"
			
			));
		}
				
	}
	
	
	public function Reporte(){
	
		//Creamos el objeto usuario
		$ciudad=new CiudadModel();
		//Conseguimos todos los usuarios
		
	
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $roles->getByPDF("id_rol, nombre_rol", " nombre_rol != '' ");
			$this->report("Ciudad",array(	"resultRep"=>$resultRep));
	
		}
					
	
	}
	
	
	//para firmar con liquidador
	
	public function firma_liquidador()
	{
		echo ('cambiar entrada');
		die();
		$user = new UsuariosModel();
		$id_usuario='38';
		
		$permisosFirmar=$user->getPermisosFirmarPdfs($id_usuario,'00-26-B6-EF-AA-60');
		
		//para obtener rol de usuario
		$consultaUsuarios=$user->getCondiciones("id_rol", "usuarios", "id_usuarios='$id_usuario'", "id_rol");
		$id_rol=$consultaUsuarios[0]->id_rol;
		
		//saber si tiene permiso para firmar
		
		if($permisosFirmar['estado'])
		{
			$id_firma = $permisosFirmar['valor'];
				
			$cantidadFirmados=0;
			$consultaUsuarios=null;
				
			$firmas= new FirmasDigitalesModel();
			$avoco=new AvocoConocimientoModel();
				
			$_id_usuarios=$id_usuario;
			//$_ruta=$rutaFiles;
			$_id_documentos='457';
			$_nombreDocumentos="";
		
			$destino = $_SERVER['DOCUMENT_ROOT'].'/coactiva/documentos/';
				
				
				
			$array_documento = explode(",", $_id_documentos);
			$respuestaCliente="Documentos firmados (";
				
			foreach ($array_documento as $id )
			{
		
		
				if(!empty($id))
				{
					$cantidadFirmados=$cantidadFirmados+1;
						
					$id_avoco = $id;
						
					$resultDocumento=$avoco->getBy("id_avoco_conocimiento='$id_avoco'");
						
					$nombrePdf=$resultDocumento[0]->nombre_documento;
						
					$nombrePdf=$nombrePdf.".pdf";
						
					$_ruta=$resultDocumento[0]->ruta_documento;
						
					//para metodo dentro del farmework
					//$id_rol=$_SESSION['id_rol'];
						
					$destino.=$_ruta.'/';
		
					try {
							
						$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$id_rol,$_id_usuarios);
		
						$firmas->UpdateBy("firma_liquidador='TRUE'", "avoco_conocimiento", "id_avoco_conocimiento='$id_avoco'");
						
						//crear notificacion usa variable de session
						//$this->notificacionImpulsor($nombrePdf);
							
						//$respuestaCliente.=$res[0].' ';
		
					} catch (Exception $e) {
							
						echo $e->getMessage();
						
						die();
					}
						
		
				}
		
		
			}
	}else{
		echo ('sin perimisos');
		die();
	}
}
	
	
	
}
?>