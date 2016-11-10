<?php

class JuicioController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

	public function index(){
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			
			$juicio = new JuiciosModel();
			//Notificaciones
			$juicio->MostrarNotificaciones($_SESSION['id_usuarios']); 
			
			$resultSet=array();
			
			$resultEdit = "";
			$resul = "";
			
			
			$permisos_rol = new PermisosRolesModel();
			
			$nombre_controladores = "Juicio";
			$id_rol= $_SESSION['id_rol'];
			
			$resultPer = $permisos_rol->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
				
					if(isset($_POST["buscar"])){
					
						$criterio_busqueda=$_POST["criterio_busqueda"];
						$contenido_busqueda=$_POST["contenido_busqueda"];
					
						$juicio = new JuiciosModel();
							
							
						$columnas = "   juicios.id_juicios, 
									  entidades.nombre_entidades, 
									  ciudad.nombre_ciudad, 
									  juicios.juicio_referido_titulo_credito, 
									  usuarios.nombre_usuarios, 
									  titulo_credito.id_titulo_credito, 
									  titulo_credito.total, 
									  clientes.nombres_clientes, 
									  etapas_juicios.nombre_etapas, 
									  tipo_juicios.nombre_tipo_juicios, 
									  juicios.descipcion_auto_pago_juicios, 
									  estados_procesales_juicios.nombres_estados_procesales_juicios, 
									  juicios.fecha_emision_juicios, 
									  estados_auto_pago_juicios.nombre_estados_auto_pago_juicios, 
									  juicios.nombre_archivado_juicios";
					
						$tablas   = "public.juicios, 
								  public.entidades, 
								  public.ciudad, 
								  public.usuarios, 
								  public.titulo_credito, 
								  public.clientes, 
								  public.etapas_juicios, 
								  public.tipo_juicios, 
								  public.estados_procesales_juicios, 
								  public.estados_auto_pago_juicios";
					
						$where    = "entidades.id_entidades = juicios.id_entidades AND
								  ciudad.id_ciudad = juicios.id_ciudad AND
								  usuarios.id_usuarios = juicios.id_usuarios AND
								  titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND
								  clientes.id_clientes = juicios.id_clientes AND
								  etapas_juicios.id_etapas_juicios = juicios.id_etapas_juicios AND
								  tipo_juicios.id_tipo_juicios = juicios.id_tipo_juicios AND
								  estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND
								  estados_auto_pago_juicios.id_estados_auto_pago_juicios = juicios.id_estados_auto_pago_juicios";
					
						$id       = "juicios.id_juicios";
					
						$where_1 = "";
						$where_2 = "";
					
						switch ($criterio_busqueda) {
							
							case 0:
								// identificacion de cliente
								$where_1 = " AND  clientes.identificacion_clientes LIKE '$contenido_busqueda'  ";
								break;
							case 1:
								//id_titulo de credito
								$where_2 = " AND  titulo_credito.id_titulo_credito = '$contenido_busqueda'  ";
								break;
							case 2:
									//id_titulo de credito
								$where_2 = " AND  juicios.juicio_referido_titulo_credito LIKE '$contenido_busqueda'  ";
								break;
					
						}
					
					
					
						$where_to  = $where . $where_1 . $where_2;
							
						$resultSet=$juicio->getCondiciones($columnas ,$tablas ,$where_to, $id);
					
							
					}
					
			
					$this->view("Juicio",array(
							
							 "resultEdit"=>$resultEdit, "resultSet"=>$resultSet
					));
			
			
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Seguimiento de Juicios"
			
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
	 
	public function ActualizarAutoPago(){
		session_start();
		
		$resultado = null;
		$permisos_rol = new PermisosRolesModel();
		$aprobacion_auto_pago = new AutoPagosModel();
		$nombre_controladores = "AprobacionAutoPago";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
			if(isset($_GET["id_auto_pagos"])){
				
			
				$estado=new EstadoModel();
				$resultEstado=$estado->getBy("nombre_estado='APROBADO'");
				
				$id_estado=$resultEstado[0]->id_estado;
				$colval="id_estado='$id_estado'";
				$id_auto_pago=$_GET["id_auto_pagos"];
				
				//para obtener id titulo credito
				$id_titulo_credito = $_GET["id_titulo_credito"];
				
				$tabla="auto_pagos";
				
				$where="id_auto_pagos='$id_auto_pago'";
				
				try {
					
					
					$col_ciudad="titulo_credito.id_ciudad";
					$tbl_ciudad="public.titulo_credito,public.ciudad";
					$whre_ciudad="ciudad.id_ciudad = titulo_credito.id_ciudad AND
					titulo_credito.id_titulo_credito='$id_titulo_credito'";
					$resultCiudad=$aprobacion_auto_pago->getCondiciones($col_ciudad, $tbl_ciudad, $whre_ciudad, "titulo_credito.id_ciudad");
					
					$id_ciudad=$resultCiudad[0]->id_ciudad;
					
					//para obtener juicio referido
					$anio=date("Y");
					$col_prefijo=" prefijos.nombre_prefijos,prefijos.consecutivo";
					$tbl_prefijo="public.prefijos";
					$whre_prefijo="prefijos.id_ciudad='$id_ciudad'";
					$resultprefijo=$aprobacion_auto_pago->getCondiciones($col_prefijo, $tbl_prefijo, $whre_prefijo, "prefijos.id_prefijos");
					
					$juicio_referido_titulo_credito=$resultprefijo[0]->nombre_prefijos."-".$resultprefijo[0]->consecutivo."-".$anio;
					
					//para obtener usuario impulsor
					$col_impulsor="titulo_credito.id_usuarios,titulo_credito.id_clientes";
					$tbl_impulsor=" public.titulo_credito";
					$whre_impulsor="titulo_credito.id_titulo_credito='$id_titulo_credito'";
					$resultusuarioImpulsor=$aprobacion_auto_pago->getCondiciones($col_impulsor, $tbl_impulsor, $whre_impulsor, "titulo_credito.id_usuarios");
						
					$id_usuarios=$resultusuarioImpulsor[0]->id_usuarios;
					
					//para obtener cliente ya trae en la consulta de resultusuarioImpulsor
					$id_clientes=$resultusuarioImpulsor[0]->id_clientes;
					
					//para obtener etapas juicios
					$col_etapa_juicio="*";
					$tbl_etapa_juicio="etapas_juicios";
					$whre_etapa_juicio="etapas_juicios.nombre_etapas LIKE '%PRIMERA%'";
					$result_etapas_juicios=$aprobacion_auto_pago->getCondiciones($col_etapa_juicio, $tbl_etapa_juicio, $whre_etapa_juicio, "id_etapas_juicios");
					
					$id_etapas_juicios=$result_etapas_juicios[0]->id_etapas_juicios;
					
					//para obtener tipo_juicios
					$col_tipo_juicio="*";
					$tbl_etapa_juicio="tipo_juicios";
					$whre_etapa_juicio="tipo_juicios.nombre_tipo_juicios LIKE 'NINGUNA'";
					$result_tipo_juicios=$aprobacion_auto_pago->getCondiciones($col_etapa_juicio, $tbl_etapa_juicio, $whre_etapa_juicio, "id_tipo_juicios");
					
					$id_tipo_juicios=$result_tipo_juicios[0]->id_tipo_juicios;
					
					//pra descripcion auto pago juicio
					$descipcion_auto_pago_juicios="Prueba de insercion";
					
					//para estados procesales juicios "Auto de Pago"
					$col_est_procesales="*";
					$tbl_est_procesales="estados_procesales_juicios";
					$whre_est_procesales="nombres_estados_procesales_juicios LIKE 'Auto de Pago'";
					$result_est_procesales=$aprobacion_auto_pago->getCondiciones($col_est_procesales, $tbl_est_procesales, $whre_est_procesales, "id_estados_procesales_juicios");
					
					$id_estados_procesales_juicios=$result_est_procesales[0]->id_estados_procesales_juicios;
					
					//para estados auto pagos juicios
					$col_est_auto_pago_juicios="*";
					$tbl_est_auto_pago_juicios="estados_auto_pago_juicios";
					$whre_est_auto_pago_juicios="nombre_estados_auto_pago_juicios LIKE 'A'";
					$result_auto_pago_juicios=$aprobacion_auto_pago->getCondiciones($col_est_auto_pago_juicios, $tbl_est_auto_pago_juicios, $whre_est_auto_pago_juicios, "id_estados_auto_pago_juicios");
					
					$id_estados_auto_pago_juicios=$result_auto_pago_juicios[0]->id_estados_auto_pago_juicios;
					
					//para archivos
					$prefijo=CLIENTE;
					$nombre_archivado_juicios=$prefijo."-".$juicio_referido_titulo_credito;
					//para entidad
					$id_entidades=10;
					
                     $resultadojuicio=$aprobacion_auto_pago->InsertaJuicio($id_entidades, $id_ciudad, $juicio_referido_titulo_credito, $id_usuarios, $id_titulo_credito, $id_clientes, $id_etapas_juicios, $id_tipo_juicios, $descipcion_auto_pago_juicios, $id_estados_procesales_juicios, $id_estados_auto_pago_juicios, $nombre_archivado_juicios);
					
					
					
				} catch (Exception $e) {
					
					$this->view("Error",array(
							"resultado"=>"Eror al Aprobar Auto pago ->". $id_auto_pago
					));
					
				}
			}
			
			$this->redirect("Juicio", "index");
		
		}
		
	}
	
	public function InsertaJuicio(){

		session_start();
		
	}
	
	public function borrarId()
	{
		$permisos_rol = new PermisosRolesModel();

		session_start();
		
		$nombre_controladores = "AsignacionTituloCredito";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosBorrar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
			if(isset($_GET["id_asignacion_secretarios"]))
			{
				$id_asigancionSecretarios=(int)$_GET["id_asignacion_secretarios"];
		
				$asignacionSecretario=new AsignacionSecretariosModel();
			
				$asignacionSecretario->deleteBy(" id_asignacion_secretarios",$id_asigancionSecretarios);
			
				$traza=new TrazasModel();
				$_nombre_controlador = "AsignacionTituloCredito";
				$_accion_trazas  = "Borrar";
				$_parametros_trazas = $id_asigancionSecretarios;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
			}
			
			
			$this->redirect("AsignacionTituloCredito", "index");
			
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Borrar Asignacion Titulo Credito"
		
			));
		
		
		}
		
	}
	
	
	public function devuelveAcciones()
	{
		$resultAcc = array();
	
		if(isset($_POST["id_controladores"]))
		{
	        $id_controladores=(int)$_POST["id_controladores"];
	        $acciones=new AccionesModel();
	        $resultAcc = $acciones->getBy(" id_controladores = '$id_controladores'  ");
	     }
	
		echo json_encode($resultAcc);
	
	}
	
	
	public function devuelveSubByAcciones()
	{
		$resultAcc = array();
	
		if(isset($_POST["id_acciones"]))
		{
	        $id_acciones=(int)$_POST["id_acciones"];
	        $acciones=new AccionesModel();
	        $resultAcc = $acciones->getBy(" id_acciones = '$id_acciones'  ");
	     }
	
		echo json_encode($resultAcc);
	
	}
	
 public function devuelveAllAcciones()
	{
		$resultAcc = array();
	    $acciones=new AccionesModel();
	    $resultAcc = $acciones->getAll(" id_controladores, nombre_acciones");
	    echo json_encode($resultAcc);
	
	}
	
	public function returnImpulsorbyciudad()
	{
	
		//CONSULTA DE USUARIOS POR SU ROL
		$idciudad=(int)$_POST["ciudad"];
		$usuarios=new UsuariosModel();
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios,ciudad,rol";
		$id="rol.id_rol";
	
		$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
		AND rol.nombre_rol='ABOGADO IMPULSOR' AND ciudad.id_ciudad='$idciudad'";
	
		$resultUsuarioImpulC=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
	
		echo json_encode($resultUsuarioImpulC);
	}
		
		
		
		public function returnAgentesbyciudad()
	{
		
		//CONSULTA DE USUARIOS POR SU ROL
		$idciudad=(int)$_POST["ciudad"];
		$usuarios=new UsuariosModel();
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios,ciudad,rol";
		$id="rol.id_rol";
		
		$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
		AND rol.nombre_rol='AGENTE JUDICIAL' AND ciudad.id_ciudad='$idciudad'";
		
		$resultUsuarioAgenteC=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
	
		echo json_encode($resultUsuarioAgenteC);
	}
	
	
	
	public function returnSecretarios()
	{
	
		
		//CONSULTA DE USUARIOS POR SU ROL
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios inner join rol on(usuarios.id_rol=rol.id_rol)";
		$id="rol.id_rol";
			
		$usuarios=new UsuariosModel();
		
		$where="rol.nombre_rol='SECRETARIO'";
		$resultUsuarioSecretario=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
	
		echo json_encode($resultUsuarioSecretario);
	
	}
	
	public function returnImpulsores()
	{
	
		//CONSULTA DE USUARIOS POR SU ROL
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios inner join rol on(usuarios.id_rol=rol.id_rol)";
		$id="rol.id_rol";
			
		$usuarios=new UsuariosModel();
	
		$where="rol.nombre_rol='ABOGADO IMPULSOR'";
		$resultUsuarioImpulsor=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
	
		echo json_encode($resultUsuarioImpulsor);
	
	}
	
	public function CompruebaImpulsores()
	{
		$resultado=0;
		//consulta para ver si hay impulsores en la tabla asignacio secretario
		$asignacionSecretarios=new AsignacionSecretariosModel();
			
		$_id_impulsor=$_POST['id_abgImpulsor'];
		$col="id_abogado_asignacion_secretarios";
		$tbl="asignacion_secretarios";
		$whre="id_abogado_asignacion_secretarios=".$_id_impulsor;
		$id="id_asignacion_secretarios";
			
		$ressultAsg=$asignacionSecretarios->getCondiciones($col, $tbl, $whre, $id);
		
		if(empty($ressultAsg)){
			
			$this->view("Error",array(
					"resultado"=>"No existen datos"
			
			));
			exit();
		}else{
			$this->view("Error",array(
					"resultado"=>"datos extraidos"
		
			));
			exit();
		}
			
		echo json_encode($ressultAsg);
	
	}
	
	
	
	public function consulta(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
	
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
			$nombre_controladores = "JuicioImpulsor";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_ciudad=$_POST['id_ciudad'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$titulo_credito=$_POST['numero_titulo'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					$citaciones= new CitacionesModel();
	
	
					$columnas = "juicios.id_juicios,
					clientes.id_clientes,
  					clientes.nombres_clientes, 
  					clientes.identificacion_clientes, 
  					ciudad.nombre_ciudad, 
  					tipo_persona.nombre_tipo_persona, 
  					juicios.juicio_referido_titulo_credito, 
  					asignacion_secretarios_view.impulsores,
  					asignacion_secretarios_view.secretarios,
					titulo_credito.numero_titulo_credito, 
  					etapas_juicios.nombre_etapas, 
  					tipo_juicios.nombre_tipo_juicios, 
  					juicios.creado, 
  					titulo_credito.total_total_titulo_credito,
							estados_procesales_juicios.nombre_estados_procesales_juicios";
	
					$tablas="public.clientes, 
					  public.ciudad, 
					  public.tipo_persona, 
					  public.juicios, 
					  public.titulo_credito, 
					  public.etapas_juicios, 
					  public.tipo_juicios,
					  public.asignacion_secretarios_view,
							 public.estados_procesales_juicios";
	
					$where="ciudad.id_ciudad = clientes.id_ciudad AND
					  tipo_persona.id_tipo_persona = clientes.id_tipo_persona AND
					  juicios.id_titulo_credito = titulo_credito.id_titulo_credito AND
					  juicios.id_clientes = clientes.id_clientes AND
					  juicios.id_tipo_juicios = tipo_juicios.id_tipo_juicios AND
					  etapas_juicios.id_etapas_juicios = juicios.id_etapas_juicios AND
					  estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND 
					 juicios.id_usuarios= asignacion_secretarios_view.id_abogado AND juicios.id_usuarios ='$_id_usuarios'";
	
					$id="juicios.id_juicios";
						
						
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
					if($numero_juicio!=""){$where_1=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
						
					if($titulo_credito!=""){$where_3=" AND juicios.id_titulo_credito='$titulo_credito'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$citaciones->getCondiciones($columnas ,$tablas , $where_to, $id);
	        }
	
	            $this->view("ConsultaJuicios",array(
						"resultSet"=>$resultSet,"resultDatos"=>$resultDatos
							
				));
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Juicios"
	
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
	
	public function consulta_secretario(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet="";
		$juicios = new JuiciosModel();
		$usuarios = new UsuariosModel();
	
	
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
		$where    = "public.asignacion_secretarios_view.id_secretario = '$_id_usuarios'";
		$id       = "asignacion_secretarios_view.id_abogado";
		$resultImpul=$juicios->getCondiciones($columnas ,$tablas ,$where, $id);
		
		
		
		$juicios = new JuiciosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "JuicioSecretario";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){
	
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
	
					$citaciones= new CitacionesModel();
	
	
					$columnas = "juicios.id_juicios,
					clientes.id_clientes,
  					clientes.nombres_clientes,
  					clientes.identificacion_clientes,
  					ciudad.nombre_ciudad,
  					tipo_persona.nombre_tipo_persona,
  					juicios.juicio_referido_titulo_credito,
  					asignacion_secretarios_view.impulsores,
  					asignacion_secretarios_view.secretarios,
					titulo_credito.numero_titulo_credito,
  					etapas_juicios.nombre_etapas,
  					tipo_juicios.nombre_tipo_juicios,
  					juicios.creado,
  					titulo_credito.total_total_titulo_credito,
							estados_procesales_juicios.nombre_estados_procesales_juicios";
	
					$tablas="public.clientes,
					  public.ciudad,
					  public.tipo_persona,
					  public.juicios,
					  public.titulo_credito,
					  public.etapas_juicios,
					  public.tipo_juicios,
					  public.asignacion_secretarios_view,
							public.estados_procesales_juicios";
	
					$where="ciudad.id_ciudad = clientes.id_ciudad AND
					tipo_persona.id_tipo_persona = clientes.id_tipo_persona AND
					juicios.id_titulo_credito = titulo_credito.id_titulo_credito AND
					juicios.id_clientes = clientes.id_clientes AND
					juicios.id_tipo_juicios = tipo_juicios.id_tipo_juicios AND
					etapas_juicios.id_etapas_juicios = juicios.id_etapas_juicios AND
					estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND 
					juicios.id_usuarios= asignacion_secretarios_view.id_abogado AND asignacion_secretarios_view.id_secretario='$_id_usuarios'";
	
					$id="juicios.id_juicios";
	
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
	
	 
				   if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
					if($id_usuarios!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_usuarios'";}
	
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
	
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
	
	
					$resultSet=$citaciones->getCondiciones($columnas ,$tablas , $where_to, $id);
				}
	
				$this->view("ConsultaJuiciosSecretarios",array(
						"resultSet"=>$resultSet,"resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul
							
				));
	          }
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Juicios Secretarios"
	
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
	
	public function consulta_seguimiento_juicio(){
	
		session_start();
	
		//Creamos objetos para otra pagina
		$resultSet="";
		$resultRol= array();
		$resultImpulsor= array();
		
		$result_etapa_juicio=array();
	
		$_id_usuarios= $_SESSION["id_usuarios"];
	    
	    
	    $estados_procesales = new EstadosProcesalesModel();
	    $result_etapa_juicio=$estados_procesales->getAll("id_estados_procesales_juicios");
	
		$juicios = new JuiciosModel();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "JuicioMixto";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $juicios->getPermisosVer(" controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				$rol = new RolesModel();
				$resultRol=$rol->getBy("id_rol='$id_rol'");
				
				$resultImpulsor = $rol->getCondiciones("id_abogado,impulsores",
													"asignacion_secretarios_usuarios_view",
													"id_secretario='$_id_usuarios'",
													"impulsores");
				
				if(isset($_POST["buscar"]))
				{
				
				}
	
				$this->view("Juicio",array(
						"result_etapa_juicio"=>$result_etapa_juicio,"resultSet"=>$resultSet, "resultEdit"=>"","resultRol"=>$resultRol,
						"resultImpulsor"=>$resultImpulsor
							
				));
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Seguimiento Juicios"
	
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
	
	
	public function paginate($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_juicios(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_juicios(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_juicios(1)'>1</a></li>";
		}
		// interval
		if($page>($adjacents+2)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// pages
	
		$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
		$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
		for($i=$pmin; $i<=$pmax; $i++) {
			if($i==$page) {
				$out.= "<li class='active'><a>$i</a></li>";
			}else if($i==1) {
				$out.= "<li><a href='javascript:void(0);' onclick='load_juicios(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_juicios(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_juicios($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_juicios(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	public function cargaDatos()
	{
		session_start();
		
		$rol = new RolesModel();
		$juicios  = new JuiciosModel();
		
		$id_rol = $_SESSION['id_rol'];
		$id_usuarios = $_SESSION['id_usuarios'];
		
		$resultRol=$rol->getBy("id_rol='$id_rol'");
		$nombre_rol='';
		if(!empty($resultRol))
		{
			$nombre_rol=$resultRol[0]->nombre_rol;
		}else {die('session caducada');}
		
	
		$id_estado_procesal = (isset($_POST['id_estado_procesal']))?$_POST['id_estado_procesal']:'';		
		$identificacion   = (isset($_POST['identificacion']))?$_POST['identificacion']:'';
		$id_impulsor      = (isset($_POST['id_impulsor']))?$_POST['id_impulsor']:'';
		$numero_juicio    = (isset($_POST['numero_juicio']))?$_POST['numero_juicio']:'';
		$fechadesde       = (isset($_POST['fecha_desde']))?$_POST['fecha_desde']:'';
		$fechahasta       = (isset($_POST['fecha_hasta']))?$_POST['fecha_hasta']:'';
	
	
		$columnas="juicios.id_juicios,
				    ciudad.nombre_ciudad,
					juicios.juicio_referido_titulo_credito,
					titulo_credito.numero_titulo_credito,
					titulo_credito.fecha_ultimo_abono_titulo_credito,
					titulo_credito.total_total_titulo_credito,
					juicios.observaciones_juicios,
					estados_procesales_juicios.nombre_estados_procesales_juicios,
					juicios.estrategia_juicios,
					asignacion_secretarios_view.impulsores,
					clientes.identificacion_clientes,
                    clientes.nombres_clientes";
	
		$from="		public.titulo_credito,
					public.juicios,
					public.estados_procesales_juicios,
					public.ciudad,
					public.clientes,
					public.asignacion_secretarios_view";
	
		$where="	titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND
					estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND
					ciudad.id_ciudad = juicios.id_ciudad AND
					clientes.id_clientes = juicios.id_clientes AND
					asignacion_secretarios_view.id_abogado = juicios.id_usuarios";
			
		$id="juicios.id_juicios";
			
		$where_1="";
		$where_2="";
		$where_3="";
		$where_4="";
		$where_5="";
		$where_6="";
					
		$where_1=($id_estado_procesal!=0)?" AND estados_procesales_juicios.id_estados_procesales_juicios='$id_estado_procesal'":'';
		$where_2=($identificacion!="")?" AND clientes.identificacion_clientes='$identificacion'":'';
		$where_3=($numero_juicio!=0)?" AND juicios.juicio_referido_titulo_credito='$numero_juicio'":'';
		if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
		
		if($nombre_rol=='ABOGADO IMPULSOR'){ $where_5=" AND juicios.id_usuarios='$id_usuarios'"; 
		}else if ($nombre_rol=='SECRETARIO'){$where_5=" AND asignacion_secretarios_view.id_secretario='$id_usuarios'";}
		
		if($id_impulsor!=''&&$id_impulsor!=0){ $where_6=" AND juicios.id_usuarios='$id_impulsor'";}
		
		$where_to=$where.$where_1.$where_2.$where_3.$where_4.$where_5.$where_6;
		
		
		$resultJuicio=$juicios->getCantidad("*", $from, $where_to);
	
		$html="";
	
		$cantidadResult=(int)$resultJuicio[0]->total;
	
	
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
		if($action == 'ajax')
		{
				
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
				
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
				
				
			$resultJuicio=$juicios->getCondicionesPag($columnas, $from, $where_to, $id, $limit);
				
			$count_query   = $cantidadResult;
				
			$total_pages = ceil($cantidadResult/$per_page);
				
			if ($cantidadResult>0)
			{
	
				//<th style="color:#456789;font-size:80%;"></th>
					
				$html.='<div class="pull-left">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div><br>';
				$html.='<section style="height:425px; overflow-y:scroll;">';
				$html.='<table class="table table-hover">';
				$html.='<thead>';
				$html.='<tr class="info">';
				$html.='<th><b>Id</b></th>';
				$html.='<th>Estado Procesal</th>';
				$html.='<th>Nº Juicio Referido</th>';
				$html.='<th>Abogado</th>';
				$html.='<th>Identificacion</th>';
				$html.='<th>Cliente</th>';
				$html.='<th>Juzgado</th>';
				$html.='<th>N° Titulo Credito</th>';
				$html.='<th>Cuantia</th>';
				$html.='<th>Ultimo Pago</th>';
				$html.='<th>Observación</th>';
				$html.='<th>Estrategia</th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
	
				foreach ($resultJuicio as $res)
				{
					//<td style="color:#000000;font-size:80%;"> <?php echo ;</td>
						
					$html.='<tr>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->id_juicios.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->nombre_estados_procesales_juicios.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->juicio_referido_titulo_credito.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->impulsores.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->identificacion_clientes.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->nombres_clientes.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->nombre_ciudad.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->numero_titulo_credito.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->total_total_titulo_credito.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->fecha_ultimo_abono_titulo_credito.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->observaciones_juicios.'</td>';
					$html.='<td style="color:#000000;font-size:80%;">'.$res->estrategia_juicios.'</td>';
					$html.='</tr>';
						
				}
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
				$html.='</section>';
	
					
			}else{
					
				$html.='<div class="alert alert-warning alert-dismissable">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> No hay datos para mostrar';
				$html.='</div>';
					
			}
				
			echo $html;
		}
	}
	
	public function reporte()
	{
	
	}
	
	public function GraficoEstadistico()
	{
		session_start();
		//id="+"&date="+"text
		
		if(isset($_GET['id'])&&isset($_GET['date'])&&isset($_GET['text']))
		{
			
			$id = explode(",",$_GET['id']);
			$fecha = explode("+",trim($_GET['date'],''));
			$texto = explode("+",trim($_GET['text'],''));
			
			$id_estados_procesales = $id[0];
			$id_impulsor = $id[1];
			
			$fecha_desde=trim($fecha[0],'');
			$fecha_hasta='';
			if(!empty($fecha[1])){$fecha_hasta=trim($fecha[1],'');}
			
			$juicio_referido = trim($texto[0],'');
			$identificacion = '';
			if(!empty($fecha[1])){$identificacion=trim($texto[1],'');}
			
			$rol = new RolesModel();
			
			$id_rol = $_SESSION['id_rol'];
			$id_usuarios = $_SESSION['id_usuarios'];
			
			$resultRol=$rol->getBy("id_rol='$id_rol'");
			$nombre_rol='';
			if(!empty($resultRol))
			{
				$nombre_rol=$resultRol[0]->nombre_rol;
			}else {die('session caducada');}
			
			//consulta
						
			
			$columnas="estados_procesales_juicios.nombre_estados_procesales_juicios,
				count(*) as	juicios, 
				sum(titulo_credito.total_total_titulo_credito) as valor_juicios";
			
			$tablas="public.juicios,
				public.estados_procesales_juicios,
				public.titulo_credito,
				public.asignacion_secretarios";
			$where="estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios 
					AND juicios.id_titulo_credito = titulo_credito.id_titulo_credito 
					AND asignacion_secretarios.id_abogado_asignacion_secretarios = juicios.id_usuarios";
			
			$grupo="estados_procesales_juicios.nombre_estados_procesales_juicios";
			
			$where_1="";
			$where_2="";
			$where_3="";
			$where_4="";
			$where_5="";
			$where_6="";
				
			//$where_1=($id_estado_procesal!=0)?" AND estados_procesales_juicios.id_estados_procesales_juicios='$id_estado_procesal'":'';
			//$where_2=($identificacion!="")?" AND clientes.identificacion_clientes='$identificacion'":'';
			//$where_3=($numero_juicio!=0)?" AND juicios.juicio_referido_titulo_credito='$numero_juicio'":'';
			//if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
			
			if($nombre_rol=='ABOGADO IMPULSOR'){ $where_5=" AND juicios.id_usuarios='$id_usuarios'";
			}else if ($nombre_rol=='SECRETARIO'){$where_5=" AND asignacion_secretarios.id_secretario_asignacion_secretarios='$id_usuarios'";}
			
			if($id_impulsor!=''&&$id_impulsor!=0){ $where_6=" AND juicios.id_usuarios='$id_impulsor'";}
			
			$where_to=$where.$where_1.$where_2.$where_3.$where_4.$where_5.$where_6;
			
			$juicios = new JuiciosModel();	
			
			//$consulta = "SELECT ".$columnas." FROM ".$tablas." WHERE ".$where_to." GROUP BY ".$grupo;
			//echo $consulta;
			//die();
			
			$resultSet = $juicios->getCondicionesGroup($columnas, $tablas, $where_to, $grupo);
						
			
			
			$this->view("Grafico", array("resultSet"=>$resultSet));
			
			die();
		}
		
		$this->view("Error", array("resultado"=>"No hay datos para generar Grafico"));
		
	}
	
	public function datos_grafico()
	{
		session_start();
		$respuesta = array();
		
		if(isset($_POST['id'])&&isset($_POST['date'])&&isset($_POST['text']))
		{
							
			$id = explode(",",$_POST['id']);
			$fecha = explode("+",trim($_POST['date'],''));
			$texto = explode("+",trim($_POST['text'],''));
				
			$id_estados_procesales = $id[0];
			$id_impulsor = $id[1];
				
			$fecha_desde=trim($fecha[0],'');
			$fecha_hasta='';
			if(!empty($fecha[1])){$fecha_hasta=trim($fecha[1],'');}
				
			$juicio_referido = trim($texto[0],'');
			$identificacion = '';
			if(!empty($fecha[1])){$identificacion=trim($texto[1],'');}
				
			$rol = new RolesModel();
				
			$id_rol = $_SESSION['id_rol'];
			$id_usuarios = $_SESSION['id_usuarios'];
				
			$resultRol=$rol->getBy("id_rol='$id_rol'");
			$nombre_rol='';
			if(!empty($resultRol))
			{
				$nombre_rol=$resultRol[0]->nombre_rol;
			}else {die('session caducada');}
				
			//consulta
	
				
			$columnas="estados_procesales_juicios.nombre_estados_procesales_juicios,
				count(*) as	juicios,
				sum(titulo_credito.total_total_titulo_credito) as valor_juicios";
				
			$tablas="public.juicios,
				public.estados_procesales_juicios,
				public.titulo_credito,
				public.asignacion_secretarios";
			$where="estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios
					AND juicios.id_titulo_credito = titulo_credito.id_titulo_credito
					AND asignacion_secretarios.id_abogado_asignacion_secretarios = juicios.id_usuarios";
				
			$grupo="estados_procesales_juicios.nombre_estados_procesales_juicios";
				
			$where_1="";
			$where_2="";
			$where_3="";
			$where_4="";
			$where_5="";
			$where_6="";
	
			//$where_1=($id_estado_procesal!=0)?" AND estados_procesales_juicios.id_estados_procesales_juicios='$id_estado_procesal'":'';
			//$where_2=($identificacion!="")?" AND clientes.identificacion_clientes='$identificacion'":'';
			//$where_3=($numero_juicio!=0)?" AND juicios.juicio_referido_titulo_credito='$numero_juicio'":'';
			//if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
				
			if($nombre_rol=='ABOGADO IMPULSOR'){ $where_5=" AND juicios.id_usuarios='$id_usuarios'";
			}else if ($nombre_rol=='SECRETARIO'){$where_5=" AND asignacion_secretarios.id_secretario_asignacion_secretarios='$id_usuarios'";}
				
			if($id_impulsor!=''&&$id_impulsor!=0){ $where_6=" AND juicios.id_usuarios='$id_impulsor'";}
				
			$where_to=$where.$where_1.$where_2.$where_3.$where_4.$where_5.$where_6;
				
			$juicios = new JuiciosModel();
				
			//$consulta = "SELECT ".$columnas." FROM ".$tablas." WHERE ".$where_to." GROUP BY ".$grupo;
			//echo $consulta;
			//die();
				
			$resultSet = $juicios->getCondicionesGroup($columnas, $tablas, $where_to, $grupo);
	
			$respuesta=$resultSet;
			
			echo json_encode($respuesta);
			die();
		}
		echo json_encode($respuesta);	
		die();
	
	}
	
	public function secretario_Consulta(){
	
		session_start();
	
		//Creamos el objeto usuario
		$resultSet=array();
		$juicios = new JuiciosModel();
		$usuarios = new UsuariosModel();
	
	
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
		$where    = "public.asignacion_secretarios_view.id_secretario = '$_id_usuarios'";
		$id       = "asignacion_secretarios_view.id_abogado";
		$resultImpul=$juicios->getCondiciones($columnas ,$tablas ,$where, $id);
		
		
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "JuicioSecretario";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				//comienza consulta
				
				//crear consulta general
				
				$columnas="juicios.id_juicios,
					clientes.id_clientes,
  					clientes.nombres_clientes,
  					clientes.identificacion_clientes,
  					ciudad.nombre_ciudad,
  					tipo_persona.nombre_tipo_persona,
  					juicios.juicio_referido_titulo_credito,
  					asignacion_secretarios_view.impulsores,
  					asignacion_secretarios_view.secretarios,
					titulo_credito.numero_titulo_credito,
  					etapas_juicios.nombre_etapas,
  					tipo_juicios.nombre_tipo_juicios,
  					juicios.creado,
  					titulo_credito.total_total_titulo_credito,
					estados_procesales_juicios.nombre_estados_procesales_juicios";
				
				$tablas="public.clientes,
					  public.ciudad,
					  public.tipo_persona,
					  public.juicios,
					  public.titulo_credito,
					  public.etapas_juicios,
					  public.tipo_juicios,
					  public.asignacion_secretarios_view,
					  public.estados_procesales_juicios";
				
				$where="ciudad.id_ciudad = clientes.id_ciudad AND
					tipo_persona.id_tipo_persona = clientes.id_tipo_persona AND
					juicios.id_titulo_credito = titulo_credito.id_titulo_credito AND
					juicios.id_clientes = clientes.id_clientes AND
					juicios.id_tipo_juicios = tipo_juicios.id_tipo_juicios AND
					etapas_juicios.id_etapas_juicios = juicios.id_etapas_juicios AND
					estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND 
					juicios.id_usuarios= asignacion_secretarios_view.id_abogado AND asignacion_secretarios_view.id_secretario='$_id_usuarios'";
				
				$id="juicios.id_juicios";
				
				$where_to="";
				
				//variables de paginacion
				
			    $registrosTotales = 0;
			    $juiciosTotales = 0;
				$hojasTotales = 0;
				$arraySel = "";
				$registrosPorPagina = 50;
				$paginaActual=1;
				$ultima_pagina=1;
				$paginasTotales=0;
				
				
				if(isset($_POST["buscar"]))
				{
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
										
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
					
					
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
					
					if($id_usuarios!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_usuarios'";}
					
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
					
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
					
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
					
					
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;					
					
					//$resultSet=$juicios->getCondiciones($columnas ,$tablas , $where_to, $id);
					
					$resultcantidad = $juicios->getCantidad("*", $tablas, $where_to);
					
					$registrosTotales = $resultcantidad[0]->total;
					$juiciosTotales = $resultcantidad[0]->total;
					$paginaActual=1;
					
					$paginasTotales = ceil($juiciosTotales / $registrosPorPagina);
					
					
					// el número de la página actual no puede ser menor a 0
					if($paginaActual < 1){
						$paginaActual = 1;
					}
					else if($paginaActual > $paginasTotales){ // tampoco mayor la cantidad de páginas totales
						$paginaActual = $paginasTotales;
					}
					
					// obtenemos cuál es el artículo inicial para la consulta
					$RegistroInicial = ($paginaActual - 1) * $registrosPorPagina;
					
					//agregamos el limit
					$limit = " LIMIT   '$registrosPorPagina' OFFSET '$RegistroInicial'";
					
					//volvemos a pedir el resultset con la pginacion
					
					$resultSet=$juicios->getCondicionesPag($columnas ,$tablas ,$where_to,  $id, $limit );
				
				}
				
				if(isset($_POST['pagina']))
				{
					
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_juicio'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
					
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
						
						
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
					if($id_usuarios!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_usuarios'";}
						
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
						
					if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
						
						
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
						
					//$resultSet=$juicios->getCondiciones($columnas ,$tablas , $where_to, $id);
						
					$resultcantidad = $juicios->getCantidad("*", $tablas, $where_to);
						
					$registrosTotales = $resultcantidad[0]->total;
					$juiciosTotales = $resultcantidad[0]->total;
					
					$paginaActual  = $_POST['pagina'];
					$ultima_pagina = $_POST['pagina'];
						
					$paginasTotales = ceil($juiciosTotales / $registrosPorPagina);
						
						
					// el número de la página actual no puede ser menor a 0
					if($paginaActual < 1){
						$paginaActual = 1;
					}
					else if($paginaActual > $paginasTotales){ // tampoco mayor la cantidad de páginas totales
						$paginaActual = $paginasTotales;
					}
						
					// obtenemos cuál es el artículo inicial para la consulta
					$RegistroInicial = ($paginaActual - 1) * $registrosPorPagina;
						
					//agregamos el limit
					$limit = " LIMIT   '$registrosPorPagina' OFFSET '$RegistroInicial'";
						
					//volvemos a pedir el resultset con la pginacion
						
					$resultSet=$juicios->getCondicionesPag($columnas ,$tablas ,$where_to,  $id, $limit );
					
				}
				
				/*	
				if(isset($_POST["id_bodegas"])){
	
	
					$id_bodegas=$_POST['id_bodegas'];
					$id_tipo_contenido_cartones=$_POST['id_tipo_contenido_cartones'];
					$numero_cartones=$_POST['numero_cartones'];
					$seccion_cartones=$_POST['seccion_cartones'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
						
					$inventario_cartones = new CartonesModel();
	
						
					$columnas = "cartones.id_cartones,
							      cartones.numero_cartones,
								  cartones.serie_cartones,
								  cartones.contenido_cartones,
								  cartones.year_cartones,
								  cartones.cantidad_documentos_libros_cartones,
								  tipo_contenido_cartones.nombre_tipo_contenido_cartones,
								  cartones.digitalizado_cartones,
								  entidades.nombre_entidades,
								  bodegas.nombre_bodegas,
								  tipo_operaciones.nombre_tipo_operaciones,
								  cartones.creado,
							      cartones.seccion_cartones";
	
	
	
					$tablas="public.cartones,
							  public.tipo_operaciones,
							  public.bodegas,
							  public.entidades,
							  public.tipo_contenido_cartones";
	
					$where="tipo_operaciones.id_tipo_operaciones = cartones.id_tipo_operaciones AND
							  bodegas.id_bodegas = cartones.id_bodegas AND
							  entidades.id_entidades = cartones.id_entidades AND
							  tipo_contenido_cartones.id_tipo_contenido_cartones = cartones.id_tipo_contenido_cartones AND (tipo_operaciones.nombre_tipo_operaciones ='SOLICITUD' OR tipo_operaciones.nombre_tipo_operaciones ='ENTRADAS')";
	
					$id="cartones.id_cartones";
	
	
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
						
	
	
					if($id_bodegas!=0){$where_0=" AND bodegas.id_bodegas='$id_bodegas'";}
	
					if($id_tipo_contenido_cartones!=0){$where_1=" AND tipo_contenido_cartones.id_tipo_contenido_cartones='$id_tipo_contenido_cartones'";}
	
					if($numero_cartones!=""){$where_2=" AND cartones.numero_cartones='$numero_cartones'";}
						
					if($seccion_cartones!=""){$where_3=" AND cartones.seccion_cartones ='$seccion_cartones'";}
	
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  cartones.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
	
	
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3. $where_4;
	
	
					$resultSet=$inventario_cartones->getCondiciones($columnas ,$tablas , $where_to, $id);
	
	
					foreach($resultSet as $res)
					{
						$registrosTotales = $registrosTotales + 1 ;
					}
	
	
				}
				else{
						
						
					$registrosTotales = 0;
					$hojasTotales = 0;
	
	
					$arraySel = "";
					$resultSet = "";
						
				}
				///aqui va la paginacion  ///
				$articulosTotales = 0;
				$paginasTotales = 0;
				$paginaActual = 0;
				$ultima_pagina = 1;
					
				if(isset($_POST["pagina"])){
	
					// en caso que haya datos, los casteamos a int
					$paginaActual = (int)$_POST["pagina"];
					$ultima_pagina = (int)$_POST["ultima_pagina"] - 5;
				}
	
				if(isset($_POST["siguiente_pagina"])){
	
					// en caso que haya datos, los casteamos a int
					$ultima_pagina = (int)$_POST["ultima_pagina"];
				}
	
					
				if(isset($_POST["anterior_pagina"])){
	
	
					$ultima_pagina = (int)$_POST["ultima_pagina"] - 10;
	
	
				}
	
	
				if ($resultSet != "")
				{
	
					foreach($resultSet as $res)
					{
						$articulosTotales = $articulosTotales + 1;
					}
	
	
					$articulosPorPagina = 50;
	
					$paginasTotales = ceil($articulosTotales / $articulosPorPagina);
	
	
					// el número de la página actual no puede ser menor a 0
					if($paginaActual < 1){
						$paginaActual = 1;
					}
					else if($paginaActual > $paginasTotales){ // tampoco mayor la cantidad de páginas totales
						$paginaActual = $paginasTotales;
					}
	
					// obtenemos cuál es el artículo inicial para la consulta
					$articuloInicial = ($paginaActual - 1) * $articulosPorPagina;
	
					//agregamos el limit
					$limit = " LIMIT   '$articulosPorPagina' OFFSET '$articuloInicial'";
	
					//volvemos a pedir el resultset con la pginacion
	
					$resultSet=$inventario_cartones->getCondicionesPag($columnas ,$tablas ,$where_to,  $id, $limit );
	
	
	
				}*/
				echo $paginaActual;
				//die();
				
				$this->view("ConsultaJuiciosSecretarios",array(
						"resultSet"=>$resultSet,"resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul,"arraySel"=>$arraySel,
						"paginasTotales"=>$paginasTotales,"registrosTotales"=> $registrosTotales,"pagina_actual"=>$paginaActual,
						"ultima_pagina"=>$ultima_pagina
							
				));
	
				//otra vista bodega
				/*	
				$this->view("ConsultaInventarioCartones",array(
						"resultSet"=>$resultSet, "resultTipoCont"=> $resultTipoCont,
						"resultBod"=>$resultBod, "resultSecc"=>$resultSecc,
						"arraySel"=>$arraySel, "paginasTotales"=>$paginasTotales,
						"registrosTotales"=> $registrosTotales,"pagina_actual"=>$paginaActual, "ultima_pagina"=>$ultima_pagina
							
							
				));
				*/
	
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Inventario Cartones"
	
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
	
		
}
?>      