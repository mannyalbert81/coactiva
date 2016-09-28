<?php

class AprobacionAutoPagoController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

	//maycol454

	public function index(){
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$aprobacion_auto_pago = new AutoPagosModel();
			//NOTIFICACIONES
			$aprobacion_auto_pago->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$resultEdit="";
			$resultDatos="";
			$resultSet="";
			
			$rol = new RolesModel();
			$resultRol=$rol->getAll("nombre_rol");
				
			$controladores=new ControladoresModel();
			$resultCon=$controladores->getAll("nombre_controladores");
			
			$clientes = new ClientesModel();
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
			$resultImpul=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
			
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "AprobacionAutoPago";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $permisos_rol->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
				
				if(isset($_POST["buscar"])){
				
					$id_ciudad=$_POST['id_ciudad'];
					$id_usuarios=$_POST['id_usuarios'];
					$identificacion=$_POST['identificacion'];
					$numero_juicio=$_POST['numero_titulo_credito'];
					$fechadesde=$_POST['fecha_desde'];
					$fechahasta=$_POST['fecha_hasta'];
				
					$aprobacion_auto_pago = new AutoPagosModel();
				
				
					$columnas = "clientes.identificacion_clientes, 
							  clientes.nombres_clientes, 
							  clientes.nombre_garantes, 
							  clientes.identificacion_garantes, 
							  clientes.telefono_garantes, 
							  clientes.celular_garantes, 
							  clientes.nombre_garantes_1, 
							  clientes.identificacion_garantes_1, 
							  clientes.telefono_garantes_1, 
							  clientes.celular_garantes_1, 
							  titulo_credito.numero_titulo_credito, 
							  titulo_credito.id_titulo_credito,
							  titulo_credito.total_total_titulo_credito, 
							  ciudad.nombre_ciudad, 
							  estado.nombre_estado, 
							  auto_pagos.id_auto_pagos,
							  auto_pagos.creado, 
							  asignacion_secretarios_view.impulsores, 
							  asignacion_secretarios_view.secretarios, 
							  asignacion_secretarios_view.id_secretario, 
							  asignacion_secretarios_view.id_abogado";
				
					$tablas=" public.asignacion_secretarios_view, 
							  public.auto_pagos, 
							  public.ciudad, 
							  public.titulo_credito, 
							  public.clientes, 
							  public.estado";
				
					$where="auto_pagos.id_titulo_credito = titulo_credito.id_titulo_credito AND
						  ciudad.id_ciudad = titulo_credito.id_ciudad AND
						  titulo_credito.id_usuarios = asignacion_secretarios_view.id_abogado AND
						  clientes.id_clientes = titulo_credito.id_clientes AND
						  estado.id_estado = auto_pagos.id_estado AND estado.nombre_estado ='PENDIENTE' AND asignacion_secretarios_view.id_secretario='$_id_usuarios'";
				
					$id="clientes.identificacion_clientes";
				
				
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					$where_4 = "";
				
				
					if($id_ciudad!=0){$where_0=" AND ciudad.id_ciudad='$id_ciudad'";}
				
					if($id_usuarios!=0){$where_1=" AND asignacion_secretarios_view.id_abogado='$id_usuarios'";}
				
					if($identificacion!=""){$where_2=" AND clientes.identificacion_clientes='$identificacion'";}
				
					if($numero_juicio!=""){$where_3=" AND titulo_credito.numero_titulo_credito='$numero_juicio'";}
				
					if($fechadesde!="" && $fechahasta!=""){$where_4=" AND  auto_pagos.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
				
				
					$where_to  = $where . $where_0 . $where_1 . $where_2. $where_3 . $where_4;
				
				
					$resultSet=$aprobacion_auto_pago->getCondiciones($columnas ,$tablas , $where_to, $id);
				}
					
					$this->view("AprobacionAutoPago",array(
							
							 "resultSet"=>$resultSet,"resultEdit"=>$resultEdit,"resultRol"=>$resultRol, "resultDatos"=>$resultDatos, "resultImpul"=>$resultImpul
					));
			
			
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Aprobacion Auto Pagos"
			
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
		
		//para generar el archivo pdf
		
		$identificador="";
		$_estado = "Guardar";
		$dato=array();
		
		
		$resultado = null;
		$permisos_rol = new PermisosRolesModel();
		$aprobacion_auto_pago = new AutoPagosModel();
		$nombre_controladores = "AprobacionAutoPago";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
			
			if(isset($_GET["id_auto_pagos"]))
			{
				$consecutivo= new ConsecutivosModel();
				$resultConsecutivo= $consecutivo->getBy("documento_consecutivos='AUTOPAGOS'");
				$identificador=$resultConsecutivo[0]->real_consecutivos;
				
				$repositorio_documento="AutoPagos";
				$nombre_documento=$repositorio_documento.$identificador;
				
				$estado=new EstadoModel();
				$resultEstado=$estado->getBy("nombre_estado='PENDIENTE'");		//para pruebas-->  'APROBADO'		
				$id_estado=$resultEstado[0]->id_estado;
				
				//para obtener el id auto de pago
				$id_auto_pago=$_GET["id_auto_pagos"];
				
				//para obtener id titulo credito
				$id_titulo_credito = $_GET["id_titulo_credito"];
				
				
				try {
					
					$resultado=$aprobacion_auto_pago->UpdateBy("id_estado='$id_estado',nombre_auto_pagos='$nombre_documento',identificador='$identificador',ruta_auto_pagos='$repositorio_documento'", "auto_pagos", "id_auto_pagos='$id_auto_pago'");
					
					//pra obtener id_juzgado
					
					$col_ciudad="titulo_credito.id_ciudad";
					$tbl_ciudad="public.titulo_credito,public.ciudad";
					$whre_ciudad="ciudad.id_ciudad = titulo_credito.id_ciudad AND
					titulo_credito.id_titulo_credito='$id_titulo_credito'";
					$resultCiudad=$aprobacion_auto_pago->getCondiciones($col_ciudad, $tbl_ciudad, $whre_ciudad, "titulo_credito.id_ciudad");
					
					$id_juzgado=$resultCiudad[0]->id_ciudad;
					
					//para obtener juicio referido
					$anio=date("Y");
					$col_prefijo=" prefijos.nombre_prefijos,prefijos.consecutivo";
					$tbl_prefijo="public.prefijos";
					$whre_prefijo="prefijos.id_ciudad='$id_juzgado'";
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
					$descipcion_auto_pago_juicios="";
					
					//para estados procesales juicios "Auto de Pago"
					$col_est_procesales="*";
					$tbl_est_procesales="estados_procesales_juicios";
					$whre_est_procesales="nombre_estados_procesales_juicios LIKE 'AUTO DE PAGO'";
					$result_est_procesales=$aprobacion_auto_pago->getCondiciones($col_est_procesales, $tbl_est_procesales, $whre_est_procesales, "id_estados_procesales_juicios");
					
					$id_estados_procesales_juicios=$result_est_procesales[0]->id_estados_procesales_juicios;
					
					//para estados auto pagos juicios
					$col_est_auto_pago_juicios="*";
					$tbl_est_auto_pago_juicios="estados_auto_pago_juicios";
					$whre_est_auto_pago_juicios="nombre_estados_auto_pago_juicios LIKE 'A'";
					$result_auto_pago_juicios=$aprobacion_auto_pago->getCondiciones($col_est_auto_pago_juicios, $tbl_est_auto_pago_juicios, $whre_est_auto_pago_juicios, "id_estados_auto_pago_juicios");
					
					$id_estados_auto_pago_juicios=$result_auto_pago_juicios[0]->id_estados_auto_pago_juicios;
					
					//para archivos
					//$prefijo=CLIENTE;
					$nombre_archivado_juicios='';
					
					//para entidad
					$id_entidades=10;
					
					//aqui va insertado de juicio
					
					$resultadojuicio=$aprobacion_auto_pago->InsertaJuicio($id_entidades, $id_juzgado , $juicio_referido_titulo_credito, $id_usuarios, $id_titulo_credito, $id_clientes, $id_etapas_juicios, $id_tipo_juicios, $descipcion_auto_pago_juicios, $id_estados_procesales_juicios, $id_estados_auto_pago_juicios, $nombre_archivado_juicios);
					
					$consecutivo->UpdateBy("real_consecutivos=real_consecutivos+1", "consecutivos", "documento_consecutivos='AUTOPAGOS'");
					
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					
					//$this->view("Error", array("resultado"=>$host.$uri));
					
					//para crear com domPdf}
					//$this->report("ImpresionAutoPago", array());
					print "<script language='JavaScript'>
					setTimeout(window.open('http://$host$uri/view/ireports/ContAutoPagoJuridicoReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
					</script>";
					
					print("<script>window.location.replace('index.php?controller=AprobacionAutoPago&action=index');</script>");
						
					
				} catch (Exception $e) {
					
					$this->view("Error",array(
							"resultado"=>"Eror al Aprobar Auto pago ->". $id_auto_pago
					));
					
				}
				
				
				
			}
			
			//$this->redirect("AprobacionAutoPago", "index");
		
		}else{
			
			$this->view("Error", array("resultado"=>"No tiene Acceso a aprobacion de Auto Pagos"));
			
			}
		
	}
	
	
	public function ActualizarAutoPago_DomPdf(){
		session_start();
	
		//para generar el archivo pdf
	
		$identificador="";
		$_estado = "Guardar";
		$dato=array();
	
	
		$resultado = null;
		$permisos_rol = new PermisosRolesModel();
		$aprobacion_auto_pago = new AutoPagosModel();
		$nombre_controladores = "AprobacionAutoPago";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
	
		if (!empty($resultPer))
		{
				
			if(isset($_GET["id_auto_pagos"]))
			{
				$consecutivo= new ConsecutivosModel();
				$resultConsecutivo= $consecutivo->getBy("documento_consecutivos='AUTOPAGOS'");
				$identificador=$resultConsecutivo[0]->real_consecutivos;
	
				$repositorio_documento="AutoPagos";
				$nombre_documento=$repositorio_documento.$identificador;
	
				$estado=new EstadoModel();
				$resultEstado=$estado->getBy("nombre_estado='PENDIENTE'");		//para pruebas-->  'APROBADO'
				$id_estado=$resultEstado[0]->id_estado;
	
				//para obtener el id auto de pago
				$id_auto_pago=$_GET["id_auto_pagos"];
	
				//para obtener id titulo credito
				$id_titulo_credito = $_GET["id_titulo_credito"];
	
	
				try {
						
					$resultado=$aprobacion_auto_pago->UpdateBy("id_estado='$id_estado',nombre_auto_pagos='$nombre_documento',identificador='$identificador',ruta_auto_pagos='$repositorio_documento'", "auto_pagos", "id_auto_pagos='$id_auto_pago'");
						
					//pra obtener id_juzgado
						
					$col_ciudad="titulo_credito.id_ciudad";
					$tbl_ciudad="public.titulo_credito,public.ciudad";
					$whre_ciudad="ciudad.id_ciudad = titulo_credito.id_ciudad AND
					titulo_credito.id_titulo_credito='$id_titulo_credito'";
					$resultCiudad=$aprobacion_auto_pago->getCondiciones($col_ciudad, $tbl_ciudad, $whre_ciudad, "titulo_credito.id_ciudad");
						
					$id_juzgado=$resultCiudad[0]->id_ciudad;
						
					//para obtener juicio referido
					$anio=date("Y");
					$col_prefijo=" prefijos.nombre_prefijos,prefijos.consecutivo";
					$tbl_prefijo="public.prefijos";
					$whre_prefijo="prefijos.id_ciudad='$id_juzgado'";
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
					$descipcion_auto_pago_juicios="";
						
					//para estados procesales juicios "Auto de Pago"
					$col_est_procesales="*";
					$tbl_est_procesales="estados_procesales_juicios";
					$whre_est_procesales="nombre_estados_procesales_juicios LIKE 'AUTO DE PAGO'";
					$result_est_procesales=$aprobacion_auto_pago->getCondiciones($col_est_procesales, $tbl_est_procesales, $whre_est_procesales, "id_estados_procesales_juicios");
						
					$id_estados_procesales_juicios=$result_est_procesales[0]->id_estados_procesales_juicios;
						
					//para estados auto pagos juicios
					$col_est_auto_pago_juicios="*";
					$tbl_est_auto_pago_juicios="estados_auto_pago_juicios";
					$whre_est_auto_pago_juicios="nombre_estados_auto_pago_juicios LIKE 'A'";
					$result_auto_pago_juicios=$aprobacion_auto_pago->getCondiciones($col_est_auto_pago_juicios, $tbl_est_auto_pago_juicios, $whre_est_auto_pago_juicios, "id_estados_auto_pago_juicios");
						
					$id_estados_auto_pago_juicios=$result_auto_pago_juicios[0]->id_estados_auto_pago_juicios;
						
					//para archivos
					//$prefijo=CLIENTE;
					$nombre_archivado_juicios='';
						
					//para entidad
					$id_entidades=10;
						
					//aqui va insertado de juicio
						
					$resultadojuicio=$aprobacion_auto_pago->InsertaJuicio($id_entidades, $id_juzgado , $juicio_referido_titulo_credito, $id_usuarios, $id_titulo_credito, $id_clientes, $id_etapas_juicios, $id_tipo_juicios, $descipcion_auto_pago_juicios, $id_estados_procesales_juicios, $id_estados_auto_pago_juicios, $nombre_archivado_juicios);
						
					$consecutivo->UpdateBy("real_consecutivos=real_consecutivos+1", "consecutivos", "documento_consecutivos='AUTOPAGOS'");
						
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
						
					//$this->view("Error", array("resultado"=>$host.$uri));
						
					//para crear com domPdf}
					$this->report("ImpresionAutoPago", array());
					
						
				} catch (Exception $e) {
						
					$this->view("Error",array(
							"resultado"=>"Eror al Aprobar Auto pago ->". $id_auto_pago
					));
						
				}
	
	
	
			}
				
			//$this->redirect("AprobacionAutoPago", "index");
	
		}else{
				
			$this->view("Error", array("resultado"=>"No tiene Acceso a aprobacion de Auto Pagos"));
				
		}
	
	}
	
	
	public function borrarId()
	{
	
		session_start();
		$permisos_rol=new PermisosRolesModel();
		$nombre_controladores = "AprobacionAutoPago";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
	
			if(isset($_GET["id_auto_pagos"]))
			{
				$id_auto_pagos=(int)$_GET["id_auto_pagos"];
	
				$aprobacion_auto_pago = new AutoPagosModel();
	
				$aprobacion_auto_pago->deleteBy(" id_auto_pagos",$id_auto_pagos);
	
				$traza=new TrazasModel();
				$_nombre_controlador = "Autos de Pago";
				$_accion_trazas  = "Rechazado";
				$_parametros_trazas = $id_auto_pagos;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
	
			}
	
			$this->redirect("AprobacionAutoPago", "index");
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Rechazar Autos de Pago"
	
			));
		}
	
	}
 
	

	
}
?>      