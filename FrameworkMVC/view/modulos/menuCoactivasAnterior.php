<div class="container" style="margin-top: 15px;" >
<div class="row">
<div class="col-xs-12">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>	
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" ><?php echo " Administración" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        	<li><a href="index.php?controller=Usuarios&action=index"><span class="glyphicon glyphicon-user" aria-hidden="true"> Usuarios</span> </a>
		    </li>
			<li><a href="index.php?controller=Roles&action=index"> <span class=" glyphicon glyphicon-asterisk" aria-hidden="true"> Roles de Usuario</span> </a>
			</li>
			<li><a href="index.php?controller=PermisosRoles&action=index"><span class="glyphicon glyphicon-plus" aria-hidden="true"> Permisos Roles</span> </a>
			</li>
			<li><a href="index.php?controller=Controladores&action=index"><span class="glyphicon glyphicon-inbox" aria-hidden="true"> Controladores</span> </a>
			</li>
			<li><a href="index.php?controller=Entidades&action=index"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"> Entidades</span> </a>
			</li>
			<li><a href="index.php?controller=TipoIdentificacion&action=index"><span class="glyphicon glyphicon-time" aria-hidden="true"> Tipo de Identificacion</span> </a>
			</li>
			<li><a href="index.php?controller=TipoNotificacion&action=index"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"> Tipo Notificacion</span> </a>
			</li>
			<li><a href="index.php?controller=Notificaciones&action=index"><span class="glyphicon glyphicon-globe" aria-hidden="true"> Notificaciones</span> </a>
			</li>
			
		</ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Procesos" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        	<li><a href="index.php?controller=Operaciones&action=index"><span class="glyphicon glyphicon-ok" aria-hidden="true"> Importacion de Cartera/Operaciones</span> </a>
		    </li>
			<li><a href="index.php?controller=Recaudacion&action=index"><span class="glyphicon glyphicon-euro" aria-hidden="true"> Procesar Archivo de Recaudacion</span> </a>
			</li>
         	<li><a href="index.php?controller=AsignacionSecretarios&action=index"><span class="glyphicon glyphicon-copy" aria-hidden="true"> Asignacion Secretarios</span> </a>
            </li>
			<li><a href="index.php?controller=FirmasDigitales&action=index"><span class="glyphicon glyphicon-pencil" aria-hidden="true"> Firmas Digitales</span> </a>
            </li>
            <li><a href="index.php?controller=CertificadosElectronicos&action=index"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"> Registrar Certificado Electronico</span> </a>
            </li>
            <li><a href="index.php?controller=FirmasDigitales&action=firmarDocumento"><span class="glyphicon glyphicon-adjust" aria-hidden="true"> Firmar Documento</span> </a>
            </li>
             <li><a href="index.php?controller=AsignacionTituloCredito&action=index"><span class="glyphicon glyphicon-adjust" aria-hidden="true"> Asignar Titulo Credito</span> </a>
            </li>
            <li><a href="index.php?controller=ReasignarTitulo&action=index"><span class="glyphicon glyphicon-edit" aria-hidden="true"> Reasignar Titulo Credito</span> </a>
            </li>
              <li><a href="index.php?controller=Clientes&action=index"><span class="glyphicon glyphicon-user" aria-hidden="true"> Clientes</span> </a>
            </li>
          	<li><a href="index.php?controller=Clientes&action=ImportacionClientes"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"> Importacion Clientes</span> </a>
            </li> 
                     </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Mantenimiento" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          

            <li><a href="index.php?controller=TipoJuicios&action=index"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"> Tipo de Juicios</span> </a>
			</li>
			<li><a href="index.php?controller=EstadosTitulosCredito&action=index"><span class="glyphicon glyphicon-collapse-up" aria-hidden="true"> Estado Titulo Credito</span> </a>
			</li>
             <li><a href="index.php?controller=EstadosProcesales&action=index"><span class="glyphicon glyphicon-log-in" aria-hidden="true"> Estado Procesal</span> </a>
            </li>
            <li><a href="index.php?controller=EtapasJuicios&action=index"><span class="glyphicon glyphicon-subtitles" aria-hidden="true"> Etapas Juicios</span> </a>
            </li>
            <li><a href="index.php?controller=LotesTituloCredito&action=index"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"> Estado Lotes</span> </a>
            </li>
            <li><a href="index.php?controller=EstAutoPagoJuicios&action=index"><span class="glyphicon glyphicon-education" aria-hidden="true"> Estado Auto de Pago</span> </a>
            </li>
             <li><a href="index.php?controller=TipoPersona&action=index"><span class="glyphicon glyphicon-option-vertical" aria-hidden="true"> Tipo de Personas</span> </a>
			</li>
            <li><a href="index.php?controller=OrigenCartera&action=index"><span class=" glyphicon glyphicon-triangle-left" aria-hidden="true"> Origen de Cartera</span> </a>
			</li>
			<li><a href="index.php?controller=Ciudad&action=index"><span class="glyphicon glyphicon-object-align-vertical" aria-hidden="true"> Ciudades</span> </a>
			</li>
            <li><a href="index.php?controller=Honorarios&action=index"><span class="glyphicon glyphicon-level-up" aria-hidden="true"> Honorarios</span> </a>
            </li>
            <li><a href="index.php?controller=TipoHonorarios&action=index"><span class="glyphicon glyphicon-saved" aria-hidden="true"> Tipo de Honorarios</span> </a>
            </li>
            <li><a href="index.php?controller=TipoGastos&action=index"><span class="glyphicon glyphicon-open" aria-hidden="true"> Tipo Gastos</span> </a>
			</li>
			<li><a href="index.php?controller=AdministradorGastos&action=index"><span class="glyphicon glyphicon-record" aria-hidden="true"> Administrador de Gastos</span> </a>
			</li>
			<li><a href="index.php?controller=TipoVehiculos&action=index"><span class="glyphicon glyphicon-export" aria-hidden="true"> Tipo de Vehiculos </span> </a>
			</li>
			<li><a href="index.php?controller=MarcaVehiculos&action=index"><span class="glyphicon glyphicon-unchecked" aria-hidden="true"> Marca de Vehiculos </span> </a>
			</li>
          </ul>
        </li>

         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Consultas" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
          <li><a href="index.php?controller=Trazas&action=index"><span class="glyphicon glyphicon-save-file" aria-hidden="true"> Auditoria del Sistema</span> </a>
            </li>
          <li><a href="index.php?controller=Citaciones&action=consulta"><span class="glyphicon glyphicon-link" aria-hidden="true"> Citaciones</span> </a>
            </li>
           <li><a href="index.php?controller=Oficios&action=consulta"><span class="glyphicon glyphicon-copy" aria-hidden="true"> Oficios</span> </a>
            </li>
            <li><a href="index.php?controller=Juicio&action=consulta"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"> Juicios</span> </a>
            </li>
            <li><a href="index.php?controller=Clientes&action=consulta"><span class=" glyphicon glyphicon-console" aria-hidden="true"> Clientes</span> </a>
            </li>      
            
			
			
