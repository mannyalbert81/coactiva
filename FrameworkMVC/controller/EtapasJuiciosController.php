<?php

class EtapasJuiciosController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
     	$etapas_juicios = new EtapasJuiciosModel(); 
		
	   //Conseguimos todos los usuarios
		$resultSet=$etapas_juicios->getAll("id_etapas_juicios");
				
		$resultEdit = "";

		
		session_start();
		

	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{

			//Notificaciones
			$etapas_juicios->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$nombre_controladores = "EtapasJuicios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $etapas_juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				
				
				if (isset ($_GET["id_etapas_juicios"])   )
				{
					
					$nombre_controladores = "EtapasJuicios";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $etapas_juicios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_etapas_juicios = $_GET["id_etapas_juicios"];
						$columnas = " id_etapas_juicios, nombre_etapas";
						$tablas   = "etapas_juicios";
						$where    = "id_etapas_juicios = '$_id_etapas_juicios' "; 
						$id       = "nombre_etapas";
							
						
						$resultEdit = $etapas_juicios->getCondiciones($columnas ,$tablas ,$where, $id);
						
						
						$traza=new TrazasModel();
						$_nombre_controlador = "Etapas Juicios";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_etapas_juicios;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
						
					
					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Etapas Juicios"
					
						));
					
					
					}
					
				}
		
				
				$this->view("EtapasJuicios",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Etapas Juicios"
				
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
	
	public function InsertaEtapasJuicios(){
			
		session_start();
        $permisos_rol=new PermisosRolesModel();
        $etapas_juicios = new EtapasJuiciosModel(); 
        $permisos_rol=new PermisosRolesModel();

		$nombre_controladores = "EtapasJuicios";
		$id_rol= $_SESSION['id_rol'];
         $resultPer = $etapas_juicios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );

		
		
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			
			$etapas_juicios = new EtapasJuiciosModel(); 
		
			//_nombre_controladores
			
			if (isset ($_POST["nombre_etapas"]) )
				
			{
				
				
				
				$_nombre_etapas = $_POST["nombre_etapas"];
				
				
				if(isset($_POST["id_etapas_juicios"])) 
				{
					
					$_id_etapas_juicios = $_POST["id_etapas_juicios"];
					
					$colval = " nombre_etapas = '$_nombre_etapas'   ";
					$tabla = "etapas_juicios";
					$where = "id_etapas_juicios = '$_id_etapas_juicios'    ";
					
					$resultado=$etapas_juicios->UpdateBy($colval, $tabla, $where);
					
				}else {
					
			
				
				$funcion = "ins_etapas_juicios";
				
				$parametros = " '$_nombre_etapas'  ";
					
				$etapas_juicios->setFuncion($funcion);
		
				$etapas_juicios->setParametros($parametros);
		
		
				$resultado=$etapas_juicios->Insert();
			
				$traza=new TrazasModel();
				$_nombre_controlador = "Etapas Juicios";
				$_accion_trazas  = "Guardar";
				$_parametros_trazas = $_nombre_etapas;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
			 }
		
			}
			$this->redirect("EtapasJuicios", "index");

		}
		else
		{
			$this->view("Error",array(
					
					"resultado"=>"No tiene Permisos de Insertar Etapas Juicios"
		
			));
		
		
		}
		
	}
	
	
	public function ActualizarEtapasJuicios(){
	
		session_start();
	
		$resultado = null;
		$notificaciones = new NotificacionesModel();
		$tipo_notificacion = new TipoNotificacionModel();
		$permisos_rol=new PermisosRolesModel();
		$etapas_juicios = new EtapasJuiciosModel(); 
		$nombre_controladores = "EtapasJuicios";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $etapas_juicios->getPermisosEditar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
	
		if (!empty($resultPer))
		{
				
			if (isset ($_POST["actualizar"]) )
			{
			
				$_id_juicios = $_POST["id_juicios"];
				$_id_etapas_juicios = $_POST["id_estados_procesales_juicios"];
				$_id_usuario_registra_llamada      = $_SESSION['id_usuarios'];
				
				
						
				$funcion = "ins_actualizar_etapas_juicios";
							$parametros = "'$_id_juicios','$_id_etapas_juicios', '$_id_usuario_registra_llamada'";
							$etapas_juicios->setFuncion($funcion);
							$etapas_juicios->setParametros($parametros);
							$resultado=$etapas_juicios->Insert();
			
					
							$traza=new TrazasModel();
							$_nombre_controlador = "EtapasJuicios";
							$_accion_trazas  = "Guardar";
							$_parametros_trazas = $_id_juicios;
							$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
								
			}
			
			
			if(isset($_POST["id_juicios"]))
			{
				
				$juicios = new JuiciosModel();
			
				$_id_juicios = $_POST["id_juicios"];
				$_numero_juicio     = $_POST["juicio_referido_titulo_credito"];
				$_estados_procesales   = $_POST["id_estados_procesales_juicios"];
				
			
				
				
				$colval = " juicio_referido_titulo_credito = '$_numero_juicio', id_estados_procesales_juicios = '$_estados_procesales'";
				$tabla = "juicios";
				$where = "id_juicios = '$_id_juicios'    ";
					
				$resultado=$juicios->UpdateBy($colval, $tabla, $where);
			
			}
			
			if(isset($_POST["id_clientes"]))
			{
				
				$clientes = new ClientesModel();
			
				$_id_clientes = $_POST["id_clientes"];
				$_nombres_clientes     = $_POST["nombres_clientes"];
				$_telefono_clientes   = $_POST["telefono_clientes"];
				$_celular_clientes   = $_POST["celular_clientes"];
				$_direccion_clientes   = $_POST["direccion_clientes"];
				
			
				$_nombre_garantes   = $_POST["nombre_garantes"];
				$_identificacion_garantes   = $_POST["identificacion_garantes"];
				$_telefono_garantes  = $_POST["telefono_garantes"];
				$_celular_garantes  = $_POST["celular_garantes"];
				
				
				$_nombre_garantes_1   = $_POST["nombre_garantes_1"];
				$_identificacion_garantes_1   = $_POST["identificacion_garantes_1"];
				$_telefono_garantes_1  = $_POST["telefono_garantes_1"];
				$_celular_garantes_1  = $_POST["celular_garantes_1"];
				
				$colval = " nombres_clientes = '$_nombres_clientes', telefono_clientes = '$_telefono_clientes',
				            celular_clientes = '$_celular_clientes', direccion_clientes = '$_direccion_clientes',
				            nombre_garantes = '$_nombre_garantes', identificacion_garantes = '$_identificacion_garantes',
				            telefono_garantes = '$_telefono_garantes', celular_garantes = '$_celular_garantes',
				            nombre_garantes_1 = '$_nombre_garantes_1', identificacion_garantes_1 = '$_identificacion_garantes_1',
				            telefono_garantes_1 = '$_telefono_garantes_1', celular_garantes_1 = '$_celular_garantes_1'";
				$tabla = "clientes";
				$where = "id_clientes = '$_id_clientes'";
					
				$resultado=$clientes->UpdateBy($colval, $tabla, $where);
			
			}
			
			else{
					
			
			}
			
				
	
			$this->redirect("EtapasJuicios", "consulta_juicios");
	
				
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos para Actualizar Etapas Juicios"
	
			));
	
		}
	
	}
	
	
	
	public function consulta_juicios(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
		
		$tipo_identificacion = new TipoIdentificacionModel();
		$resultTipoIdent = $tipo_identificacion->getAll("nombre_tipo_identificacion");
			
		$tipo_persona = new TipoPersonaModel();
		$resultTipoPer =$tipo_persona->getAll("nombre_tipo_persona");
			
		$ciudad = new CiudadModel();
		$resultCiu = $ciudad->getBy("nombre_ciudad='QUITO' OR nombre_ciudad='GUAYAQUIL'");
		 
		$estados_pro = new EstadosProcesalesModel();
		$resultEstPro =$estados_pro->getAll("nombre_estados_procesales_juicios");
		
		
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
	
		$juicios = new JuiciosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "EtapasJuicios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
				$resultEdit="";
				
				if (isset ($_GET["id_juicios"])   )
				{
					$_id_juicios = $_GET["id_juicios"];
				
				
					$columnas = "clientes.id_clientes,
							  tipo_identificacion.id_tipo_identificacion,
							  tipo_identificacion.nombre_tipo_identificacion,
							  clientes.identificacion_clientes,
							  clientes.nombres_clientes,
							  clientes.telefono_clientes,
							  clientes.celular_clientes,
							  clientes.direccion_clientes,
							  ciudad.id_ciudad,
							  ciudad.nombre_ciudad,
							  tipo_persona.id_tipo_persona,
							  tipo_persona.nombre_tipo_persona,
							  clientes.nombre_garantes,
							  clientes.identificacion_garantes,
							  clientes.telefono_garantes,
							  clientes.celular_garantes,
							  clientes.nombre_garantes_1,
							  clientes.identificacion_garantes_1,
							  clientes.telefono_garantes_1,
							  clientes.celular_garantes_1,
							  titulo_credito.id_titulo_credito,
							  titulo_credito.numero_titulo_credito,
							  titulo_credito.total_total_titulo_credito,
							  juicios.id_juicios,
							  juicios.juicio_referido_titulo_credito,
							  asignacion_secretarios_view.id_abogado,
							  asignacion_secretarios_view.id_secretario,
							  asignacion_secretarios_view.secretarios,
							  asignacion_secretarios_view.impulsores,
							  etapas_juicios.id_etapas_juicios,
							  etapas_juicios.nombre_etapas,
							  tipo_juicios.id_tipo_juicios,
							  tipo_juicios.nombre_tipo_juicios,
							  estados_auto_pago_juicios.id_estados_auto_pago_juicios,
							  estados_auto_pago_juicios.nombre_estados_auto_pago_juicios,
							  estados_procesales_juicios.id_estados_procesales_juicios,
							  estados_procesales_juicios.nombre_estados_procesales_juicios,
							  juicios.year_juicios,
							  juicios.numero_juicios,
							  juicios.creado";
					
					$tablas="public.clientes,
						  public.ciudad,
						  public.juicios,
						  public.titulo_credito,
						  public.tipo_identificacion,
						  public.tipo_persona,
						  public.etapas_juicios,
						  public.tipo_juicios,
						  public.estados_auto_pago_juicios,
						  public.asignacion_secretarios_view,
						  public.estados_procesales_juicios";
					
					$where="clientes.id_ciudad = ciudad.id_ciudad AND
					clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
					clientes.id_clientes = titulo_credito.id_clientes AND
					juicios.id_titulo_credito = titulo_credito.id_titulo_credito AND
					tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND
					etapas_juicios.id_etapas_juicios = juicios.id_etapas_juicios AND
					tipo_juicios.id_tipo_juicios = juicios.id_tipo_juicios AND
					estados_auto_pago_juicios.id_estados_auto_pago_juicios = juicios.id_estados_auto_pago_juicios AND
					asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND
					estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND juicios.id_juicios ='$_id_juicios'";
					
					$id="juicios.id_juicios";
					
					$resultEdit = $juicios->getCondiciones($columnas ,$tablas ,$where, $id);
				
						
				}
				
					
				if(isset($_POST["buscar"])){
	
					$id_ciudad=$_POST['id_ciudad'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$titulo_credito=$_POST['numero_titulo'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					$citaciones= new CitacionesModel();
	
	
					$columnas = "clientes.id_clientes, 
							  tipo_identificacion.id_tipo_identificacion, 
							  tipo_identificacion.nombre_tipo_identificacion, 
							  clientes.identificacion_clientes, 
							  clientes.nombres_clientes, 
							  clientes.telefono_clientes, 
							  clientes.celular_clientes, 
							  clientes.direccion_clientes, 
							  ciudad.id_ciudad, 
							  ciudad.nombre_ciudad, 
							  tipo_persona.id_tipo_persona, 
							  tipo_persona.nombre_tipo_persona, 
							  clientes.nombre_garantes, 
							  clientes.identificacion_garantes, 
							  clientes.telefono_garantes, 
							  clientes.celular_garantes, 
							  clientes.nombre_garantes_1,
							  clientes.identificacion_garantes_1,
							  clientes.telefono_garantes_1,
							  clientes.celular_garantes_1,
							  titulo_credito.id_titulo_credito, 
							  titulo_credito.numero_titulo_credito, 
							  titulo_credito.total_total_titulo_credito, 
							  juicios.id_juicios, 
							  juicios.juicio_referido_titulo_credito, 
							  asignacion_secretarios_view.id_abogado, 
							  asignacion_secretarios_view.id_secretario, 
							  asignacion_secretarios_view.secretarios, 
							  asignacion_secretarios_view.impulsores, 
							  etapas_juicios.id_etapas_juicios, 
							  etapas_juicios.nombre_etapas, 
							  tipo_juicios.id_tipo_juicios, 
							  tipo_juicios.nombre_tipo_juicios, 
							  estados_auto_pago_juicios.id_estados_auto_pago_juicios, 
							  estados_auto_pago_juicios.nombre_estados_auto_pago_juicios, 
							  estados_procesales_juicios.id_estados_procesales_juicios, 
							  estados_procesales_juicios.nombre_estados_procesales_juicios, 
							  juicios.year_juicios, 
							  juicios.numero_juicios,
							  juicios.creado";
	
					$tablas="public.clientes, 
						  public.ciudad, 
						  public.juicios, 
						  public.titulo_credito, 
						  public.tipo_identificacion, 
						  public.tipo_persona, 
						  public.etapas_juicios, 
						  public.tipo_juicios, 
						  public.estados_auto_pago_juicios, 
						  public.asignacion_secretarios_view, 
						  public.estados_procesales_juicios";
	
					$where="clientes.id_ciudad = ciudad.id_ciudad AND
					  clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
					  clientes.id_clientes = titulo_credito.id_clientes AND
					  juicios.id_titulo_credito = titulo_credito.id_titulo_credito AND
					  tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND
					  etapas_juicios.id_etapas_juicios = juicios.id_etapas_juicios AND
					  tipo_juicios.id_tipo_juicios = juicios.id_tipo_juicios AND
					  estados_auto_pago_juicios.id_estados_auto_pago_juicios = juicios.id_estados_auto_pago_juicios AND
					  asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND
					  estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND juicios.id_usuarios ='$_id_usuarios'";
	
					$id="juicios.id_juicios";
	
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
	
					if($numero_juicio!=""){$where_1=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
	
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
	
					if($titulo_credito!=""){$where_3=" AND titulo_credito.numero_titulo_credito='$titulo_credito'";}
	
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$citaciones->getCondiciones($columnas ,$tablas , $where_to, $id);
	
	
				}
	     
				$this->view("ActualizaEtapasJuicios",array(
						"resultSet"=>$resultSet,"resultDatos"=>$resultDatos, "resultEdit"=>$resultEdit, "resultTipoIdent"=> $resultTipoIdent, "resultTipoPer"=> $resultTipoPer, "resultCiu"=>$resultCiu, "resultEstPro"=>$resultEstPro
							
				));
	
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Actualizar Etapas Juicios"
	
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
	
	
	
	
	public function borrarId()
	{

		session_start();
		
		$permisos_rol=new PermisosRolesModel();
		$nombre_controladores = "EtapasJuicios";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
			if(isset($_GET["id_etapas_juicios"]))
			{
				$id_etapas_juicios=(int)$_GET["id_etapas_juicios"];
				
				$etapas_juicios = new EtapasJuiciosModel(); 
				
				$etapas_juicios->deleteBy(" id_etapas_juicios", $id_etapas_juicios);
				
				$traza=new TrazasModel();
				$_nombre_controlador = "Etapas Juicios";
				$_accion_trazas  = "Borrar";
				$_parametros_trazas = $id_etapas_juicios;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
				
			}
			
			$this->redirect("EtapasJuicios", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Etapas Juicios"
			
			));
		}
				
	}
	
	
	
	
	
	
}
?>