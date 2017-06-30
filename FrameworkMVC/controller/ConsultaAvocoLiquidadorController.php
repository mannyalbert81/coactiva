<?php
class ConsultaAvocoLiquidadorController extends ControladorBase{
	
	public function __construct() {
		parent::__construct();
	}

	
	public function consulta_liquidador_avoco(){

		session_start();

		//Creamos el objeto usuario
		$resultSet="";
		$avoco_liquidador=new AvocoConocimientoModel();
		$usuarios = new UsuariosModel();
		// saber la ciudad del usuario
		$_id_usuario= $_SESSION["id_usuarios"]; 
		
		$columnas = " usuarios.id_ciudad, 
					  ciudad.nombre_ciudad, 
					  usuarios.nombre_usuarios";
			
		$tablas   = "public.usuarios, 
                     public.ciudad";
			
		$where    = "ciudad.id_ciudad = usuarios.id_ciudad AND usuarios.id_usuarios = '$_id_usuario'";
			
		$id       = "usuarios.id_ciudad";
		$resultDatos=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
		
		
		// saber los impulsores del secretario
		$_id_usuarios= $_SESSION["id_usuarios"];
		
		$columnas = " asignacion_secretarios_view.id_abogado,
					  asignacion_secretarios_view.impulsores";
			
		$tablas   = "public.asignacion_secretarios_view";
			
		$where    = "public.asignacion_secretarios_view.id_liquidador = '$_id_usuarios'";
			
		$id       = "asignacion_secretarios_view.id_abogado";
		$resultImpul=$avoco_liquidador->getCondiciones($columnas ,$tablas ,$where, $id);
		
		
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getAll("nombre_ciudad");
		
		
		$usuarios = new UsuariosModel();
		$resultUsu = $usuarios->getAll("nombre_usuarios");
		

		$avoco_liquidador=new AvocoConocimientoModel();


		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			//notificaciones
			$avoco_liquidador->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaAvocoLiquidador";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $avoco_liquidador->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );

			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){

					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];

					$avoco_liquidador=new AvocoConocimientoModel();


					$columnas = "avoco_conocimiento.id_avoco_conocimiento, 
							  juicios.juicio_referido_titulo_credito, 
							  clientes.nombres_clientes, 
							  clientes.identificacion_clientes, 
							  ciudad.nombre_ciudad, 
							  asignacion_secretarios_view.secretarios, 
							  asignacion_secretarios_view.impulsores,
							  avoco_conocimiento.creado";

					$tablas=" public.avoco_conocimiento, 
							  public.juicios, 
							  public.ciudad, 
							  public.asignacion_secretarios_view, 
							  public.clientes";

					$where="avoco_conocimiento.id_secretario = asignacion_secretarios_view.id_secretario AND
						  avoco_conocimiento.id_impulsor = asignacion_secretarios_view.id_abogado AND
						  juicios.id_juicios = avoco_conocimiento.id_juicios AND
						  ciudad.id_ciudad = avoco_conocimiento.id_ciudad AND
						  clientes.id_clientes = juicios.id_clientes AND 
						  avoco_conocimiento.firma_impulsor='TRUE' AND avoco_conocimiento.firma_secretario='TRUE' AND avoco_conocimiento.firma_liquidador ='FALSE' AND asignacion_secretarios_view.id_liquidador='$_id_usuarios'";

					$id="avoco_conocimiento.id_avoco_conocimiento";
						
						
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";


					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
					
					if($id_usuarios!=0){$where_1=" AND avoco_conocimiento.id_impulsor='$id_usuarios'";}
						
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
						
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
					
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  avoco_conocimiento.creado BETWEEN '$fechadesde' AND '$fechahasta'";}

                    $where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
                    
