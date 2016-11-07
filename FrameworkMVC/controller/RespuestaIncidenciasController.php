<?php

class RespuestaIncidenciasController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

public function index(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
		$respuesta_incidencias=new RespuestaIncidenciaModel();
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
	
	
		$respuesta_incidencias=new RespuestaIncidenciaModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "RespuestaIncidencias";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $respuesta_incidencias->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				
					$respuesta_incidencias=new RespuestaIncidenciaModel();
	
	
						
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
					
					$where="incidencia.id_usuario = usuarios.id_usuarios AND respuesta_incidencia=false";
	
	
				
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
	
	
	public function enviarRespuesta()
	{
		$return = Array('ok'=>TRUE);
		session_start();
		
		
		if(isset($_POST['id_incidencia'])&&isset($_POST['descripcion_respuesta'])&&isset($_FILES['image_respuesta']))
		{
			
			$respuesta_incidencia = new RespuestaIncidenciaModel();
			
			$id_incidencia=$_POST['id_incidencia'];
			$descripcion_respuesta=$_POST['descripcion_respuesta'];
			$id_usuarios=$_SESSION['id_usuarios'];
			
			$upload_folder =$_SERVER['DOCUMENT_ROOT']."/coactiva/incidencia/respuesta";
			
			$nombre_archivo = $_FILES['image_respuesta']['name'];
					
			$tipo_archivo = $_FILES['image_respuesta']['type'];
					
			$tamano_archivo = $_FILES['image_respuesta']['size'];
					
			$tmp_archivo = $_FILES['image_respuesta']['tmp_name'];
					
			$archivador = $upload_folder . '/' . $nombre_archivo;
			
			if (move_uploaded_file($tmp_archivo, $archivador)) 
			{
				$data = file_get_contents($archivador);
				$imagen_respuesta = pg_escape_bytea($data);
				
				$funcion = "ins_respuesta_incidencia";
				//parametros
				//_id_incidencia integer,_id_usuario integer,_descripcion_respuesta_incidencia character varying, _imagen_respuesta_incidencia bytea
				$parametros = "'$id_incidencia','$id_usuarios','$descripcion_respuesta','$imagen_respuesta'";
				$respuesta_incidencia->setFuncion($funcion);
				$respuesta_incidencia->setParametros($parametros);
				$resultado=$respuesta_incidencia->Insert();
				
				$update=$respuesta_incidencia->UpdateBy("respuesta_incidencia='true'", "incidencia", "id_incidencia='$id_incidencia'");
				
				if(!$resultado)
				{
					$return = Array('ok' => FALSE,'msg'=>"Datos no registrados");
					
				}
				
					
			}else {
				$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => "error");
					
			}
			
		}else{
			
			$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al enviar sus Datos");
			
		}
		
		echo json_encode($return);
		
	}
	
	
}
?>