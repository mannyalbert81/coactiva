 <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Consulta Cordinador - coactiva 2016</title>
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		  			   
          <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
		  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
        <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
        <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
 		
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
				alertify.success("Has Pulsado en Reporte"); 
				return false;
			}
			
			function Borrar(){
				alertify.success("Has Pulsado en Borrar"); 
				return false; 
			}

			function notificacion(){
				alertify.success("Has Pulsado en Buscar"); 
				return false; 
			}
		</script>
		
	
        
       <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }
                
            
        </style>
        
	<script>
	$(document).ready(function(){
			$("#fecha_hasta").change(function(){
				 var startDate = new Date($('#fecha_desde').val());

                 var endDate = new Date($('#fecha_hasta').val());

                 if (startDate > endDate){
 
                    $("#mensaje_fecha_hasta").text("Fecha desde no debe ser mayor ");
		    		$("#mensaje_fecha_hasta").fadeIn("slow"); //Muestra mensaje de error  
		    		$("#fecha_hasta").val("");

                        }
				});

			 $( "#fecha_hasta" ).focus(function() {
				  $("#mensaje_fecha_hasta").fadeOut("slow");
			   });
			});
        </script>
        
     <script>
	$(document).ready(function(){
		$("#id_secretario").change(function(){

            // obtenemos el combo de resultado combo 2
           var $ddl_impulsor = $("#id_impulsor");
       	

            // lo vaciamos
           var ddl_secretario = $(this).val();

          
          
            if(ddl_secretario != 0)
            {
            	 $ddl_impulsor.empty();
            	
            	 var datos = {
                   	   
           			   usuarios:$(this).val()
                  };
             
            	
         	   $.post("<?php echo $helper->url("ConsultaCordinador","Impulsor"); ?>", datos, function(resultado) {

          		  if(resultado.length==0)
          		   {
          				$ddl_impulsor.append("<option value='0' >--Sin Especificar--</option>");	
             	   }else{
             		    $ddl_impulsor.append("<option value='0' >--Selecione--</option>");
          		 		$.each(resultado, function(index, value) {
          		 			$ddl_impulsor.append("<option value= " +value.id_abogado +" >" + value.impulsores  + "</option>");	
                     		 });
             	   }	
            	      
         		  }, 'json');


            }
            
		//alert("hola;");
		});
        });
	
       

	</script>
   	
	<script>
	$(document).ready(function(){
		$("#id_ciudad").change(function(){

            // obtenemos el combo de resultado combo 2
           var $ddl_secretario = $("#id_secretario");
           var $ddl_impulsor = $("#id_impulsor");       	

            // lo vaciamos
           var ddl_ciudad = $(this).val();

          
           $ddl_secretario.empty();
           $ddl_impulsor.empty();

          
            if(ddl_ciudad != 0)
            {
            	
            	 var datos = {
                   	   
           			   ciudad:$(this).val()
                  };
             
            	


         	   $.post("<?php echo $helper->url("ConsultaCordinador","Secrtetarios"); ?>", datos, function(resultSecretario) {

         		  if(resultSecretario.length==0)
          		   {
          				$ddl_secretario.append("<option value='0' >--Sin Especificar--</option>");	
             	   }else{
             		  $ddl_secretario.append("<option value='0' >--Selecione--</option>");
         		 		$.each(resultSecretario, function(index, value) {
         		 			$ddl_secretario.append("<option value= " +value.id_usuarios +" >" + value.nombre_usuarios  + "</option>");	
                    		 });
             	   }

         		 		 	 		   
         		  }, 'json');

         	  
              	 var datos = {
                     	   
             			   id_ciudad:$(this).val()
                    };
               
              	
           	   $.post("<?php echo $helper->url("ConsultaCordinador","Impulsor"); ?>", datos, function(resultado) {

           		   if(resultado.length==0)
           		   {
           				$ddl_impulsor.append("<option value='0' >--Sin Especificar--</option>");	
              	   }else{
              		    $ddl_impulsor.append("<option value='0' >--Selecione--</option>");
           		 		$.each(resultado, function(index, value) {
           		 			$ddl_impulsor.append("<option value= " +value.id_usuarios +" >" + value.nombre_usuarios  + "</option>");	
                      		 });
              	   }

           		 		 	 		   
           		  }, 'json');



            }
            else
            {
                
              $ddl_secretario.append("<option value='0' >--Sin Especificar--</option>");
         	  $ddl_impulsor.append("<option value='0' >--Sin Especificar--</option>");

            }
		//alert("hola;");
		});
	});
		
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		$("#id_etapa_juicio").change(function(){

			 $("#id_impulsor").val(0);
			 $("#id_secretario").val(0); 
			 $("#id_ciudad").val(0);
			
			});
		});    
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		//load_juicios(1);

		$("#find").click(function(){

			load_juicios(1);
			
			});
	});

	
	function load_juicios(pagina){
		
		//iniciar variables
		 var con_etapa_juicio=$("#id_etapa_juicio").val();
		 var con_ciudad=$("#id_ciudad").val();
		 var con_secretario=$("#id_secretario").val();
		 var con_impulsor=$("#id_impulsor").val();
		 var con_identificacion=$("#identificacion").val();
		 var con_juicio=$("#numero_juicio").val();
		 var con_desde=$("#fecha_desde").val();
		 var con_hasta=$("#fecha_hasta").val();

		  var con_datos={
				  id_etapa_juicio:con_etapa_juicio,
				  id_ciudad:con_ciudad,
				  id_secretario:con_secretario,
				  id_impulsor:con_impulsor,
				  identificacion:con_identificacion,
				  numero_juicio:con_juicio,
				  fecha_desde:con_desde,
				  fecha_hasta:con_hasta,
				  action:'ajax',
				  page:pagina
				  };


		$("#juicios").fadeIn('slow');
		$.ajax({
			url:"<?php echo $helper->url("ConsultaCordinadorJuicios","cargaDatos");?>",
            type : "POST",
            async: true,			
			data: con_datos,
			 beforeSend: function(objeto){
			$("#juicios").html('<img src="view/images/ajax-loader.gif"> Cargando...');
			},
			success:function(data){
				$(".div_contable").html(data).fadeIn('slow');
				$("#juicios").html("");
			}
		})
	}
	
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		
		$("#reporte").click(function(){

			if (!$('#total_query').length){
				
				alert("Realice una Busqueda");
			    return false;
				}
			
			});
	});
	
	</script>

    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       <?php $array_documentos=array("auto_pago"=>'Auto de Pago',"avoco_conocimiento"=>'Avoco Conocimiento',"citaciones"=>'Citaciones',"oficios"=>'Oficios',"providencias"=>'Providencias');?>
       <?php $array_estado_doc=array("true"=>'Firmado',"false"=>'No Firmado');?>
       <?php //print_r($sql);?>
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
       
      <form action="<?php echo $helper->url("ConsultaCordinadorJuicios","_report"); ?>" method="post" enctype="multipart/form-data"  target="_blank" class="col-lg-12" id="cordinador_juicios">
         
         <!-- comienxza busqueda  -->
         <div class="col-lg-12" style="margin-top: 10px">
         
       	 <h4 style="color:#ec971f;">Consulta Cordinador</h4>
       	 
       	 
       	 <div class="panel panel-default">
  			<div class="panel-body">
  			
  			
		   <div class="row">
		   <div class="col-xs-2 ">
			   <p  class="formulario-subtitulo" >Etapa Juicio:</p>
			  
			   <select name="id_etapa_juicio" id="id_etapa_juicio"  class="form-control">
			   <option value="0">--Todos--</option>
			    <?php foreach ($result_etapa_juicio as $res){?>
			    <option value="<?php echo $res->id_estados_procesales_juicios; ?>"<?php echo ($res->id_estados_procesales_juicios==$sel_etapa_juicio)?'selected':'';?>><?php echo $res->nombre_estados_procesales_juicios;?></option>
			    <?php }?>
			   </select>
	      </div> 
	      
	     <div class="col-xs-2">
			  	<p  class="formulario-subtitulo" style="" >Juzgado:</p>
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control">
			  	<option value="0"  >--Seleccione--</option>
			  		<?php foreach($resultCiu as $res) {?>
						 <option value="<?php echo $res->id_ciudad; ?>" <?php if($sel_id_ciudad==$res->id_ciudad){echo "selected";}?>   ><?php echo $res->nombre_ciudad; ?> </option>
			            <?php } ?>
				</select>
		 </div>
		 
	      <div class="col-xs-2">
			  	<p  class="formulario-subtitulo" style="" >Secretarios:</p>
			  <select name="id_secretario" id="id_secretario"  class="form-control">
			  	<option value="0">--Sin Especificar--</option>
			    </select>
		 </div>
		   	
		  <div class="col-xs-2">
			  	<p  class="formulario-subtitulo" style="" >Impulsores:</p>
			  	<select name="id_impulsor" id="id_impulsor"  class="form-control">
			  	<option value="0">--Sin Especificar--</option>
			    </select>
		 </div>
		  		
		 <div class="col-xs-2 ">
			  	<p  class="formulario-subtitulo" >Identificacion:</p>
			  	<input type="text"  name="identificacion" id="identificacion" value="<?php echo $sel_identificacion;?>" class="form-control" placeholder="Ingrese"/> 
			    <div id="mensaje_identificacion" class="errores"></div>

         </div>
		 
		  <div class="col-xs-2 ">
			  	<p  class="formulario-subtitulo" >Nº Juicio:</p>
			  	<input type="text"  name="numero_juicio" id="numero_juicio" value="<?php echo $sel_numero_juicio;?>" class="form-control" placeholder="Ingrese"/> 
			    <div id="mensaje_juicio" class="errores"></div>

         </div>
        </div>
	     
	    <div class="row"> 
	              
         <div class="col-xs-2 ">
         		<p class="formulario-subtitulo" >Desde:</p>
			  	<input type="date"  name="fecha_desde" id="fecha_desde" value="<?php echo $sel_fecha_desde;?>" class="form-control " placeholder="Seleccione"/> 
			    <div id="mensaje_fecha_desde" class="errores"></div>
		</div>
         
        <div class="col-xs-2 ">
          		<p class="formulario-subtitulo" >Hasta:</p>
			  	<input type="date"  name="fecha_hasta" id="fecha_hasta" value="<?php echo $sel_fecha_hasta;?>" class="form-control " placeholder="Seleccione"/> 
			    <div id="mensaje_fecha_hasta" class="errores"></div>
		</div>
		 </div>
  			</div>
  		<div class="col-lg-12" style="text-align: center; margin-bottom: 20px">
		 <!-- <input type="submit" id="buscar" name="buscar" value="Buscar" onClick="notificacion(); this.form.action = '<?php  echo $helper->url("ConsultaCordinadorJuicios","index"); ?>'; this.form.target = '_self';" class="btn btn-warning " style="margin-top: 10px;"/> --> 
		 <input type="button" id="find" name="find" value="Buscar" class="btn btn-warning " style="margin-top: 10px;"/> 	
		 	
		 
		 <!-- <?php  echo $helper->url("ConsultaCordinadorJuicios","Reporte"); ?> -->
		 <input type="submit" name="reporte" id="reporte" value="Reporte" class="btn btn-success" style="margin-top: 10px;" />
		 <input type="hidden" name="data_report" id="data_report" value="<?php echo $where_sql['where_to']; ?>"/>
		 
		 
		 </div>
		</div>
		
		<div style="height: 200px; display: block;">
		
		 <h4 style="color:#ec971f;">Datos Juicios</h4>
			  <div >					
					<div id="juicios" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="div_contable" ></div><!-- Datos ajax Final -->
		      </div>
		       <br>
				  
		 </div>
        	
		 </div>
		 
		 <!-- para la paginacion en nueva tabla -->
		 
		 <!-- termina la paginacion -->
		
		 </form>
		 

 
         
 
   </div>

     
     
      </div>
 
      <!-- termina busqueda  -->
       
       
   </body>  

</html>   