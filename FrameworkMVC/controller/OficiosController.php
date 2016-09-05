<?php

class OficiosController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
     	$oficios= new OficiosModel(); 
		
	   //Conseguimos todos los usuarios
		$resultSet=$oficios->getAll("id_oficios");
		
		$entidades = new EntidadesModel();
		$resultEnt = $entidades->getAll("nombre_entidades");
				
		$resultEdit = "";

		
		$oficios= new OficiosModel();
		
		
		
		
		$resultDatos="";
		
		session_start();

	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			
			$oficios= new OficiosModel();
			//Notificaciones
			$oficios->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "Oficios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $oficios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_oficios"])   )
				{

					$nombre_controladores = "Oficios";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $oficios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_oficios = $_GET["id_oficios"];
						
						$columnas = " id_oficios";
						$tablas   = "oficios";
						$where    = "id_oficios = '$_id_oficios' "; 
						$id       = "id_oficios";
							
						$resultEdit = $oficios->getCondiciones($columnas ,$tablas ,$where, $id);

						$traza=new TrazasModel();
						$_nombre_controlador = "Oficios";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_oficios;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Tipos de Identificaciones"
					
						));
					
					
					}
					
				}
		
				if(isset($_POST["buscar"])){
						
					$criterio_busqueda=$_POST["criterio_busqueda"];
					$contenido_busqueda=$_POST["contenido_busqueda"];
						
					$oficios= new OficiosModel(); 
						
						
					$columnas = " clientes.id_clientes,
							juicios.id_juicios,
								  clientes.identificacion_clientes, 
								  clientes.nombres_clientes, 
								  juicios.juicio_referido_titulo_credito";
						
					$tablas   = " public.clientes, 
                                  public.juicios";
						
					$where    = "juicios.id_clientes = clientes.id_clientes";
						
					$id       = "juicios.juicio_referido_titulo_credito";
						
						
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					
						
					switch ($criterio_busqueda) {
							
						case 0:
							// identificacion de cliente
							$where_0 = " ";
							break;
						case 1:
							// identificacion de cliente
							$where_1 = " AND  clientes.identificacion_clientes LIKE '$contenido_busqueda'  ";
							break;
						case 2:
							//id_titulo de credito
							$where_2 = " AND  juicios.juicio_referido_titulo_credito = '$contenido_busqueda'  ";
							break;
				
						
								
					}
						
						
						
					$where_to  = $where . $where_0 . $where_1 . $where_2 ;
				
						
					$resultDatos=$oficios->getCondiciones($columnas ,$tablas ,$where_to, $id);
						
						
				}
				
				
				
				
				$this->view("Oficios",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit, "resultDatos" =>$resultDatos, "resultEnt" =>$resultEnt
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a oficios"
				
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
	
	public function InsertaOficios(){
			
		session_start();

		
		$oficios=new OficiosModel();
		$nombre_controladores = "Oficios";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $oficios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		
		if (!empty($resultPer))
		{
		$resultado = null;
			$oficios=new OficiosModel();
				
			if (isset ($_POST["Guardar"]) )
			{
				$_estado="Guardar";
					
				$consecutivo= new ConsecutivosModel();
				$resultConsecutivo= $consecutivo->getBy("documento_consecutivos='OFICIOS'");
				$identificador=$resultConsecutivo[0]->real_consecutivos;
				
				$repositorio_documento="Oficios";					
				$nombre_oficio=$repositorio_documento.$identificador;
				
			 	$_array_juicios = $_POST["id_juicios"];
				$_id_entidades = $_POST["id_entidades"];
				$_id_usuario_registra_oficios  = $_SESSION['id_usuarios'];
				
					foreach($_array_juicios  as $id  )
					{
						if (!empty($id))
						{
							//busco si exties este nuevo id
							try
							{
								$_id_juicios = $id;
								
								$anio=date("Y");
								$col_prefijo="prefijos.id_prefijos,prefijos.nombre_prefijos,prefijos.consecutivo";
								$tbl_prefijo="public.prefijos";
								$whre_prefijo="prefijos.nombre_prefijos='OFI'";
								
								$resultprefijo=$oficios->getCondiciones($col_prefijo, $tbl_prefijo, $whre_prefijo, "prefijos.id_prefijos");
								
								$id_prefijo=$resultprefijo[0]->id_prefijos;
								
								$consecutivo_oficio=(int)$resultprefijo[0]->consecutivo;
								$consecutivo_oficio=$consecutivo_oficio+1;
								$numero_oficio="OFI"."-".$consecutivo_oficio."-".$anio;
								
								
								$funcion = "ins_oficios";
								//parametros
								//, , , _,  ,  character varying,  character varying
								$parametros = "'$numero_oficio', '$_id_juicios', '$_id_entidades', '$_id_usuario_registra_oficios','$identificador','$nombre_oficio','$repositorio_documento' ";
								$oficios->setFuncion($funcion);
		                        $oficios->setParametros($parametros);
					            $resultado=$oficios->Insert();
					            
					            $prefijos=new PrefijosModel();
					            $colval="consecutivo=consecutivo+1";
					            $tabla="prefijos";
					            $where="id_prefijos='$id_prefijo'";
					             
					            $resultado=$prefijos->UpdateBy($colval, $tabla, $where);
					            $res=$consecutivo->UpdateBy("real_consecutivos=real_consecutivos+1", "consecutivos", "documento_consecutivos='OFICIOS'");
					            
					           
		                      
							} catch (Exception $e)
							{
								$this->view("Error",array(
										"resultado"=>"Eror al Asignar ->". $id
								));
							}
							
							$traza=new TrazasModel();
							$_nombre_controlador = "Oficios";
							$_accion_trazas  = "Guardar";
							$_parametros_trazas = $numero_oficio;
							$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
							
							
							$host  = $_SERVER['HTTP_HOST'];
							$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
							
							print "<script language='JavaScript'>
							setTimeout(window.open('http://$host$uri/view/ireports/ContOficiosCrearReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_oficio','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
							</script>";
								
							print("<script>window.location.replace('index.php?controller=Oficios&action=index');</script>");
								
						}
					
					}
					
				
				
				
				}
			 
			//$this->redirect("Oficios", "index");

		}
		else
		{
			$this->view("Error",array(
					
					"resultado"=>"No tiene Permisos de Insertar Oficios"
		
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
			if(isset($_GET["id_oficios"]))
			{
				$id_oficios=(int)$_GET["id_oficios"];
				
				$oficios=new OficiosModel();
				
				$oficios->deleteBy(" id_oficios",$id_oficios);
				
				$traza=new TrazasModel();
				$_nombre_controlador = "Oficios";
				$_accion_trazas  = "Borrar";
				$_parametros_trazas = $id_oficios;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
			}
			
			$this->redirect("Oficios", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Oficios"
			
			));
		}
				
	}
	
	public function consulta(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
	
		$usuarios = new UsuariosModel();
		$resultUsu= $usuarios->getAll("nombre_usuarios");
	
		$oficios = new OficiosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "Oficios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $oficios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$numero_oficios=$_POST['numero_oficios'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					$oficios= new OficiosModel();
					
					$columnas = "oficios.id_oficios,
					oficios.creado,
					oficios.numero_oficios,
					juicios.id_juicios,
					juicios.juicio_referido_titulo_credito,
					juicios.id_titulo_credito,
					clientes.nombres_clientes,
					clientes.identificacion_clientes,
					entidades.id_entidades,
					entidades.nombre_entidades";
	
					$tablas="public.oficios,
					public.juicios,
					public.entidades,
					public.clientes,
					public.usuarios";
	
					$where="juicios.id_juicios = oficios.id_juicios AND
					entidades.id_entidades = oficios.id_entidades AND
					clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios";
	
					$id="oficios.id_oficios";
						
						
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_usuarios!=0){$where_0=" AND usuarios.id_usuarios='$id_usuarios'";}
						
					if($numero_juicio!=""){$where_1=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
						
					if($numero_oficios!=""){$where_3=" AND oficios.numero_oficios='$numero_oficios'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  oficios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$oficios->getCondiciones($columnas ,$tablas , $where_to, $id);
	
	
				}
	
	
	
	
				$this->view("ConsultaOficios",array(
						"resultSet"=>$resultSet,"resultUsu"=>$resultUsu
							
				));
	
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Citaciones"
	
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
	
	
	
	public function consulta_firmar(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
	
		$usuarios = new UsuariosModel();
		$resultUsu= $usuarios->getAll("nombre_usuarios");
	
		$oficios = new OficiosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "Oficios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $oficios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$numero_oficios=$_POST['numero_oficios'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					$oficios= new OficiosModel();
						
					$columnas = "oficios.id_oficios,
					oficios.creado,
					oficios.numero_oficios,
					juicios.id_juicios,
					juicios.juicio_referido_titulo_credito,
					juicios.id_titulo_credito,
					clientes.nombres_clientes,
					clientes.identificacion_clientes,
					entidades.id_entidades,
					entidades.nombre_entidades";
	
					$tablas="public.oficios,
					public.juicios,
					public.entidades,
					public.clientes,
					public.usuarios";
	
					$where="juicios.id_juicios = oficios.id_juicios AND
					entidades.id_entidades = oficios.id_entidades AND
					clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios";
	
					$id="oficios.id_oficios";
	
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_usuarios!=0){$where_0=" AND usuarios.id_usuarios='$id_usuarios'";}
	
					if($numero_juicio!=""){$where_1=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
	
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
	
					if($numero_oficios!=""){$where_3=" AND oficios.numero_oficios='$numero_oficios'";}
	
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  oficios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$oficios->getCondiciones($columnas ,$tablas , $where_to, $id);
	
	
				}
				
			if(isset($_POST['firmar']))
				{
					/*
					$firmas= new FirmasDigitalesModel();
					$oficios = new OficiosModel();
					$tipo_notificacion = new TipoNotificacionModel();
					$asignacion_secreatario= new AsignacionSecretariosModel();
					
					
					$ruta="";
					$nombrePdf="";
					
					$destino = $_SERVER['DOCUMENT_ROOT'].'/documentos/';
					
					$array_documento=$_POST['file_firmar'];
					
										
					$permisosFirmar=$permisos_rol->getPermisosFirmarPdfs($_SESSION['id_usuarios']);
					
					//para las notificaciones 
					$_nombre_tipo_notificacion="documentos";					
					$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");						
					$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;					
					$descripcion="Documento Firmado por";
					$numero_movimiento=0;
					$id_impulsor="";
					
					
					if($permisosFirmar['estado'])
					{
						
						$id_firma = $permisosFirmar['valor'];
						
						
						foreach ($array_documento as $id )
						{
														
							if(!empty($id))
							{
								
								$id_oficios = $id;
								
								$resultOficio=$oficios->getBy("id_oficios='$id_oficios'");
								
								$nombrePdf=$resultOficio[0]->nombre_oficio;
								
								$nombrePdf.=".pdf";
								
								$ruta=$resultOficio[0]->ruta_oficio;
				
								$id_rol=$_SESSION['id_rol'];
								
								$destino.=$ruta.'/';
								
								
								try {
									
									$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$id_rol);
									
									$firmas->UpdateBy("firma_secretario='TRUE'", "oficios", "id_oficios='$id_oficios'");
									
									//dirigir notificacion
									$usuarioDestino=$resultOficio[0]->id_usuario_registra_oficios;
									
									//$result_notificaciones=$firmas->CrearNotificacion($id_tipo_notificacion, $usuarioDestino, $descripcion, $numero_movimiento, $nombrePdf);
											
									
																		
								} catch (Exception $e) {
									
									echo $e->getMessage();
								}
								
							}
						}
					}else{
						//para cuando no puede firmar
						
						$this->view("Error", array("resultado"=>"Error <br>".$permisosFirmar['error']));
						exit();
						
					} 
					*/
				}
				
	
	
	
	
				$this->view("ConsultaOficiosFirmar",array(
						"resultSet"=>$resultSet,"resultUsu"=>$resultUsu
							
				));
				
				
				
	
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Citaciones"
	
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
		$oficios = new OficiosModel();
	
		if(isset($_GET['id']))
		{
				
			$id_oficios = $_GET ['id'];
				
			$resultOficios = $oficios->getBy ( "id_oficios='$id_oficios'" );
				
			if (! empty ( $resultOficios )) {
	
				$nombrePdf = $resultOficios [0]->nombre_oficio;
	
				$nombrePdf .= ".pdf";
	
				$ruta = $resultOficios [0]->ruta_oficio;
	
				$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/documentos/' . $ruta . '/' . $nombrePdf;
				
				//echo $directorio;
	
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="'.$directorio.'"');
				readfile($directorio);
			}
	
		}
	
	
	
	}
	
	//funcion utilizado por el applet de java
	public  function EnviarApplet()
	{
		//pasar parametros
	
		session_start();
	
		$consulta = array();
	
		$resultUsuario="";
		$resultnombreFiles="";
		$ruta="";
		$resultIds="";
	
	
		$citaciones = new CitacionesModel();
		$oficios = new OficiosModel();
	
		if(isset($_POST['file_firmar']))
		{
			$resultUsuario=$_SESSION['id_usuarios'];
	
			$arrayFilesAfirmar=$_POST['file_firmar'];
			$cadenaFiles="";
			$cadenaId="";
			$ruta="Oficios";
			$nombreUsuario="";
			$controlador="Oficios";
			$accion="FirmarOficiosApplet";
	
			foreach ($arrayFilesAfirmar as $res)
			{
				$cadenaId.=$res.",";
			}
	
			//$cadenaFiles = substr($cadenaFiles, 0, -1);
			//$cadenaId = substr($cadenaId, 0, -1);
	
			$resultIds = trim($cadenaId,",");
	
			$consulta=$oficios->getBy("id_oficios in ('$resultIds')");
	
			if (!empty($consulta)) {  foreach($consulta as $res) {
	
				$cadenaFiles.=$res->nombre_oficio;
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
	
	//metodo utilizado por el applet para firmar oficios impulsor
	public  function FirmarOficiosApplet()
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
				$consultaUsuarios=$user->getCondiciones("id_rol,nombre_rol", "usuarios", "id_usuarios='$id_usuario'", "id_rol");
				$id_rol=$consultaUsuarios[0]->id_rol;
				$nombre_Rol=$consultaUsuarios[0]->nombre_rol;
	
				//para las notificaciones
				$tipo_notificacion = new TipoNotificacionModel();
				$asignacion_secretario= new AsignacionSecretariosModel();
				$_nombre_tipo_notificacion="";
				$descripcion="Oficio Firmado por";
				$actualizar="";
				
				if($nombre_Rol=="ABOGADO IMPULSOR"){
					$actualizar="firma_impulsor='TRUE'";
					$_nombre_tipo_notificacion="oficio_impulsor";
				}else if($nombre_Rol=="SECRETARIO"){
					$_nombre_tipo_notificacion="oficio_secretario";
					$actualizar="firma_secretario='TRUE'";
				}
				
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
					$citaciones = new CitacionesModel();
	
					$_id_usuarios=$id_Usuario;
					$_ruta=$rutaFiles;
					$_id_documentos=$idsFiles;
					$_nombreDocumentos="";
	
					$destino = $_SERVER['DOCUMENT_ROOT'].'/documentos/';
	
	
	
					$array_documento = explode(",", $_id_documentos);
					$respuestaCliente="Documentos firmados (";
	
					foreach ($array_documento as $id )
					{
	
	
						if(!empty($id))
						{
							$cantidadFirmados=$cantidadFirmados+1;
	
							$id_citacion = $id;
	
							$resultDocumento=$citaciones->getBy("id_citaciones='$id_citacion'");
	
							$nombrePdf=$resultDocumento[0]->nombre_citacion;
	
							$nombrePdf=$nombrePdf.".pdf";
	
							$_ruta=$resultDocumento[0]->ruta_citacion;
	
							//para metodo dentro del farmework
							//$id_rol=$_SESSION['id_rol'];
	
							$destino.=$_ruta.'/';
	
							try {
									
								$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$rol,$_id_usuarios);
	
								$firmas->UpdateBy($actualizar, "citaciones", "id_citaciones='$id_citacion'");
	
								//crear notificacion usa variable de session
								//$this->notificacionImpulsor($nombrePdf);
	
							} catch (Exception $e) {
									
								$respuestaCliente= $e->getMessage();
							}
	
	
						}
	
	
					}
	
					$respuestaCliente.=$cantidadFirmados.")";
	
	
	
				}else {
	
					$traza=new TrazasModel();
					$_nombre_controlador = "Oficios";
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