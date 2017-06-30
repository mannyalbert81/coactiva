<?php
class ConsultaCitacionesLiquidadorController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function consulta_liquidador(){

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
		
		$citaciones = new CitacionesModel();


		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaCitacionesLiquidador";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $citaciones->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );

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


					$columnas = "citaciones.id_citaciones,
					juicios.id_juicios,
  					juicios.juicio_referido_titulo_credito,
 					clientes.nombres_clientes,
  					clientes.identificacion_clientes,
  					citaciones.fecha_citaciones,
  					ciudad.nombre_ciudad,
  					ciudad.id_ciudad,
  					tipo_citaciones.id_tipo_citaciones,
  					tipo_citaciones.nombre_tipo_citaciones,
  					citaciones.nombre_persona_recibe_citaciones,
  					citaciones.relacion_cliente_citaciones,
  					usuarios.nombre_usuarios";

					$tablas=" public.citaciones,
  					public.juicios,
  					public.ciudad,
  					public.tipo_citaciones,
  					public.usuarios,
  					public.clientes";

					$where="juicios.id_juicios = citaciones.id_juicios AND
  					ciudad.id_ciudad = citaciones.id_ciudad AND
  					tipo_citaciones.id_tipo_citaciones = citaciones.id_tipo_citaciones AND
  					usuarios.id_usuarios = citaciones.id_usuarios AND
  					clientes.id_clientes = juicios.id_clientes AND citaciones.firma_citador='TRUE'";

					$id="citaciones.id_citaciones";
						
						
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";


					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
						
					if($numero_juicio!=""){$where_1=" AND juicios.juicio_referido_titulo_credito='$numero_juicio'";}
						
					if($identificacion!=""){$where_2=" AND clientes.identificacion='$identificacion'";}
						
					if($titulo_credito!=""){$where_3=" AND juicios.id_titulo_credito='$titulo_credito'";}
						
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  citaciones.creado BETWEEN '$fechadesde' AND '$fechahasta'";}


					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;


					$resultSet=$citaciones->getCondiciones($columnas ,$tablas , $where_to, $id);


				}




				$this->view("ConsultaCitacionesLiquidadorFirmadas",array(
						"resultSet"=>$resultSet, "resultDatos"=>$resultDatos
							
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
		$citaciones = new CitacionesModel();
	
		if(isset($_GET['id']))
		{
	
			$id_oficios = $_GET ['id'];
	
			$resultCitaciones = $citaciones->getBy ( "id_citaciones='$id_oficios'" );
	
			if (! empty ( $resultCitaciones )) {
	
				$nombrePdf = $resultCitaciones [0]->nombre_citacion;
	
				$nombrePdf .= ".pdf";
	
				$ruta = $resultCitaciones [0]->ruta_citacion;
	
				$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/coactiva/documentos/' . $ruta . '/' . $nombrePdf;
	
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="'.$directorio.'"');
				readfile($directorio);
			}
	
	
		}
	
	}


}
?>