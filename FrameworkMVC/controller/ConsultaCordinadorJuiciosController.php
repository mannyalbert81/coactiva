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
					
					$where_sql=array("where_to"=>$where_to);
					
				}
				

				$this->view("ConsultaCordinadorJuicios",array(
						"resultCiu"=>$resultCiu,"result_etapa_juicio"=>$result_etapa_juicio,"resultJuicio"=>$resultJuicio,
						"where_sql"=>$where_sql
							
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
	
	public function Reporte()
	{
		$sql=array();
		if(isset($_POST['data_report']))
		{
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
			
			$where=$_POST['data_report'];
			
			$consulta='SELECT '.$columnas.' FROM '.$from.' WHERE '.$where;
			
			$sql=array("sql"=>$consulta);
			
			$this->ireport_vizualizar ( "CordinadorReport",array (
					"sql" => $sql ) );
		}
	}
	
	public  function _report()
	{
		session_start();
		
		
		$juicios = new JuiciosModel();
		
		if (isset(  $_SESSION['usuario_usuarios']) )
		{	
			//variables de envio
			$resultJuicio=array();
			$where_sql=array();
			
			$permisos_rol = new PermisosRolesModel();
			$nombre_controladores = "ConsultaCordinador";
			$id_rol= $_SESSION['id_rol'];				
			
			$resultPer = $juicios->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
			if (!empty($resultPer))
			{
					
				if(isset($_POST["reporte"])&&isset($_POST["total_query"]))
				{
		
					$id_etapa_juicio  = (isset($_POST['id_etapa_juicio']))?$_POST['id_etapa_juicio']:'';
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
					
					$consulta='SELECT '.$columnas.' FROM '.$from.' WHERE '.$where_to;
						
					$sql=array("sql"=>$consulta);
						
					$this->ireport_vizualizar ( "CordinadorReport",array (
							"sql" => $sql ) );
					
						
				}else 
				{
					$this->view("Error",array(
							
							"resultado"=>"No hay Datos a mostrar"
					
					));
				}
				
		
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
	
	//para la paginacion con ajax (Jquery)
	public function prueba()
	{
		
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
		
		$juicios = new JuiciosModel();
		
		$id_etapa_juicio=(isset($_POST['id_etapa_juicio']))?$_POST['id_etapa_juicio']:'';
		$id_ciudad        = (isset($_POST['id_ciudad']))?$_POST['id_ciudad']:0;
		$id_secretario    = (isset($_POST['id_secretario']))?$_POST['id_secretario']:0;
		$id_impulsor      = (isset($_POST['id_impulsor']))?$_POST['id_impulsor']:0;
		$identificacion   = (isset($_POST['identificacion']))?$_POST['identificacion']:'';
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
		$where_7="";
			
		$where_1=($id_etapa_juicio!=0)?" AND estados_procesales_juicios.id_estados_procesales_juicios='$id_etapa_juicio'":'';
		$where_2=($id_secretario!=0)?" AND asignacion_secretarios_view.id_secretario='$id_secretario'":'';
		$where_3=($id_impulsor!=0)?" AND asignacion_secretarios_view.id_abogado='$id_impulsor'":'';
		$where_4=($id_ciudad!=0)?" AND ciudad.id_ciudad='$id_ciudad'":'';
		$where_5=($identificacion!="")?" AND clientes.identificacion_clientes='$identificacion'":'';
		$where_6=($numero_juicio!=0)?" AND juicios.juicio_referido_titulo_credito='$numero_juicio'":'';		
		if($fechadesde!="" && $fechahasta!=""){$where_7=" AND  juicios.creado BETWEEN '$fechadesde' AND '$fechahasta'";}
			
			
		$where_to=$where.$where_1.$where_2.$where_3.$where_4.$where_5.$where_6.$where_7;		
		
		
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
	
}
?> 