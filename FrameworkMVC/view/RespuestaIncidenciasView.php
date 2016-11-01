
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
  
  <script type="text/javascript">

  
				
	function respuesta_incidencias(rowTabla){

			  //id_respuesta_incidencia serial NOT NULL, //listo pgsql
			  //id_incidencia integer, //listo
			  //id_usuario_responde integer, //listo
			  //descripcion_respuesta_incidencia character varying(400),
			  //imagen_respuesta_incidencia bytea,
			  //creado timestamp with time zone, //listo en pgsql

		   var id_incidencia = rowTabla.id;
		   var id_usuario = <?php echo $_SESSION['id_usuarios']; ?>;		        	
		        	
		   //console.log(id_incidencia+'\n'+id_usuario);
		   
		     $('#modal_incidencia').dialog({
				                   autoOpen: false,
				                   modal: true,
				                   height: 450,
				                   width: 500,
				                   buttons: {
				      	"Actualizar": function() {

					          var datos = { 
							         id_entidad_p_cuentas:$('#id_entidad').val(),
							         id_p_cuentas:$('#modal_edit_id').val(),
			                    	 nombre_p_cuentas:$('#modal_edit_nombre').val(),
			                    	 codigo_p_cuentas:$('#modal_edit_codigo').val(),
			                    	 id_moneda_p_cuentas:$('#modal_edit_id_moneda').val(),
			                    	 n_p_cuentas:$('#modal_edit_naturaleza').val(),
			                    	 id_centro_c_p_cuentas:$('#modal_edit_id_centro_c').val()
			                    	 	 };
				                     //alert(datos['id_entidad_p_cuentas']);
				                     
				                 var nombre_edit= $('#modal_edit_nombre').val();
			                    
			                     if(nombre_edit!='')
			                     {
					                $.ajax({
				                           url:"<?php echo $helper->url("RespuestaIncidencias","enviarRespuesta");?>"
				                           ,type : "POST"
				                           ,async: true
				                           ,data : datos
				                           ,success: function(msg){

												var res = msg.split('"');
				                        	   
					                           if(res[1]=='1' || res[1]==1)
					                           {
				                                $('#modal_edit_cuenta').dialog('close');
				                                //loading();
					                           }else
					                           {
					                        	   $('#modal_respuesta_grupo').html ("<span style='color:red'>!datos no han sido actualizados..</span>"); 
							                     
					                           }
				                           }
				                   });
				                     
			                     }else
			                     {
			                    	 textFail("modal_edit_nombre");
			                         $('#modal_respuesta_edit').html ("<span style='color:red'>!Existen campos vacios..</span>"); 
			                           
			                     }                      
				   
				                },
				                "Cancelar": function(){
				                    $('#modal_incidencia').dialog('close');
				                }
				            }    

				        }); 

				        var  html = "";
				        html+="<h4 style='color:#ec971f;'>Respuesta Incidencia</h4><hr/>";
				        html+="<div class = 'col-xs-12 col-md-6'>";
				        html+="<div class='form-group'>";
				        html+="<label for='modal_edit_codigo' class='control-label'>Codigo</label><br>";
				        html+="<input type='text' class='form-control' id='modal_edit_codigo' name='modal_edit_codigo' value='' readonly >";
				        html+="</div>";
				        html+="</div><br>";	
			            html+="<div class = 'col-xs-12 col-md-6'>";
				        html+="<div class='form-group'>";
				        html+="<label for='modal_edit_nombre' class='control-label'>Nombre</label><br>";
				        html+="<input type='text' class='form-control' id='modal_edit_nombre' name='modal_edit_nombre' value='' onfocus='textSucces(this)' >";
				        html+="<input type='hidden' class='form-control'  id='modal_edit_id' name='modal_edit_id' value=''  >";
					    html+="</div>";
				        html+="</div>";				        
				        html+="<div class='col-xs-12 col-md-6'>";
				        html+="<div class='form-group'>";
				        html+="<label for='modal_edit_naturaleza' class='control-label'>Naturaleza</label>";
				        html+="<select name='modal_edit_naturaleza' id='modal_edit_naturaleza'  class='form-control' >";
				        html+="<?php if(!empty($n_plan_cuentas)){ foreach($n_plan_cuentas as $res=>$valor) {?>";
				        html+="<option value='<?php echo $res; ?>' ><?php echo $valor; ?> </option>";
						html+="<?php } }else{?>";
						html+="<option value='-1' >Sin registros</option>";
						html+="<?php }?>";
					    html+="</select>"; 
					    html+="<span class='help-block'></span>"; 
					    html+="</div>";
					    html+="</div>";
				        html+="<div class='col-xs-12 col-md-6'>";
				        html+="<div class='form-group'>";
				        html+="<label for='modal_edit_id_centro_c' class='control-label'>Centro Costos</label>";
				        html+="<select name='modal_edit_id_centro_c' id='modal_edit_id_centro_c'  class='form-control' >";
				        html+="<?php if(!empty($resultCentroC)){ foreach($resultCentroC as $res) {?>";
				        html+="<option value='<?php echo $res->id_centro_costos; ?>' ><?php echo $res->nombre_centro_costos; ?> </option>";
						html+="<?php } }else{?>";
						html+="<option value='-1' >Sin registros</option>";
						html+="<?php }?>";
					    html+="</select>"; 
					    html+="<span class='help-block'></span>"; 
					    html+="</div>";
					    html+="</div>";
					    html+="<div class='col-xs-12 col-md-6'>";
				        html+="<div class='form-group'>";
				        html+="<label for='modal_edit_id_moneda' class='control-label'>Moneda</label>";
				        html+="<select name='modal_edit_id_moneda' id='modal_edit_id_moneda'  class='form-control' >";
				        html+="<?php if(!empty($resultMoneda)){ foreach($resultMoneda as $res) {?>";
				        html+="<option value='<?php echo $res->id_monedas; ?>' ><?php echo $res->nombre_monedas; ?> </option>";
						html+="<?php } }else{?>";
						html+="<option value='-1' >Sin Grupos</option>";
						html+="<?php }?>";
					    html+="</select>"; 
					    html+="<span class='help-block'></span>"; 
					    html+="</div>";
					    html+="</div>";
					    html+="<div class='col-xs-12 col-md-12' id='modal_respuesta_edit'></div><br>";

					    				       
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
  
  <div id="modal_incidencia">
    <h4 style='color:#ec971f;'>Respuesta Incidencia</h4><hr/>
	<div class = 'col-xs-12 col-md-6'>
	<div class='form-group'>
	<label for='modal_edit_codigo' class='control-label'>Codigo</label><br>
	<input type='text' class='form-control' id='modal_edit_codigo' name='modal_edit_codigo' value='' readonly >
	</div>
	</div><br>	
	<div class = 'col-xs-12 col-md-6'>
	<div class='form-group'>
	<label for='modal_edit_nombre' class='control-label'>Nombre</label><br>
	<input type='text' class='form-control' id='modal_edit_nombre' name='modal_edit_nombre' value='' onfocus='textSucces(this)' >
	<input type='hidden' class='form-control'  id='modal_edit_id' name='modal_edit_id' value=''  >
	</div>
	</div>				        
	<div class='col-xs-12 col-md-6'>
	<div class='form-group'>
	<label for='modal_edit_naturaleza' class='control-label'>Naturaleza</label>
	<select name='modal_edit_naturaleza' id='modal_edit_naturaleza'  class='form-control' >
	<?php if(!empty($n_plan_cuentas)){ foreach($n_plan_cuentas as $res=>$valor) {?>
	<option value='<?php echo $res; ?>' ><?php echo $valor; ?> </option>
	<?php } }else{?>
	<option value='-1' >Sin registros</option>
	<?php }?>
	</select> 
	<span class='help-block'></span> 
	</div>
	</div>
	<div class='col-xs-12 col-md-6'>
	<div class='form-group'>
	<label for='modal_edit_id_centro_c' class='control-label'>Centro Costos</label>
	<select name='modal_edit_id_centro_c' id='modal_edit_id_centro_c'  class='form-control' >
	<?php if(!empty($resultCentroC)){ foreach($resultCentroC as $res) {?>
	<option value='<?php echo $res->id_centro_costos; ?>' ><?php echo $res->nombre_centro_costos; ?> </option>
	<?php } }else{?>
	<option value='-1' >Sin registros</option>
	<?php }?>
	</select> 
	<span class='help-block'></span> 
	</div>
	</div>
	<div class='col-xs-12 col-md-6'>
	<div class='form-group'>
	<label for='modal_edit_id_moneda' class='control-label'>Moneda</label>
	<select name='modal_edit_id_moneda' id='modal_edit_id_moneda'  class='form-control' >
	<?php if(!empty($resultMoneda)){ foreach($resultMoneda as $res) {?>
	<option value='<?php echo $res->id_monedas; ?>' ><?php echo $res->nombre_monedas; ?> </option>
	<?php } }else{?>
	<option value='-1' >Sin Grupos</option>
	<?php }?>
	</select>
	<span class='help-block'></span>
	</div>
	</div>
	<div class='col-xs-12 col-md-12' id='modal_respuesta_edit'></div><br>			        
  </div>  
   </body>  

    </html>   