// JavaScript Document

function soloNumeros(evt){
		//asignamos el valor de la tecla a keynum
		if(window.event){// IE
		keynum = evt.keyCode;
		}else{
		keynum = evt.which;
		}
		//comprobamos si se encuentra en el rango
		if(keynum>47 && keynum<58){
		return true;
		}else{
		return false;
		}
	}