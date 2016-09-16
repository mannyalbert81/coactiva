<?php

class FichaJuicioController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

	public function index(){
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			
			$juicio = new JuiciosModel();
			$ciudad = new CiudadModel();
			
			//usuario
			$_id_usuarios=$_SESSION['id_usuarios'];
			//Notificaciones
			$juicio->MostrarNotificaciones($_SESSION['id_usuarios']); 
			
			$resultSet=array();
			$resultCiudad=array();
			$resultImpul=array();
			
			$colImpulsores = " asignacion_secretarios_view.id_abogado,asignacion_secretarios_view.impulsores";				
			$tblImpulsores = "public.asignacion_secretarios_view";				
			$whereImpulsores = "public.asignacion_secretarios_view.id_secretario = '$_id_usuarios'";				
			$idImpulsores = "asignacion_secretarios_view.id_abogado";
			
			$resultImpul=$juicio->getCondiciones($colImpulsores ,$tblImpulsores ,$whereImpulsores, $idImpulsores);
			
			
			$colCiudad = " usuarios.id_ciudad,ciudad.nombre_ciudad,usuarios.nombre_usuarios";				
			$tblCiudad   = "public.usuarios,public.ciudad";				
			$whereCiudad    = "ciudad.id_ciudad = usuarios.id_ciudad AND usuarios.id_usuarios = '$_id_usuarios'";				
			$idCiudad       = "usuarios.id_ciudad";
			
			$resultCiudad=$ciudad->getCondiciones($colCiudad, $tblCiudad, $whereCiudad, $idCiudad);
			
			$resultEdit = "";
			$resul = "";
			
			
			$permisos_rol = new PermisosRolesModel();
			
			$nombre_controladores = "FichaJuicio";
			$id_rol= $_SESSION['id_rol'];
			
			$resultPer = $permisos_rol->getPermisosVer("  controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
				
					if(isset($_POST["buscar"])){
					
						
						
						$id_ciudad=$_POST['id_ciudad'];
						$id_impulsor=$_POST['id_usuarios'];
						$identificacion_cliente=$_POST['identificacion'];
						$numero_juicio=$_POST['numero_juicio'];
						$fechadesde=$_POST['fecha_desde'];
						$fechahasta=$_POST['fecha_hasta'];
						
						
							
						$columnas = " ciudad.nombre_ciudad,
							clientes.nombres_clientes,
							clientes.identificacion_clientes,
							juicios.observaciones_juicios,
							juicios.estrategia_juicios,
							juicios.juicio_referido_titulo_credito,
							juicios.creado,
							estados_procesales_juicios.nombre_estados_procesales_juicios,
							juicios.id_juicios,
							juicios.fecha_emision_juicios,
							juicios.numero_juicios,
							asignacion_secretarios_view.secretarios,
							asignacion_secretarios_view.liquidador,
							asignacion_secretarios_view.impulsores";
					
						$tablas   = "public.ciudad,
							public.juicios,
							public.clientes,
							public.estados_procesales_juicios,
							public.asignacion_secretarios_view";
					
						$where    = "ciudad.id_ciudad = juicios.id_ciudad AND
							clientes.id_clientes = juicios.id_clientes AND
							estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND
							asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND juicios.revisado_juicios = FALSE";
						
						$id       = "juicios.id_juicios";
							
						$where_0 = "";
						$where_1 = "";
						$where_2 = "";
						$where_3 = "";
						$where_4 = "";
						
						
						if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
						if($id_impulsor!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_impulsor'";}
						
						if($identificacion_cliente!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion_cliente'";}
						
						if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
						if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
						
						
					
						$where_to  = $where .$where_0. $where_1 . $where_2.$where_3.$where_4;
						
						
							
						$resultSet=$juicio->getCondiciones($columnas ,$tablas ,$where_to, $id);
					
							
					}
					
			
					$this->view("FichaJuicio",array(
							
							 "resultEdit"=>$resultEdit, "resultSet"=>$resultSet,"resultCiudad"=>$resultCiudad,"resultImpul"=>$resultImpul
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
	
	public function verFichaGeneral()
	{
		$juicio= new JuiciosModel();
		
		if(isset($_POST["reporte"]))
		{
			
			$id_ciudad=$_POST['id_ciudad'];
			$id_impulsor=$_POST['id_usuarios'];
			$identificacion_cliente=$_POST['identificacion'];
			$numero_juicio=$_POST['numero_juicio'];
			$fechadesde=$_POST['fecha_desde'];
			$fechahasta=$_POST['fecha_hasta'];
		
				
			$columnas = " ciudad.nombre_ciudad,
							clientes.nombres_clientes,
							clientes.identificacion_clientes,
							juicios.observaciones_juicios,
							juicios.estrategia_juicios,
							juicios.juicio_referido_titulo_credito,
							juicios.creado,
							estados_procesales_juicios.nombre_estados_procesales_juicios,
							juicios.id_juicios,
							juicios.fecha_emision_juicios,
							juicios.numero_juicios,
							asignacion_secretarios_view.secretarios,
							asignacion_secretarios_view.liquidador,
							asignacion_secretarios_view.impulsores";
				
			$tablas   = "public.ciudad,
							public.juicios,
							public.clientes,
							public.estados_procesales_juicios,
							public.asignacion_secretarios_view";
				
			$where    = "ciudad.id_ciudad = juicios.id_ciudad AND
							clientes.id_clientes = juicios.id_clientes AND
							estados_procesales_juicios.id_estados_procesales_juicios = juicios.id_estados_procesales_juicios AND
							asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND juicios.revisado_juicios = FALSE";
		
			$id       = "juicios.id_juicios";
				
			$where_0 = "";
			$where_1 = "";
			$where_2 = "";
			$where_3 = "";
			$where_4 = "";
		
		
			if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
		
			if($id_impulsor!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_impulsor'";}
		
			if($identificacion_cliente!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion_cliente'";}
		
			if($numero_juicio!=""){$where_3=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
		
			if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
		
		
				
			$where_to  = $where .$where_0. $where_1 . $where_2.$where_3.$where_4;
		
		
				
			$resultSet=$juicio->getCondiciones($columnas ,$tablas ,$where_to, $id);
				
				
		}
		
	}
	
	public function verFicha()
	{
		
		$usuarios = new UsuariosModel();
		$juicios = new JuiciosModel();
		$ciudad = new CiudadModel();
		
		$identificador="";
		$_estado="Visualizar";
		$dato=array();
		$arrayGet=array();
		$resultCiudad=array();
		
		if (isset($_POST["Visualizar"]))
		{
			 
			//parametros
			$_id_ciudad     			= $_POST["id_ciudad"];
			$_id_juicio      			= $_POST["id_juicios"];
			$_id_secretario_reemplazar  = $_POST["id_secretario_reemplazo"];
			$_id_impulsor_reemplazar  = $_POST["id_impulsor_reemplazo"];
			$_id_secretario     		= $_POST["id_secretario"];
			$_id_abogado      			= $_POST["id_impulsor"];
			$_tipo_avoco     			= $_POST["tipo_avoco"];
			 
		
			//consulta datos de juicio
			$columnas="juicios.juicio_referido_titulo_credito,
			clientes.nombres_clientes,clientes.identificacion_clientes,clientes.nombre_garantes,
					  clientes.identificacion_garantes";
			 
			$tablas="public.juicios,public.clientes";
			 
			$where="clientes.id_clientes = juicios.id_clientes AND  juicios.id_juicios='$_id_juicio'";
			 
			$resultJuicio = $juicios->getCondiciones($columnas, $tablas, $where, "clientes.id_clientes");
			 
			//datos ciudad
			$resultCiudad=$ciudad->getBy("id_ciudad='$_id_ciudad'");
			 
			//datos secretario q se reemplaza
			$resultSecretario=$usuarios->getBy("id_usuarios='$_id_secretario_reemplazar'");
		
			$resultImpulsor=$usuarios->getBy("id_usuarios='$_id_impulsor_reemplazar'");
			 
			//datos Secretario e impulsor
			$resultAbogados=$usuarios->getCondiciones("asignacion_secretarios_view.id_abogado,asignacion_secretarios_view.id_secretario,
                                                      asignacion_secretarios_view.secretarios,asignacion_secretarios_view.impulsores",
					"public.asignacion_secretarios_view",
					"asignacion_secretarios_view.id_abogado = '$_id_abogado' AND asignacion_secretarios_view.id_secretario='$_id_secretario'",
					"asignacion_secretarios_view.secretarios");
			 
			 
			//cargar datos para el reporte
			 
			$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$dato['ciudad']=$resultCiudad[0]->nombre_ciudad;
			$dato['juicio_referido']=$resultJuicio[0]->juicio_referido_titulo_credito;
			$dato['cliente']=$resultJuicio[0]->nombres_clientes;
			$dato['identificacion']=$resultJuicio[0]->identificacion_clientes;
			$dato['secretario_reemplazar']=$resultSecretario[0]->nombre_usuarios;
			$dato['impulsor_reemplazar']=$resultImpulsor[0]->nombre_usuarios;
			$dato['secretario']=$resultAbogados[0]->secretarios;
			$dato['abogado']=$resultAbogados[0]->impulsores;
			$dato['garante']=$resultJuicio[0]->nombre_garantes;
			$dato['identificacion_garante']=$resultJuicio[0]->identificacion_garantes;
			$dato['fecha']=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
			$dato['hora']= date ("h:i:s");
			//$this->view("Error", array("resultado"=>print_r($dato))); exit();
		
		
			$traza=new TrazasModel();
			$_nombre_controlador = "Avoco";
			$_accion_trazas  = "Visualizar";
			$_parametros_trazas = "Cambiar".($resultSecretario[0]->nombre_usuarios)."Por".$resultAbogados[0]->secretarios;
			$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
			 
			 
			//cargar array q va por get
			 
			$arrayGet['id_juicio']=$_id_juicio;
			$arrayGet['juicio']=$resultJuicio[0]->juicio_referido_titulo_credito;
			$arrayGet['id_reemplazo']=$_id_secretario_reemplazar;
			$arrayGet['reemplazo']=$resultSecretario[0]->nombre_usuarios;
			$arrayGet['id_reemplazo1']=$_id_impulsor_reemplazar;
			$arrayGet['reemplazo1']=$resultImpulsor[0]->nombre_usuarios;
			$arrayGet['id_ciudad']=$resultCiudad[0]->id_ciudad;
			$arrayGet['ciudad']=$resultCiudad[0]->nombre_ciudad;
			$arrayGet['id_secretario']=$_id_secretario;
			$arrayGet['secretario']=$resultAbogados[0]->secretarios;
			$arrayGet['id_impulsor']=$_id_abogado;
			$arrayGet['impulsor']=$resultAbogados[0]->impulsores;
			$arrayGet['tipoAvoco']=$_tipo_avoco;
			 
			 
		}
		
		
		$result=urlencode(serialize($dato));
		
		$resultArray=urlencode(serialize($arrayGet));
		
		if($_tipo_avoco == "sin_garante"){
		
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		
		
		
			print "<script language='JavaScript'>
			setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSinGaranteReport.php?estado=$_estado&dato=$result','Popup','height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
			</script>";
		
			print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index&dato=$resultArray');</script>");
		
		
		}
		
	}
	
	public function verFichaby()
	{
		if(isset($_GET['id_juicios']))
		{
			$id_juicios=$_GET['id_juicios'];
			
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			
			print("<script>window.location.replace('http://$host$uri/view/ireports/ContFichaReport.php?id_juicios=$id_juicios');</script>");
			
			
		}
		
	}
	
	
	
}
?>      