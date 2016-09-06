
   <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Documentos - aDocument 2015</title>
        
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
		    	var juicios = $("#juicios").val();
		    	var detalle_documentos = $("#detalle_documentos").val();
		    	var observacion_documentos = $("#observacion_documentos").val();
		    	var avoco_vistos_documentos = $("#avoco_vistos_documentos").val();
		    	
		   				
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
		    	

				if (detalle_documentos == "")
		    	{
			    	
		    		$("#mensaje_detalle").text("Introduzca un Detalle");
		    		$("#mensaje_detalle").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_detalle").fadeOut("slow"); //Muestra mensaje de error
		            
				}if (observacion_documentos == "")
		    	{
			    	
		    		$("#mensaje_observacion").text("Introduzca una Observacion");
		    		$("#mensaje_observacion").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_observacion").fadeOut("slow"); //Muestra mensaje de error
		            
				}if (avoco_vistos_documentos == "")
		    	{
			    	
		    		$("#mensaje_avoco").text("Introduzca un Contenido");
		    		$("#mensaje_avoco").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_avoco").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
		    	

			
		    					    

			}); 


		 
				
				$( "#juicios" ).focus(function() {
					$("#mensaje_juicio").fadeOut("slow");
					});
					
					
						$( "#detalle_documentos" ).focus(function() {
							$("#mensaje_detalle").fadeOut("slow");
						});

							$( "#observacion_documentos" ).focus(function() {
								$("#mensaje_observacion").fadeOut("slow");
							});
								$( "#avoco_vistos_documentos" ).focus(function() {
									$("#mensaje_avoco").fadeOut("slow"); 			});
				
			
		
				
		
		      
				    
		}); 

	</script>
	 <script >
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
		}); 

	</script>
	
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
	
	  

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
       
       
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       
       	if(!empty($resulSet)){
       	$sel_juicios = $_POST['juicios'];
       	 }
       	 
       }
        
       if($_SERVER['REQUEST_METHOD']=='GET')
       {
       	
       	if(isset($_GET['dato']))
       	{
       	$a=stripslashes($_GET['dato']);
       	
       	$_dato=urldecode($a);
       	
       	$_dato=unserialize($a);
       	
       	$sel_juicios=$_dato['juicio'];
       	$sel_id_juicio=$_dato['id_juicio'];
       	$sel_detalle=$_dato['detalle'];
       	$sel_observacion=$_dato['observacion'];
       	$sel_avoco=$_dato['avoco'];
       	}
      
       }
        
       
       
       $habilitar="disabled";
       
       if(!empty($resulSet) || $sel_juicios!=""){
       	$habilitar="";
       }
       
		   
		?>
 
			  
			  <div class="container">
			  
			  <div class="row" style="background-color: #ffffff;" >
			  
			  <h4 ALIGN="center"></h4>
			 <div class="" style="margin-left:50px">	
				<BR>
            	
		    <h4 style="color:#ec971f;" ALIGN="center" >EMISIÓN Y APROBACIÓN DE DOCUMENTOS</h4>
		    
            	<br>
            	 
            	<div class="col-lg-11" style=" text-aling: justify;">
            	 	<p align = "justify"><center><b><font face="univers" size=2>***Esta Leyenda será incluída automaticamente por el sistema a las Providencias para los casos de Juicios anteriores a la gestión del nuevo Liquidador***</font></b></center></p>
					<p align = "justify"><font face="univers" size=1><b>NOTA DE DESCARGO:</b>  La información contenida en este mensaje y sus anexos tiene carácter confidencial,y está dirigida únicamente al destinatario de la misma y sólo podrá ser usada por éste. Si el lector de este mensaje no es el destinatario del mismo, se le notifica que cualquier copia o distribución de éste se encuentra totalmente prohibida. Si usted ha recibido este mensaje por error, por favor notifique inmediatamente al remitente por este mismo medio y borre el mensaje de su sistema. Las opiniones que contenga este mensaje son exclusivas de su autor y no necesariamente representan la opinión oficial del BANCO NACIONAL DE FOMENTO. Este mensaje ha sido examinado por Symantec y se considera libre de virus y spam.-</font></p>
			  	
			  </div>
			     <br>
			     <br>
			 </div>
    
     
     
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("Documentos","index"); ?>" method="post" enctype="multipart/form-data">
            
        <div class="col-lg-12" style="margin-top: 10px">
         
       	 <div class="panel panel-default">
  			<div class="panel-body">
  			
  			 <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
            
		    
		     <?php } } else {?>
  			
             <div class="col-xs-6 col-md-4" >
			  	<p  class="formulario-subtitulo" >Ciudad:</p>
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control" readonly >
					<?php foreach($resultDatos as $res) {?>
						 <option value="<?php echo $res->id_ciudad; ?>"  ><?php echo $res->nombre_ciudad; ?> </option>
			            <?php } ?>
				</select> 
			 </div>
			  
		    <div class="col-xs-6 col-md-4" >
			  <p  class="formulario-subtitulo" >Juicios:</p>
	          <input type="text" id="juicios" name="juicios" class="form-control" placeholder="Nº Juicio" value="<?php echo $sel_juicios;?>">
	         <input type="hidden" id="id_juicios" name="id_juicios" value="<?php if(!empty($resulSet)){ foreach ($resulSet as $res){
	         echo 	$res->id_juicios;
	         }}elseif ($sel_id_juicio!=""){echo $sel_id_juicio;}?>">
		   	<div id="mensaje_juicio" class="errores"></div>	   
		    </div>
			  
			  <div class="col-xs-12 col-md-3">
		     <p  class="formulario-subtitulo" >Validar:</p>
			  <input type="submit" id="Validar" name="Validar" value="Validar" onClick="Ok()" class="btn btn-warning"/>
			 </div>
			 <br>
			 <hr>
			 		        
		       <div class="col-xs-6 col-md-2" style="margin-top:10px">
			  	<p  class="formulario-subtitulo" >Estado Procesal:</p>
			  	 <select name="id_estados_procesales_juicios" id="id_estados_procesales_juicios"  class="form-control" readonly>
				 <?php foreach($resultEstPro as $res) {?>
						<option value="<?php echo $res->id_estados_procesales_juicios; ?>"  ><?php echo $res->nombre_estados_procesales_juicios; ?> </option>
			        <?php } ?>
				</select> 
				   
			  </div>
			  
			  <div class="col-xs-6 col-md-2" style="margin-top:10px">
			  <p  class="formulario-subtitulo" >Fecha de Providencia:</p>
			 <input type="text" id="fecha_emision_documentos" name="fecha_emision_documentos" value="<?php $sdate=date("d")."/".date("m")."/".date("Y"); $stime=date("h").":".date("i"); echo "$sdate";?>" class="form-control" <?php echo $habilitar;?>>
		   	   	<div id="mensaje_criterio" class="errores"></div>	   
		    </div>
  		    
  		     <div class="col-xs-6 col-md-2" style="margin-top:10px">
			  <p  class="formulario-subtitulo" >Hora de Providencia:</p>
	          <input type="text" id="hora_emision_documentos" name="hora_emision_documentos" class="form-control" value="<?php $sdate=date("d")."/".date("m")."/".date("Y"); $stime=date("h").":".date("i");  echo " $stime";?>" <?php echo $habilitar;?>>
		   	<div id="mensaje_criterio" class="errores"></div>	   
		    </div>
  		    
  		    <div class="col-xs-6 col-md-3" style="margin-top:10px">
			  <p  class="formulario-subtitulo" >Detalle:</p>
			  <input type="text" id="detalle_documentos" name="detalle_documentos" placeholder="Ingrese" class="form-control" value="<?php echo $sel_detalle;?>" <?php echo $habilitar;?>>
		   	   	<div id="mensaje_detalle" class="errores"></div>	   
		    </div>
  		    
  		    <div class="col-xs-6 col-md-3" style="margin-top:10px">
			  <p  class="formulario-subtitulo" >Observación:</p>
	          <input type="text" id="observacion_documentos" name="observacion_documentos" class="form-control" placeholder="Ingrese" value="<?php echo $sel_observacion; ?>" <?php echo $habilitar;?>>
		   	<div id="mensaje_observacion" class="errores"></div>	   
		    </div>
		    
		    <?php } ?>
		    
		    </div>
		    </div>
		    </div>
		    		
		<div class="col-xs-12 col-md-12" style="margin-top:10px">
		 <div class="form-group">
		       
	        <?php  include ("view/ckeditor/ckeditor.php");
			   $valor = "$sel_avoco";
			   $CKEditor = new CKEditor();
			   $config = array();
			   $config['toolbar'] = array(
			   	      array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
			   		  array( 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
			   	      array( 'TextColor','BGColor','-','NewPage','Maximize'),
			   		  array( 'NumberedList','BulletedList','-','Outdent','Indent','/'),
			   		  array( 'Styles','Format','Font','FontSize')
			   	  );
			  $CKEditor->basePatch = "./ckeditor/";
			   $CKEditor->editor("avoco_vistos_documentos",$valor,$config);
			   //$CKEditor->replaceAll();
	           ?> 
	           
	          
	          <!--  
	          <div class="col-xs-12 col-md-12" style="margin-top:10px">
		       
  				<label for="comment"><?php setlocale(LC_ALL,"es_ES");  echo strftime("%A %d de %B del %Y");?></label>
  				<textarea class="form-control" rows="8" id="avoco" name="avoco"  <?php echo $habilitar;?>><?php echo "Vistos: ".$sel_avoco;?></textarea>
  				<div id="mensaje_avoco" class="errores"></div>
			 
			  </div>
  			  -->
		    
     
			  
		      <div class="col-xs-12 col-md-6" style="text-align: center; margin-top:10px"  >
		      </div>
		       <div class="col-xs-12 col-md-3" style="text-align: center; margin-top:10px"  >
			  <input type="submit" id="Guardar" name="Guardar" onclick="this.form.action='<?php  echo $helper->url("Documentos","InsertaDocumentos"); ?>'" value="Guardar" class="btn btn-success" <?php echo $habilitar;?>/>
			  </div>
			   <div class="col-xs-12 col-md-3" style="text-align: center; margin-top:10px" >
			 <input type="submit" id="Visualizar" name="Visualizar" onclick="this.form.action='<?php echo $helper->url("Documentos","VisualizarDocumentos"); ?>'" value="Visualizar" class="btn btn-info" <?php echo $habilitar;?>/>
			 </div>
			 
			 <div class="col-xs-6 col-md-12" style="margin-top:50px">
			 </div>
		    
  			 
		</div>
		
		
		 
		</div>
		
	   </form>
       
      </div>
      </div>
     

     
   </body>  
 <?php include 'view/modulos/footer.php';?>
    </html>   