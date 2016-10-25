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
       
      <form action="<?php echo $helper->url("ConsultaCordinadorJuicios","index"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
         
         <!-- comienxza busqueda  -->
         <div class="col-lg-12" style="margin-top: 10px">
         
       	 <h4 style="color:#ec971f;">Consulta Cordinador</h4>
       	 
       	 
       	 <div class="panel panel-default">
  			<div class="panel-body">
  			
  			
		   <div class="row">
		   <div class="col-xs-2 ">
			   <p  class="formulario-subtitulo" >Etapa Juicio:</p>
			  
			   <select name="id_etapa_juicio" id="id_etapa_juicio"  class="form-control">
			   <option value="0">--Seleccione--</option>
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
		 <input type="submit" id="buscar" name="buscar" value="Buscar" onClick="notificacion()" class="btn btn-warning " style="margin-top: 10px;"/> 	
		 
		 <?php if(!empty($resultJuicio))  {?>
		 
		  <a href="<?php echo $helper->url("ConsultaCordinadorJuicios","Reporte");?>" onclick=" window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false;" style="margin-top: 10px;" class="btn btn-success">Reporte</a>
		  <input type="hidden" name="data_report" id="data_report" value="<?php echo ?>"/>
		 
		  <?php } else {?>
		  
		  <?php } ?>
		 </div>
		</div>
        	
		 </div>
		 
		 
		 <div class="col-lg-12">
		
		 <section class="" style="height:300px;overflow-y:scroll;">
        
        	<table class="table table-hover ">
        	
 <?php if (!empty($resultJuicio)) {?>
               	<tr>
		        <span class="form-control"><strong>Registros:</strong><?php if(!empty($resultJuicio)) echo "  ".count($resultJuicio);?></span>
		        </tr>
                <tr >
	            <th style="color:#456789;font-size:80%;"><b>Id</b></th>
	            <th style="color:#456789;font-size:80%;">Estado Procesal</th>
	    		<th style="color:#456789;font-size:80%;">Nº Juicio Referido</th>
	    		<th style="color:#456789;font-size:80%;">Abogado</th>
	    		<th style="color:#456789;font-size:80%;">Identificacion</th>
	    		<th style="color:#456789;font-size:80%;">Cliente</th>
	    		<th style="color:#456789;font-size:80%;">Juzgado</th>
	    		<th style="color:#456789;font-size:80%;">N° Titulo Credito</th>
	    		<th style="color:#456789;font-size:80%;">Cuantia</th>
	    		<th style="color:#456789;font-size:80%;">Ultimo Pago</th>
	    		<th style="color:#456789;font-size:80%;">Observación</th>
	    		<th style="color:#456789;font-size:80%;">Estrategia</th>
	    		
	  		    </tr>
					
					
                 <?php		foreach($resultJuicio as $res) {   ?>
	          
               		<tr>
	        		   <td style="color:#000000;font-size:80%;"> <?php echo $res->id_juicios; ?></td>
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_estados_procesales_juicios; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->juicio_referido_titulo_credito; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->impulsores; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->identificacion_clientes; ?></td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombres_clientes; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_ciudad; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->numero_titulo_credito; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->total_total_titulo_credito; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->fecha_ultimo_abono_titulo_credito; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->observaciones_juicios; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->estrategia_juicios; ?>     </td> 
		               
		    		</tr>
		
		<?php } }else {?>
		    		
		    		
	         <tr >
	            <th style="color:#456789;font-size:80%;"><b>Id</b></th>
	            <th style="color:#456789;font-size:80%;">Estado Procesal</th>
	    		<th style="color:#456789;font-size:80%;">Nº Juicio Referido</th>
	    		<th style="color:#456789;font-size:80%;">Abogado</th>
	    		<th style="color:#456789;font-size:80%;">Identificacion</th>
	    		<th style="color:#456789;font-size:80%;">Cliente</th>
	    		<th style="color:#456789;font-size:80%;">Juzgado</th>
	    		<th style="color:#456789;font-size:80%;">N° Titulo Credito</th>
	    		<th style="color:#456789;font-size:80%;">Cuantia</th>
	    		<th style="color:#456789;font-size:80%;">Ultimo Pago</th>
	    		<th style="color:#456789;font-size:80%;">Observación</th>
	    		<th style="color:#456789;font-size:80%;">Estrategia</th>
	    		<th></th>
	    		<th></th>
	  		</tr>
		    		
		    		<tr>
	                  	<td></td>
            			<td></td>
            			<td></td>
            			<td colspan="6" style="color:#ec971f;font-size:8;" style="text-aling:center;"> <?php echo '<span id="snResult">NO EXISTE DATOS PARA LA BUSQUEDA REQUERIDA</span>' ?></td>
            			<td></td>
            			<td></td>
            			<td></td>
	       				
		   			</tr>
		    		
		    		<?php } ?>
               
       	</table>
       </section>
		</div>
		 </form>
		
<div class="text-center">	
  <ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>                       
 </div>
 </div>

     
     
      </div>
 
      <!-- termina
       busqueda  -->
   </body>  

    </html>   