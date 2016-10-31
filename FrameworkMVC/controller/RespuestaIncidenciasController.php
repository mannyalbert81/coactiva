<?php

class RespuestaIncidenciasController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

public function index(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
		$respuesta_incidencias=new RespuestaIncidenciasModel();
		$ciudad = new CiudadModel();
	
		$_id_usuarios= $_SESSION["id_usuarios"];
	
		$columnas = " usuarios.id_ciudad,
					  ciudad.nombre_ciudad,
					  usuarios.nombre_usuarios";
			
		$tablas   = "public.usuarios,
                     public.ciudad";
			
		$where    = "ciudad.id_ciudad = usuarios.id_ciudad AND usuarios.id_usuarios = '$_id_usuarios'";
			
		$id       = "usuarios.id_ciudad";
	
			
		$resultDatos=$ciudad->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getAll("nombre_ciudad");
	
	
		$usuarios = new UsuariosModel();
		$resultUsu = $usuarios->getAll("nombre_usuarios");
	
	
		$respuesta_incidencias=new RespuestaIncidenciasModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "RespuestaIncidencias";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $respuesta_incidencias->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				
					$respuesta_incidencias=new RespuestaIncidenciasModel();
	
	
						
					$columnas = "incidencia.descripcion_incidencia,
					incidencia.asunto_incidencia,
					incidencia.creado,
					incidencia.respuesta_incidencia,
					incidencia.imagen_incidencia,
					incidencia.id_incidencia,
					incidencia.id_usuario,
					usuarios.nombre_usuarios";
	
					$tablas=" public.incidencia,
					public.usuarios";
	
					
					$id="incidencia.id_incidencia";
					
					$where="incidencia.id_usuario = usuarios.id_usuarios";
	
	
				
					$resultSet=$respuesta_incidencias->getCondiciones($columnas ,$tablas , $where, $id);
						 
	
				}
	
	
				$this->view("RespuestaIncidencias",array(
						"resultSet"=>$resultSet,"resultCiu"=>$resultCiu, "resultUsu"=>$resultUsu, "resultDatos"=>$resultDatos
							
				));
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Respuesta Incidencias"
	
				));
	
				exit();
			}
	
		
		
	
	}
	
	
}
?>