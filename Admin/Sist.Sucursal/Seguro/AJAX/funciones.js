


function IrPaso3() {


	// validar veh_chassis
	if ($('#veh_chassis').val().length < 6) {
		$('#errorveh_chassis').fadeIn('9');
		var HayError = true;
	} else { $('#errorveh_chassis').fadeOut('3'); }

	// validar apellidos
	if ($('#veh_matricula').val().length < 7) {
		$('#errorveh_matricula').fadeIn('9');
		var HayError = true;
	} else { $('#errorveh_matricula').fadeOut('3'); }


	// si envia error
	if (HayError == true) {
		//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {

		$("#tab3").fadeIn(0);
		$("#tab1").fadeOut(0);
		$("#tab2").fadeOut(0);

		var nombres = $("#asegurado_nombres").val();
		$("#label_nombres").text(nombres);

		var apellidos = $("#asegurado_apellidos").val();
		$("#label_apellidos").text(apellidos);

		var cedula = $("#asegurado_cedula").val();
		$("#label_cedula").text(cedula);

		var telefono1 = $("#asegurado_telefono1").val();
		$("#label_telefono1").text(telefono1);

		var telefono2 = $("#asegurado_telefono2").val();
		$("#label_telefono2").text(telefono2);

		var veh_tipo = $("#veh_tipo").val();
		$("#label_veh_tipo").text(veh_tipo);

		var veh_marca = $("#veh_marca :selected").text();
		$("#label_veh_marca").text(veh_marca);

		var veh_modelo = $("#veh_modelo :selected").text();
		$("#label_veh_modelo").text(veh_modelo);

		var veh_ano = $("#veh_ano").val();
		$("#label_veh_ano").text(veh_ano);

		var veh_chassis = $("#veh_chassis").val();
		$("#label_veh_chassis").text(veh_chassis);

		var veh_matricula = $("#veh_matricula").val();
		$("#label_veh_matricula").text(veh_matricula);
	}
}


function soloLetras(e) {
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toLowerCase();
	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
	especiales = [8, 37, 39, 46];

	tecla_especial = false
	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
	}
}



function DivGuionesCed(key) {
	v = $('#asegurado_cedula').val();
	if (v.length == '3' && key != '9') {
		$('#asegurado_cedula').val(v + '-');
	}
	if (v.length == '11' && key != '9') {
		$('#asegurado_cedula').val(v + '-');
	}
}

$('#asegurado_cedula').keyup(function (event) {
	key = event.which;
	DivGuionesCed(key);
});




function DivGuionesTel1(key) {
	v = $('#asegurado_telefono1').val();
	if (v.length == '3' && key != '8') {
		$('#asegurado_telefono1').val(v + '-');
	}
	if (v.length == '7' && key != '8') {
		$('#asegurado_telefono1').val(v + '-');
	}
}

$('#asegurado_telefono1').keyup(function (event) {
	key = event.which;
	DivGuionesTel1(key);
});


function DivGuionesTel2(key) {
	v = $('#asegurado_telefono2').val();
	if (v.length == '3' && key != '8') {
		$('#asegurado_telefono2').val(v + '-');
	}
	if (v.length == '7' && key != '8') {
		$('#asegurado_telefono2').val(v + '-');
	}
}

$('#asegurado_telefono2').keyup(function (event) {
	key = event.which;
	DivGuionesTel2(key);
});


function ImprimirTicket(id) {
	CargarAjax2('Seguros/ticketNew.php?id=' + id + '', '', 'GET', 'formprinc');
}
	  
	  
	 
	
	
	< !--------------- para asegurado_telefono2---------------->


	function IrPaso1() {
		$("#tab1").fadeIn(0);
		$("#tab2").fadeOut(0);
		$("#tab3").fadeOut(0);
		$("#tab4").fadeOut(0);
	}


function IrPaso2() {
	$("#tab2").fadeIn(0);
	$("#tab1").fadeOut(0);
	$("#tab3").fadeOut(0);
	$("#tab4").fadeOut(0);
}

function IrPaso3() {
	$("#tab3").fadeIn(0);
	$("#tab1").fadeOut(0);
	$("#tab2").fadeOut(0);
	$("#tab4").fadeOut(0);
}


function IrPaso4() {
	$("#tab4").fadeIn(0);
	$("#tab1").fadeOut(0);
	$("#tab2").fadeOut(0);
	$("#tab3").fadeOut(0);
}

function ImprimirTicket(nombre) {
	var ficha = document.getElementById(nombre);
	var ventimp = window.open(' ', 'popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}

var nav4 = window.Event ? true : false;
function acceptNum(evt) {
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57));
}
 ==========================================================
// * QuickAdmin v1.3.3
// * form_wizards.js
// * 
// * http://www.mosaicpro.biz
// * Copyright MosaicPro
// *
// * Built exclusively for sale @Envato Marketplaces
// * ==========================================================  



function soloLetras(e) {
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toLowerCase();
	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
	especiales = [8, 37, 39, 46];

	tecla_especial = false
	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
	}
}
	
	
	
		< !--------------- para la cedula---------------->
	function DivGuionesCed(key) {
		v = $('#asegurado_cedula').val();
		if (v.length == '3' && key != '9') {
			$('#asegurado_cedula').val(v + '-');
		}
		if (v.length == '11' && key != '9') {
			$('#asegurado_cedula').val(v + '-');
		}
	}

$('#asegurado_cedula').keyup(function (event) {
	key = event.which;
	DivGuionesCed(key);
});
	< !--------------- para la cedula---------------->
	
	
	< !--------------- para asegurado_telefono1---------------->


	function DivGuionesTel1(key) {
		v = $('#asegurado_telefono1').val();
		if (v.length == '3' && key != '8') {
			$('#asegurado_telefono1').val(v + '-');
		}
		if (v.length == '7' && key != '8') {
			$('#asegurado_telefono1').val(v + '-');
		}
	}

$('#asegurado_telefono1').keyup(function (event) {
	key = event.which;
	DivGuionesTel1(key);
});
	< !--------------- para asegurado_telefono1---------------->


	function ImprimirTicket(id) {
		CargarAjax2('Seguros/ticketNew.php?id=' + id + '', '', 'GET', 'formprinc');
	}

function EnviarSeguro() {
	// validar FECHAS
	HayError = false;
	var fecha1 = $('#fecha_inicio').val();
	//alert(fecha1+"-");
	var fechaD = fecha1.split("-");
	var fechaF = parseInt(fechaD[0] + "" + fechaD[1] + "" + fechaD[2]);
	var fechaH = parseInt(<?= date("Ymd");?>);

	//alert(fechaF+"-"+fechaH);

	if (fechaF <= fechaH) {
		$("#fecha_inicio").css("border", "solid 1px #F00");
		HayError2 = true;
	} else {
		$("#fecha_inicio").css("border", "solid 1px #ccc");
	}


	// si envia error
	if (HayError == true) {
		//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
	} else {
		if (confirm('Realmente deseas comprar este seguro?')) {
			CargarAjax2_form('Modulos/Seguro/seguro2.php', 'form_edit_prof', 'formprinc');
			$(this).attr('disabled', true);
		}
	}
}