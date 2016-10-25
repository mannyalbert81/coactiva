<?php
class ControladorBase{

    public function __construct() {
        require_once 'EntidadBase.php';
        require_once 'ModeloBase.php';
        
        //Incluir todos los modelos
        foreach(glob("model/*.php") as $file){
            require_once $file;
        }
    }
    
    //Plugins y funcionalidades
    
    public function view($vista,$datos){
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor; 
        }
        
        require_once 'core/AyudaVistas.php';
        $helper=new AyudaVistas();
    
        require_once 'view/'.$vista.'View.php';
    }
    
    public function report($vista,$datos){
    	foreach ($datos as $id_assoc => $valor) {
    		${$id_assoc}=$valor;
    	}
    
    	require_once 'core/AyudaVistas.php';
    	$helper=new AyudaVistas();
    
    	require_once 'view/reportes/'.$vista.'Report.php';
    }
    

    
    
    public function afuera($vista,$datos){
    	foreach ($datos as $id_assoc => $valor) {
    		${$id_assoc}=$valor;
    	}
    	
    
    	require_once 'core/AyudaVistas.php';
    	$helper=new AyudaVistas();
    
    	require_once 'http://localhost:3000/'.$vista;
    }
    
    
    public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        header("Location:index.php?controller=".$controlador."&action=".$accion);
    }
    
    public function ireport_vizualizar($reporte_jxml,$datos){
    	
    	foreach ($datos as $id_assoc => $valor) {
    		${$id_assoc}=$valor;
    	}
    	
    	ob_end_clean();
    	
    	require_once('./view/ireports/PhpJasperLibrary/class/tcpdf/tcpdf.php');
    	require_once('./view/ireports/PhpJasperLibrary/class/PHPJasperXML.inc.php');
    	require_once ('./view/ireports/conexion.php');
    	
    	$server  = server;
    	$user    = user;
    	$pass    = pass;
    	$db      = db;
    	$driver  = driver;
    	ini_set('display_errors', 0);
    	
    	$data=$sql;
    	
    	$archivo = './view/ireports/'.$reporte_jxml.'.jrxml';
    	
    	$PHPJasperXML = new PHPJasperXML();
    	
    	$PHPJasperXML->arrayParameter=array("_sql"=>$data['sql']);
    	
    	$PHPJasperXML->load_xml_file($archivo);
    	
    	$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, $driver);
    	$PHPJasperXML->outpage("I");
    	    
    }
    
    //Métodos para los controladores

}
?>
