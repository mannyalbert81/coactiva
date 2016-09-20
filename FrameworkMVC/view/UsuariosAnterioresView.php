<!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Usuarios Anteriores - coactiva 2016</title>
        
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
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Guardarrr").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var cedula_usuario = $("#cedula_usuarios").val();
		    	var nombre_usuario = $("#nombre_usuarios").val();
		    	var usuario_usuario = $("#usuario_usuarios").val();
		    	var clave_usuario = $("#clave_usuarios").val();
		    	var cclave_usuario = $("#cclave_usuarios").val();
		    	var celular_usuario = $("#celular_usuarios").val();
		    	var correo_usuario  = $("#correo_usuarios").val();
		    	var correo_usuario  = $("#correo_usuarios").val();
		    	
		    	
		    	if (cedula_usuario == "")
		    	{
			    	
		    		$("#mensaje_cedula").text("Introduzca una Cedula");
		    		$("#mensaje_cedula").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_cedula").fadeOut("slow"); //Muestra mensaje de error
		            
				}    
				
		    	if (nombre_usuario == "")
		    	{
			    	
		    		$("#mensaje_nombres").text("Introduzca un Nombre");
		    		$("#mensaje_nombres").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombres").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
		    	if (usuario_usuario == "")
		    	{
			    	
		    		$("#mensaje_usuario").text("Introduzca una Usuario");
		    		$("#mensaje_usuario").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_usuario").fadeOut("slow"); //Muestra mensaje de error
		            
				}   
						    	
				//la clave

		    	if (clave_usuario == "")
		    	{
		    		
		    		$("#mensaje_clave").text("Introduzca una Clave");
		    		$("#mensaje_clave").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_clave").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	

		    	if (cclave_usuario == "")
		    	{
		    		
		    		$("#mensaje_cclave").text("Introduzca una Clave");
		    		$("#mensaje_cclave").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_cclave").fadeOut("slow"); 
		            
				}
		    	
		    	if (clave_usuario != cclave_usuario)
		    	{
			    	
		    		$("#mensaje_cclave").text("Claves no Coinciden");
		    		$("#mensaje_cclave").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else
		    	{
		    		$("#mensaje_cclave").fadeOut("slow"); 
			        
		    	}	
				

				//los telefonos
		    	
		    	if (celular_usuario == "" )
		    	{
			    	
		    		$("#mensaje_celular").text("Ingrese un Celular");
		    		$("#mensaje_celular").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_celular").fadeOut("slow"); //Muestra mensaje de error
		            
				}

				// correos
				
		    	if (correo_usuario == "")
		    	{
			    	
		    		$("#mensaje_correo").text("Introduzca un correo");
		    		$("#mensaje_correo").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else if (regex.test($('#correo_usuario').val().trim()))
		    	{
		    		$("#mensaje_correo").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	else 
		    	{
		    		$("#mensaje_correo").text("Introduzca un correo Valido");
		    		$("#mensaje_correo").fadeIn("slow"); //Muestra mensaje de error
		            return false;	
			    }

		    	

		    					    

			}); 


		        $( "#cedula_usuarios" ).focus(function() {
				  $("#mensaje_cedula").fadeOut("slow");
			    });
				
				$( "#nombre_usuarios" ).focus(function() {
					$("#mensaje_nombres").fadeOut("slow");
    			});
				$( "#usuario_usuarios" ).focus(function() {
					$("#mensaje_usuario").fadeOut("slow");
    			});
    			
				$( "#clave_usuarios" ).focus(function() {
					$("#mensaje_clave").fadeOut("slow");
    			});
				$( "#cclave_usuarios" ).focus(function() {
					$("#mensaje_cclave").fadeOut("slow");
    			});
				
				$( "#celular_usuarios" ).focus(function() {
					$("#mensaje_celular").fadeOut("slow");
    			});
				
				$( "#correo_usuarios" ).focus(function() {
					$("#mensaje_correo").fadeOut("slow");
    			});
			
		
				
		      
				    
		}); 

	</script>
	

	
    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       
       
       <?php
       
     
		?>
 
  
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
      
      <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("UsuariosAnteriores","InsertaUsuarios"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-5">
            
         
        	    <h4 style="color:#ec971f;">Insertar Usuarios Anteriores</h4>
            	<hr/>
            	
		   		
            
          <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
            
            
            
         
			   
			   <div class="row">
		       <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Nombres Usuario</p>
			  	<input type="text"  name="nombre_usuarios" id="nombre_usuarios" value="<?php echo $resEdit->nombre_usuarios; ?>" class="form-control"/> 
			    <div id="mensaje_nombres" class="errores"></div>
			  </div>
			  
			   </div>
		    
		    
		    
		    <div class="row">
			  
			  
			  <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Roles</p>
			  	<select name="id_rol" id="id_rol"  class="form-control" >
					<?php foreach($resultRol as $resRol) {?>
					<option value="<?php echo $resRol->id_rol; ?>" <?php if ($resRol->id_rol == $resEdit->id_rol )  echo  ' selected="selected" '  ;  ?> ><?php echo $resRol->nombre_rol; ?> </option>
						            
						<?php } ?>
				</select> 
			  </div>
		      </div>
		      
		      <div class="row">
			    
			  <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Estados</p>
			  	<select name="estados" id="estados"  class="form-control" readonly>
					<?php foreach($resultEst as $resEst) {?>
						<option value="<?php echo $resEst->id_estado; ?>" <?php if ($resEst->id_estado == $resEdit->id_estado )  echo  ' selected="selected" '  ;  ?> ><?php echo $resEst->nombre_estado; ?> </option>
						           
			        <?php } ?>
				</select> 			  
			  </div>
		
			  </div>
			  
			 
		 <hr>
            
            
		     <?php } } else {?>
		    
		       
			   <div class="row">
		       <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Nombres Usuario</p>
			  	<input type="text"  name="nombre_usuarios" id="nombre_usuarios" value="" class="form-control"/> 
			    <div id="mensaje_nombres" class="errores"></div>
			  </div>
			   </div>
		    
		    
		    
		    <div class="row">
			  
			  <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Roles</p>
			  	<select name="id_rol" id="id_rol"  class="form-control" >
					<?php foreach($resultRol as $resRol) {?>
						<option value="<?php echo $resRol->id_rol; ?>"  ><?php echo $resRol->nombre_rol; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
		      </div>
		      
		      <div class="row">
			    
			  <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Estados</p>
			  	<select name="estados" id="estados"  class="form-control" readonly>
					<?php foreach($resultEst as $resEst) {?>
						<option value="<?php echo $resEst->id_estado; ?>"  ><?php echo $resEst->nombre_estado; ?> </option>
			        <?php } ?>
				</select> 			  
			  </div>
			  
			   
			  
			</div>
			
			<hr>
		    
		   
               	
		     <?php } ?>
		       <div class="row">
			  <div class="col-xs-12 col-md-12" style="text-align: center;" >
			  	<input type="submit" id="Guardar" name="Guardar" value="Guardar" onClick="Ok()" class="btn btn-success"/>
			  </div>
			</div>     
               
		
		 <hr>
          
          </form>
       
         <!-- termina el form -->
       
        <div class="col-lg-7">
            <h4 style="color:#ec971f;">Lista de Usuarios</h4>
           
     <!-- empieza formulario de busqueda -->
     
            <hr>
        <div class="row">
           <form action="<?php echo $helper->url("UsuariosAnteriores","index"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
           
           <div class="col-lg-4">
           <input type="text"  name="contenido" id="contenido" value="" class="form-control"/>
           <div id="mensaje_contenido" class="errores"></div>
            </div>
            
           <div class="col-lg-4">
           <select name="criterio" id="criterio"  class="form-control">
                                    <?php foreach($resultMenu as $val=>$desc) {?>
                                         <option value="<?php echo $val ?>" <?php //if ($resRol->id_rol == $resEdit->id_rol )  echo  ' selected="selected" '  ;  ?> ><?php echo $desc ?> </option>
                                    <?php } ?>
                                        
           </select>
           <div id="mensaje_criterio" class="errores"></div>
           </div>
          
           
          
           <div class="col-lg-2">
           <input type="submit" id="Buscar" name="Buscar" value="Buscar" class="btn btn-default"/>
           </div>
           
         
          </form>
          
       <!-- termina formulario de busqueda -->
        <hr/>
         
       <section class="col-lg-12  usuario" style="height:450px;overflow-y:scroll;">
        <table class="table table-hover ">
	         <tr >
	         
	    		<th style="color:#456789;font-size:80%;">Id</th>
	    		<th style="color:#456789;font-size:80%;">Nombre</th>
	    		<th style="color:#456789;font-size:80%;">Rol</th>
	    		<th style="color:#456789;font-size:80%;">Estado</th>
	    		<th></th>
	    		<th></th>
	  		</tr>
            
	            <?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
	        		<tr>
	        		   <td style="color:#000000;font-size:80%;"> <?php echo $res->id_usuarios; ?></td>
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_usuarios; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_rol; ?>  </td>
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_estado; ?>  </td>
		           	   <td>
			           		<div class="right">
			                    <a href="<?php echo $helper->url("UsuariosAnteriores","index"); ?>&id_usuarios=<?php echo $res->id_usuarios; ?>" class="btn btn-warning" onClick="notificacion()" style="font-size:65%;">Editar</a>
			                </div>
			            
			             </td>
			             <td>   
			                	<div class="right">
			                    <a href="<?php echo $helper->url("UsuariosAnteriores","borrarId"); ?>&id_usuarios=<?php echo $res->id_usuarios; ?>" class="btn btn-danger" onClick="Borrar()" style="font-size:65%;">Borrar</a>
			                </div>
			           </td>
		               
		    		</tr>
		        <?php } }else{ ?>
            <tr>
            <td></td>
            <td></td>
	                   <td colspan="5" style="color:#ec971f;font-size:8;"> <?php echo '<span id="snResult">No existen resultados</span>' ?></td>
	        <td></td>
		               
		    		</tr>
            <?php 
		}
            //echo "<script type='text/javascript'> alert('Hola')  ;</script>";
            
            ?>
            
       	</table>     
		     
      </section>
        
        </div>
       
       
      
      </div>
      </div>
   </div>
     </body>  
    </html>   