</ul>
</li>

          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Juicios" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
          <li><a href="index.php?controller=Juicio&action=index"><span class="glyphicon glyphicon-sort" aria-hidden="true"> Seguimiento Juicio</span> </a>
            </li>
         
         <li><a href="index.php?controller=AutoPagos&action=index"><span class="glyphicon glyphicon-filter" aria-hidden="true"> Auto Pagos</span> </a>
            </li>
            <li><a href="index.php?controller=AprobacionAutoPago&action=index"><span class="glyphicon glyphicon-tasks" aria-hidden="true"> Aprobacion Auto Pagos</span> </a>
            </li>
            <li><a href="index.php?controller=RegistroVehiculosEmbargados&action=index"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"> Registro Vehiculos Embargados</span> </a>
            </li>

            <li><a href="index.php?controller=ReporteVehiculosEmbargados&action=index"><span class="glyphicon glyphicon-text-size" aria-hidden="true"> Reporte Vehiculos Embargados</span> </a>
			</li>
			 <li><a href="index.php?controller=ImpresionAutoPago&action=index"><span class=" glyphicon glyphicon-triangle-bottom" aria-hidden="true"> Impresion Auto Pagos</span> </a>
            </li>

           </ul>
           </li>

<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Gastos" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
          <li><a href="index.php?controller=DistribucionGastos&action=index"><span class="glyphicon glyphicon-text-background" aria-hidden="true"> Distribucion Gastos</span> </a>
            </li>
          <li><a href="index.php?controller=AprobacionDistribucionGastos&action=index"><span class="glyphicon glyphicon-oil" aria-hidden="true"> Aprobacion Gastos</span> </a>
           </li>
             <li><a href="index.php?controller=Oficios&action=index"><span class="glyphicon glyphicon-leaf" aria-hidden="true"> Oficios</span> </a>
            </li>
             <li><a href="index.php?controller=SeguimientoGastos&action=index"><span class="glyphicon glyphicon-resize-full" aria-hidden="true"> Seguimiento Gastos</span> </a>
            </li>

