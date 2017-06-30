<?php

class ConsultaOficiosLiquidadorController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	
	public function consulta_oficios_liquidador(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
	
		$oficios_liquidador=new OficiosModel();
		$usuarios = new UsuariosModel();
		// saber la ciudad del usuario
		$_id_usuarios= $_SESSION["id_usuarios"];
	
		$columnas = " usuarios.id_ciudad,
					  ciudad.nombre_ciudad,
					  usuarios.nombre_usuarios";
			
		$tablas   = "public.usuarios,
                     public.ciudad";
			
		$where    = "ciudad.id_ciudad = usuarios.id_ciudad AND usuarios.id_usuarios = '$_id_usuarios'";
			
		$id       = "usuarios.id_ciudad";
		$resultDatos=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		// saber los impulsores del secretario
		$_id_usuarios= $_SESSION["id_usuarios"];
	
		$columnas = " asignacion_secretarios_view.id_abogado,
					  asignacion_secretarios_view.impulsores";
			
		$tablas   = "public.asignacion_secretarios_view";
			
		$where    = "public.asignacion_secretarios_view.id_liquidador = '$_id_usuarios'";
			
		$id       = "asignacion_secretarios_view.id_abogado";
		$resultImpul=$oficios_liquidador->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getAll("nombre_ciudad");
	
	
		$usuarios = new UsuariosModel();
		$resultUsu = $usuarios->getAll("nombre_usuarios");
	
	
		$oficios_secretarios=new OficiosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			//notificaciones
			$oficios_liquidador->MostrarNotificaciones($_SESSION['id_usuarios']);
				
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaOficiosLiquidador";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $oficios_liquidador->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					$oficios_liquidador=new OficiosModel();
	
	
					$columnas = "oficios.id_oficios,
							ciudad.nombre_ciudad,
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
					public.usuarios,
					public.ciudad";
	
					$where="juicios.id_ciudad = ciudad.id_ciudad AND juicios.id_juicios = oficios.id_juicios AND
					entidades.id_entidades = oficios.id_entidades AND
					clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios AND oficios.firma_impulsor='TRUE' AND oficios.firma_secretario='TRUE'  AND oficios.firma_liquidador='FALSE'";
	
					$id="oficios.id_oficios";
				
	
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
					if($id_usuarios!=0){$where_1=" AND usuarios.id_usuarios='$id_usuarios'";}
	
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
	
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  oficios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
					$resultSet=$oficios_liquidador->getCondiciones($columnas ,$tablas , $where_to, $id);
	
	
				}
	
	
	
				$this->view("ConsultaOficiosLiquidadorFirmar",array(
						"resultSet"=>$resultSet,"resultCiu"=>$resultCiu, "resultUsu"=>$resultUsu, "resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul
							
				));
	
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Oficios Liquidador"
	
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
	
	
	
	public function consulta_oficios_liquidador_firmados(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
		$oficios_liquidador=new OficiosModel();
		$usuarios = new UsuariosModel();
		// saber la ciudad del usuario
		$_id_usuarios= $_SESSION["id_usuarios"];
	
		$columnas = " usuarios.id_ciudad,
					  ciudad.nombre_ciudad,
					  usuarios.nombre_usuarios";
			
		$tablas   = "public.usuarios,
                     public.ciudad";
			
		$where    = "ciudad.id_ciudad = usuarios.id_ciudad AND usuarios.id_usuarios = '$_id_usuarios'";
			
		$id       = "usuarios.id_ciudad";
		$resultDatos=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		// saber los impulsores del secretario
		$_id_usuarios= $_SESSION["id_usuarios"];
	
		$columnas = " asignacion_secretarios_view.id_abogado,
					  asignacion_secretarios_view.impulsores";
			
		$tablas   = "public.asignacion_secretarios_view";
			
		$where    = "public.asignacion_secretarios_view.id_liquidador = '$_id_usuarios'";
			
		$id       = "asignacion_secretarios_view.id_abogado";
		$resultImpul=$oficios_liquidador->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getAll("nombre_ciudad");
	
	
		$usuarios = new UsuariosModel();
		$resultUsu = $usuarios->getAll("nombre_usuarios");
	
	
		$oficios_liquidador=new OficiosModel();
		$oficios_liquidador=new DocumentosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaOficiosLiquidador";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $oficios_liquidador->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
				$oficios_liquidador=new OficiosModel();
	
	
					$columnas = "oficios.id_oficios,
							ciudad.nombre_ciudad,
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
					public.usuarios,
					public.ciudad";
	
					$where=" juicios.id_ciudad = ciudad.id_ciudad AND juicios.id_juicios = oficios.id_juicios AND
					entidades.id_entidades = oficios.id_entidades AND
					clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios AND oficios.firma_impulsor='TRUE' AND oficios.firma_secretario='TRUE' AND oficios.firma_liquidador='TRUE'";
	
					$id="oficios.id_oficios";
				
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
	
					if($id_usuarios!=0){$where_1=" AND usuarios.id_usuarios='$id_usuarios'";}
	
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
	
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
	
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  oficios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$oficios_liquidador->getCondiciones($columnas ,$tablas , $where_to, $id);
	
				}
	
				$this->view("ConsultaOficiosLiquidadorFirmados",array(
						"resultSet"=>$resultSet,"resultCiu"=>$resultCiu, "resultUsu"=>$resultUsu, "resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul
							
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Oficios Liquidador Firmados"
	
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
			$controlador="ConsultaOficiosLiquidador";
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
	
							$id_citacion = $id;
	
							$resultDocumento=$citaciones->getBy("id_citaciones='$id_citacion'");
	
							$nombrePdf=$resultDocumento[0]->nombre_citacion;
	
							$nombrePdf=$nombrePdf.".pdf";
	
							$_ruta=$resultDocumento[0]->ruta_citacion;
	
							//para metodo dentro del farmework
							//$id_rol=$_SESSION['id_rol'];
	
							$destino.=$_ruta.'/';
	
							try {
									
								$res=$firmas->FirmarPDFs( $destino, $nombrePdf, $id_firma,$id_rol,$_id_usuarios);
	
								//$firmas->UpdateBy($actualizar, "citaciones", "id_citaciones='$id_citacion'");
	
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
					$_nombre_controlador = "ConsultaOficiosLiquidador";
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