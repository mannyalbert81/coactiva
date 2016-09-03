<?php

class FirmasDigitalesController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
		

	
		//Creamos el objeto usuario
     	$firmas_digitales = new FirmasDigitalesModel(); 
     	
     	
		
	   //Conseguimos todos los usuarios
     	$columnas  = "firmas_digitales.id_usuarios, usuarios.nombre_usuarios, firmas_digitales.imagen_firmas_digitales, firmas_digitales.id_firmas_digitales";
     	$tablas    = "public.firmas_digitales, public.usuarios";
     	$where     = "usuarios.id_usuarios = firmas_digitales.id_usuarios";
     	$id        = "usuarios.nombre_usuarios";
     	
		$resultSet=$firmas_digitales->getCondiciones($columnas, $tablas, $where, $id);
				
		$resultEdit = "";
		
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios inner join rol on(usuarios.id_rol=rol.id_rol)";
		$id="rol.id_rol";
		
		$usuarios=new UsuariosModel();
		$where="rol.nombre_rol='SECRETARIO' OR rol.nombre_rol='ABOGADO IMPULSOR' OR rol.nombre_rol='LIQUIDADOR'";
		$resultUsuarioSecretario=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
		
		
		session_start();

	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{

			//Notificaciones
			$firmas_digitales->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$nombre_controladores = "FirmasDigitales";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $firmas_digitales->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				
				
				
				
				if (isset ($_GET["id_firmas_digitales"])   )
				{

					$nombre_controladores = "FirmasDigitales";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $firmas_digitales->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_firmas_digitales = $_GET["id_firmas_digitales"];
						$columnas  = "usuarios.id_usuarios, usuarios.nombre_usuarios, firmas_digitales.imagen_firmas_digitales, firmas_digitales.id_firmas_digitales";
						$tablas    = "public.firmas_digitales, public.usuarios";
						$where     = "usuarios.id_usuarios = firmas_digitales.id_usuarios AND firmas_digitales.id_firmas_digitales = '$_id_firmas_digitales'";
						$id        = "usuarios.nombre_usuarios";
						
							
						$resultEdit = $firmas_digitales->getCondiciones($columnas ,$tablas ,$where, $id);
						
						$traza=new TrazasModel();
						$_nombre_controlador = "Firmas Digitales";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_firmas_digitales;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Firmas Digitales"
					
						));
					
					
					}
					
				}
		
				
				$this->view("FirmasDigitales",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit, "resultUsuarioSecretario" =>$resultUsuarioSecretario
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Controladores"
				
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
	
		
	public function InsertaFirmasDigitales(){
			
		session_start();
		

		$nombre_controladores = "FirmasDigitales";

		
		$firmas_digitales = new FirmasDigitalesModel(); 
		
		$id_rol= $_SESSION['id_rol'];
		
		$resultPer = $firmas_digitales->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$firmas_digitales = new FirmasDigitalesModel(); 
		
			//_nombre_controladores
			
			if (isset ($_POST["abogados"]) )
				
			{
				$usuarios=new UsuariosModel();
				$_id_usuarios =  $_POST["abogados"] ;
				
				$firmas_digitales = new FirmasDigitalesModel();
				$directorio = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
					
				$nombre = $_FILES['imagen_firmas_digitales']['name'];
				$tipo = $_FILES['imagen_firmas_digitales']['type'];
				$tamano = $_FILES['imagen_firmas_digitales']['size'];
					
				// temporal al directorio definitivo
					
				move_uploaded_file($_FILES['imagen_firmas_digitales']['tmp_name'],$directorio.$nombre);
					
				$data = file_get_contents($directorio.$nombre);
					
				$imagen_firmas_digitales = pg_escape_bytea($data);
					
					
					
			    $funcion = "ins_firmas_digitales";
				
				
				$parametros = " '$_id_usuarios' ,'{$imagen_firmas_digitales}' ";
				$firmas_digitales->setFuncion($funcion);	
				$firmas_digitales->setParametros($parametros);
			   
				
				try {
				
					$resultado=$firmas_digitales->Insert();
					
					$traza=new TrazasModel();
					$_nombre_controlador = "Firmas Digitales";
					$_accion_trazas  = "Guardar";
					$_parametros_trazas = $_id_usuarios;
					$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					
					
				} catch (Exception $e) {
					
					$this->view("Error",array(
							"resultado"=>$e
					));
					
					
				}
				
					
				}
				//pasante
				
				$this->redirect("FirmasDigitales", "index");
		}
		else
		{
			$this->view("Error",array(
					
					"resultado"=>"No tiene Permisos de Insertar Firmas Digitales"
		
			));
		
		
		}
		
	}
	
	public function borrarId()
	{
		session_start();
		$permisos_rol=new PermisosRolesModel();
		$nombre_controladores = "FirmasDigitales";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
		
			if(isset($_GET["id_firmas_digitales"]))
			{
				$id_firmas_digitales=(int)$_GET["id_firmas_digitales"];
		
				$firmas_digitales = new FirmasDigitalesModel();
		
				$firmas_digitales->deleteBy(" id_firmas_digitales",$id_firmas_digitales);
		
				$traza=new TrazasModel();
				$_nombre_controlador = "Firmas Digitales";
				$_accion_trazas  = "Borrar";
				$_parametros_trazas = $id_firmas_digitales;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
		
			}
		
			$this->redirect("FirmasDigitales", "index");
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Borrar Clientes"
		
			));
		}
		
		
		
	}
	
	public function firmarDocumento() 
	{
		session_start();
		
		if (isset( $_SESSION['usuario_usuarios']) )
		{
			
				$permisos_rol=new PermisosRolesModel();
				$nombre_controladores = "FirmasDigitales";
				$tipo_notificacion=new TipoNotificacionModel();				
				$id_rol= $_SESSION['id_rol'];
				$resultPer = $permisos_rol->getPermisosEditar(" controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
					
				if (!empty($resultPer))
				{
						$id_usuario=$_SESSION['id_usuarios'];
						
						$firmas = new FirmasDigitalesModel();
						
						
						$resultSet= array();
						$resultEdit= null;
						$resultUsuarioSecretario=null;
						
						if(isset($_POST['guardar']))
							{
						
								$directorio = $_SERVER['DOCUMENT_ROOT'].'/documentos/';
									
								$nombre = $_FILES['imagen_firmas_digitales']['name'];
								$tipo = $_FILES['imagen_firmas_digitales']['type'];
								$tamano = $_FILES['imagen_firmas_digitales']['size'];
								
								move_uploaded_file($_FILES['imagen_firmas_digitales']['tmp_name'],$directorio.$nombre);
								
								$resultado=$firmas->getPermisosFirmar();
										
										if ($resultado == "") 
										{
											$resultFirmas = $firmas->getBy ( "id_usuarios='$id_usuario'" );
											$id_firma = $resultFirmas [0]->id_firmas_digitales;
											
											
											$resultado=$firmas->FirmarDocumentos( $directorio, $nombre, $id_firma );
											
											
											//inserta las notificacion
												
											$_nombre_tipo_notificacion="firma";
											$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
												
											$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
											$descripcion="Documento Firmado por";
											$numero_movimiento=0;
											$cantidad_cartones=$nombre;
												
											//dirigir notificacion
											$id_impulsor=$_SESSION['id_usuarios'];
											$asignacion_secreatario= new AsignacionSecretariosModel();
											
											$result_asg_secretario=$asignacion_secreatario->getBy("id_abogado_asignacion_secretarios='$id_impulsor'");
												
											if(!empty($result_asg_secretario))
											{
												$usuarioDestino=$result_asg_secretario[0]->id_secretario_asignacion_secretarios;
													
												$result_notificaciones=$firmas->CrearNotificacion($id_tipo_notificacion, $usuarioDestino, $descripcion, $numero_movimiento, $cantidad_cartones);
													
											}else
											{
											
											}
											
											
										} else {
											
											$this->view ( "Error", array (
													"resultado" => $resultado
											)
											 );
											
											exit ();
										}
								
								$this->redirect("FirmasDigitales","firmarDocumento");
							
							}
					
					
					$this->view("FirmarDocumentos",array(
							"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
					
					));
				
				}
				else
				{
					$this->view("Error",array(
							"resultado"=>"No tiene Permisos para Firmar Documentos comuquese con el Administrador"
				
					));
				}
		
		}
		else
		{
			$this->view("ErrorSesion",array(
					"resultSet"=>""
		
			));
		
		}
		
	}
	
	public function DocumentosFirmarApplet()
	{
		session_start();
		
		if(isset($_POST['filesIds'])&&isset($_POST['mac'])&&isset($_POST['ruta'])&&isset($_POST['id_usuario']))
		{
			if(is_null($_POST['filesIds']) || is_null($_POST['mac']) || is_null($_POST['ruta']) || is_null($_POST['id_usuario'])){
				
				$rutaXfirmar=$_POST['ruta'];
				$macCliente=$_POST['mac'];
				$idsFiles=$_POST['filesIds'];
				$id_usuario=$_POST['id_usuario'];
				
				$respuestaCliente="";
				
				// saber a donde dirigirse  de acuerdo a la ruta
				
				switch ($rutaXfirmar)
				{
					case "Avoco" :
							$respuestaCliente=$this->firmarAvoco($idsFiles,$rutaXfirmar,$id_usuario,$macCliente);
						break;
					
					case "Providencias" :
							$respuestaCliente=$this->firmarProvidencias($idsFiles,$rutaXfirmar,$id_usuario,$macCliente);
						break;
					
					case "Oficios":
							$respuestaCliente=$this->firmarProvidencias($idsFiles,$rutaXfirmar,$id_usuario,$macCliente);
						break;
						
					default: break;
				}
				
				echo $respuestaCliente;
				
				
			}else{
				
				echo 'error en el envio de datos';
			}
			
		}else{
			echo 'error sus Datos no han sido enviados';
		}
		
	}
	
	
	public function firmarAvoco($idsFiles,$rutaFiles,$id_Usuario,$mac)
	{
		$respuesta="";
		$cantidadFirmados=0;
		$consultaUsuarios=null;
		
		$usuarios= new UsuariosModel();
		$firmas= new FirmasDigitalesModel();
		$avoco=new AvocoConocimientoModel();
		$tipo_notificacion = new TipoNotificacionModel();
		$asignacion_secreatario= new AsignacionSecretariosModel();
		
		
		$_id_usuarios=$id_Usuario;
		$_ruta=$rutaFiles;
		$_macCliente=$mac;
		$_id_documentos=$idsFiles;
		$_nombreDocumentos="";
		
				
		$destino = $_SERVER['DOCUMENT_ROOT'].'/documentos/';
			
		
			
		$permisosFirmar=$avoco->getPermisosFirmarPdfs($_id_usuarios,$_macCliente);
			
		//para las notificaciones
		$_nombre_tipo_notificacion="avoco";
		$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
		$descripcion="Avoco Firmado por";
		$numero_movimiento=0;
		$id_impulsor="";
		
		//para obtener rol de usuario
		$consultaUsuarios=$usuarios->getCondiciones("id_rol", "usuarios", "id_usuarios='$_id_usuarios'", "id_rol");
		$id_rol=$consultaUsuarios[0]->id_rol;
		
			
		if($permisosFirmar['estado'])
		{
		
			$id_firma = $permisosFirmar['valor'];
				
			$array_documento = explode(",", $_id_documentos);
		
		
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
						
					$respuesta="Documentos firmados (";
		
		
					try {
							
						$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$id_rol,$_id_usuarios);
							
						$firmas->UpdateBy("firma_secretario='TRUE'", "avoco_conocimiento", "id_avoco_conocimiento='$id_avoco'");
							
						//$this->notificacionImpulsor($nombrePdf);
							
							
		
					} catch (Exception $e) {
							
						$respuesta= $e->getMessage();
					}
		
				}
			}
				
		$respuesta.=$cantidadFirmados.")";
			 
		}else{
				
			$respuesta= $permisosFirmar['error'];
		}
		
		return $respuesta;
			
	}
	
	public function firmarProvidencias($idsFiles,$rutaFiles,$id_Usuario,$mac)
	{
		$respuesta="";
		$cantidadFirmados=0;
		$consultaUsuarios=null;
		
		$usuarios= new UsuariosModel();
		$firmas= new FirmasDigitalesModel();
		$documentos=new DocumentosModel();
		$tipo_notificacion = new TipoNotificacionModel();
		$asignacion_secreatario= new AsignacionSecretariosModel();
		
		
		$_id_usuarios=$id_Usuario;
		$_ruta=$rutaFiles;
		$_macCliente=$mac;
		$_id_documentos=$idsFiles;
		$_nombreDocumentos="";
		
		
		$destino = $_SERVER['DOCUMENT_ROOT'].'/documentos/';
		
		$permisosFirmar=$documentos->getPermisosFirmarPdfs($_id_usuarios,$_macCliente);
			
		//para las notificaciones
		$_nombre_tipo_notificacion="providencia_secretario";
		$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
		$descripcion="Providencia Firmada por";
		$numero_movimiento=0;
		$id_impulsor="";
		
		//para obtener rol de usuario session inabilitado para metodo en applet
		$consultaUsuarios=$usuarios->getCondiciones("id_rol", "usuarios", "id_usuarios='$_id_usuarios'", "id_rol");
		$id_rol=$consultaUsuarios[0]->id_rol;
		
			
		if($permisosFirmar['estado'])
		{
		
			$id_firma = $permisosFirmar['valor'];
				
			$array_documento = explode(",", $_id_documentos);
		
		
			foreach ($array_documento as $id )
			{
		
		
				if(!empty($id))
				{
					$cantidadFirmados=$cantidadFirmados+1;
		
					$id_providencia = $id;
		
					$resultDocumento=$documentos->getBy("id_documentos='$id_providencia'");
		
					$nombrePdf=$resultDocumento[0]->nombre_documento;
		
					$nombrePdf=$nombrePdf.".pdf";
		
					$_ruta=$resultDocumento[0]->ruta_documento;
						
					//para metodo dentro del farmework
					//$id_rol=$_SESSION['id_rol'];
		
					$destino.=$_ruta.'/';
						
					$respuesta="Documentos firmados (";
		
		
					try {
							
						$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$id_rol,$_id_usuarios);
							
						$firmas->UpdateBy("firma_secretario='TRUE'", "documentos", "id_documentos='$id_providencia'");
							
						//$this->notificacionImpulsor($nombrePdf);
							
							
		
					} catch (Exception $e) {
							
						$respuesta= $e->getMessage();
					}
		
				}
			}
				
		$respuesta.=$cantidadFirmados.")";
			 
		}else{
				
			$respuesta= $permisosFirmar['error'];
		}
		
		return $respuesta;
	
	}
	
	public function firmarOficios()
	{
		$respuesta="";
		$cantidadFirmados=0;
		$consultaUsuarios=null;
		
		$usuarios= new UsuariosModel();
		$firmas= new FirmasDigitalesModel();
		$oficios=new OficiosModel();
		$tipo_notificacion = new TipoNotificacionModel();
		$asignacion_secreatario= new AsignacionSecretariosModel();
		
		
		$_id_usuarios=$id_Usuario;
		$_ruta=$rutaFiles;
		$_macCliente=$mac;
		$_id_documentos=$idsFiles;
		$_nombreDocumentos="";
		
		
		$destino = $_SERVER['DOCUMENT_ROOT'].'/documentos/';
		
		$permisosFirmar=$oficios->getPermisosFirmarPdfs($_id_usuarios,$_macCliente);
			
		//para las notificaciones
		$_nombre_tipo_notificacion="providencia_secretario";
		$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
		$descripcion="Oficio Firmado por";
		$numero_movimiento=0;
		$id_impulsor="";
		
		//para obtener rol de usuario session inabilitado para metodo en applet
		$consultaUsuarios=$usuarios->getCondiciones("id_rol", "usuarios", "id_usuarios='$_id_usuarios'", "id_rol");
		$id_rol=$consultaUsuarios[0]->id_rol;
		
			
		if($permisosFirmar['estado'])
		{
		
			$id_firma = $permisosFirmar['valor'];
		
			$array_documento = explode(",", $_id_documentos);
		
		
			foreach ($array_documento as $id )
			{
		
		
				if(!empty($id))
				{
					$cantidadFirmados=$cantidadFirmados+1;
		
					$id_providencia = $id;
		
					$resultDocumento=$documentos->getBy("id_documentos='$id_providencia'");
		
					$nombrePdf=$resultDocumento[0]->nombre_documento;
		
					$nombrePdf=$nombrePdf.".pdf";
		
					$_ruta=$resultDocumento[0]->ruta_documento;
		
					//para metodo dentro del farmework
					//$id_rol=$_SESSION['id_rol'];
		
					$destino.=$_ruta.'/';
		
					$respuesta="Documentos firmados (";
		
		
					try {
							
						$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$id_rol,$_id_usuarios);
							
						$firmas->UpdateBy("firma_secretario='TRUE'", "documentos", "id_documentos='$id_providencia'");
							
						//$this->notificacionImpulsor($nombrePdf);
							
							
		
					} catch (Exception $e) {
							
						$respuesta= $e->getMessage();
					}
		
				}
			}
		
			$respuesta.=$cantidadFirmados.")";
		
		}else{
		
			$respuesta= $permisosFirmar['error'];
		}
		
		return $respuesta;
	
	}
	
	public function firmarCitaciones()
	{
	
	}
	
	/*
	 * $traza=new TrazasModel();
						$_nombre_controlador = "Controladores";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_controladores;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
						
	 */
	
}
?>