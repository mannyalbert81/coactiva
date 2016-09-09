 <!DOCTYPE HTML>
<html lang="es">

      <head>
      
        <meta charset="utf-8"/>
        <title>Actualiza Etapas Juicios - coactiva 2016</title>
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		  			   
          <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
		  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
		
		
		<link type="text/css" rel="stylesheet" href="view/css/modal.css" />
		<script type="text/javascript" src="jquery-1.2.3.min.js"></script>
		<script type="text/javascript" src="view/css/modal.js"></script>
		
		
		
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
       
       
 
 
    
    </head>
    <body style="background-color: #d9e3e4;">
    
       <?php include("view/modulos/modal.php"); ?>
       <?php include("view/modulos/head.php"); ?>
       <?php include("view/modulos/menu.php"); ?>
       
       <?php
     
       $sel_id_ciudad = "";
       $sel_identificacion="";
       $sel_numero_juicio="";
       $sel_numero_titulo="";
       $sel_fecha_desde="";
       $sel_fecha_hasta="";
    
       
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       
       
       	$sel_id_ciudad = $_POST['id_ciudad'];
       	$sel_identificacion=$_POST['identificacion'];
       	$sel_numero_juicio=$_POST['numero_juicio'];
       	$sel_numero_titulo=$_POST['numero_titulo'];
       	$sel_fecha_desde=$_POST['fecha_desde'];
       	$sel_fecha_hasta=$_POST['fecha_hasta'];

       }
       
       $habilitar="disabled";
       if(!empty($resultEdit)){
       	$habilitar="";
       }
		?>
 
  
  <div class="container">
  
  <div class="row" style="background-color: #ffffff;">
  
       <!-- empieza el form --> 
       
      <form action="<?php echo $helper->url("EtapasJuicios","consulta_juicios"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12">
         
         <!-- comienxza busqueda  -->
         <div class="col-lg-12" style="margin-top: 10px">
         
       	 <h4 style="color:#ec971f;">Actualiza Etapas Juicios</h4>
       	 
       	 
       	 <div class="panel panel-default">
  			<div class="panel-body">
  			
  			
		   			
          <div class="col-xs-2">
			  	<p  class="formulario-subtitulo" style="" >Ciudad:</p>
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control" readonly>
			  		<?php foreach($resultDatos as $res) {?>
						 <option value="<?php echo $res->id_ciudad; ?>" <?php if($sel_id_ciudad==$res->id_ciudad){echo "selected";}?>   ><?php echo $res->nombre_ciudad; ?> </option>
			            <?php } ?>
				</select>
		 </div>
		 
		 <div class="col-xs-2 ">
			  	<p  class="formulario-subtitulo" >Identificacion:</p>
			  	<input type="text"  name="identificacion" id="identificacion" value="<?php echo $sel_identificacion;?>" class="form-control"/> 
			    <div id="mensaje_identificacion" class="errores"></div>

         </div>
		 
		  <div class="col-xs-2 ">
			  	<p  class="formulario-subtitulo" >Nº Juicio:</p>
			  	<input type="text"  name="numero_juicio" id="numero_juicio" value="<?php echo $sel_numero_juicio;?>" class="form-control"/> 
			    <div id="mensaje_nombres" class="errores"></div>

         </div>
          <div class="col-xs-2 ">
			  	<p  class="formulario-subtitulo" >Nº Titulo:</p>
			  	<input type="text"  name="numero_titulo" id="numero_titulo" value="<?php echo $sel_numero_titulo;?>" class="form-control"/> 
			    <div id="mensaje_numero_titulo" class="errores"></div>

         </div>
         
         <div class="col-xs-2 ">
         		<p class="formulario-subtitulo" >Desde:</p>
			  	<input type="date"  name="fecha_desde" id="fecha_desde" value="<?php echo $sel_fecha_desde;?>" class="form-control "/> 
			    <div id="mensaje_fecha_desde" class="errores"></div>
		</div>
         
          <div class="col-xs-2 ">
          		<p class="formulario-subtitulo" >Hasta:</p>
			  	<input type="date"  name="fecha_hasta" id="fecha_hasta" value="<?php echo $sel_fecha_hasta;?>" class="form-control "/> 
			    <div id="mensaje_fecha_hasta" class="errores"></div>
		</div>
		
  		
  		<div class="col-lg-12" style="text-align: center; margin-bottom: 10px">
		 <input type="submit" id="buscar" name="buscar" value="Buscar" class="btn btn-warning " onClick="notificacion()" style="margin-top: 10px;"/> 	
		
		<?php if(!empty($resultSet))  {?>
		 <a href="/FrameworkMVC/view/ireports/ContJuiciosReport.php?id_ciudad=<?php  echo $sel_id_ciudad ?>&identificacion=<?php  echo $sel_identificacion?>&numero_juicio=<?php  echo $sel_numero_juicio?>&numero_titulo=<?php  echo $sel_numero_titulo?>&fecha_desde=<?php  echo $sel_fecha_desde?>&fecha_hasta=<?php  echo $sel_fecha_hasta?>" onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false" style="margin-top: 10px;" class="btn btn-success">Reporte</a>
		  <?php } else {?>
		  <?php } ?>
		 </div>
		</div>
        	</div>	
		
		 
		 </div>
			 
			 
		<?php if(!empty($resultSet))  {?>	 
		 <div class="col-lg-12">
		 
		 <div class="col-lg-12">
		 <div class="col-lg-10"></div>
		 <div class="col-lg-2">
		 <span class="form-control"><strong>Registros:</strong><?php if(!empty($resultSet)) echo "  ".count($resultSet);?></span>
		 </div>
		 </div>
		 <div class="col-lg-12">
		 
		 
		 <section class="" style="height:200px;overflow-y:scroll;">
        <table class="table table-hover ">
	         <tr >
	            <th style="color:#456789;font-size:80%;"><b>Id</b></th>
	    		<th style="color:#456789;font-size:80%;">Coactivad@</th>
	    		<th style="color:#456789;font-size:80%;">Identificacion</th>
	    		<th style="color:#456789;font-size:80%;">Ciudad</th>
	    	<th style="color:#456789;font-size:80%;">Nº Juicio</th>
	    		<th style="color:#456789;font-size:80%;">Nº Titulo Credito</th>
	    		<th style="color:#456789;font-size:80%;">Impulsor</th>
	    		<th style="color:#456789;font-size:80%;">Secretario</th>
	    		<th style="color:#456789;font-size:80%;">Etapa</th>
	    		<th style="color:#456789;font-size:80%;">Tipo Juicio</th>
	    		<th style="color:#456789;font-size:80%;">Total</th>
	    		<th></th>
	    		<th></th>
	  		</tr>
            
	            <?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
	        		<tr>
	        	       <td style="color:#000000;font-size:80%;"> <?php echo $res->id_juicios; ?></td>
	                   <td style="color:#000000;font-size:80%;"> <?php echo $res->nombres_clientes; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->identificacion_clientes; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_ciudad; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->juicio_referido_titulo_credito; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->numero_titulo_credito; ?>     </td>
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->impulsores; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->secretarios; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_etapas; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->nombre_tipo_juicios; ?>     </td> 
		               <td style="color:#000000;font-size:80%;"> <?php echo $res->total_total_titulo_credito; ?>     </td> 
		               <td>
			           		<div class="right">
			           			<a href="/FrameworkMVC/view/ireports/ContJuiciosSubReport.php?id_juicios=<?php echo $res->id_juicios; ?>" onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false" class="btn btn-success" onClick="Ok()" style="font-size:70%;">Ver</a>
		             		</div>
			            
			          </td>  
			          <td>
			           		<div class="right">
			                    <a href="<?php echo $helper->url("EtapasJuicios","consulta_juicios"); ?>&id_juicios=<?php echo $res->id_juicios; ?>" class="btn btn-warning" onClick="notificacion()" style="font-size:75%;">--Seleccionar--</a>
			                </div>
			            
			             </td>
		    		</tr>
		        <?php } }  ?>
              
       	</table>     
        </section>
      
       
	     </div>
		</div>
		 <?php } else {?>
		  
		  <?php } ?> 
		
		
		<br>
		<br>
	
		
		 <div class="col-lg-12">
		
  		
  		<?php if (!empty($resultEdit) ) { foreach($resultEdit as $resEdit) {?>
            
          <div class="col-lg-8">
		     <div class="panel panel-default">
  			<div class="panel-body">
  			
  			<h4 style="color:#ec971f; text-align: center;" >Datos del Cliente</h4>
  			<hr>
		    <div class="row">
		    
		    <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Tipo Identificacion</p>
			  	<select name="id_tipo_identificacion" id="id_tipo_identificacion"  class="form-control" readonly>
					<?php foreach($resultTipoIdent as $resTipoIdent) {?>
					<option value="<?php echo $resTipoIdent->id_tipo_identificacion; ?>"  <?php if ($resTipoIdent->id_tipo_identificacion == $resEdit->id_tipo_identificacion ) echo ' selected="selected" '  ; ?> ><?php echo $resTipoIdent->nombre_tipo_identificacion; ?> </option>
						   <?php } ?>
				</select> 
			  </div>
		    
		    <div class="col-xs-8 col-md-8">
			  	<p  class="formulario-subtitulo" >Nombres Cliente</p>
			  	<input type="text" name="nombres_clientes" id="nombres_clientes" value="<?php echo $resEdit->nombres_clientes; ?>" class="form-control" readonly/>
			   </div>
			  
			   </div>
			   
			   
		    <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >TelÃ©fono</p>
			  	<input type="text" name="telefono_clientes" id="telefono_clientes" value="<?php echo $resEdit->telefono_clientes; ?>" class="form-control" readonly/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Celular </p>
			  	<input type="text" name="celular_clientes" id="celular_clientes" value="<?php echo $resEdit->celular_clientes; ?>" class="form-control" readonly/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Ciudad</p>
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control" readonly>
					<?php foreach($resultCiu as $res) {?>
						<option value="<?php echo $res->id_ciudad; ?>" <?php if ($res->id_ciudad == $resEdit->id_ciudad ) echo ' selected="selected" '  ; ?>  ><?php echo $res->nombre_ciudad; ?> </option>
						
			        <?php } ?>
				</select> 
			    </div>
		    </div>
		    
		     <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Tipo Persona</p>
			  	<select name="id_tipo_persona" id="id_tipo_persona"  class="form-control" readonly>
					<?php foreach($resultTipoPer as $res) {?>
						<option value="<?php echo $res->id_tipo_persona; ?>"  <?php if ($res->id_tipo_persona == $resEdit->id_tipo_persona ) echo ' selected="selected" '  ; ?>  ><?php echo $res->nombre_tipo_persona; ?> </option>
						
			        <?php } ?>
				</select> 
			  </div>
			  <div class="col-xs-8 col-md-8">
			  	<p  class="formulario-subtitulo" >DirecciÃ³n</p>
			  	<input type="text" name="direccion_clientes" id="direccion_clientes" value="<?php echo $resEdit->direccion_clientes; ?>" class="form-control" readonly/>
			  </div>
			  
		    </div>
		    
		    
			  
			  </div>
		    </div> 
          </div> 
          
          <div class="col-lg-4">
		     
		     <div class="panel panel-default">
  			 <div class="panel-body">
		     
		     <h4 style="color:#ec971f; text-align: center;" >Datos del Garante</h4>
		     <hr>
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Nombre</p>
			  	<input type="text" name="nombre_garantes" id="nombre_garantes" value="<?php echo $resEdit->nombre_garantes; ?>" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Identificacion</p>
			  	<input type="text" name="identificacion_garantes" id="identificacion_garantes" value="<?php echo $resEdit->identificacion_garantes; ?>" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Telefono</p>
			  	<input type="text" name="telefono_garantes" id="telefono_garantes" value="<?php echo $resEdit->telefono_garantes; ?>" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     </div>
		     </div>
		     </div>
          
          
           <div class="col-lg-8">	
		     <div class="panel panel-default">
  			 <div class="panel-body">
  			 <h4 style="color:#ec971f; text-align: center;" >Datos del Juicio</h4>
		     <hr>
  			 
  			 <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Juicio</p>
			  	<input type="text" name="juicio_referido_titulo_credito" id="juicio_referido_titulo_credito" value="<?php echo $resEdit->juicio_referido_titulo_credito; ?>" class="form-control" <?php echo $habilitar;?>/>
			   <input type="hidden"  name="id_juicios" id="id_juicios" value="<?php echo $resEdit->id_juicios; ?>" class="form-control"/> 
			 
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Impulsor</p>
			  	<input type="text" name="impulsores" id="impulsores" value="<?php echo $resEdit->impulsores; ?>" class="form-control" readonly/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Secretario</p>
			  	<input type="text" name="secretarios" id="secretarios" value="<?php echo $resEdit->secretarios; ?>" class="form-control" readonly/>
			  </div>
			  
		    </div>
		    
		    <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Etapa</p>
			  	<select name="id_etapas_juicios" id="id_etapas_juicios"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultEtapas as $res) {?>
						<option value="<?php echo $res->id_etapas_juicios; ?>" <?php if ($res->id_etapas_juicios == $resEdit->id_etapas_juicios ) echo ' selected="selected" '  ; ?> ><?php echo $res->nombre_etapas; ?> </option>
			         	
			        <?php } ?>
				</select> 
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Tipo Juicio</p>
			  	<select name="id_tipo_juicios" id="id_tipo_juicios"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultTipJui as $res) {?>
						<option value="<?php echo $res->id_tipo_juicios; ?>" <?php if ($res->id_tipo_juicios == $resEdit->id_tipo_juicios ) echo ' selected="selected" '  ; ?> ><?php echo $res->nombre_tipo_juicios; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
			  
			    <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Estados Procesales</p>
			  	<select name="id_estados_procesales_juicios" id="id_estados_procesales_juicios"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultEstPro as $res) {?>
						<option value="<?php echo $res->id_estados_procesales_juicios; ?>" <?php if ($res->id_estados_procesales_juicios == $resEdit->id_estados_procesales_juicios ) echo ' selected="selected" '  ; ?> ><?php echo $res->nombre_estados_procesales_juicios; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
			  
		    </div>
  			 <br>
  			 <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Año</p>
			  	<input type="text" name="year_juicios" id="year_juicios" value="<?php echo $resEdit->year_juicios; ?>" class="form-control"readonly/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Numero</p>
			  	<input type="text" name="numero_juicios" id="numero_juicios" value="<?php echo $resEdit->numero_juicios; ?>" class="form-control" readonly/>
			  </div>
			  
			   <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Creacion</p>
			  	<input type="text" name="creado" id="creado" value="<?php echo $resEdit->creado; ?>" class="form-control" readonly/>
			  </div>
		    </div>
  			 
  			  </div>	 
		     </div>	
		     </div>	
  			 	 
		     	 
		      <div class="col-lg-4">	
		     <div class="panel panel-default">
  			 <div class="panel-body">
  			 <h4 style="color:#ec971f; text-align: center;" >Datos del Titulo Credito</h4>
		     <hr>
  			 <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Titulo Credito</p>
			  	<input type="text" name="numero_titulo_credito" id="numero_titulo_credito" value="<?php echo $resEdit->numero_titulo_credito; ?>" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Deuda</p>
			  	<input type="text" name="total_total_titulo_credito" id="total_total_titulo_credito" value="<?php echo $resEdit->total_total_titulo_credito; ?>" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     </div>	 
		     </div>	
		     </div>	
          
		     <?php } } else {?>
		     
		     <div class="col-lg-8">
		     
		    <div class="panel panel-default">
  			<div class="panel-body">
		    <h4 style="color:#ec971f; text-align: center;" >Datos del Cliente</h4>
		    <hr>
		  <div class="row">
		    
		    <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Tipo Identificacion</p>
			  	<select name="id_tipo_identificacion" id="id_tipo_identificacion"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultTipoIdent as $resTipoIdent) {?>
						<option value="<?php echo $resTipoIdent->id_tipo_identificacion; ?>"  ><?php echo $resTipoIdent->nombre_tipo_identificacion; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
		    
		    <div class="col-xs-8 col-md-8">
			  	<p  class="formulario-subtitulo" >Nombres </p>
			  	<input type="text" name="nombres_clientes" id="nombres_clientes" value="" class="form-control" <?php echo $habilitar;?>/>
			  </div>
			  </div>
			   
			   
		    <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >TelÃ©fono</p>
			  	<input type="text" name="telefono_clientes" id="telefono_clientes" value="" class="form-control" <?php echo $habilitar;?>/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Celular </p>
			  	<input type="text" name="celular_clientes" id="celular_clientes" value="" class="form-control" <?php echo $habilitar;?>/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Ciudad</p>
			  	<select name="id_ciudad" id="id_ciudad"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultCiu as $res) {?>
						<option value="<?php echo $res->id_ciudad; ?>"  ><?php echo $res->nombre_ciudad; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
		    </div>
		    
		    <div class="row">
		    <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Tipo Persona</p>
			  	<select name="id_tipo_persona" id="id_tipo_persona"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultTipoPer as $res) {?>
						<option value="<?php echo $res->id_tipo_persona; ?>"  ><?php echo $res->nombre_tipo_persona; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
			  
			  <div class="col-xs-8 col-md-8">
			  	<p  class="formulario-subtitulo" >DirecciÃ³n</p>
			  	<input type="text" name="direccion_clientes" id="direccion_clientes" value="" class="form-control" <?php echo $habilitar;?>/>
			  </div>
			  
		    </div>
		    
			  </div>
			   </div> 
		     	 </div>
		     	 
		     	 
		     	 <div class="col-lg-4">
		     
		     <div class="panel panel-default">
  			 <div class="panel-body">
		     
		     <h4 style="color:#ec971f; text-align: center;" >Datos del Garante</h4>
		     <hr>
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Nombre</p>
			  	<input type="text" name="nombre_garantes" id="nombre_garantes" value="" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Identificacion</p>
			  	<input type="text" name="identificacion_garantes" id="identificacion_garantes" value="" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Telefono</p>
			  	<input type="text" name="telefono_garantes" id="telefono_garantes" value="" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     </div>
		     </div>
		     </div>
		     
		     
		      <div class="col-lg-8">	
		     <div class="panel panel-default">
  			 <div class="panel-body">
  			 <h4 style="color:#ec971f; text-align: center;" >Datos del Juicio</h4>
		     <hr>
  			 
  			 <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Juicio</p>
			  	<input type="text" name="juicio_referido_titulo_credito" id="juicio_referido_titulo_credito" value="" class="form-control" <?php echo $habilitar;?>/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Impulsor</p>
			  	<input type="text" name="impulsores" id="impulsores" value="" class="form-control" readonly/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Secretario</p>
			  	<input type="text" name="secretarios" id="secretarios" value="" class="form-control" readonly/>
			  </div>
			  
		    </div>
		    
		    <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Etapa</p>
			  	<select name="id_etapas_juicios" id="id_etapas_juicios"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultEtapas as $res) {?>
						<option value="<?php echo $res->id_etapas_juicios; ?>"  ><?php echo $res->nombre_etapas; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Tipo Juicio</p>
			  	<select name="id_tipo_juicios" id="id_tipo_juicios"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultTipJui as $res) {?>
						<option value="<?php echo $res->id_tipo_juicios; ?>"  ><?php echo $res->nombre_tipo_juicios; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
			  
			    <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Estados Procesales</p>
			  	<select name="id_estados_procesales_juicios" id="id_estados_procesales_juicios"  class="form-control" <?php echo $habilitar;?>>
					<?php foreach($resultEstPro as $res) {?>
						<option value="<?php echo $res->id_estados_procesales_juicios; ?>"  ><?php echo $res->nombre_estados_procesales_juicios; ?> </option>
			        <?php } ?>
				</select> 
			  </div>
			  
		    </div>
  			 <br>
  			 <div class="row">
		    
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Año</p>
			  	<input type="text" name="year_juicios" id="year_juicios" value="" class="form-control"readonly/>
			  </div>
			  
			  <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Numero</p>
			  	<input type="text" name="numero_juicios" id="numero_juicios" value="" class="form-control" readonly/>
			  </div>
			  
			   <div class="col-xs-4 col-md-4">
			  	<p  class="formulario-subtitulo" >Creacion</p>
			  	<input type="text" name="creado" id="creado" value="" class="form-control" readonly/>
			  </div>
		    </div>
  			 
  			  </div>	 
		     </div>	
		     </div>	
  			 	 
		     	 
		      <div class="col-lg-4">	
		     <div class="panel panel-default">
  			 <div class="panel-body">
  			 <h4 style="color:#ec971f; text-align: center;" >Datos del Titulo Credito</h4>
		     <hr>
  			 <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Titulo Credito</p>
			  	<input type="text" name="numero_titulo_credito" id="numero_titulo_credito" value="" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     <div class="row">
		    
			  <div class="col-xs-12 col-md-12">
			  	<p  class="formulario-subtitulo" >Deuda</p>
			  	<input type="text" name="total_total_titulo_credito" id="total_total_titulo_credito" value="" class="form-control" readonly/>
			  </div>
			
		     </div>
		     
		     </div>	 
		     </div>	
		     </div>		
		     
		      
		     <?php } ?>
  		
		</div>
		
		<div class="row">
		 <div class="col-xs-12 col-md-12" style="text-align: center;">
		
  		     <input type="submit" id="actualizar" name="actualizar"  onclick="this.form.action='<?php echo $helper->url("EtapasJuicios","ActualizarEtapasJuicios"); ?>'" class="btn btn-success" value="Actualizar" style="margin-top: 30px;" <?php echo $habilitar;?>/>
			
  		</div>
		
		</div>
		<br>
		<br>
		</form>
     
      </div>
     
  </div>
      <!-- termina
       busqueda  -->
   </body>  

    </html>   