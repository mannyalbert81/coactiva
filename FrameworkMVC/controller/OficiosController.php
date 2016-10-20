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
					
					$_id_usuarios= $_SESSION["id_usuarios"];
					$criterio_busqueda=$_POST["criterio_busqueda"];
					$contenido_busqueda=$_POST["contenido_busqueda"];
						
					$oficios= new OficiosModel(); 
					
					$columnas = " juicios.id_juicios, 
								  juicios.juicio_referido_titulo_credito, 
								  clientes.nombres_clientes, 
								  clientes.identificacion_clientes, 
								  titulo_credito.numero_titulo_credito, 
								  ciudad.nombre_ciudad, 
								  titulo_credito.total_total_titulo_credito, 
								  juicios.id_usuarios,
							      usuarios.nombre_usuarios";
						
					$tablas   = " public.clientes, 
								  public.juicios, 
								  public.titulo_credito, 
								  public.ciudad,
							      public.usuarios";
						
					$where    = "clientes.id_clientes = titulo_credito.id_clientes AND
								  titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND
								  ciudad.id_ciudad = juicios.id_ciudad AND juicios.id_usuarios = usuarios.id_usuarios AND titulo_credito.asignado_titulo_credito='TRUE' AND juicio_titulo_credito='TRUE' AND juicios.id_usuarios='$_id_usuarios'";
						
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
					            
					           
					            $traza=new TrazasModel();
					            $_nombre_controlador = "Oficios";
					            $_accion_trazas  = "Guardar";
					            $_parametros_trazas = $numero_oficio;
					            $resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					            	
					         $columnas = "  oficios.id_oficios,
							oficios.creado,
							oficios.numero_oficios,
							juicios.id_juicios,
							juicios.juicio_referido_titulo_credito,
							juicios.id_titulo_credito,
							clientes.nombres_clientes,
							clientes.identificacion_clientes,
							entidades.id_entidades,
							entidades.nombre_entidades,
							juicios.juicio_referido_titulo_credito,
							oficios.creado,
							juicios.creado,
							titulo_credito.numero_titulo_credito,
							titulo_credito.total_total_titulo_credito,
							clientes.identificacion_clientes,
							clientes.nombres_clientes,
							clientes.direccion_clientes,
							ciudad.nombre_ciudad,
							asignacion_secretarios_view.secretarios,
							asignacion_secretarios_view.impulsores,
							asignacion_secretarios_view.liquidador,
							oficios.numero_oficios,
					        oficios.identificador";
					            
					            
					        $tablas= "public.oficios,
							public.juicios,
							public.entidades,
							public.clientes,
							public.usuarios,
							public.ciudad,
							public.titulo_credito,
							public.asignacion_secretarios_view";
					            
					       $where= "juicios.id_juicios = oficios.id_juicios AND
					       entidades.id_entidades = oficios.id_entidades AND
			     	       clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios
				           AND juicios.id_usuarios = asignacion_secretarios_view.id_abogado
					       AND titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND ciudad.id_ciudad = juicios.id_ciudad AND
					       oficios.identificador='$identificador'";
					       $id= "oficios.id_oficios";
					            
					            
					       $resultSet= $oficios->getCondiciones($columnas, $tablas, $where, $id);
					            
					       $this->report("Oficios_Guardar",array( "resultSet"=>$resultSet));
					            	
					          
							} catch (Exception $e)
							{
								$this->view("Error",array(
										"resultado"=>"Eror al Asignar ->". $id
								));
							}
							
									
						}
					
					}
					
				
				
				
				}
			 
			$this->redirect("Oficios", "index");

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
					clientes.id_clientes = juicios.id_clientes AND usuarios.id_usuarios = oficios.id_usuario_registra_oficios AND oficios.firma_impulsor='TRUE' AND oficios.firma_secretario='TRUE'";
	
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
	
	
		
}
?>