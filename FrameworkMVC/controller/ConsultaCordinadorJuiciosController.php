<?php
class ConsultaCordinadorJuiciosController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	public function index(){

		session_start();
		
		
		$juicios = new JuiciosModel();
		
            if (isset(  $_SESSION['usuario_usuarios']) )
		    {
			//notificaciones
			$juicios->MostrarNotificaciones($_SESSION['id_usuarios']);
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaCordinador";
			$id_rol= $_SESSION['id_rol'];
			
			//variables de envio
			$resultJuicio=array();
			$where_sql=array();
			
			$estados_procesales = new EstadosProcesalesModel();
			$result_etapa_juicio=$estados_procesales->getAll("id_estados_procesales_juicios");
			
			$ciudad = new CiudadModel();
			$resultCiu = $ciudad->getBy("nombre_ciudad='QUITO' OR nombre_ciudad='GUAYAQUIL' ");
			
			$resultPer = $juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );

			if (!empty($resultPer))
			{
					
				if(isset($_POST["buscar"])){

					$id_etapa_juicio=(isset($_POST['id_etapa_juicio']))?$_POST['id_etapa_juicio']:'';
					$id_ciudad        = (isset($_POST['id_ciudad']))?$_POST['id_ciudad']:0;
					$id_secretario    = (isset($_POST['id_secretario']))?$_POST['id_secretario']:0;
					$id_impulsor      = (isset($_POST['id_impulsor']))?$_POST['id_impulsor']:0;
					$identificacion   = (isset($_POST['identificacion']))?$_POST['identificacion']:'';
					$numero_juicio    = (isset($_POST['numero_juicio']))?$_POST['numero_juicio']:'';
					$estado_documento = (isset($_POST['estado_documento']))?$_POST['estado_documento']:0;
					$fechadesde       = (isset($_POST['fecha_desde']))?$_POST['fecha_desde']:'';
					$fechahasta       = (isset($_POST['fecha_hasta']))?$_POST['fecha_hasta']:'';
					
					$columnas="
					juicios.id_juicios,
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
					$from="
					public.titulo_credito,
					public.juicios,
					public.estados_procesales_juicios,
					public.ciudad,
					public.clientes,
					public.asignacion_secretarios_view";
					$where="
					titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND
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
					$where_7="";
					
					$where_1=($id_etapa_juicio!=0)?" AND estados_procesales_juicios.id_estados_procesales_juicios='$id_etapa_juicio'":'';
					$where_2=($id_secretario!=0)?" AND asignacion_secretarios_view.id_secretario='$id_secretario'":'';
					$where_3=($id_impulsor!=0)?" AND asignacion_secretarios_view.id_abogado='$id_impulsor'":'';
					$where_4=($id_ciudad!=0)?" AND ciudad.id_ciudad='$id_ciudad'":'';
					$where_5=($identificacion!="")?" AND clientes.identificacion_clientes='$identificacion'":'';
					$where_6=($numero_juicio!=0)?" AND juicios.juicio_referido_titulo_credito='$numero_juicio'":'';
					
					if($fechadesde!="" && $fechahasta!=""){$where_7=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
					
					
					$where_to=$where.$where_1.$where_2.$where_3.$where_4.$where_5.$where_6.$where_7;
					
					$resultJuicio=$juicios->getCondiciones($columnas, $from, $where_to, $id);
					
					$where_sql=array()
					
				}
				
				

				$this->view("ConsultaCordinadorJuicios",array(
						"resultCiu"=>$resultCiu,"result_etapa_juicio"=>$result_etapa_juicio,"resultJuicio"=>$resultJuicio
							
				));

			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Consulta Cordinador"

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

	  
	
	public function Secrtetarios()
	{
	
		//CONSULTA DE USUARIOS POR SU ROL
		$idciudad=(int)$_POST["ciudad"];
		$usuarios=new UsuariosModel();
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios,ciudad,rol";
		$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
		AND rol.nombre_rol='SECRETARIO' AND ciudad.id_ciudad='$idciudad'";
		$id="usuarios.nombre_usuarios";
		
		$resultSecretario=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
		
		echo json_encode($resultSecretario);
	}
	
	public function Impulsor()
	{
		if(isset($_POST["id_ciudad"]))
		{
			//CONSULTA DE USUARIOS POR SU ROL
			$id_ciudad=(int)$_POST["id_ciudad"];
			$usuarios=new UsuariosModel();
			$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
			$tablas="usuarios,ciudad,rol";
			$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
			AND rol.nombre_rol='ABOGADO IMPULSOR' AND ciudad.id_ciudad='$id_ciudad'";
			$id="usuarios.nombre_usuarios";
			
			$resultado=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
			
			echo json_encode($resultado);
			
		}else if(isset($_POST["usuarios"]))
		{
			//CONSULTA DE USUARIOS POR SU ROL
			$idusuarios=(int)$_POST["usuarios"];
			$usuarios=new UsuariosModel();
			$columnas = "asignacion_secretarios_view.id_abogado,
					  asignacion_secretarios_view.impulsores";
			$tablas="public.asignacion_secretarios_view";
			$id="asignacion_secretarios_view.id_abogado";
			
			$where="public.asignacion_secretarios_view.id_secretario = '$idusuarios'";
			
			$resultImpulsor=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
			
			echo json_encode($resultImpulsor);
		}
		
	}
	
	public function pruebamerge()
	{
		
		$array1 = array("fila1"=>1,"fila2"=>2);
		$array2 = array("fila1"=>3,"fila2"=>4);
		//muestro los arrays
		var_export ($array1);
		echo '<br><br><br>';
		var_export ($array2);
		echo '<br><br><br>';
		//uno los arrays y muestro el array resultante
		$array_resultante= array_merge($array1,$array2);
		$array_prueba=$array1+$array2;
		var_export ($array_resultante);
		echo '<br><br><br>';
		var_export($array_prueba);
		
		echo '<br><br><br>';
		$array1 = array("id1" => "value1");
		
		$array2 = array("id2" => "value2", "id3" => "value3", "id4" => "value4");
		
		$array3 = array_merge($array1, $array2/*, $arrayN, $arrayN*/);
		$array4 = $array1 + $array2;
		
		echo '<pre>';
		var_dump($array3);
		var_dump($array4);
		echo '</pre>';
		
	}
	
	public function Reporte()
	{
		session_start ();
		$sql = array ();
		$sql = $_SESSION ['data_ireport'];
		
		switch ($sql['documento'])
		{
			case 'avoco':
				$this->ireport_vizualizar ( "CordinadorAvoco", array (
				"sql" => $sql ) );
			break;
			case 'auto_pago':
				$this->ireport_vizualizar ( "CordinadorAuto_Pago", array (
				"sql" => $sql ) );
			break;
			case 'citaciones':
				$this->ireport_vizualizar ( "CordinadorCitaciones", array (
				"sql" => $sql ) );
			break;
			case 'providencias':
				$this->ireport_vizualizar ( "CordinadorProvidencias", array (
				"sql" => $sql ) );
			break;
			case 'oficios':
				$this->ireport_vizualizar ( "CordinadorOficios", array (
				"sql" => $sql ) );
			break;
			default:
				echo'error en la consulta';
				unset($_SESSION ['data_ireport']);
				die();
			break;
		}
		
		
		
		// header("Location:view/ireports/ContCordinadorDocumentosReport.php");
	}	
	
}
?> 