
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
	
	<script>
	$(document).ready(function(){
		
		$("#id_secretario").change(function(){

            // identificamos al ddl de impulsor
           var $ddl_impulsor = $("#id_impulsor");
       	

            // tomamos parametros -> idSecretario
           var ddl_secretario = $(this).val();

          //vaciamos el ddl para secretario
            $ddl_impulsor.empty();

          
            if(ddl_secretario != 0)
            {
            	
            	 var datos = {  
                    	 		idSecretario:$(this).val()  
                    	 	 };
             
            	
         	   	$.post("<?php echo $helper->url("AvocoConocimiento","returnImpulsoresxSecretario"); ?>", datos, function(resultado) {

         		 		$.each(resultado, function(index, value) {
            		 	    $ddl_impulsor.append("<option value= " +value.id_abogado +" >" + value.impulsores  + "</option>");	
                    		 });

         		 		 	 		   
         		  }, 'json');


            }
            else
            {
                
         	   $ddl_impulsor.empty();

            }
		//alert("hola;");
		});

		
		});
	
	</script>
	
	
   
      <script >
	$(document).ready(function(){

		habilitarCb(true);		
		
		$("#div_con_garante").fadeIn();

		$("#con_garante").click(function(){

			habilitarCb(false);
			
			});
		$("#sin_garante").click(function(){

			habilitarCb(false);			
			
			});
		$("#secretario").click(function(){
			
			$('#id_impulsor_reemplazo').prop('disabled', true);
			$('#id_impulsor').prop('disabled', true);
			$('#id_secretario_reemplazo').prop('disabled', false);
			$('#id_secretario').prop('disabled', false);
			$('#id_ciudad').prop('disabled', true);
						
			});
		$("#impulsor").click(function(){

			$('#id_secretario_reemplazo').prop('disabled', true);
			$('#id_secretario').prop('disabled', true);
			$('#id_impulsor_reemplazo').prop('disabled', false);
			$('#id_impulsor').prop('disabled', false);
			$('#id_ciudad').prop('disabled', true);

			});
		
		$("#Guardar").click(function(){

			habilitarCb(false);

			$("#con_garante").prop('disabled', false);

			$("#sin_garante").prop('disabled', false);

			
		});
		

		
	});

	function habilitarCb(bool ){
		$('#id_secretario_reemplazo').prop('disabled', bool);
		$('#id_secretario').prop('disabled', bool);
		$('#id_impulsor_reemplazo').prop('disabled', bool);
		$('#id_impulsor').prop('disabled', bool);
		$('#id_ciudad').prop('disabled', bool);
	}
	
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
         
       	 <div class="panel panel-default">
  			<div class="panel-body">
			 <div class="col-xs-3 col-md-3" >
			   
		     </div>
		     
		     <div class="col-xs-4 col-md-4" style="text-align: center;" >
			  <input type="text" id="juicios" name="juicios" class="form-control" placeholder="Nº Juicio" value="<?php if (!empty($datosGet)){echo $datosGet['juicio'];}else { echo $sel_juicios;} ?>">
	        
	         <input type="hidden" id="id_juicios" name="id_juicios" value="<?php if(!empty($resulSet)){ foreach ($resulSet as $res){
	         echo 	$res->id_juicios;

	         }}elseif (!empty($datosGet)){echo $datosGet['id_juicio'];}?>">

		   	<div id="mensaje_juicio" class="errores"></div>	   
		    </div>
			  
			 
			  <div class="col-xs-5 col-md-5">
		    <input type="submit" id="Validar" name="Validar" value="Validar"  class="btn btn-warning"/>
			 </div>
			 </div>
		    </div>
		    </div>
			 <br>
			 
			 
			<div class="col-lg-12" style="margin-top: 10px" >
            <div class="panel panel-default">
  			<div class="panel-body">
  			
  			 <div class="row">
  			 <h4 class="formulario-subtitulo"  style="text-align: center;" >Tipo Avoco</h4>
  			 
  			 <div class="col-xs-6 col-md-6" style="text-align: center;">
  			 <p  class="formulario-subtitulo" >-- Con Garante --</p>
  			 <input type="radio" name="tipo_avoco" id="con_garante" value="con_garante" <?php echo $habilitar;?> <?php if (!empty($datosGet)){if($datosGet['tipoAvoco']=="con_garante"){echo $checked; }}?>/>
  			</div>
  			 
  			 <div class="col-xs-6 col-md-6" style="text-align: center;">
  			 <p  class="formulario-subtitulo">-- Sin Garante --</p>
  			 <input type="radio" name="tipo_avoco" id="sin_garante" value="sin_garante" <?php echo $habilitar;?> <?php if (!empty($datosGet)){if($datosGet['tipoAvoco']=="sin_garante"){echo $checked; }}?>/>
  			</div>
  			 <!-- 
  			 <div class="col-xs-3 col-md-3" style="text-align: center;">
  			 <p  class="formulario-subtitulo" >-- Solo Secretario --</p>
  			 <input type="radio" name="tipo_avoco" id="secretario" value="secretario" <?php echo $habilitar;?>/>
  			</div>
  			 
  			 <div class="col-xs-3 col-md-3" style="text-align: center;">
  			 <p  class="formulario-subtitulo">-- Solo Impulsor --</p>
  			 <input type="radio" name="tipo_avoco" id="impulsor" value="impulsor" <?php echo $habilitar;?>/>
  			</div>
  			 -->
  			 </div>
  			
  			</div>
		    </div>
		    </div>
			 
		 	   <div class="col-lg-12"  id="div_con_garante" style="display: none;">   
		 	  <div class="panel panel-default">
  			  <div class="panel-body"> 
		 	    
		 	     <div class="row">   
		       <div class="col-xs-6 col-md-3" >
			  	<p  class="formulario-subtitulo" >Secretario A Reemplazar:</p>
			  	 <select name="id_secretario_reemplazo" id="id_secretario_reemplazo"  class="form-control">
				     <?php if (!empty($datosGet)){ ?>
			  		<option value="<?php echo $datosGet['id_reemplazo']; ?>"  ><?php echo $datosGet['reemplazo']; ?> </option>
			  		<?php }else{ ?>
			  		<option value="0">--Seleccione--</option>
					<?php foreach($resulSecretario as $res) {?>
					 <option value="<?php echo $res->id_usuarios; ?>"  ><?php echo $res->nombre_usuarios; ?> </option>
			        <?php }} ?>
				</select> 
				<div id="mensaje_re_secretario" class="errores"></div>
				   
			  </div>
			  
			   <div class="col-xs-6 col-md-3" >
			  	<p  class="formulario-subtitulo" >Impulsor A Reemplazar:</p>
			  	 <select name="id_impulsor_reemplazo" id="id_impulsor_reemplazo"  class="form-control">
				     <?php if (!empty($datosGet)){ ?>
			  		<option value="<?php echo $datosGet['id_reemplazo1']; ?>"  ><?php echo $datosGet['reemplazo1']; ?> </option>
			  		<?php }else{ ?>
			  		<option value="0">--Seleccione--</option>
					<?php foreach($resulImpulsor as $res) {?>
					 <option value="<?php echo $res->id_usuarios; ?>"  ><?php echo $res->nombre_usuarios; ?> </option>
			        <?php }} ?>
				</select> 
				<div id="mensaje_re_secretario" class="errores"></div>
				   
			  </div>
			  
			  </div>
			  <br>
			
			  
			  <hr>
			   <div class="col-xs-6 col-md-4" >
			  	<p  class="formulario-subtitulo" >Juzgado:</p>
			  	
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control" >
			  		<?php if (!empty($datosGet)){ ?>
			  		<option value="<?php echo $datosGet['id_ciudad']; ?>"  ><?php echo $datosGet['ciudad']; ?> </option>
			  		<?php }else{ ?>
			  		<option value="0">--Seleccione--</option>
					<?php foreach($resultDatos as $res) {?>
					<option value="<?php echo $res->id_ciudad; ?>"  ><?php echo $res->nombre_ciudad; ?> </option>
					<?php }} ?>
				</select> 
			 </div>
			 	        
		       <div class="col-xs-6 col-md-3" >
			  	<p  class="formulario-subtitulo" >Secretario:</p>
			  	 <select name="id_secretario" id="id_secretario"  class="form-control">
			  	 
				 <?php if (!empty($datosGet)){ ?>
				 
			  		<option value="<?php echo $datosGet['id_secretario']; ?>"  ><?php echo $datosGet['secretario']; ?> </option>
			  	 
			  	 <?php }?>
				</select> 
				   
			  </div>
			  
			  <div class="col-xs-6 col-md-3">
			  	<p  class="formulario-subtitulo" >Impulsor:</p>
			  	 <select name="id_impulsor" id="id_impulsor"  class="form-control">
			   	 <?php if (!empty($datosGet)){ ?>
			  	 
			  		<option value="<?php echo $datosGet['id_impulsor']; ?>"  ><?php echo $datosGet['impulsor']; ?> </option>
			  	
			  	<?php } ?>
			     </select>
  		
		    </div>
		   
		</div>
		</div>
		</div>
		
		 
		<div class="col-xs-12 col-md-12" style="margin-top:10px">
		 <div class="form-group">
		     
		       <div class="col-xs-6 col-md-6" style="text-align: center; margin-top:10px"  >
			  <input type="submit" id="Guardar" name="Guardar" onclick="this.form.action='<?php  echo $helper->url("AvocoConocimiento","InsertaAvoco"); ?>'" value="Guardar" class="btn btn-success" />
			  </div>
			   <div class="col-xs-6 col-md-6" style="text-align: center; margin-top:10px" >
			 <input type="submit" id="Visualizar" name="Visualizar" onclick="this.form.action='<?php echo $helper->url("AvocoConocimiento","VisualizarAvoco"); ?>'" value="Visualizar" class="btn btn-info"/>
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