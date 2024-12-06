	// -----------------------------------------------------
	function CargarAjax2(arch, vares, tipo,div){
	$('#apps_cargar_ajax').fadeIn();
	$.ajax({
   	type: tipo,
   	url: arch,
   	data: vares,
   	success: function(data){
    
	if(div ==''){ $('#cargaajax').html(data); }else{
	$('#'+div+'').html(data); }
	
	$('#apps_cargar_ajax').fadeOut();
	//$.unblockUI();
	
   	}}).done(function( msg ) {
  		//alert( msg );
	});
}
	
	// -----------------------------------------------------
	function CargarAjax2_form(arch, form1,div1){
	vares = $('#'+form1+'').serialize();
	$('#apps_cargar_ajax').fadeIn();
		$.ajax({
		type: 'POST',
		url: arch,
		data: vares,
		success: function(data){
		
		if(div1 ==''){ 
			$('#cargaajax').html(data); 
		}else{
			$('#'+div1+'').html(data); 
		}
	
		$('#apps_cargar_ajax').fadeOut();
   	}});
}
	
	
	//--------PARA UBICAR EL ESPACIO DEL TOP DE LA VENTANA FLOTANTE----------
	function CargarAjax_win(arch){
	
	$("#abrir_modal").click();
	$('#contenedor_win').html('');
	$.ajax({
		type: "GET",
		url: arch,
		data: "",
		success: function(msg){
		$('#contenedor_win').html(msg);

	}});
}

	
	// ALERT DE RESPUESTAS A LLAMADAS AJAX
	function AlertRespuestaOK(text){
	var text = '<div class=\"alert_respuesta_ok\">'+text+'</div>';
	
	$('#alert_respuesta').html(''+text+'');
	$('#alert_respuesta').show();
	setTimeout('$(\"#alert_respuesta\").fadeOut(2000)',5000);
}	