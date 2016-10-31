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
							
													 
						} 
						
						
						$my_file = "tuarchivo.png"; // puede ser cualquier formato
						$my_path = $_SERVER['DOCUMENT_ROOT']."/ruta_a_tu_archivo/";
						$my_name = "Tu nombre";
						$my_mail = "tumail@tudominio.com";
						$my_replyto = "tumail@tudominio.com";
						$my_subject = "Le adjuntamos la credencial de invuitación al evento";
						$my_message = "Tu mensaje";
						mail_attachment($my_file, $my_path, "casilla_destinatario@dominio.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
					
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
	
	
	function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
		$file = $path.$filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		if (mail($mailto, $subject, "", $header)) {
			echo "mail send ... OK"; // or use booleans here
		} else {
			echo "mail send ... ERROR!";
		}
	}


	
	
}
?>