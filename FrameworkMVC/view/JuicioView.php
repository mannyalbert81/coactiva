<!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Seguimiento Juicio - coactiva 2016</title>
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		  			   
          <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
		  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
        <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
        <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
        <script src="view/css/Chart.js"></script>
 		
 		<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
 				
		<script>
		    webshims.setOptions('forms-ext', {types: 'date'});
			webshims.polyfill('forms forms-ext');
		</script>
		
           <!-- AQUI NOTIFICAIONES -->
		<script type="text/javascript" src="view/css/lib/alertify.js"></script>
		<link rel="stylesheet" href="view/css/themes/alertify.core.css" />
		<link rel="stylesheet" href="view/css/themes/alertify.default.css" />
		
		
		
		<script>

		function Ok(){
				alertify.success("Has Pulsado en Buscar"); 
				return false;
			}
			
			function Borrar(){
				alertify.success("Has Pulsado en Borrar"); 
				return false; 
			}

			function notificacion(){
				alertify.success("Has Pulsado en Editar"); 
				return false; 
			}
		</script>
		
		
		
		<!-- TERMINA NOTIFICAIONES -->
        
       <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }
                
            
        </style>
        
        <script type="text/javascript">
	$(document).ready(function(){
		//load_juicios(1);

		$("#find").click(function(){
			
			load_juicios(1);
			
			});
	});

	
	function load_juicios(pagina){
		
		//iniciar variables
		 var con_estado_procesal=$("#id_estado_procesal").val();
		 var con_identificacion=$("#identificacion").val();
		 var con_juicio=$("#numero_juicio").val();
		 var con_desde=$("#fecha_desde").val();
		 var con_hasta=$("#fecha_hasta").val();
		 var con_id_impulsor='';
		 if ( $("#id_impulsor").length > 0 ) {
			 con_id_impulsor=$("#id_impulsor").val();
			}

		  var con_datos={
				  id_estado_procesal:con_estado_procesal,
				  id_impulsor:con_id_impulsor,
				  identificacion:con_identificacion,
				  numero_juicio:con_juicio,
				  fecha_desde:con_desde,
				  fecha_hasta:con_hasta,
				  action:'ajax',
				  page:pagina
				  };


		$("#juicios").fadeIn('slow');
		$.ajax({
			url:"<?php echo $helper->url("Juicio","cargaDatos");?>",
            type : "POST",
            async: true,			
			data: con_datos,
			 beforeSend: function(objeto){
			$("#juicios").html('<img src="view/images/ajax-loader.gif"> Cargando...');
			},
			success:function(data){
				$("#juicios").html("");
				$(".div_juicios").html(data).fadeIn('slow');
			}
		})
	}
	
	</script>
    
    <script type="text/javascript">
    $(document).ready(function(){
		//load_juicios(1);

		$("#graficar_prueba").click(function(){

			//iniciar variables
			 var juicio_estado_procesal=$("#id_estado_procesal").val();
			 var juicio_identificacion=$("#identificacion").val();
			 var juicio_juicio=$("#numero_juicio").val();
			 var juicio_desde=$("#fecha_desde").val();
			 var juicio_hasta=$("#fecha_hasta").val();
			 var juicio_id_impulsor='';
			 if ( $("#id_impulsor").length > 0 ) {
				 juicio_id_impulsor=$("#id_impulsor").val();
				}
			var id=juicio_estado_procesal+','+juicio_id_impulsor;
			var date = juicio_desde+'+'+juicio_hasta;
			var text = juicio_juicio+'+'+juicio_identificacion;

			var url_garfico="<?php echo $helper->url("Juicio","GraficoEstadistico");?>"+"&id="+id+"&date="+date+"&text="+text;

			 window.open(url_garfico, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=700, height=500");

			//graficar_juicios();
			
			});
	});

    function getColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

	
	function graficar_juicios(){

		//iniciar variables
		 var gf_estado_procesal=$("#id_estado_procesal").val();
		 var gf_identificacion=$("#identificacion").val();
		 var gf_juicio=$("#numero_juicio").val();
		 var gf_desde=$("#fecha_desde").val();
		 var gf_hasta=$("#fecha_hasta").val();
		 var gf_id_impulsor='';
		 if ( $("#id_impulsor").length > 0 ) {
			 gf_id_impulsor=$("#id_impulsor").val();
			}
		var gf_id=gf_estado_procesal+','+gf_id_impulsor;
		var gf_date = gf_desde+'+'+gf_hasta;
		var gf_text = gf_juicio+'+'+gf_identificacion;
		var datos={
				id:gf_id,
				date:gf_date,
				text:gf_text
		};

		
		$.ajax({
			url:"<?php echo $helper->url("Juicio","datos_grafico");?>",
            type : "POST",
            async: true,			
			data: datos,
			datatype:"JSON",
			success:function(data){
				var resultSet =  $.parseJSON(data);//JSON.stringify()

				var array_titulos=new Array();
				var array_valores = {};
				var array_color = new Array();

				var letters = '0123456789ABCDEF'.split('');
				var color='#';
		        
				for(i=0;i<resultSet.length;i++)
				{
					array_titulos.push(resultSet[i].nombre_estados_procesales_juicios); //JSON.stringify(resultSet[i].nombre_estados_procesales_juicios);//"'"+resultSet[i].nombre_estados_procesales_juicios+"'";
					array_valores[i]=resultSet[i].juicios;
					for(j=0;j<6;j++)
					{
						color+=letters[Math.floor(Math.random() * 16)];
					}
					array_color.push(color);

					color='#';
				}

				//console.log(array_color.toString());
				var ChartData = {
						labels : array_titulos ,
						datasets : [
							{
								label: "Segumiento Juicios",
								fillColor : '#16B2F0',
								strokeColor : "rgba(220,220,220,0.8)",
								highlightFill: "rgba(220,220,220,0.75)",
								highlightStroke: "rgba(220,220,220,1)",
					            borderWidth: 1,
								data : array_valores
							}
						]						

					}

				
				var ctx = document.getElementById("canvas").getContext("2d");
				
						window.myBar = new Chart(ctx).Bar(ChartData, {
							responsive : true
						});
			}
		})
		
		
	}
    </script>
  
  
	<script type="text/javascript">
		$(function(){

		        $('#graficar').click(function(){

						
					$('#grafico_juicio').dialog({
				                            autoOpen: false,
				                            modal: true,
				                            height: 550,
				                            width: 700,
				                            buttons: {
				                
				                "Cerrar": function(){
				                    $('#grafico_juicio').dialog('close');
				                }
				            }    

				        }); 

					$("#grafico_juicio").html("").html('<canvas id="canvas" height="450" width="600" ></canvas>');
					
				        $('#grafico_juicio').dialog('open');
				        graficar_juicios();
										   
		        });

		        
		});
		
		</script>
    
    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       <?php
       $sel_id_ciudad = "";
       $sel_etapa_juicio ="";
       $sel_id_secretario = "";
       $sel_id_impulsor = "";
       $sel_identificacion="";
       $sel_numero_juicio="";
       $sel_estado_doc="";
      
       $sel_fecha_desde="";
       $sel_fecha_hasta="";
       
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       
       	$sel_id_ciudad = 			$_POST['id_ciudad'];
       	$sel_etapa_juicio = 		(isset($_POST['id_etapa_juicio']))?$_POST['id_etapa_juicio']:'';
       	$sel_estado_doc     = 		(isset($_POST['estado_documento']))?$_POST['estado_documento']:'';
       	$sel_id_secretario = 		$_POST['id_secretario'];
       	$sel_id_impulsor = 			$_POST['id_impulsor'];
       	$sel_identificacion=		$_POST['identificacion'];
       	$sel_numero_juicio=			$_POST['numero_juicio'];
      
       	$sel_fecha_desde=			$_POST['fecha_desde'];
       	$sel_fecha_hasta=			$_POST['fecha_hasta'];
       
       }
       ?>
 
  
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
  
    <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("Juicio","reporte"); ?>" method="post"  target="_blank" class="col-lg-12" id="cordinador_juicios">
         
         <!-- comienxza busqueda  -->
         <div class="col-lg-12" style="margin-top: 10px">
         
       	 <h4 style="color:#ec971f;">Seguimiento Juicio</h4>
       	 
       	 
       	 <div class="panel panel-default">
  			<div class="panel-body">
  			
  			
		   <div class="row">
		   <div class="col-xs-4 col-md-3">
			   <p  class="formulario-subtitulo" >Etapa Juicio:</p>
			  
			   <select name="id_estado_procesal" id="id_estado_procesal"  class="form-control">
			   <option value="0">--Todos--</option>
			    <?php foreach ($result_etapa_juicio as $res){?>
			    <option value="<?php echo $res->id_estados_procesales_juicios; ?>"<?php echo ($res->id_estados_procesales_juicios==$sel_etapa_juicio)?'selected':'';?>><?php echo $res->nombre_estados_procesales_juicios;?></option>
			    <?php }?>
			   </select>
	      </div> 
	      
	      <?php if(!empty($resultRol)&&$resultRol[0]->nombre_rol=='SECRETARIO'&&!empty($resultImpulsor)){?>
	      <div class="col-xs-4 col-md-3">
			   <p  class="formulario-subtitulo" >Ab. Impulsor:</p>			  
			   <select name="id_impulsor" id="id_impulsor"  class="form-control">
			   <option value="0">--Todos--</option>
			    <?php foreach ($resultImpulsor as $res){?>
			    <option value="<?php echo $res->id_abogado; ?>"><?php echo $res->impulsores;?></option>
			    <?php }?>
			   </select>
	      </div> 
	      <?php }?>
	      
		 <div class="col-xs-4 col-md-3">
			  	<p  class="formulario-subtitulo" >Identificacion:</p>
			  	<input type="text"  name="identificacion" id="identificacion" value="<?php echo $sel_identificacion;?>" class="form-control" placeholder="Ingrese"/> 
			    <div id="mensaje_identificacion" class="errores"></div>

         </div>
		 
		  <div class="col-xs-4 col-md-3">
			  	<p  class="formulario-subtitulo" >Nº Juicio:</p>
			  	<input type="text"  name="numero_juicio" id="numero_juicio" value="<?php echo $sel_numero_juicio;?>" class="form-control" placeholder="Ingrese"/> 
			    <div id="mensaje_juicio" class="errores"></div>

         </div>
         
         <div class="col-xs-4  col-md-3">
         		<p class="formulario-subtitulo" >Desde:</p>
			  	<input type="date"  name="fecha_desde" id="fecha_desde" value="<?php echo $sel_fecha_desde;?>" class="form-control " placeholder="Seleccione"/> 
			    <div id="mensaje_fecha_desde" class="errores"></div>
		</div>
		
		<div class="col-xs-4 col-md-3">
          		<p class="formulario-subtitulo" >Hasta:</p>
			  	<input type="date"  name="fecha_hasta" id="fecha_hasta" value="<?php echo $sel_fecha_hasta;?>" class="form-control " placeholder="Seleccione"/> 
			    <div id="mensaje_fecha_hasta" class="errores"></div>
		</div>
		
        </div>
	     
         
         
        
		</div>
		 
  		<div class="col-lg-12" style="text-align: center; margin-bottom: 20px">
		 <!-- <input type="submit" id="buscar" name="buscar" value="Buscar" onClick="notificacion(); this.form.action = '<?php  echo $helper->url("ConsultaCordinadorJuicios","index"); ?>'; this.form.target = '_self';" class="btn btn-warning " style="margin-top: 10px;"/> --> 
		 <input type="button" id="find" name="find" value="Buscar" class="btn btn-warning " style="margin-top: 10px;"/> 	
		 <input type="button" id="graficar" name="graficar" value="Ver Grafico" class="btn btn-info " style="margin-top: 10px;"/> 	
		 		 
		 <!-- <?php  echo $helper->url("ConsultaCordinadorJuicios","Reporte"); ?> -->
		 <!-- para los reportes -->
		 <!-- <input type="submit" name="reporte" id="reporte" value="Reporte" class="btn btn-success" style="margin-top: 10px;" />
		 <input type="hidden" name="data_report" id="data_report" value="<?php echo $where_sql['where_to']; ?>"/>
		  --><!--termina-> para los reportes -->
		 
		 </div>
		 <!--para visualizar grafico -->
		 <div id="grafico_juicio"  style="width: 50%; display: none;">
			<canvas id="canvas" height="450" width="600"></canvas>
		</div>
		<!--termina-> grafico -->
		
		</div>
		
		<div style="display: block;">
		
		 <h4 style="color:#ec971f;">Datos Juicios</h4>
			  <div >					
					<div id="juicios" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="div_juicios" ></div><!-- Datos ajax Final -->
		      </div>
		       <br>
				  
		 </div>
		 
		 
        	
		 </div>
		 
		 <!-- para la paginacion en nueva tabla -->
		 
		 <!-- termina la paginacion -->
		
		 </form>
  
  
    </div>
   </div>
     </body>  
    </html>   