</ul>
</li>

<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Citaciones" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            
          <li><a href="index.php?controller=Citaciones&action=index"><span class=" glyphicon glyphicon-usd" aria-hidden="true"> Generar Citaciones</span> </a>
            </li>
          <li><a href="index.php?controller=RegistroConvenioPagoSolicitud&action=index"><span class=" glyphicon glyphicon-usd" aria-hidden="true"> Convenio Pago Solicitud</span> </a>
            </li>   
                     
      </ul>
      </li>
      
<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Reportes" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
           
             <li><a href="/FrameworkMVC/view/ireports/ContClientesReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class="glyphicon glyphicon-home" aria-hidden="true"> Clientes</span> </a>
           </li>
            
            <li><a href="/FrameworkMVC/view/ireports/ContUsuariosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class="glyphicon glyphicon-file" aria-hidden="true"> Usuarios</span> </a>
            </li>  
            
            <li><a href="/FrameworkMVC/view/ireports/ContVehiculosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class=" glyphicon glyphicon-print" aria-hidden="true"> Vehiculos Embargados</span> </a>
            </li>   
            
            <li><a href="/FrameworkMVC/view/ireports/ContCitacionesReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class=" glyphicon glyphicon-book" aria-hidden="true"> Citaciones</span> </a>
            </li>   
            
            <li><a href="/FrameworkMVC/view/ireports/ContAdministradorGastosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-fullscreen" aria-hidden="true"> Administrador de Gastos</span> </a>
             </li>
             
            <li><a href="/FrameworkMVC/view/ireports/ContHonorariosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-th" aria-hidden="true"> Honorarios</span> </a>
            </li>
            
            <li><a href="/FrameworkMVC/view/ireports/ContNotificacionesReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-envelope" aria-hidden="true"> Notificaciones</span> </a>
            </li>
            
            <li><a href="/FrameworkMVC/view/ireports/ContAsignacionSecretariosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-stop" aria-hidden="true"> Asignacion Secretarios</span> </a>
            </li>
            
            <li><a href="/FrameworkMVC/view/ireports/ContTrazasReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"> Auditoria del Sistema</span> </a>
            </li>
            
            <li><a href="/FrameworkMVC/view/ireports/ContProvidenciaReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"> Providencia</span> </a>
            </li>
      </ul>
      </li>
      
      
      
<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-refresh" ><?php echo " Reportes NUEVO ACTUALIZADOS" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
            <li><a href="/FrameworkMVC/view/ireports/ContClientesReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class="glyphicon glyphicon-home" aria-hidden="true"> Clientes</span> </a>
            </li>
            <li><a href="/FrameworkMVC/view/ireports/ContUsuariosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class="glyphicon glyphicon-file" aria-hidden="true"> Usuarios</span> </a>
            </li>  
            <li><a href="/FrameworkMVC/view/ireports/ContVehiculosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"> <span class=" glyphicon glyphicon-print" aria-hidden="true"> Vehiculos Embargados</span> </a>
            </li>   
            <li><a href="/FrameworkMVC/view/ireports/ContAdministradorGastosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-fullscreen" aria-hidden="true"> Administrador de Gastos</span> </a>
            </li>
            <li><a href="/FrameworkMVC/view/ireports/ContHonorariosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-th" aria-hidden="true"> Honorarios</span> </a>
            </li>
            <li><a href="/FrameworkMVC/view/ireports/ContNotificacionesReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-envelope" aria-hidden="true"> Notificaciones</span> </a>
            </li>
            <li><a href="/FrameworkMVC/view/ireports/ContAsignacionSecretariosReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-stop" aria-hidden="true"> Asignacion Secretarios</span> </a>
            </li>
            <li><a href="/FrameworkMVC/view/ireports/ContTrazasReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"> Auditoria del Sistema</span> </a>
            </li>
            <li><a href="/FrameworkMVC/view/ireports/ContJuiciosSubReport.php"onclick="window.open(this.href, this.target, ' width=1000, height=800, menubar=no');return false"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"> Juicios</span> </a>
            </li>
</ul>
</li>
</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
</div>
</div>