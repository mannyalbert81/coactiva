
   <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Avoco Conocimiento - Coactiva 2016</title>
        
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
		<link rel="stylesheet" href="view/css/themes/alertify.de43fault.css" />
		
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

		 <script>
		$(document).ready(function(){

		    // cada vez que se cambia el valor del combo
		    $("#Validar").click(function() 
			{
		    	var juicios = $("#juicios").val();
		   				
		    	if (juicios == "")
		    	{
			    	
		    		$("#mensaje_juicio").text("Introduzca un Juicio");
		    		$("#mensaje_juicio").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_juicio").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
			}); 

			$( "#juicios" ).focus(function() {
				$("#mensaje_juicio").fadeOut("slow");
			});

		}); 

	</script>

		<script>
		$(document).ready(function(){

		    // cada vez que se cambia el valor del combo
		    $("#Guardar").click(function() 
			{
		    	var id_secretario_reemplazo = $("#id_secretario_reemplazo").val();
		   				
		    	if (id_secretario_reemplazo == "")
		    	{
			    	
		    		$("#mensaje_re_secretario").text("Seleccione un Secretario");
		    		$("#mensaje_re_secretario").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_re_secretario").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
			}); 

			$( "#id_secretario_reemplazo" ).focus(function() {
				$("#mensaje_re_secretario").fadeOut("slow");
			});

		}); 

	</script>

	
	 <script>
	$(document).ready(function(){
		
		$("#id_ciudad").change(function(){

            // identificamos al ddl de secretario
           var $ddl_secretario = $("#id_secretario");
       	

            // tomamos parametros -> idCiudad
           var ddl_ciudad = $(this).val();

          //vaciamos el ddl para secretario y de impulsor
            $ddl_secretario.empty();
            var $ddl_impulsor = $("#id_impulsor");
            $ddl_impulsor.empty();

          
            if(ddl_ciudad != 0)
            {
            	
            	 var datos = {  
                    	 		ciudad:$(this).val()  
                    	 	 };
             
            	
         	   	$.post("<?php echo $helper->url("AvocoConocimiento","returnSecretariosbyciudad"); ?>", datos, function(resultado) {

         		 		$.each(resultado, function(index, value) {
            		 	    $ddl_secretario.append("<option value= " +value.id_usuarios +" >" + value.nombre_usuarios  + "</option>");	
                    		 });

         		 		 	 		   
         		  }, 'json');


            }
            else
            {
                
         	   $ddl_resultado.empty();

            }
		//alert("hola;");
		});

		
		});
	
	</script>
	

	
	
   
     
     

     
    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       
       
       <?php
       
       $sel_juicios = "";
       $sel_id_juicio="";
       $sel_detalle="";
       $sel_observacion="";
       $sel_avoco="";
       $sel_tipo_avoco="";
       $checked='checked="checked"';
       
       
       $datosGet=array();
       
       
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
        if(!empty($resulSet))
       	{
       
        $sel_juicios = $_POST['juicios'];
        
        }
        
       }
       
       if($_SERVER['REQUEST_METHOD']=='GET')
       {
       	
       	if(isset($_GET['dato']))
       	{
       	$a=stripslashes($_GET['dato']);
       	
       	$datosGet=urldecode($a);
       	
       	$datosGet=unserialize($a);
       	}
      
       }
        
       
       $habilitar="disabled";
       
       if(!empty($resulSet) || $sel_juicios!="" || !empty($datosGet)){
       	$habilitar="";
       }
		?>
 
			  
			  <div class="container">
			  
			  <div class="row" style="background-color: #ffffff;" >
			  
			  <h4 ALIGN="center"></h4>
			 <div class="" style="margin-left:50px">	
				<BR>
            	
		    <h4 style="color:#ec971f;" ALIGN="center" >EMISIÓN AVOCO DE CONOCIMIENTO</h4>
		   
            	<br>
            	 
            	<div class="col-lg-11" style=" text-aling: justify;">
            	 <p align="justify"><center><b><font face="univers" size=2>***Esta Leyenda será incluída automaticamente por el sistema a las Providencias para los casos de Juicios anteriores a la gestión del nuevo Liquidador***</font></b></center></p>
				</div>
			     <br>
			</div>
    
     
     
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("AvocoConocimiento","index"); ?>" method="post" enctype="multipart/form-data">
            
        <div class="col-lg-12" style="margin-top: 10px" >
         
       
		    </div>
			 <br>
			 
			 
			<div class="col-lg-12" style="margin-top: 10px; height:400px;"  >
			
			<div class="panel panel-default" >
  			<div class="panel-body" style="margin-bottom: 50px; margin-top: 40px;">
  			
  			 <div class="row">
  			 <h4 class="formulario-subtitulo"  style="text-align: center;" >Persona a Reemplazar</h4>
  			 
  			 <div class="col-xs-6 col-md-4" style="text-align: center;">
  			 <p  class="formulario-subtitulo" >-- Secretario e Impulsor --</p>
  			 <input type="submit" id="r_secretario_impulsor" name="r_secretario_impulsor"  value="Reemplazar"  onclick="this.form.action='<?php echo $helper->url("AvocoConocimiento","AvocoSecretarioImpulsor"); ?>'" class="btn btn-info" style="margin-top: 10px;"/>
		  </div>
  			 
  			 <div class="col-xs-6 col-md-4" style="text-align: center;">
  			 <p  class="formulario-subtitulo">-- Secretario --</p>
  			 <input type="submit" id="r_secretario" name="r_secretario"  value="Reemplazar"  onclick="this.form.action='<?php echo $helper->url("AvocoConocimiento","AvocoSecretario"); ?>'" class="btn btn-info" style="margin-top: 10px;"/>
		  </div>
  			 
  			 <div class="col-xs-6 col-md-4" style="text-align: center;">
  			 <p  class="formulario-subtitulo" >-- Impulsor --</p>
  			 <input type="submit" id="r_impulsor" name="r_impulsor"  value="Reemplazar"  onclick="this.form.action='<?php echo $helper->url("AvocoConocimiento","AvocoImpulsor"); ?>'" class="btn btn-info" style="margin-top: 10px;"/>
		  </div>
  			 
  			 </div>
  			
  			</div>
		    </div>
		
		
		    </div>
		   
	
		<br>
		<br>
		<br>
		
		</form>
		
	   
       
      </div>
      </div>
     
   </body>  
 <?php include 'view/modulos/footer.php';?>
    </html>   