$("#submit").click(function() { 
	//--------------------------------------------------	
	    console.log('Validando');
		
		var usuario 	= $("#usuario").val().length;
		var pass 		= $("#clave").val().length;
		
		var usuarioVal 	= $("#usuario").val();
		var passVal 	= $("#clave").val();
		//console.log(monto)
	
		//Si el usuario esta vacio
		if(usuario < 1){  
			$('#val-usuario').fadeIn().html('Digite su usuario');
			return false;
		}else{
			$('#val-usuario').fadeOut();
		}
		
		//Si la contraseña esta vacia
		if(pass < 1){  
			$('#val-pass').fadeIn().html('Digite su contraseña');
			return false;
		}else{
			$('#val-pass').fadeOut();
		}
		
		// VERIFICAR EN EL SERVIDOR:
		Loguearme(usuarioVal,passVal,true);
		  
		return false;
	
	//--------------------------------------------------
	});