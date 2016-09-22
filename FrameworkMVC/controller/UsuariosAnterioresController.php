<?php
ini_set('memory_limit','128M');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);


//include_once('class/phpjasperxml/class/tcpdf/tcpdf.php');
//include_once("class/phpjasperxml/class/PHPJasperXML.inc.php");

//include_once ('class/phpjasperxml/setting.php');



//include_once('setting.php');//no se puede enviar nada mas que el reporte, NINGUN espacio o caracter previo al repote

class UsuariosAnterioresController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    //maycol
public function index(){
	
		session_start();
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			
			$usuarios=new UsuariosModel();
			//Notificaciones
			$usuarios->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$id_usuario=$_SESSION['id_usuarios'];
			
			//creacion menu busqueda
			//$resultMenu=array("1"=>Nombre,"2"=>Usuario,"3"=>Correo,"4"=>Rol);
			$resultMenu=array(0=>'Nombre');
			
			
				//Creamos el objeto usuario
			$rol=new RolesModel();
			$resultRol = $rol->getBy("nombre_rol='SECRETARIO' OR nombre_rol='ABOGADO IMPULSOR'");
			
			
			$estado = new EstadoModel();
			$resultEst = $estado->getBy("nombre_estado='INACTIVO'");
			
			
			
			$usuarios = new UsuariosModel();

			$nombre_controladores = "UsuariosAnteriores";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $usuarios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			     	$columnas = " usuarios.id_usuarios,  usuarios.nombre_usuarios, rol.nombre_rol, estado.nombre_estado, rol.id_rol, estado.id_estado";
					$tablas   = "public.rol,  public.usuarios, public.estado";
					//$where    = "rol.id_rol = usuarios.id_rol AND estado.id_estado = usuarios.id_estado AND estado.nombre_estado='INACTIVO' AND usuarios.id_usuarios_registra='$id_usuario'";
					$where    = "rol.id_rol = usuarios.id_rol AND estado.id_estado = usuarios.id_estado AND estado.nombre_estado='INACTIVO'";
					$id       = "usuarios.nombre_usuarios"; 
			
					
					//Conseguimos todos los usuarios
					$resultSet=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
					
					$resultEdit = "";
			
					if (isset ($_GET["id_usuarios"])   )
					{
						$_id_usuario = $_GET["id_usuarios"];
						$where    = "rol.id_rol = usuarios.id_rol AND estado.id_estado = usuarios.id_estado AND usuarios.id_usuarios = '$_id_usuario' "; 
						$resultEdit = $usuarios->getCondiciones($columnas ,$tablas ,$where, $id); 
				
					
						$traza=new TrazasModel();
						$_nombre_controlador = "UsuariosAnteriores";
						$_accion_trazas  = "Editar";
						$_parametros_trazas = $_id_usuario;
						$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
					
					
					}
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Usuarios"
			
				));
				exit();
			
			
			}
			
			
			///si tiene permiso de ver
			//$resultPerVer = $usuarios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			$resultPerVer= $usuarios->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPerVer))
			{
				if (isset ($_POST["criterio"])  && isset ($_POST["contenido"])  )
				{
						
					
					/*	
					$columnas = "documentos_legal.id_documentos_legal,  documentos_legal.fecha_documentos_legal, categorias.nombre_categorias, subcategorias.nombre_subcategorias, tipo_documentos.nombre_tipo_documentos, cliente_proveedor.nombre_cliente_proveedor, carton_documentos.numero_carton_documentos, documentos_legal.paginas_documentos_legal, documentos_legal.fecha_desde_documentos_legal, documentos_legal.fecha_hasta_documentos_legal, documentos_legal.ramo_documentos_legal, documentos_legal.numero_poliza_documentos_legal, documentos_legal.ciudad_emision_documentos_legal, soat.cierre_ventas_soat,   documentos_legal.creado  ";
					$tablas   = "public.documentos_legal, public.categorias, public.subcategorias, public.tipo_documentos, public.carton_documentos, public.cliente_proveedor, public.soat";
					$where    = "categorias.id_categorias = subcategorias.id_categorias AND subcategorias.id_subcategorias = documentos_legal.id_subcategorias AND tipo_documentos.id_tipo_documentos = documentos_legal.id_tipo_documentos AND carton_documentos.id_carton_documentos = documentos_legal.id_carton_documentos AND cliente_proveedor.id_cliente_proveedor = documentos_legal.id_cliente_proveedor   AND documentos_legal.id_soat = soat.id_soat ";
					$id       = "documentos_legal.fecha_documentos_legal, carton_documentos.numero_carton_documentos";
					*/	
					
					
					
					$columnas = " usuarios.id_usuarios,  usuarios.nombre_usuarios, rol.nombre_rol, estado.nombre_estado, rol.id_rol, estado.id_estado";
					$tablas   = "public.rol,  public.usuarios, public.estado";
					$where    = "rol.id_rol = usuarios.id_rol AND estado.id_estado = usuarios.id_estado AND estado.nombre_estado='INACTIVO'";
					$id       = "usuarios.nombre_usuarios";
					

					$criterio = $_POST["criterio"];
					$contenido = $_POST["contenido"];
						
					
					//$resultSet=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
						
					if ($contenido !="")
					{
							
						$where_0 = "";
						
							
						switch ($criterio) {
							case 0:
								//Ruc Cliente/Proveedor
								$where_0 = " AND  usuarios.nombre_usuarios LIKE '%$contenido%'   ";
								break;
							
						}
							
							
							
						$where_to  = $where .  $where_0 ;
							
							
						$resul = $where_to;
						
						//Conseguimos todos los usuarios con filtros
						$resultSet=$usuarios->getCondiciones($columnas ,$tablas ,$where_to, $id);
							
							
							
							
					}
				}
				
				if (isset ($_POST["Imprimir"])   )
     			{
     					
     				 
     				
     				//ContUsuariosReport.php
				   $this->ireport("ContUsuarios", "");
				   
				   exit();
				   
					
				}	
				
			}
			
			
			$this->view("UsuariosAnteriores",array(
					"resultSet"=>$resultSet, "resultRol"=>$resultRol, "resultEdit" =>$resultEdit, "resultEst"=>$resultEst,"resultMenu"=>$resultMenu
			
			));
			
			
			
			
			
			
		
		}
		else 
		{
			$this->view("ErrorSesion",array(
					"resultSet"=>""
		
			));
			
			
			
		}
		
	}
	
	public function InsertaUsuarios(){
		
		session_start();
		$resultado = null;
		$usuarios=new UsuariosModel();
		
		$id_usuario=$_SESSION['id_usuarios'];
	
		$nombre_controladores = "UsuariosAnteriores";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $usuarios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
		
		//_nombre_categorias character varying, _path_categorias character varying
		if (isset ($_POST["Guardar"]) )
		{

			
			$_nombre_usuario     = $_POST["nombre_usuarios"];
			$_id_rol             = $_POST["id_rol"];
		    $_id_estado          = $_POST["estados"];
		    
		    
	
			$funcion = "ins_usuarios_antiguos";
			
			$parametros = " '$_nombre_usuario' , '$_id_rol', '$_id_estado','$id_usuario'";
			$usuarios->setFuncion($funcion);
	
			$usuarios->setParametros($parametros);
	
	
			$resultado=$usuarios->Insert();
			
		}
		$this->redirect("UsuariosAnteriores", "index");
		
		}
		else
		{
		
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Insertar Usuarios Anteriores"
		
			));
		
		}
		
		
		
	}
	
	public function borrarId()
	{
		
		if(isset($_GET["id_usuarios"]))
		{
			$id_usuario=(int)$_GET["id_usuarios"];
	
			$usuarios=new UsuariosModel();
				
			$usuarios->deleteBy(" id_usuarios",$id_usuario);
				
			$traza=new TrazasModel();
			$_nombre_controlador = "Usuarios";
			$_accion_trazas  = "Borrar";
			$_parametros_trazas = $id_usuario;
			$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
		}
	
		$this->redirect("UsuariosAnteriores", "index");
	}
	
    
    
    	
}
?>
