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
		$usuarios = new UsuariosModel();
		
		$nombre_controladores = "Incidencias";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $incidencia->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		
		if (!empty($resultPer))
		{
			
			$resultado = null;
			$incidencia=new IncidenciaModel();
		
			//_nombre_tipo_identificacion
			
			if(isset($_POST['Enviar']))
			{
				//phpinfo();
				//die();
				$_descripcion_incidencia= $_POST["descripcion_incidencia"];
				$_id_usuario=$_POST['id_usuario'];
				$_asunto_incidencia = $_POST["asunto_incidencia"];
				
				
				//parametro para pdf
				$datos=array();
				
				
				if ($_FILES['image_incidencia']['name']!="")
				{
					
				
					if(is_array($_FILES['image_incidencia']['name'])) 
					{
						$correo_from="";
						
						$resultUsuario=$usuarios->getBy("id_usuarios='$_id_usuario'");
						
						$correo_from=$resultUsuario[0]->correo_usuarios;
						
						$correo_to="";
						
						$resultUsuario=$usuarios->getCondiciones("usuarios.correo_usuarios",
																"public.usuarios,public.rol",
																"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='ADMINISTRADOR'",
																"rol.id_rol");
						
						foreach ($resultUsuario as $res)
						{
							$correo_to.=$res->correo_usuarios.',';
						}
						
						$correo_to=substr($correo_to,0,-1);
						
									
						$cantidad= count($_FILES["image_incidencia"]["name"]);
						
						
						$directorio = $_SERVER['DOCUMENT_ROOT'].'/incidencia/';
						$hoy = date("Y-m-d");
						
						//por defecto solo una imagen
						for ($i=0; $i<1; $i++)
						{
							$nombre='_'.$_id_usuario.'_'.$hoy.'_';
							$nombre .= $_FILES['image_incidencia']['name'][$i];
							$tipo = $_FILES['image_incidencia']['type'];
							$tamano = $_FILES['image_incidencia']['size'];
							
							move_uploaded_file($_FILES['image_incidencia']['tmp_name'][$i],$directorio.$nombre);
							
							$data = file_get_contents($directorio.$nombre);
							$_imagen_correo=$directorio.$nombre;
							$imagen_incidencia = pg_escape_bytea($data);
								
							$funcion = "ins_incidencia";
							$parametros = "'$_descripcion_incidencia','$_id_usuario', '$imagen_incidencia','$_asunto_incidencia'";
							$incidencia->setFuncion($funcion);
							$incidencia->setParametros($parametros);
							$resultado=$incidencia->Insert();
							
							
							
							
							
							//$mail=$incidencia->phpMailerSend(); die();
							
							/*
							$my_file = $nombre; // puede ser cualquier formato
							$my_path = $_SERVER['DOCUMENT_ROOT']."/incidencia/";
							$my_name = "Danny";
							$my_mail = "danny@masoft.net";//aqui va el correo_from
							$my_replyto = "maycol@masoft.net";
							$my_subject = $_asunto_incidencia;
							$my_message = $_descripcion_incidencia;
							//como parametro va el correo_to
							$this->mail_attachment($my_file, $my_path, "steven@masoft.net", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
						
							*/					 
						} 
						
						
						
					}
					
				
				}
					
				else
				{
					echo "paso al caso contrario";    
				
				}
				
				
				$para = "maycol@masoft.net" .","."danny@masoft.net" ;
				$titulo = "";
					
					
				$columnas = " usuarios.nombre_usuarios, 
							  usuarios.correo_usuarios, 
							  rol.nombre_rol, 
						     incidencia.id_incidencia,
							  incidencia.asunto_incidencia, 
							  incidencia.descripcion_incidencia, 
							  incidencia.creado,
						      incidencia.imagen_incidencia";
				
				$tablas   = "public.incidencia, 
							  public.usuarios, 
							  public.rol";
				$where    = "usuarios.id_usuarios = incidencia.id_usuario AND
                             rol.id_rol = usuarios.id_rol AND usuarios.id_usuarios='$_id_usuario' AND incidencia.descripcion_incidencia='$_descripcion_incidencia' AND incidencia.asunto_incidencia='$_asunto_incidencia'";
				$id       = "incidencia.creado";
				$lista = $incidencia->getCondiciones($columnas, $tablas, $where, $id);
				
				$imagen = $_imagen_correo;
				
				$incidencia->SendMail($para, $titulo, $lista, $imagen);
						
			
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
	/*
	
	function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $mensaje) 
	{
		
		$file = $path.$filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		
		$eol = PHP_EOL;
		
		// Basic headers
		$header = "From: ".$from_name." <".$from_mail.">".$eol;
		$header .= "Reply-To: ".$replyto.$eol;
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"";
		
		// Put everything else in $message
		$message = "--".$uid.$eol;
		$message .= "Content-Type: text/html; charset=ISO-8859-1".$eol;
		$message .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
		$message .= $mensaje.$eol;
		$message .= "--".$uid.$eol;
		$message .= "Content-Type: application/pdf; name=\"".$filename."\"".$eol;
		$message .= "Content-Transfer-Encoding: base64".$eol;
		$message .= "Content-Disposition: attachment; filename=\"".$filename."\"".$eol;
		$message .= $content.$eol;
		$message .= "--".$uid."--";
		
		
		if (mail($mailto, $subject,$message, $header)) {
			echo "mail send ... OK"; // or use booleans here
		} else {
			echo "mail send ... ERROR!";
		}
	}

*/
	
	
}
?>