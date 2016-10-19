
   <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Citaciones - Coactiva 2016</title>
        
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
		
        
        
       <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }
                
            
        </style>
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
     
     <script >
	        $(document).ready(function() {
			
			var respuesta;

			//function to call inside ajax callback 
			function set_exists(x){
				respuesta = x;
			}
			
			$('#Guardar').click(function()
			{
				$("#msg_alert").hide();

				 var validarElementos=validarFields();
				 
				 if(validarElementos)
				 {
						 var selected = '';  
 
						
						var checkboxValues = "";
							
							$('input[type=checkbox]:checked').each(function() {
								checkboxValues += $(this).val() + ",";
								selected +=$(this)+' esta '+$(this).val()+', ';
							});
							
							checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);

			
						if (selected != '') 
						{

							
						 var datos = {
									   
									 id_juicio:checkboxValues,
									 id_tipo_citacion:$("#id_tipo_citaciones").val()
								};

								$.ajax({
									url: "<?php echo $helper->url("Citaciones","ValidarJuicioCitacion"); ?>",
									type: "POST",
									async: false, 
									data: datos,
									success: function(data){
										

										var result= data;
										var arrayJuicio=JSON.parse(data);

										if(result==0)
										{
											set_exists(true);
											 console.log('puede guardar datos');

											 $("#resultado_consulta").text('1');
											 
											 
										}else
										{
											set_exists(false);

											var juicio_referido=arrayJuicio[0].juicio_referido_titulo_credito;
											
											$("#resultado_consulta").text(juicio_referido);
											
										}
									}
								});
									
							
							
							
						}
						else{
						
							alert('Debes seleccionar un juicio.');
						   
							set_exists(false);
						}
				 
				 }
				
				    var juicio = $("#resultado_consulta").text();
					var citacion = $("#id_tipo_citaciones option:selected").text();

				   // alert(texto);

				   if(juicio=='1')
				   {
					   set_exists(true);
						  
				   }else if(juicio==0)
				   {
					   set_exists(false);
				   }else
				   {
					   $("#lbl_juicio").text(juicio);
					   $("#lbl_citacion").text(citacion);
					   $("#msg_alert").show();
					 
					   set_exists(false);
				  }
		
		      return respuesta;
		    }); 
			
			function validarFields()
			{
				var rpta=false;
				
				var fecha_citaciones= $("#fecha_citaciones").val();
		     	var nombre_persona_recibe_citaciones = $("#nombre_persona_recibe_citaciones").val();
		    	var relacion_cliente_citaciones = $("#relacion_cliente_citaciones").val();
		    	 	
		    		    	
		    	
		    	if (fecha_citaciones == "")
		    	{
			    	
		    		$("#mensaje_fecha").text("Introduzca una Fecha");
		    		$("#mensaje_fecha").fadeIn("slow"); //Muestra mensaje de error
		            rpta=false;
			    }
		    	else 
		    	{
		    		$("#mensaje_fecha").fadeOut("slow"); //Muestra mensaje de error
		            rpta=true;
				}    
				
		    	if (nombre_persona_recibe_citaciones == "")
		    	{
			    	
		    		$("#mensaje_recibe").text("Introduzca un Nombre");
		    		$("#mensaje_recibe").fadeIn("slow"); //Muestra mensaje de error
		            rpta=false;
		            
			    }
		    	else 
		    	{
		    		$("#mensaje_recibe").fadeOut("slow"); //Muestra mensaje de error
		            rpta=true;
				}
		    	
		    	if (relacion_cliente_citaciones == "")
		    	{
			    	
		    		$("#mensaje_relacion").text("Introduzca una Relacion con el Cliente");
		    		$("#mensaje_relacion").fadeIn("slow"); //Muestra mensaje de error
		           rpta=false;
		            
			    }
		    	else 
		    	{
		    		$("#mensaje_relacion").fadeOut("slow"); //Muestra mensaje de error
		            rpta=true;
				}
				
				return rpta;
			
			}
			
			$( "#fecha_citaciones" ).focus(function() {
				  $("#mensaje_fecha").fadeOut("slow");
			    });
				
			$( "#nombre_persona_recibe_citaciones" ).focus(function() {
					$("#mensaje_recibe").fadeOut("slow");
    			});
			$( "#relacion_cliente_citaciones" ).focus(function() {
					$("#mensaje_relacion").fadeOut("slow");
    			});
				
				
	
		});
		</script>
	
		


		
    </head>
    <body style="background-color: #d9e3e4;">
    <span id="resultado_consulta" style="display: none;">0</span>
     <div id="div_alert" class="alert alert-warning alert-dismissable" style="display: none">
			     <button type="button" class="close" data-dismiss="alert">&times;</button>
			     <span id="mostrar_resultado"></span>
     </div>
    
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       
       
       <?php
       
       $resultMenu=array(0=>"Todos",1=>"Identificacion",2=>"Juicio");
       $sel_id_ciudad="";
       $sel_fecha_citacion="";
       $sel_id_usuarios="";
       $sel_id_tipo_citaciones="";
       $sel_nombre_usuarios = "";
       
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       
       	$sel_id_ciudad=$_POST['id_ciudad'];
       	$sel_fecha_citacion=$_POST['fecha_citaciones'];
       	$sel_nombre_usuarios= $_POST['id_usuarioCitador'];
       	$sel_id_tipo_citaciones=$_POST['id_tipo_citaciones'];
       }
       
		   
		?>
 
  
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
  
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("Citaciones","InsertaCitaciones"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
            
         		
            <div class="col-lg-5">
            
            <h4 style="color:#ec971f;">Insertar Citaciones </h4>
            	<hr/>
          <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
            
		     <?php } } else {?>
		    <div class="row">
		    <div class="col-xs-6 col-md-6">
			  <p  class="formulario-subtitulo" >Fecha de Citacion </p>
	          <input type="date" id="fecha_citaciones" name="fecha_citaciones" class="form-control" value="<?php echo $sel_fecha_citacion;?>">
		   	<div id="mensaje_fecha" class="errores"></div>	   
		    </div>
            	
		   	<div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Juzgado</p>
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control" readonly>
					<?php foreach($resultCiu as $resCiu) {?>
						<option value="<?php echo $resCiu->id_ciudad; ?>" <?php if($sel_id_ciudad==$resCiu->id_ciudad){echo "selected";}?> ><?php echo $resCiu->nombre_ciudad; ?> </option>
				        <?php } ?>
				</select> 			  
			  </div>
			  </div>
			  
			  <div class="row">
			  <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Tipo Boleta</p>
			  	<select name="id_tipo_citaciones" id="id_tipo_citaciones"  class="form-control" >
					<?php foreach($resultTipoCit as $res) {?>
						<option value="<?php echo $res->id_tipo_citaciones; ?>" <?php if($sel_id_tipo_citaciones==$res->id_tipo_citaciones){echo "selected";}?> ><?php echo $res->nombre_tipo_citaciones; ?> </option>
			        <?php } ?>
				</select> 			  
			  </div>
			  
			  <div class="col-xs-6 col-md-6">
			  	<p  class="formulario-subtitulo" >Citador Judicial</p>
			  	<select name="id_usuarioCitador" id="id_usuarioCitador"  class="form-control" >
					
					<?php foreach($resultUsuarios as $res) {?>
						<option value="<?php echo $res->id_usuarios; ?>" <?php if($sel_nombre_usuarios==$res->id_usuarios){echo "selected";}?> ><?php echo $res->nombre_usuarios; ?> </option>
			        <?php } ?>
								
				</select> 			  
			  </div>
			  </div>
			  
			  <div class="row" >
		       <div class="col-xs-6 col-md-6" style="margin-top:20px;">
			  	<p  class="formulario-subtitulo" >Nombre Persona Recibe</p>
			  	<input type="text"  name="nombre_persona_recibe_citaciones" id="nombre_persona_recibe_citaciones" value="" class="form-control"/> 
			    <div id="mensaje_recibe" class="errores"></div>
			  </div>
			  
			   <div class="col-xs-6 col-md-6" style="margin-top:20px;">
			  	<p  class="formulario-subtitulo" >Relacion con Cliente</p>
			  	<input type="text"  name="relacion_cliente_citaciones" id="relacion_cliente_citaciones" value="" class="form-control"/> 
			    <div id="mensaje_relacion" class="errores"></div>
			  </div>
			 
			 <div id="msg_alert" class="col-xs-12 col-md-12" style="margin-top:20px; display: none;">
			  	<div class="alert alert-warning">
				    <strong>Warning!</strong> El juicio <span id="lbl_juicio">juicio</span> ya tiene la <span id="lbl_citacion">citacion</span>
				</div>
			  </div>
			 </div>
			 
			 
			 
			  
			  <hr>
		    	
		     <?php } ?>
		     
		       <div class="row">
			  <div class="col-xs-12 col-md-12" style="text-align: center;" >
			  	<input type="submit" id="Guardar" name="Guardar" value="Guardar"  class="btn btn-success"/>
			  </div>
			  <div class="col-xs-12 col-md-12">
			  <div id="mensaje_resultado" class="errores"><span>hola</span></div>
			  </div>
			</div>     
               
		
		 
          </div>
       
       
        <div class="col-lg-7">
            <h4 style="color:#ec971f;">Lista de Clientes - Titulo Credito</h4>
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
		
			  	<input type="submit" id="buscar" name="buscar"  onclick="this.form.action='<?php echo $helper->url("Citaciones","index"); ?>'" class="btn btn-info" value="Buscar" />
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
		           	    
		    		</tr>
		        <?php } } ?>
            
            <?php 
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