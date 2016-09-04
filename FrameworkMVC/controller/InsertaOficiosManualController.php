<?php
class InsertaOficiosManualController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    //maycol
public function index(){
	
		session_start();
		
		$nombre_juicios ="";
		$id_juicios = "";
		$id_clientes = "";
		
	   $oficios = new OficiosModel();
	   
	   $entidades = new EntidadesModel();
	   $resultEnt = $entidades->getAll("nombre_entidades");
		
		
		if (isset(  $_SESSION['usuario_usuarios']) )
		{
			$datos=array();
			
			//NOTIFICACIONES
			$oficios->MostrarNotificaciones($_SESSION['id_usuarios']);
			
			$nombre_controladores = "Oficios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $oficios->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			
				
				$resultEdit = "";
				
				if(isset($_GET["juicio_referido_titulo_credito"]) && isset($_GET["nombres_clientes"])&& isset($_GET["id_juicios"]))
				{
					$oficios = new OficiosModel();
					
					$id_juicios = $_GET["id_juicios"];
					$nombre_juicios = $_GET["juicio_referido_titulo_credito"];
					$id_clientes = $_GET["nombres_clientes"];
				
					$datos=array("NombreJuicios"=>$nombre_juicios,"idClientes"=>$id_clientes,"idJuicios"=>$id_juicios);
					
				}
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Inserta Oficios Manual"
			
				));
				exit();
			
			}
			
			$this->view("InsertaOficiosManual",array(
					 "resultEdit"=>$resultEdit,"datos"=>$datos, "resultEnt"=>$resultEnt
			
			));
			
			
		}
		else 
		{
			$this->view("Error",array(
					"resultado"=>"Debe Iniciar Sesion"
		
			));
		}
		
	}
	
	
	public function InsertaOficiosManual(){
			
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
				$cuerpo="";
				$consecutivo= new ConsecutivosModel();
				$resultConsecutivo= $consecutivo->getBy("documento_consecutivos='OFICIOS'");
				$identificador=$resultConsecutivo[0]->real_consecutivos;
	
				$repositorio_documento="Oficios";
				$nombre_oficio=$repositorio_documento.$identificador;
	
				$_id_juicios = $_POST["id_juicios"];
				$_id_entidades = $_POST["id_entidades"];
				$_id_usuario_registra_oficios  = $_SESSION['id_usuarios'];
				$_cuerpo_oficios   = $cuerpo. $_POST["cuerpo_oficios"];
				$_oficio_manual  = "TRUE";
	
							$anio=date("Y");
							$col_prefijo="prefijos.id_prefijos,prefijos.nombre_prefijos,prefijos.consecutivo";
							$tbl_prefijo="public.prefijos";
							$whre_prefijo="prefijos.nombre_prefijos='OFI'";
	
							$resultprefijo=$oficios->getCondiciones($col_prefijo, $tbl_prefijo, $whre_prefijo, "prefijos.id_prefijos");
	
							$id_prefijo=$resultprefijo[0]->id_prefijos;
	
							$consecutivo_oficio=(int)$resultprefijo[0]->consecutivo;
							$consecutivo_oficio=$consecutivo_oficio+1;
							$numero_oficio="OFI"."-".$consecutivo_oficio."-".$anio;
	
	
							$funcion = "ins_oficios_manual";
							//parametros
							//, , , _,  ,  character varying,  character varying
							$parametros = "'$numero_oficio', '$_id_juicios', '$_id_entidades', '$_id_usuario_registra_oficios','$identificador','$nombre_oficio','$repositorio_documento', '$_cuerpo_oficios', '$_oficio_manual' ";
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
							
							
						$host  = $_SERVER['HTTP_HOST'];
						$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
							
						print "<script language='JavaScript'>
						setTimeout(window.open('http://$host$uri/view/ireports/ContOficiosCrearManualReport.php?identificador=$identificador&estado=$_estado&nombre=$nombre_oficio','Popup','height=300,width=400,scrollTo,resizable=1,scrollbars=1,location=0'), 5000);
						</script>";
	
						print("<script>window.location.replace('index.php?controller=Oficios&action=index');</script>");
	
	
			}
	
			//$this->redirect("Oficios", "index");
	
		}
		else
		{
			$this->view("Error",array(
						
					"resultado"=>"No tiene Permisos de Insertar Oficios"
	
			));
	
	
		}
	
	
	
	
	}
	
	
	public function VisualizarOficiosManual(){
		
		session_start();
		
		$cuerpo='';
			
		$oficios=new OficiosModel();
		$entidades=new EntidadesModel();
		
		$identificador="";
		$_estado="Visualizar";
		$dato=array();
		$arrayGet=array();
		
		if (isset($_POST["Visualizar"]))
		{
			
			$_id_juicios = $_POST["id_juicios"];
			$_nombre_juicios = $_POST["numero_juicios"];
			$_id_clientes = $_POST["nombre_clientes"];
			$_id_entidades   = $_POST["id_entidades"];
			$_id_usuario_registra_oficios  = $_SESSION['id_usuarios'];
			$_cuerpo_oficios   = $_POST["cuerpo_oficios"];
			
			
			$resultEnt=$entidades->getBy("id_entidades='$_id_entidades'");
             //traer datos para el reporte	
			$dato['cuerpo_oficios']=$cuerpo.$_cuerpo_oficios;
			$dato['entidades']=$resultEnt[0]->nombre_entidades;
		
			$traza=new TrazasModel();
			$_nombre_controlador = "Oficios";
			$_accion_trazas  = "Visualizar";
			$_parametros_trazas = $_id_juicios;
			$resultado = $traza->AuditoriaControladores($_accion_trazas, $_parametros_trazas, $_nombre_controlador);
			
			
			//cargar array q va por get
			$arrayGet['cuerpo']=$_cuerpo_oficios;
			$arrayGet['idJuicios']=$_id_juicios;
			$arrayGet['entidades']=$resultEnt[0]->nombre_entidades;
			$arrayGet['NombreJuicios']=$_nombre_juicios;
			$arrayGet['idClientes']=$_id_clientes;
		}
		

		$result=urlencode(serialize($dato));
		
		$resultArray=urlencode(serialize($arrayGet));
		
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		
		
        
		print "<script language='JavaScript'>
			 setTimeout(window.open('http://$host$uri/view/ireports/ContOficiosCrearManualReport.php?estado=$_estado&dato=$result','Popup','height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0'), 5000); 
		      </script>";
		
		print("<script>window.location.replace('index.php?controller=InsertaOficiosManual&action=index&dato=$resultArray');</script>");
		

	}
	
	
	
	
	public function verError(){
		$resultado=$_GET['dato'];
		$this->view("error", array('resultado'=>print_r($resultado)));
	}
	
	public function devuelveArray($dato)
	{
		$a=stripslashes($dato);
		
		$array=urldecode($a);
		
		$array=unserialize($a);
		
		return $array;
	}
	
	
	
}
?>
