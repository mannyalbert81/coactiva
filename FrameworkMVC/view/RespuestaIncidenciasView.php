
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
		
		
		
		<!-- TERMINA NOTIFICAIONES -->
		
		<!-- para el modal -->
  <!-- script generar respuesta -->
  
   <script>
      function contador (campo,limite) {
        var cuentacampo = $("#remLen");        
  		if (campo.value.length > limite) campo.value = campo.value.substring(0, limite);
  		else  var total = limite-campo.value.length; cuentacampo.val(total);
  		} 
    </script>
  
  <script type="text/javascript">
		
	function respuesta_incidencias(rowTabla){

		   var id_incidencia_modal = rowTabla.id;
		   var id_usuario = <?php echo $_SESSION['id_usuarios']; ?>;		        	
		        	
		   //console.log(id_incidencia_modal+'\n'+id_usuario);
		   
		     $('#modal_incidencia').dialog({
				                   autoOpen: false,
				                   modal: true,
				                   height: 500,
				                   width: 800,
				                   buttons: {
				      	"Enviar Respuesta": function() {

				      		var inputFileImage = document.getElementById("image_respuesta");
				      		var file = inputFileImage.files[0];
				      		var data = new FormData();
				      		data.append('image_respuesta',file);
				      		data.append('id_incidencia',id_incidencia_modal);
				      		data.append('descripcion_respuesta',$('#descripcion_respuesta').val());

					          var datos = { 
							        
			                    	 	 };
				                 
					                $.ajax({
				                           url:"<?php echo $helper->url("RespuestaIncidencias","enviarRespuesta");?>"
				                           ,type : "POST"
				                           ,async: true
				                           ,data : data
				                           ,contentType: false
				                           ,processData: false
				                           ,cache: false
				                           ,success: function(msg){

												var datos =JSON.parse(msg);
												console.log(datos);
				                        	   
					                           if(datos['ok'])
					                           {
					                        	//console.log('llego');
				                                $('#modal_incidencia').dialog('close');
				                                var header = "<?php echo $helper->url("RespuestaIncidencias","index"); ?>";
				                                window.location = header;
				                                //loading();
					                           }else
					                           {
					                            $('#modal_respuesta_incidencia').html ("<span style='color:red'>!datos no han sido actualizados..</span>"); 
							                   }
				                           }
				                   });
				                  
				                },
				                "Cancelar": function(){
				                   $('#modal_incidencia').dialog('close');
				                   $('#descripcion_respuesta').val('');
				                }
				            }    

				        }); 
		       
				       // $('#modal_incidencia').html (html);  
				       
				        $('#modal_incidencia').dialog('open');
					
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

    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
    
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
  
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("RespuestaIncidencias","index"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
         
         <!-- comienxza busqueda  -->
         <div class="col-lg-12" style="margin-top: 10px">
         
       	 <h4 style="color:#ec971f;">INCIDENCIAS</h4>
		 </div>
		 
		 
		 <div class="col-lg-12">
		 
		 <div class="col-lg-12">
		 <div class="col-lg-10"></div>
		 <div class="col-lg-2">
		 <span class="form-control"><strong>Registros:</strong><?php if(!empty($resultSet)) echo "  ".count($resultSet);?></span>
		 </div>
		 </div>
		 <div class="col-lg-12">
		 
		 
		 <section class="" style="height:300px;overflow-y:scroll;">
        <table class="table table-hover ">
	         <tr >
	            
				<th style="color:#456789;font-size:80%;"><b>Id</b></th>
	    		<th style="color:#456789;font-size:80%;">Descripcion</th>
	    		<th style="color:#456789;font-size:80%;">Usuario</th>
	    		<th style="color:#456789;font-size:80%;">Asunto</th>
	    		<th style="color:#456789;font-size:80%;">Fecha</th>
	    		<th style="color:#456789;font-size:80%;">Imagen</th>
	    	
	    		<th></th>
	  		</tr>
            
	            <?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
	        		<tr>
	        		
	        		  
	                   <td style="color:#000000;font-size:80%;"> <?php echo $res->id_incidencia; ?></td>
	                   <td style="color:#000000;font-size:80%;"> <?php echo $res->descripcion_incidencia; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->id_usuario; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->asunto_incidencia; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->creado; ?>     </td> 
		               <td style="color:#000000;font-size:80%;">
		                  <?php //$datoscuenta=$res->id_plan_cuentas.','.$res->codigo_plan_cuentas.','.$res->nombre_plan_cuentas; ?>
			              <a  title="<?php echo $res->id_usuario; ?>" id="<?php echo $res->id_incidencia; ?>"  href="javascript:null()" class="btn btn-warning" onclick="respuesta_incidencias(this);" style="font-size:85%;">Respuesta</a>
			           </td> 
		    		</tr>
		        <?php } }  ?>
           
       	</table>     
      </section>
      
      </div>
		 
		 		 
		 </div>
		 
		
		
      
       </form>
     
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
  
  <div id="modal_incidencia" style="display: none;">
  
    <h4 style='color:#ec971f;'>Respuesta Incidencia</h4><hr/>
    <div class = 'col-xs-12 col-md-6'>
	<div class='form-group'>
	<input type='hidden' class='form-control'  id='modal_respuesta_id' name='modal_respuesta_id' value=''  >
	<p  class="formulario-subtitulo" >Descripción:</p>
	<textarea  class="form-control" id="descripcion_respuesta" name="descripcion_respuesta" wrap="physical" rows="8"  onKeyDown="contador(this,400);" onKeyUp="contador(this,400);"></textarea>
	<p  class="formulario-subtitulo" >Te quedan <input type="text"  style="border:none; color:black;" id="remLen" name="remLen" size="2" maxlength="2" value="400" readonly="readonly"> letras por escribir. </p>
	</div>
	</div>
	<div class = 'col-xs-12 col-md-6'>
	<div class='form-group'>
	<label for='image_incidencia' class='control-label'>Seleccionar</label><br>
	<input type="file" id="image_respuesta" accept="image/*" name="image_respuesta" onchange="loadFile(event)" />
	</div>
	<div class='form-group'>
	<div><img class = 'col-xs-12 col-md-12'  id="output" /></div>
	</div>
	</div>	
	<div class='col-xs-12 col-md-12' id='modal_respuesta_incidencia'></div><br>			        
  	
  </div>  
   </body>  

    </html>   