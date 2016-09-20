
   <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Oficios - Coactiva 2016</title>
        
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
				alertify.success("Has Pulsado en Guardar"); 
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
         
         <script >
		$(document).ready(function(){

		    // cada vez que se cambia el valor del combo
		    $("#Guardar").click(function() 
			{
		   
		    	var nombre_oficios= $("#nombre_oficios").val();
		    
		   				
		    	if (nombre_oficios == "")
		    	{
			    	
		    		$("#mensaje_nombres").text("Introduzca Información para el Oficio");
		    		$("#mensaje_nombres").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombres").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
			}); 

				
				$( "#nombre_oficios" ).focus(function() {
					$("#mensaje_nombres").fadeOut("slow");
    			});
				
			 
				    
		}); 

	</script>
	
	<script>
    $(document).ready(function(){
        $("#marcar_todo").change(function () {
            if ($(this).is(':checked')) {
               
                $(".marcados").prop('checked', true); 
            } else {
                
                $("input:checkbox").prop('checked', false);
                $("input[type=checkbox]").prop('checked', false);
            }
        });
        });
    </script>
    
    <script >
	$(document).ready(function() {
		
		$('#Guardar').click(function(){
	        var selected = '';  
	          
	        $('.marcados').each(function(){
	            if (this.checked) {
	                selected +=$(this)+' esta '+$(this).val()+', ';
	            }
	        }); 
	       
	        if (selected != '') {
	            return true;
	        }
	        else{
	            alert('Debes seleccionar un juicio.');
	            return false;
	        }

	      
	    }); 

	});
	</script>

<script >
	$(document).ready(function() {
		
		$('#Guardar1').click(function(){
	        var selected1 = '';  
	          
	        $('.marcados').each(function(){
	            if (this.checked) {
	                selected1 +=$(this)+' esta '+$(this).val()+', ';
	            }
	        }); 
	       
	        if (selected1 != '') {
	            return true;
	        }
	        else{
	            alert('Debes seleccionar un juicio.');
	            return false;
	        }

	      
	    }); 

	});
	</script>
	
	
	
	
	      <script>
       $(document).ready(function(){

    	   $("#id_entidades").prop("disabled","disabled");
    	   $("#Guardar").prop("disabled","disabled");
    	   $("#Guardar1").prop("disabled","disabled");
 

            $(".marcados").click(function(){

            	var cant = $("input:checked").length;
            	
                if(cant!=0)
                {
            	 $("#id_entidades").prop("disabled","");
          	     $("#Guardar").prop("disabled","");
          	   $("#Guardar1").prop("disabled","");
                }else
                    {
                	  $("#id_entidades").prop("disabled","disabled");
               	      $("#Guardar").prop("disabled","disabled");
               	   $("#Guardar1").prop("disabled","disabled");
                    }
                
                });
 	 });
       </script>
       
        <script >
    $(document).ready(function(){
        
        $("#marcar_todo").change(function () {
            if ($(this).is(':checked')) {
               
                $(".marcados").prop('checked', true); 
               
         	    $("#id_entidades").prop("disabled","");
         	   $("#Guardar").prop("disabled","");
         	   $("#Guardar1").prop("disabled","");
               

                
            } else {
                
                $("input:checkbox").prop('checked', false);
                $("input[type=checkbox]").prop('checked', false);
                $("#id_entidades").prop("disabled","disabled");
         	   $("#Guardar").prop("disabled","disabled");
         	   $("#Guardar1").prop("disabled","disabled");
               
               
            }
        });
        });
	</script>

    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       
       
       <?php
       
       $resultMenu=array(0=>"Todos",1=>"Identificacion",2=>"Juicio");
       
        
		?>
 
  
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
  
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("Oficios","InsertaOficios"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
            
               
        	    
            	
		   		
            <div class="col-lg-5">
            
            <h4 style="color:#ec971f;">Insertar Oficios </h4>
            	<hr/>
          <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
            
		     <?php } } else {?>
		     	 <div class="panel panel-default">
  			<div class="panel-body">
		    <br>
		    <br>
		    <br>
		    <br>
		    <br>
		     <br>
			  <div class="row">
			  <div class="col-xs-12 col-md-12" style="text-align: center; ">
			  	<p  class="formulario-subtitulo" >Entidad:</p>
			  	<select name="id_entidades" id="id_entidades"  class="form-control" >
					<?php foreach($resultEnt as $res) {?>
						<option value="<?php echo $res->id_entidades; ?>"  ><?php echo $res->nombre_entidades; ?> </option>
			        <?php } ?>
				</select> 			  
			  </div>
			  </div>
			  <br>
			  <br>
			  <br>
			  <br>
			  </div>
			  </div>
			   
			  <hr>
		    
		   
               	
		     <?php } ?>
		     
		     
		       <div class="row">
			  <div class="col-xs-12 col-md-12" style="text-align: center;" >
			  	<input type="submit" id="Guardar" name="Guardar" value="Generar" onClick="Ok()" class="btn btn-success"/>
			  </div>
			  
			</div>     
               
		
		 <hr>
          </div>
       
       
        <div class="col-lg-7">
            <h4 style="color:#ec971f;">Lista de Clientes - Jucios</h4>
            <hr/>
            <div class="col-xs-3">
			
           <input type="text"  name="contenido_busqueda" id="contenido_busqueda" value="" class="form-control"/>
           <div id="mensaje_contenido_busqueda" class="errores"></div>
            </div>
            
           <div class="col-xs-3">
           <select name="criterio_busqueda" id="criterio_busqueda"  class="form-control">
                                    <?php foreach($resultMenu as $val=>$desc) {?>
                                         <option value="<?php echo $val ?>" <?php //if ($resRol->id_rol == $resEdit->id_rol )  echo  ' selected="selected" '  ;  ?> ><?php echo $desc ?> </option>
                                    <?php } ?>
                                        
           </select>
           <div id="mensaje_criterio" class="errores"></div>
           </div>
           
           <div class="col-xs-2" >
		
			  	<input type="submit" id="buscar" name="buscar"  onclick="this.form.action='<?php echo $helper->url("Oficios","index"); ?>'" value="buscar" class="btn btn-info"/>
			</div>
			
			
			<div class="col-lg-4">
		 <span class="form-control" style="margin-bottom:0px;"><strong>Registros:</strong><?php if(!empty($resultDatos)) echo "  ".count($resultDatos);?></span>
		 </div>
		
	
	<div class="col-xs-12">
        
        <section class="col-lg-12 usuario" style="height:400px;overflow-y:scroll;">
        <table class="table table-hover ">
	         <tr >
	            <th style="color:#456789;font-size:80%;"></th>
	    		<th style="color:#456789;font-size:80%;"><b>N° Titulo Credito</b></th>
	    		<th style="color:#456789;font-size:80%;">N° Juicio</th>
	    		<th style="color:#456789;font-size:80%;">CI</th>
	    		<th style="color:#456789;font-size:80%;">Nombre Cliente</th>
	    		<th style="color:#456789;font-size:80%;">Impulsor</th>
	    		
	    		
	    		
	    		<th></th>
	    		<th></th>
	  		</tr>
            
	            <?php if (!empty($resultDatos)) {  foreach($resultDatos as $res) {?>
	        		<tr>
	        		<th style="color:#456789;font-size:80%;"><input type="checkbox" id="id_juicios[]"   name="id_juicios[]"  value="<?php echo $res->id_juicios; ?>" class="marcados"></th>
	                   <td style="color:#000000;font-size:80%;"> <?php echo $res->numero_titulo_credito; ?></td>
	                   <td style="color:#000000;font-size:80%;"> <?php echo $res->juicio_referido_titulo_credito; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->identificacion_clientes; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombres_clientes; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_usuarios; ?>     </td> 
		              <!-- 
		               <td style="color:#000000;font-size:80%;">
		               <a href="<?php echo $helper->url("InsertaOficiosManual","index"); ?>&id_juicios=<?php echo $res->id_juicios; ?>&juicio_referido_titulo_credito=<?php echo $res->juicio_referido_titulo_credito; ?>&nombres_clientes=<?php echo $res->nombres_clientes; ?>" class="btn btn-warning" onClick="notificacion()" style="font-size:85%;">Generar Oficio Manual</a>
			           </td>
		               -->
		           	   
			            
		    		</tr>
		        <?php } } ?>
            
            <?php 
            
            //echo "<script type='text/javascript'> alert('Hola')  ;</script>";
            
            ?>
            
       	</table>     
      </section>
      </div>
      </div>
      <br>
      <br>
       <br>
      
      
       </form>
       <!-- termina el form --> 
      </div>
      </div>
     
   </body>  

    </html>   