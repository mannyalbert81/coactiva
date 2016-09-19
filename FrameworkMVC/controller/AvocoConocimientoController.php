 <?php
class AvocoConocimientoController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    
    
public function index(){
	
		session_start();
		
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$ciudad = new CiudadModel();
			$usarios= new UsuariosModel();
			$avoco = new AvocoConocimientoModel();
			
			$resulSecretario=array();
			$resulImpulsor=array();
			$resultDatos=array();
			$resulSet=array();
			
			$_id_usuarios= $_SESSION["id_usuarios"];
			
			//notificaciones
			$usarios->MostrarNotificaciones($_id_usuarios);
			
			$documentos = new DocumentosModel();
			
			
			$nombre_controladores = "Avoco";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $documentos->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
				
				if(isset($_POST['Validar']))
				{
					$resultDatos=$ciudad->getBy("nombre_ciudad='QUITO' OR nombre_ciudad='GUAYAQUIL'");
					
					$resulSecretario=$usarios->getCondiciones("usuarios.id_usuarios,usuarios.nombre_usuarios",
																"public.rol,public.usuarios", 
																"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='SECRETARIO' AND usuarios.id_estado=2",
																"usuarios.nombre_usuarios");
					
					$resulImpulsor=$usarios->getCondiciones("usuarios.id_usuarios,usuarios.nombre_usuarios",
							"public.rol,public.usuarios",
							"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='ABOGADO IMPULSOR' AND usuarios.id_estado=2",
							"usuarios.nombre_usuarios");
					
					//$this->view("Error", array("resultado"=>print_r($resulSecretario))); exit();
					
					$juicio = new  JuiciosModel();
					$juicio_referido=$_POST['juicios'];
				
					$resulSet=$juicio->getCondiciones("id_juicios,juicio_referido_titulo_credito", "juicios", "juicio_referido_titulo_credito='$juicio_referido'", "id_juicios");
					
				}
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Avoco Conocimiento"
				));
				exit();
			}
			
			$this->view("AvocoConocimiento",array(
					 "resulImpulsor"=>$resulImpulsor,"resulSecretario"=>$resulSecretario,"resulSet"=>$resulSet, "resultDatos"=>$resultDatos
			
			));
		}
		else 
		{
			$this->view("Error",array(
					"resultado"=>"Debe Iniciar Sesion"
		
			));
		}
	}
	
	public function InsertaAvoco(){
		
		
		session_start();

		$avoco = new AvocoConocimientoModel();
		
		$juicio = new  JuiciosModel();
		$nombre_controladores = "Avoco";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $avoco->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		$id_usuario=$_SESSION['id_usuarios'];
		
		if (!empty($resultPer))
		{
		
			$resultado = null;
		
			if (isset ($_POST["Guardar"]))
			{
				//estado de documento pdf
				$_estado = "";
				
				$dato=array();
				
				//identificador de pdf
				$identificador="";
				
				//inicializar Parametros
				$_id_ciudad = "";
				$_id_juicio = "";
				$_id_secretario_reemplazar  = null;
				$_id_impulsor_reemplazar  = null;
				$_id_secretario = null;
				$_id_impulsor = null;
				$_tipo_avoco = "";

				if(isset($_POST["id_secretario_reemplazo"])){$_id_secretario_reemplazar  = $_POST["id_secretario_reemplazo"];}
				
				if(isset($_POST["id_impulsor_reemplazo"])){$_id_impulsor_reemplazar  = $_POST["id_impulsor_reemplazo"];}
				
				if(isset($_POST["id_secretario"])){$_id_secretario  = $_POST["id_secretario"];}
				
				if(isset($_POST["id_impulsor"])){$_id_impulsor  = $_POST["id_impulsor"];}
				
				//parametros
				$_id_ciudad  = $_POST["id_ciudad"];
				$_id_juicio  = $_POST["id_juicios"];
				$_tipo_avoco  = $_POST["tipo_avoco"];
				
				
				/*$this->view("Error", array("resultado"=>'ciudad '.$_id_ciudad.' juicio '.$_id_juicio.' secretario '.$_id_secretario_reemplazar.
						' impulsor '.$_id_impulsor_reemplazar.' secretario '.$_id_secretario.' impulsor '.$_id_impulsor.' tipoavoco '.$_tipo_avoco
				));
				exit();*/
						
				$consecutivo= new ConsecutivosModel();
				$resultConsecutivo= $consecutivo->getBy("documento_consecutivos='AVOCO'");
						
				$identificador=$resultConsecutivo[0]->real_consecutivos;
						
				$repositorio_documento="Avoco";
						
				$nombre_documento=$repositorio_documento.$identificador;
						
				$funcion = "ins_avoco_conocimiento";
							
				$parametros = " '$_id_juicio' ,'$_id_ciudad' , '$_id_secretario' , '$_id_impulsor' , '$id_usuario' , '$nombre_documento' , '$repositorio_documento' , '$identificador','$_id_secretario_reemplazar','$_id_impulsor_reemplazar'";
				$avoco->setFuncion($funcion);
														
				$avoco->setParametros($parametros);
				$resultado=$avoco->Insert();
				
				$updateJuicio = $avoco->UpdateBy("id_usuarios='$_id_impulsor'", "juicios", "id_juicios='$_id_juicio'");
				
				/*$this->view("Error", array("resultado"=>print_r($resultado)));
				exit();*/
						
				//auditoria
				$traza=new TrazasModel();
				$_nombre_controlador = "Avoco";
				$_accion_trazas  = "Guardar";
				$_parametros_trazas = "Archivo ".$nombre_documento." en ".$repositorio_documento;
				$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
						
				$consecutivo->UpdateBy("real_consecutivos=real_consecutivos+1", "consecutivos", "documento_consecutivos='AVOCO'");
						
				$_estado = "Guardar";
						
				//inserta las notificaciones
				//$this->notificacionSecretario($_id_secretario,$nombre_documento);
				//$this->notificacionimpulsor($_id_impulsor,$nombre_documento);
				//$this->notificacionSecretarioReemplazo($_id_secretario_reemplazar,$nombre_documento);
				
				$host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				
				switch ($_tipo_avoco){
					
					case "con_garante":
						
						print "<script language='JavaScript'>
						setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSecretarioImpulsorGaranteReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
						</script>";
						
						print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
						break;
					
					case "sin_garante":
						
						print "<script language='JavaScript'>
						setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSecretarioImpulsorReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
						</script>";
						
						print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
						
						break;
						
					case "con_dos_garante":
						
						print "<script language='JavaScript'>
						setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSecretarioImpulsor2GaranteReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
						</script>";
						
						print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
						
						break;
						
					case "impulsor":
						
						print "<script language='JavaScript'>
						setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoImpulsorReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
						</script>";
						
						print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
						
						break;
				}
						
			   }
				
			   
			}else
				{
					
					$this->view("Error",array(
						
					"resultado"=>"No tiene Permisos de Insertar Documentos"
		
					));
		
				}
				
          }
	
          public function VisualizarAvoco(){
          
          	session_start();
          
          
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
          		$dato['garante_1']=$resultJuicio[0]->nombre_garantes_1;
          		$dato['identificacion_garante']=$resultJuicio[0]->identificacion_garantes;
          		$dato['identificacion_garante_1']=$resultJuicio[0]->identificacion_garantes_1;
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
          	 elseif ($_tipo_avoco == "con_garante"){
          
          		$host  = $_SERVER['HTTP_HOST'];
          		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          		
          		print "<script language='JavaScript'>
          		setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoReport.php?estado=$_estado&dato=$result','Popup','height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
          		</script>";
          		
          		print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index&dato=$resultArray');</script>");
          		
          		
          
          	}
          	
          	elseif ($_tipo_avoco == "secretario"){
          	
          		$host  = $_SERVER['HTTP_HOST'];
          		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          	
          		print "<script language='JavaScript'>
          		setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSecretarioReport.php?estado=$_estado&dato=$result','Popup','height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
          		</script>";
          	
          		print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index&dato=$resultArray');</script>");
          	
          	
          	
          	}
          	
          	elseif ($_tipo_avoco == "impulsor"){
          	
          		$host  = $_SERVER['HTTP_HOST'];
          		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          	
          		print "<script language='JavaScript'>
          		setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoImpulsorReport.php?estado=$_estado&dato=$result','Popup','height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
          		</script>";
          	
          		print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index&dato=$resultArray');</script>");
          	
          	
          	
          	}
          
          
          }
	
	
	public function GuardarReporte()
	{
		$resultado=$_GET['dato'];
		
		$result=explode(".", $resultado);
		
		$documentos = new  DocumentosModel();
		
		$result=$documentos->UpdateBy("ruta_documento='$result[0]',nombre_documento='$result[1]'", "documentos", "identificador='$result[2]'");
		
	}
	
	public function verError(){
		$resultado=$_GET['dato'];
		$this->view("error", array('resultado'=>print_r($resultado)));
	}
	
	
	public function notificacionimpulsor($id_impulsor,$documento=null)
	{
		$tipo_notificacion= new TipoNotificacionModel();
		
		$res_tipo_notificacion=array();
		
		$destino=$id_impulsor;
		
		$archivoPdf=$documento;
		
		$_nombre_tipo_notificacion="avoco_impulsor";
	
		$resul_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		$id_tipo_notificacion=$resul_tipo_notificacion[0]->id_tipo_notificacion;
		
		$descripcion="Avoco Conocimiento";
		
		$numero_movimiento=0;
	
		$tipo_notificacion->CrearNotificacion($id_tipo_notificacion, $destino, $descripcion, $numero_movimiento, $archivoPdf);
	
	}
	
	public function notificacionSecretario($id_secretario,$documento=null)
	{
		$tipo_notificacion= new TipoNotificacionModel();
		
		$res_tipo_notificacion=array();
		
		$destino=$id_secretario;
		
		$archivoPdf=$documento;
		
		$_nombre_tipo_notificacion="avoco_secretario";
		
		$res_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
		
		$id_tipo_notificacion=$res_tipo_notificacion[0]->id_tipo_notificacion;
		
		$descripcion="Avoco Conocimiento";
		
		$numero_movimiento=0;		
		
		$tipo_notificacion->CrearNotificacion($id_tipo_notificacion, $destino, $descripcion, $numero_movimiento, $archivoPdf);
	
	}
	
	public function notificacionSecretarioReemplazo($id_secretario_reemplazo,$documento=null)
	{
		$tipo_notificacion= new TipoNotificacionModel();
	
		$res_tipo_notificacion=array();
	
		$destino=$id_secretario_reemplazo;
	
		$archivoPdf=$documento;
	
		$_nombre_tipo_notificacion="avoco_secretario";
	
		$res_tipo_notificacion=$tipo_notificacion->getBy("descripcion_notificacion='$_nombre_tipo_notificacion'");
	
		$id_tipo_notificacion=$res_tipo_notificacion[0]->id_tipo_notificacion;
	
		$descripcion="Avoco Conocimiento";
	    $numero_movimiento=0;
	    $tipo_notificacion->CrearNotificacion($id_tipo_notificacion, $destino, $descripcion, $numero_movimiento, $archivoPdf);
	
	}
	
	//funcion script para mosttrar Secretarios de acuerdo a la ciudad selecionada
	public function returnSecretariosbyciudad()
	{
	
		//CONSULTA DE USUARIOS POR SU ROL
		$idciudad=(int)$_POST["ciudad"];
		$usuarios=new UsuariosModel();
		$columnas = "usuarios.id_usuarios,usuarios.nombre_usuarios";
		$tablas="usuarios,ciudad,rol";
		$id="rol.id_rol";
	
		$where="rol.id_rol=usuarios.id_rol AND usuarios.id_ciudad=ciudad.id_ciudad
		AND rol.nombre_rol='SECRETARIO' AND usuarios.id_estado=1 AND ciudad.id_ciudad='$idciudad'";
	
		$resultado=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
	
		echo json_encode($resultado);
	}
	
	//funcion script para mosttrar Impulsores de acuerdo a su secretario
	public function returnImpulsoresxSecretario()
	{
	
		//consulta de impulsores
		$idSecretario=(int)$_POST["idSecretario"];
		$usuarios=new UsuariosModel();
		$columnas = "asignacion_secretarios_view.id_abogado,asignacion_secretarios_view.impulsores";
		$tablas="public.asignacion_secretarios_view";
		$id="asignacion_secretarios_view.impulsores";
	
		$where=" asignacion_secretarios_view.id_secretario='$idSecretario'";
	
		$resultado=$usuarios->getCondiciones($columnas ,$tablas , $where, $id);
	
		echo json_encode($resultado);
	}
	
	//Avocos nuevas vistas
	
	public function nueva(){
	
		session_start();
	
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$ciudad = new CiudadModel();
			$usarios= new UsuariosModel();
			$avoco = new AvocoConocimientoModel();
				
			$resulSecretario=array();
			$resulImpulsor=array();
			$resultDatos=array();
			$resulSet=array();
				
			$_id_usuarios= $_SESSION["id_usuarios"];
				
			//notificaciones
			$usarios->MostrarNotificaciones($_id_usuarios);
				
			$documentos = new DocumentosModel();
				
				
			$nombre_controladores = "Avoco";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $documentos->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
	
				if(isset($_POST['Validar']))
				{
					$resultDatos=$ciudad->getBy("nombre_ciudad='QUITO' OR nombre_ciudad='GUAYAQUIL'");
						
					$resulSecretario=$usarios->getCondiciones("usuarios.id_usuarios,usuarios.nombre_usuarios",
							"public.rol,public.usuarios",
							"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='SECRETARIO' AND usuarios.id_estado=2",
							"usuarios.nombre_usuarios");
						
					$resulImpulsor=$usarios->getCondiciones("usuarios.id_usuarios,usuarios.nombre_usuarios",
							"public.rol,public.usuarios",
							"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='ABOGADO IMPULSOR' AND usuarios.id_estado=2",
							"usuarios.nombre_usuarios");
						
					//$this->view("Error", array("resultado"=>print_r($resulSecretario))); exit();
						
					$juicio = new  JuiciosModel();
					$juicio_referido=$_POST['juicios'];
	
					$resulSet=$juicio->getCondiciones("id_juicios,juicio_referido_titulo_credito", "juicios", "juicio_referido_titulo_credito='$juicio_referido'", "id_juicios");
						
				}
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Avoco Conocimiento"
				));
				exit();
			}
				
			$this->view("AvocoConocimientoNueva",array(
					"resulImpulsor"=>$resulImpulsor,"resulSecretario"=>$resulSecretario,"resulSet"=>$resulSet, "resultDatos"=>$resultDatos
						
			));
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"Debe Iniciar Sesion"
	
			));
		}
	}
	
	public function AvocoSecretarioImpulsor()
	{
		session_start();
		
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$ciudad = new CiudadModel();
			$usarios= new UsuariosModel();
			$avoco = new AvocoConocimientoModel();
				
			$resulSecretario=array();
			$resulImpulsor=array();
			$resultDatos=array();
			$resulSet=array();
				
			$_id_usuarios= $_SESSION["id_usuarios"];
				
			//notificaciones
			$usarios->MostrarNotificaciones($_id_usuarios);
				
			$documentos = new DocumentosModel();
				
				
			$nombre_controladores = "Avoco";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $documentos->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
			if (!empty($resultPer))
			{
		
				if(isset($_POST['Validar']))
				{
					$resultDatos=$ciudad->getBy("nombre_ciudad='QUITO' OR nombre_ciudad='GUAYAQUIL'");
						
					$resulSecretario=$usarios->getCondiciones("usuarios.id_usuarios,usuarios.nombre_usuarios",
							"public.rol,public.usuarios",
							"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='SECRETARIO' AND usuarios.id_estado=2",
							"usuarios.nombre_usuarios");
						
					$resulImpulsor=$usarios->getCondiciones("usuarios.id_usuarios,usuarios.nombre_usuarios",
							"public.rol,public.usuarios",
							"rol.id_rol = usuarios.id_rol AND rol.nombre_rol='ABOGADO IMPULSOR' AND usuarios.id_estado=2",
							"usuarios.nombre_usuarios");
						
					//$this->view("Error", array("resultado"=>print_r($resulSecretario))); exit();
						
					$juicio = new  JuiciosModel();
					$juicio_referido=$_POST['juicios'];
		
					$resulSet=$juicio->getCondiciones("id_juicios,juicio_referido_titulo_credito", "juicios", "juicio_referido_titulo_credito='$juicio_referido'", "id_juicios");
						
				}
		
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Avoco Conocimiento"
				));
				exit();
			}
				
			$this->view("AvocoSecretarioImpulsor",array(
					"resulImpulsor"=>$resulImpulsor,"resulSecretario"=>$resulSecretario,"resulSet"=>$resulSet, "resultDatos"=>$resultDatos
						
			));
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"Debe Iniciar Sesion"
		
			));
		}
		
	}
	
	public function InsertarAvocoSecretarioImpulsor()
	{
		
			session_start();
		
			$avoco = new AvocoConocimientoModel();
		
			$juicio = new  JuiciosModel();
			$nombre_controladores = "Avoco";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $avoco->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			$id_usuario=$_SESSION['id_usuarios'];
		
			if (!empty($resultPer))
			{
		
				$resultado = null;
		
				if (isset ($_POST["Guardar"]))
				{
					//estado de documento pdf
					$_estado = "";
		
					$dato=array();
		
					//identificador de pdf
					$identificador="";
		
					//inicializar Parametros
					$_id_ciudad = "";
					$_id_juicio = "";
					$_id_secretario_reemplazar  = null;
					$_id_impulsor_reemplazar  = null;
					$_id_secretario = null;
					$_id_impulsor = null;
					$_tipo_avoco = "";
		
					if(isset($_POST["id_secretario_reemplazo"])){$_id_secretario_reemplazar  = $_POST["id_secretario_reemplazo"];}
		
					if(isset($_POST["id_impulsor_reemplazo"])){$_id_impulsor_reemplazar  = $_POST["id_impulsor_reemplazo"];}
		
					if(isset($_POST["id_secretario"])){$_id_secretario  = $_POST["id_secretario"];}
		
					if(isset($_POST["id_impulsor"])){$_id_impulsor  = $_POST["id_impulsor"];}
		
					//parametros
					$_id_ciudad  = $_POST["id_ciudad"];
					$_id_juicio  = $_POST["id_juicios"];
					$_tipo_avoco  = $_POST["tipo_avoco"];
		
		
					/*$this->view("Error", array("resultado"=>'ciudad '.$_id_ciudad.' juicio '.$_id_juicio.' secretario '.$_id_secretario_reemplazar.
					 ' impulsor '.$_id_impulsor_reemplazar.' secretario '.$_id_secretario.' impulsor '.$_id_impulsor.' tipoavoco '.$_tipo_avoco
						));
					exit();*/
		
					$consecutivo= new ConsecutivosModel();
					$resultConsecutivo= $consecutivo->getBy("documento_consecutivos='AVOCO'");
		
					$identificador=$resultConsecutivo[0]->real_consecutivos;
		
					$repositorio_documento="Avoco";
		
					$nombre_documento=$repositorio_documento.$identificador;
		
					$funcion = "ins_avoco_conocimiento";
						
					$parametros = " '$_id_juicio' ,'$_id_ciudad' , '$_id_secretario' , '$_id_impulsor' , '$id_usuario' , '$nombre_documento' , '$repositorio_documento' , '$identificador','$_id_secretario_reemplazar','$_id_impulsor_reemplazar'";
					$avoco->setFuncion($funcion);
		
					$avoco->setParametros($parametros);
					$resultado=$avoco->Insert();
		
					$updateJuicio = $avoco->UpdateBy("id_usuarios='$_id_impulsor'", "juicios", "id_juicios='$_id_juicio'");
		
					/*$this->view("Error", array("resultado"=>print_r($resultado)));
						exit();*/
		
					//auditoria
					$traza=new TrazasModel();
					$_nombre_controlador = "Avoco";
					$_accion_trazas  = "Guardar";
					$_parametros_trazas = "Archivo ".$nombre_documento." en ".$repositorio_documento;
					$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
		
					$consecutivo->UpdateBy("real_consecutivos=real_consecutivos+1", "consecutivos", "documento_consecutivos='AVOCO'");
		
					$_estado = "Guardar";
		
					//inserta las notificaciones
					//$this->notificacionSecretario($_id_secretario,$nombre_documento);
					//$this->notificacionimpulsor($_id_impulsor,$nombre_documento);
					//$this->notificacionSecretarioReemplazo($_id_secretario_reemplazar,$nombre_documento);
		
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		
					switch ($_tipo_avoco){
							
						case "con_garante":
		
							print "<script language='JavaScript'>
							setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
							</script>";
		
							print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
							break;
								
						case "sin_garante":
		
							print "<script language='JavaScript'>
							setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSinGaranteReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
							</script>";
		
							print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
		
							break;
		
						case "con_dos_garante":
		
							print "<script language='JavaScript'>
							setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoSecretarioReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
							</script>";
		
							print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
		
							break;
		
						case "impulsor":
		
							print "<script language='JavaScript'>
							setTimeout(window.open('http://$host$uri/view/ireports/ContAvocoImpulsorReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_documento','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
							</script>";
		
							print("<script>window.location.replace('index.php?controller=AvocoConocimiento&action=index');</script>");
		
							break;
					}
		
				}
		
		
			}else
			{
					
				$this->view("Error",array(
		
						"resultado"=>"No tiene Permisos de Insertar Documentos"
		
				));
		
			}
		
		
		
	}
	
	public function AvocoSecretario()
	{
		
	}
	
	public function AvocoImpulsor()
	{
	
	}
}
?>