                    $resultSet=$avoco_liquidador->getCondiciones($columnas ,$tablas , $where_to, $id);


				}
				
				




				$this->view("ConsultaAvocoLiquidador",array(
						"resultSet"=>$resultSet,"resultCiu"=>$resultCiu, "resultUsu"=>$resultUsu, "resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul
							
				));



			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Firmar Avoco Liquidador"

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


	
	
	public function consulta_liquidador_avoco_firmados(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
		$avoco_liquidador=new AvocoConocimientoModel();
		$usuarios = new UsuariosModel();
		// saber la ciudad del usuario
		$_id_usuario= $_SESSION["id_usuarios"];
	
		$columnas = " usuarios.id_ciudad,
					  ciudad.nombre_ciudad,
					  usuarios.nombre_usuarios";
			
		$tablas   = "public.usuarios,
                     public.ciudad";
			
		$where    = "ciudad.id_ciudad = usuarios.id_ciudad AND usuarios.id_usuarios = '$_id_usuario'";
			
		$id       = "usuarios.id_ciudad";
		$resultDatos=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		// saber los impulsores del secretario
		$_id_usuarios= $_SESSION["id_usuarios"];
	
		$columnas = " asignacion_secretarios_view.id_abogado,
					  asignacion_secretarios_view.impulsores";
			
		$tablas   = "public.asignacion_secretarios_view";
			
		$where    = "public.asignacion_secretarios_view.id_liquidador = '$_id_usuarios'";
			
		$id       = "asignacion_secretarios_view.id_abogado";
		$resultImpul=$avoco_liquidador->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getAll("nombre_ciudad");
	
	
		$usuarios = new UsuariosModel();
		$resultUsu = $usuarios->getAll("nombre_usuarios");
	
	
	    $avoco_secretarios=new AvocoConocimientoModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaAvocoLiquidador";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $avoco_liquidador->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					 $avoco_liquidador=new AvocoConocimientoModel();
	
	
					$columnas = "avoco_conocimiento.id_avoco_conocimiento, 
							juicios.id_juicios,
							  juicios.juicio_referido_titulo_credito, 
							  clientes.nombres_clientes, 
							  clientes.identificacion_clientes, 
							  ciudad.nombre_ciudad, 
							  asignacion_secretarios_view.secretarios, 
							  asignacion_secretarios_view.impulsores,
							  avoco_conocimiento.creado";
	
					$tablas=" public.avoco_conocimiento, 
							  public.juicios, 
							  public.ciudad, 
							  public.asignacion_secretarios_view, 
							  public.clientes";
	
					$where="avoco_conocimiento.id_secretario = asignacion_secretarios_view.id_secretario AND
						  avoco_conocimiento.id_impulsor = asignacion_secretarios_view.id_abogado AND
						  juicios.id_juicios = avoco_conocimiento.id_juicios AND
						  ciudad.id_ciudad = avoco_conocimiento.id_ciudad AND
						  clientes.id_clientes = juicios.id_clientes
						AND avoco_conocimiento.firma_impulsor='TRUE' AND avoco_conocimiento.firma_secretario ='TRUE' AND avoco_conocimiento.firma_liquidador ='TRUE' AND asignacion_secretarios_view.id_liquidador='$_id_usuarios'";
	
					$id="avoco_conocimiento.id_avoco_conocimiento";
	
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
					if($id_usuarios!=0){$where_1=" AND avoco_conocimiento.id_impulsor='$id_usuarios'";}
	
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
	
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  avoco_conocimiento.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$avoco_liquidador->getCondiciones($columnas ,$tablas , $where_to, $id);
	
	         }
	
				$this->view("ConsultaAvocoLiquidadorFirmados",array(
						"resultSet"=>$resultSet,"resultCiu"=>$resultCiu, "resultUsu"=>$resultUsu, "resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul
							
				));
	
	         }
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Avoco Secretarios Firmados"
	
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

	public function abrirPdf()
	{
		$avoco = new AvocoConocimientoModel();
		
		if(isset($_GET['id']))
		{
			
			$id_documento = $_GET ['id'];
			
			$resultDocumento = $avoco->getBy ( "id_avoco_conocimiento='$id_documento'" );
			
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
	
	public function rechazarPdf()
	{
		session_start();
		
		$avoco = new AvocoConocimientoModel();

		$firmas= new FirmasDigitalesModel();
	
		$tipo_notificacion = new TipoNotificacionModel();
		$asignacion_secreatario= new AsignacionSecretariosModel();
	
			
		//para las notificaciones
		$_nombre_tipo_notificacion="rechazado";
		$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
		$descripcion="Avoco Rechazo por";
		$numero_movimiento=0;
		$id_impulsor="";
	
		if(isset($_GET['id']))
		{
	
			$id_avoco = $_GET ['id'];
			$resultAvoco = $avoco->getBy ( "id_avoco_conocimiento='$id_avoco'" );
				
				
			if (! empty ( $resultAvoco )) {
	
				$nombrePdf = $resultAvoco [0]->nombre_documento;
	
				$nombrePdf .= ".pdf";
	
				$ruta = $resultAvoco [0]->ruta_documento;
	
				$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	
	
				try {
						
					$eliminado=unlink($directorio);
					$resultDocumento=$avoco->deleteById("id_avoco_conocimiento='$id_avoco'");
					
					
					//dirigir notificacion
					$usuarioDestino=$resultAvoco[0]->id_usuario_registra_avoco;
						
					$result_notificaciones=$firmas->CrearNotificacion($id_tipo_notificacion, $usuarioDestino, $descripcion, $numero_movimiento, $nombrePdf);
										
					//$this->view("Error", array("resultado"=>"no se elimino el archivo <br>".print_r($result_notificaciones)));
					$this->redirect("ConsultaAvocoLiquidador","consulta_liquidador_avoco");
					
				} catch (Exception $e)
				{
					$this->view("Error", array("resultado"=>"no se elimino el archivo <br>".$e->getMessage()));
				}
					
			}
	
	
		}
	
	
	}

	public function notificacionImpulsor($documento=null)
	{
		$tipo_notificacion= new TipoNotificacionModel();
		$usuario = new UsuariosModel();
		
		$res_tipo_notificacion=array();
		
		$res_liquidador=$usuario->getCondiciones("usuarios.id_usuarios",
											  "public.usuarios,public.rol", 
											  "rol.id_rol = usuarios.id_rol AND rol.nombre_rol = 'LIQUIDADOR'",
											  "usuarios.id_usuarios"
												);
		$destino=$res_liquidador[0]->id_usuarios;
		
		$archivoPdf=$documento;
		
		$_nombre_tipo_notificacion="avoco_impulsor";
		
		$res_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		
		$id_tipo_notificacion=$res_tipo_notificacion[0]->id_tipo_notificacion;
		
		$descripcion="Avoco Conocimiento";
		
		$numero_movimiento=0;
		
		$tipo_notificacion->CrearNotificacion($id_tipo_notificacion, $destino, $descripcion, $numero_movimiento, $archivoPdf);
		
	}
	
	//funcion que envia al applet
	public  function EnviarApplet()
	{
		//pasar parametros 
		
		session_start();
		
		$consulta = array();
		
		$resultUsuario="";
		$resultnombreFiles="";
		$ruta="";
		$resultIds="";
		
		$avoco=new AvocoConocimientoModel();
		
		if(isset($_POST['file_firmar']))
		{
			$resultUsuario=$_SESSION['id_usuarios'];
			
			$arrayFilesAfirmar=$_POST['file_firmar'];
			$cadenaFiles="";
			$cadenaId="";
			$ruta="Avoco";
			$nombreUsuario="";
			$controlador="ConsultaAvocoLiquidador";
			$accion="FirmarAvocoApplet";
				
				foreach ($arrayFilesAfirmar as $res)
				{
					$cadenaId.=$res.",";
				}
				
			//$cadenaFiles = substr($cadenaFiles, 0, -1);
			//$cadenaId = substr($cadenaId, 0, -1);
			
			$resultIds = trim($cadenaId,",");
			
			$consulta=$avoco->getBy("id_avoco_conocimiento in ('$resultIds')");
			
			if (!empty($consulta)) {  foreach($consulta as $res) {
						
						$cadenaFiles.=$res->nombre_documento;
					}
				}
			
			$resultnombreFiles = trim($cadenaFiles,",");
			
			$certificado=new CertificadosModel();
			$firma = new FirmasDigitalesModel();
			
			$msg="";
			
			$conCertificado= $certificado->getBy("id_usuarios_certificado_digital='$resultUsuario'");
			
			$conFirma=$firma->getBy("id_usuarios='$resultUsuario'");
			
			if(empty($conCertificado)){$msg="Usted no tiene registrado un Certfificado electronico";}
			
			if(empty($conFirma)){$msg="Usted no cuenta con una firma digital registrado en el sistema";}
			
			$nombreUsuario=$_SESSION['nombre_usuarios'];
			
			
			$this->view("FirmarPdf",array(
						
					"resultUsuario"=>$resultUsuario,"resultnombreFiles"=>$resultnombreFiles,"ruta"=>$ruta,"resultIds"=>$resultIds,"msg"=>$msg,"nombreUsuario"=>$nombreUsuario,"controlador"=>$controlador,"accion"=>$accion
			
			));
			
			 
			/*$this->view("Error",array(
						
					"resultado"=>$resultUsuario."resultnombreFiles".$resultnombreFiles."ruta".$ruta."resultIds".$resultIds."msg".$msg."nombreUsuario".$nombreUsuario
			
			
			));*/
			
			
			
		}else {
			
			$this->view("Error",array(
			
					"resultado"=>"no hay archivos"
						
			));
		}
		
	}
	
	//metodo utilizado por el applet para firmar avoco
	public  function FirmarAvocoApplet()
	{
		session_start();
		
		if(isset($_POST['filesIds'])&&isset($_POST['mac'])&&isset($_POST['ruta'])&&isset($_POST['id_usuario']))
		{
			if(!is_null($_POST['filesIds']) || !is_null($_POST['mac']) || !is_null($_POST['ruta']) || !is_null($_POST['id_usuario'])){
		
				$rutaXfirmar=$_POST['ruta'];
				$macCliente=$_POST['mac'];
				$idsFiles=$_POST['filesIds'];
				$id_usuario=$_POST['id_usuario'];
		
				$user = new UsuariosModel();
				$permisosFirmar=$user->getPermisosFirmarPdfs($id_usuario,$macCliente);
		
				//para obtener rol de usuario
				$consultaUsuarios=$user->getCondiciones("id_rol", "usuarios", "id_usuarios='$id_usuario'", "id_rol");
				$id_rol=$consultaUsuarios[0]->id_rol;
		
				//para las notificaciones
				$tipo_notificacion = new TipoNotificacionModel();
				$asignacion_secretario= new AsignacionSecretariosModel();
				$_nombre_tipo_notificacion="avoco";
				$descripcion="Avoco Firmado por";
				$numero_movimiento=0;
				$id_impulsor="";
				$respuestaCliente="";
				$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
				$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
		
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
					$_id_documentos=$idsFiles;
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
											
											$respuestaCliente= $e->getMessage();
										}
					
								
							}
		
				
						}
						
						$respuestaCliente.=$cantidadFirmados.")";
						
				
						
				}else {
						
					$traza=new TrazasModel();
					$_nombre_controlador = "Firmas Digitales";
					$_accion_trazas  = "Se intento Firmar desde ";
					$_parametros_trazas = $macCliente;
					$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador,$id_usuario);
						
					$respuestaCliente=$permisosFirmar['error'];
						
				}
		
				echo $respuestaCliente;
		
		
			}else{
		
				echo 'error en el envio de datos';
			}
				
		}else{
			echo 'error sus Datos no han sido enviados';
		}
		
	}


}
?>