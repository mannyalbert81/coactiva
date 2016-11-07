
   <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Incidencias - coactiva 2016</title>
        
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
         
         <script >
		$(document).ready(function(){

		    // cada vez que se cambia el valor del combo
		    $("#Guardar").click(function() 
			{
		   
		    	var nombre_ciudad = $("#nombre_ciudad").val();
		    
		   				
		    	if (nombre_ciudad == "")
		    	{
			    	
		    		$("#mensaje_nombres").text("Introduzca una ciudad ");
		    		$("#mensaje_nombres").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombres").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
		    	

			
		    					    

			}); 


		 
				
				$( "#nombre_ciudad" ).focus(function() {
					$("#mensaje_nombres").fadeOut("slow");
    			});
				
			
		
				
		
		      
				    
		}); 

	</script>
	
	
	
     
      <script>
      function contador (campo, cuentacampo, limite) {
  		if (campo.value.length > limite) campo.value = campo.value.substring(0, limite);
  		else cuentacampo.value = limite - campo.value.length;
  		} 
    </script>

    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       
       
       <?php
       
       $sel_id_usuarios="";
       
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       	$sel_id_usuarios = $_POST['id_usuarios'];
       }
        
		   
		?>
 
  
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
  
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("Incidencias","InsertaIncidencias"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
            
	    <h4 style="color:#ec971f;">Generar Incidencias</h4>
            	<hr/>
            <div class="col-lg-6">
			 <div class="row">
		     <div class="col-xs-6 col-md-6">
			    <p  class="formulario-subtitulo" style="" >Usuario:</p>
			  	<select name="id_usuario" id="id_usuario"  class="form-control" readonly>
			    <option value="<?php echo $_SESSION['id_usuarios'];  ?>" <?php if($sel_id_usuarios==$_SESSION['id_usuarios']){echo "selected";}?>  ><?php echo $_SESSION['nombre_usuarios'];  ?></option>  
			    </select>
		     </div>
			 </div>
			 
			 <div class="row">
		     <div class="col-xs-6 col-md-6"  style="margin-top: 10px">
			    <p  class="formulario-subtitulo" style="" >Asunto:</p>
			  	<input type="text" name="asunto_incidencia" id="asunto_incidencia" maxlength="30" class="form-control" value=""/>
		     </div>
			 </div>

		    <div class="row">
		    <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Descripción:</p>
	          	<textarea  class="form-control" id="descripcion_incidencia" name="descripcion_incidencia" wrap="physical" rows="8"  onKeyDown="contador(this.form.descripcion_incidencia,this.form.remLen,400);" onKeyUp="contador(this.form.descripcion_incidencia,this.form.remLen,400);"></textarea>
	          	<p  class="formulario-subtitulo" >Te quedan <input type="text"  style="border:none; color:black;" name="remLen" size="2" maxlength="2" value="400" readonly="readonly"> letras por escribir. </p>
	        		   
		     </div>
			 </div>
			 
			  <div class="col-lg-12">
		      <div class="row">
			  <div class="col-xs-12" style="text-align: center; margin-top:10px" >
			  <input type="submit" id="Enviar" name="Enviar" value="Enviar" onClick="Ok()" class="btn btn-info"/>
			  </div>
			  </div> 
			  </div> 
		    </div>
		    
		    
		     <div class="col-lg-6">
		     <div class="row">
		     <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Seleccionar:</p>
			  	<input type="file" id="image_incidencia" accept="image/*" name="image_incidencia[]" onchange="loadFile(event)" multiple/>
	          </div>
		    <div class="col-xs-12 col-md-12" style="height: 300px;">
			  	<p  class="formulario-subtitulo" >Archivos:</p>
	          	<div><img id="output" height="350px" width="450px"/></div>
	         </div>
	         
			 </div>
		    </div>
		    
		    <script>
		    var loadFile = function(event) {
		        var reader = new FileReader();
		        reader.onload = function(){
		          var output = document.getElementById('output');
		          output.src = reader.result;
		        };
		        reader.readAsDataURL(event.target.files[0]);
		      };
            </script>
		 
		      
            
		 <br>
		 <br>
		 <br>
		 <br>
          
       </form>
     </div>
      </div>
   </body>  

    </html>   