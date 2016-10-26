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
			
			if (isset ($_POST["descripcion_incidencia"]) )
				
			{
				
				
				
				$_descripcion_incidencia= $_POST["descripcion_incidencia"];
				
				if(isset($_POST["id_incidencia"])) 
				{
					
					$_id_incidencia = $_POST["id_incidencia"];
					$colval = " descripcion_incidencia = '$_descripcion_incidencia'   ";
					$tabla = "incidencia";
					$where = "id_incidencia = '$_id_incidencia'    ";
					
					$resultado=$incidencia->UpdateBy($colval, $tabla, $where);
					
				}else {
					
			

				
				$funcion = "ins_incidencia";
				
				$parametros = " '$_descripcion_incidencia'  ";
					
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