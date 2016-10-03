var solo_8_numeros = /^\d{8,8}$/;

$(document).ready(function () {
	$("#boton").click(function (){ //función para el boton de enviar
		//recolectamos en variables, lo que tenga cada input.
		//Para mejor manipulación en los if's 
		var matricula = $("#matricula").val();

        if(matricula == "" || !solo_8_numeros.test(matricula)){
			$("#mensaje1").fadeIn("slow"); //Muestra mensaje de error
            return false;				   // con false sale de la secuencia
        }
        else{
			$("#mensaje1").fadeOut();	//Si el anterior if cumple, se oculta el error
			
        }
 
    });//fin click
    
	$("#matricula").keyup(function(){
		if( $(this).val() != "" && solo_8_numeros.test($(this).val())){
			$("#mensaje1").fadeOut();
			return false;
		}
    });
  
  
    
    
    
});//fin ready

