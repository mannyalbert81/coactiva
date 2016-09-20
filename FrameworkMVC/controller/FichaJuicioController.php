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
							asignacion_secretarios_view.id_abogado = juicios.id_usuarios AND juicios.revisado_juicios = TRUE";
						
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
		session_start();
		
		$dato = array();
		$id_usuario = $_SESSION['id_usuarios'];
		
		if(isset($_POST["reporte"]))
		{
			
			$id_ciudad=$_POST['id_ciudad'];
			$id_impulsor=$_POST['id_usuarios'];
			$identificacion_cliente=$_POST['identificacion'];
			$numero_juicio=$_POST['numero_juicio'];
			$fechadesde=$_POST['fecha_desde'];
			$fechahasta=$_POST['fecha_hasta'];
			
			$dato['id_ciudad']=$id_ciudad;
			$dato['id_usuario']=$id_usuario;
			$dato['id_impulsor']=$id_impulsor;
			$dato['identificacion']=$identificacion_cliente;
			$dato['numero_juicio']=$numero_juicio;
			$dato['fecha_desde']=$fechadesde;
			$dato['fecha_hasta']=$fechahasta;
			
			$sendDato=urlencode(serialize($dato));
			
			
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			
			print "<script language='JavaScript'>
			setTimeout(window.open('http://$host$uri/view/ireports/ContFichaGeneralReport.php?dato=$sendDato','Popup','height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
			</script>";
			
			print("<script language='JavaScript' >window.location.replace('http://$host$uri/index.php?controller=FichaJuicio&action=index');</script>");
			
			
			//print("<script>window.location.replace('http://$host$uri/view/ireports/ContFichaGeneralReport.php?dato=$sendDato');</script>");
				
		}
		
	}
	
	public function verFicha()
	{
		echo 'funcion sin declarar';
	}
	
	public function verFichaby()
	{
		if(isset($_GET['id_juicios']))
		{
			$id_juicios=$_GET['id_juicios'];
			
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			
			print("<script>window.location.replace('http://$host$uri/view/ireports/ContFichaReport.php?id_juicios=$id_juicios');</script>");
			
			//include_once 'http://$host$uri/view/ireports/ContFichaReport.php?id_juicios=$id_juicios';
			
		}
		
	}
	
	
	
}
?>      