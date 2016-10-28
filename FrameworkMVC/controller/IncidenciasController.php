<?php

class IncidenciasController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		session_start();

	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$incidencia= new IncidenciaModel();
			
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "Incidencias";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $incidencia->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_incidencia"])   )
				{

					$nombre_controladores = "Incidencias";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $incidencia->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_incidencia = $_GET["id_incidencia"];
						$columnas = " id_incidencia, descripcion_incidencia, imagen_incidencia";
						$tablas   = "incidencia";
						$where    = "id_incidencia = '$_id_incidencia' "; 
						$id       = "descripcion_incidencia";
							
						$resultEdit = $incidencia->getCondiciones($columnas ,$tablas ,$where, $id);

						$traza=new TrazasModel();
						$_nombre_controlador = "Incidencias";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_incidencia;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Incidencias"
					
						));
					
					
					}
					
				}
		
				
				$this->view("Incidencias",array(
						"resultSet"=>"", "resultEdit" =>""
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Incidencias"
				
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
	
	public function InsertaIncidencias(){
			
		session_start();

		$incidencia= new IncidenciaModel();
		
		$nombre_controladores = "Incidencias";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $incidencia->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$incidencia=new IncidenciaModel();
		
			//_nombre_tipo_identificacion
			
			if(isset($_POST['Guardar']))
			{
				$_descripcion_incidencia= $_POST["descripcion_incidencia"];
				$_id_usuario=$_POST['id_usuario'];
				
				if ($_FILES['image_incidencia']['name']!="")
				{
					
				
					if(is_array($_FILES['image_incidencia']['name'])) 
					{
											
						$cantidad= count($_FILES["image_incidencia"]["name"]);
						
						
						$directorio = $_SERVER['DOCUMENT_ROOT'].'/coactiva/incidencia/';
						$hoy = date("Y-m-d");
						
						
						for ($i=0; $i<$cantidad; $i++)
						{
							$nombre='_'.$_id_usuario.'_'.$hoy.'_';
							$nombre .= $_FILES['image_incidencia']['name'][$i];
							$tipo = $_FILES['image_incidencia']['type'];
							$tamano = $_FILES['image_incidencia']['size'];
							
							move_uploaded_file($_FILES['image_incidencia']['tmp_name'][$i],$directorio.$nombre);
							
							$data = file_get_contents($directorio.$nombre);
							
							$imagen_incidencia = pg_escape_bytea($data);
								
							$funcion = "ins_incidencia";
							
							$parametros = "'$_descripcion_incidencia','$_id_usuario', '$imagen_incidencia'";
							$incidencia->setFuncion($funcion);
							
							$incidencia->setParametros($parametros);
							
							$resultado=$incidencia->Insert();
							
							var_dump($resultado);
							die('llego');
						 
						} 
						
					
					}
					
				
				}
					
				else
				{
					    
				
						$funcion = "ins_incidencia";
					
						$parametros = "'$_descripcion_incidencia','$_id_usuario'";
							
						$incidencia->setFuncion($funcion);
					
						$incidencia->setParametros($parametros);
					
						$resultado=$incidencia->Insert();
						
						$traza=new TrazasModel();
						$_nombre_controlador = "Incidencias";
						$_accion_trazas  = "Guardar";
						$_parametros_trazas = $_descripcion_incidencia;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					
				}
				
				
				
						
			
			}
				
			$this->redirect("Incidencias", "index");

		}
		else
		{
			$this->view("Error",array(
					
					"resultado"=>"No tiene Permisos de Insertar Incidencias"
		
			));
		
		
		}
	

		
	}


	
	
}
?>