<?php
//PARA CAMBIAR LOS PRECIOS DE LOS PRODUCTOS HAY QUE IR A LA RUTA:
$servicios = $_POST['servicios'];
session_start();
ini_set('display_errors', 0);
include "../../../incluidos/conexion_inc.php";
include "../../../incluidos/fechas.func.php";
include "../../../incluidos/nombres.func.php";
include('../../../controller/VehiculoController.php');

Conectarse();
//include("../../inc/loteprint.func.php");

$fecha1 = fecha_despues('' . date('d/m/Y') . '', -0);
//$fech_Calc = fecha_despues(''.date('d/m/Y').'',-30);

if ($_POST) {
	//print_r($_POST);

	if ($_SESSION['user_id'] == '13') {
		//print_r($_POST);
	}

	if ($_POST['nombres'] && $_SESSION['user_id']) {
		$_POST['servicios'] = $servicios;

		for ($i = 0; $i < count($_POST['servicios']); $i++) {
			$_POST['serv'] .= "" . $_POST['servicios'][$i] . "-";
		}

		//echo "Servicios elegidos ".$_POST['serv']."<br>";
		unset($_POST['servicios']);

		$sql = mysql_query(
			"SELECT id, password FROM personal WHERE id='" .
				$_SESSION['user_id'] .
				"' LIMIT 1"
		);
		$user = mysql_fetch_array($sql);

		// para verificar seguro
		//$xID 	= "WEB-".$_SESSION['user_id'].date('Ymdhis');
		$url =
			"https://multiseguros.com.do/ws_schat/Seguros/GET_Poliza.php" .
			"?xID=WEB-" .
			$_SESSION['user_id'] .
			date('Ymdhis') .
			"&usuario=" .
			trim($user['id']) .
			"&clave=" .
			trim($user['password']) .
			"&nombres=" .
			str_replace(' ', '+', $_POST['nombres']) .
			"&apellidos=" .
			str_replace(' ', '+', $_POST['apellidos']) .
			"&cedula=" .
			$_POST['cedula'] .
			"&pasaporte=" .
			$_POST['pasaporte'] .
			"&direccion=" .
			$_POST['direccion'] .
			"&telefono1=" .
			$_POST['telefono1'] .
			"&email=" .
			$_POST['email'] .
			"&ciudad=" .
			$_POST['ciudad'] .
			"&tipo=" .
			$_POST['tipo'] .
			"&year=" .
			$_POST['year'] .
			"&marca=" .
			$_POST['marca'] .
			"&modelo=" .
			$_POST['modelo'] .
			"&chassis=" .
			$_POST['chassis'] .
			"&placa=" .
			$_POST['placa'] .
			"&vigencia_poliza=" .
			$_POST['vigencia_poliza'] .
			"&serv_adc=" .
			$_POST['serv'] .
			"&aseguradora=" .
			$_POST['aseguradora'] .
			"&fecha_inicio=" .
			$_POST['fecha_inicio'] .
			"&idApi=2wessd@d3e";
		$url = str_replace(" ", "+", $url);

		if ($_SESSION['user_id'] == '13') {
			//echo $url;
		}

		$getWS = file_get_contents($url);
		$respuesta = explode("/", $getWS);
		// para verificar seguro

		if ($_SESSION['user_id'] == '13') {
			//echo "Codigo: ".$respuesta[0];
		}

		echo '<div style="padding:30px;">';
		if ($respuesta[0] == '00') {
			echo '
				<center>
					<img src="images/check.png" width="128" height="128" /><br>
					 <font size="4" color="#0066CC">   
						' .
				$respuesta[1] .
				'
					  </font>
						<br>
					  <font size="2">Cliente:&nbsp;&nbsp;<b>' .
				$_POST['nombres'] .
				' ' .
				$_POST['apellidos'] .
				'</b>
					  </font><br>
					  <font size="2">Transaccion no.: ' .
				$respuesta[2] .
				'<br></font><b>
			    </center>
				
				
				'; ?>

			<table style="width: 50%;
    margin-top: 25px;
    margin-left: 25%;">
				<tr>
					<td align="right"><a href="javascript:void(0)" class="btn btn-success" onClick="CargarAjax2('Admin/Sist.Sucursal/Seguro/ticket.php?id=<?= $respuesta[2] ?>','','GET','ver');"><b>Imprimir Ticket</b></a>

					</td>

					<td align="right"><a href="javascript:void(0)" class="btn btn-success" onClick="CargarAjax2('Admin/Sist.Sucursal/Seguro/Imprimir_Poliza.php?id_trans=<?= $respuesta[2] ?>','','GET','ver');"><b>Imprimir Poliza</b></a></td>


				</tr>
			</table>


<?php
		} elseif ($respuesta[0] == '13') {
			echo '
			<center>
				<font size="5" color="#FF0000">Error: <b>' .
				$respuesta[0] .
				'</b></font>
				<br><font size="3">' .
				$respuesta[1] .
				'</font>
			</center>';
		} elseif ($respuesta[0] == '12') {
			//echo $respuesta[0]." - ".$respuesta[1]." - ".$respuesta[2];
			echo '
			<center>
				<font size="5" color="#FF0000">Error: <b>' .
				$respuesta[0] .
				'</b></font>
				<br><font size="3">' .
				$respuesta[1] .
				'</font>
			</center>';
		} elseif ($respuesta[0] !== '00') {
			echo '
			<center>
				<font size="5" color="#FF0000">Error: <b>' .
				$respuesta[0] .
				'</b></font>
				<br><font size="3">Por favor, comuniquese con su proveedor.</font>
			</center> ';
		}

		echo '</div>';
		exit();
	}
}
?>

<script>
	//$("#tab2").fadeIn(0);
	function ImprimirTicket(nombre) {
		var ficha = document.getElementById(nombre);
		var ventimp = window.open(' ', 'popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
	}

	function IrPaso1() {

		$("#tab1").fadeIn(0);
		$("#tab2").fadeOut(0);
		$("#tab3").fadeOut(0);
		$("#tab4").fadeOut(0);

		//var label_vigencia3 = $("#label_vigencia3").val();
		//		$("#label_vigencia31").text(label_vigencia3);


	}

	function IrPaso2() {

		//var label_vigencia3 = $("#label_vigencia3").val();
		//		$("#label_vigencia3").text(label_vigencia3);

		//		$("#tab2").fadeIn(0);
		//		
		var tipo = $("#tipo").val();
		var marca = $("#marca").val();
		var year = $("#year").val();
		//		
		// validar chassis
		if (tipo == "") {
			$("#tipo").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#tipo").css("border", "solid 1px #CCC");
		}


		if (marca == "") {
			$("#marca").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#marca").css("border", "solid 1px #CCC");
		}


		if (year == "") {
			$("#year").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#year").css("border", "solid 1px #CCC");
		}


		// validar chassis
		if ($('#chassis').val().length < 6) {
			$("#chassis").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#chassis").css("border", "solid 1px #CCC");
		}


		// validar apellidos
		if ($('#placa').val().length < 7) {
			$("#placa").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#placa").css("border", "solid 1px #CCC");
		}




		if (HayError == true) {
			//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
		} else {
			//alert("ya no hay error");	
			$("#tab1").fadeOut(0);
			$("#tab2").fadeIn(0);
			$("#tab3").fadeOut(0);
		}
	}



	function IrPaso3() {
		//var HayError = true;
		//alert("entro aqui a la validacion");

		var nombres2 = $("#nombres").val();
		var apellidos2 = $("#apellidos").val();
		var cedula2 = $("#cedula").val();
		var direccion2 = $("#direccion").val();
		var telefono12 = $("#telefono1").val();
		var ciudad2 = $("#ciudad").val();

		// validar nombres ------------------------------------------------	
		if (nombres2 == "") {
			$("#nombres").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#nombres").css("border", "solid 1px #CCC");
		}

		if ($('#nombres').val().length < 2) {
			$("#nombres").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#nombres").css("border", "solid 1px #CCC");
		}
		// validar nombres ------------------------------------------------

		// validar apellidos ---------------------------------------------------------
		if (apellidos2 == "") {
			$("#apellidos").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#apellidos").css("border", "solid 1px #CCC");
		}

		if ($('#apellidos').val().length < 2) {
			$("#apellidos").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#apellidos").css("border", "solid 1px #ccc");
		}
		// validar apellidos ---------------------------------------------------------

		// validar cedula --------------------------------------------------------------
		if (cedula2 == "") {
			$("#cedula").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#cedula").css("border", "solid 1px #CCC");
		}

		if ($('#cedula').val().length < 13) {
			$("#cedula").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#cedula").css("border", "solid 1px #ccc");
		}
		// validar cedula --------------------------------------------------------------

		// validar direccion -----------------------------------------------------------
		if (direccion2 == "") {
			$("#direccion").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#direccion").css("border", "solid 1px #CCC");
		}

		if ($('#direccion').val().length < 3) {
			$("#direccion").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#direccion").css("border", "solid 1px #ccc");
		}
		// validar direccion -----------------------------------------------------------

		// validar telefono -----------------------------------------------------------
		if (telefono12 == "") {
			$("#telefono1").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#telefono1").css("border", "solid 1px #CCC");
		}

		if ($('#telefono1').val().length < 12) {
			$("#telefono1").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#telefono1").css("border", "solid 1px #ccc");
		}
		// validar telefono -----------------------------------------------------------

		// validar ciudad -------------------------------------------------------------
		if (ciudad2 == "") {
			$("#ciudad").css("border", "solid 1px #F00");
			var HayError = true;
		} else {
			$("#ciudad").css("border", "solid 1px #CCC");
		}
		// validar ciudad -------------------------------------------------------------


		if (HayError == true) {
			//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
		} else {
			//alert("ya no hay error");	
			$("#tab3").fadeIn(0);
			$("#tab2").fadeOut(0);
			$("#tab4").fadeOut(0);
		}
	}



	function IrPaso4() {
		var HayError = false;
		var aseguradora = $("#aseguradora").val();



		var nombres = $("#nombres").val();
		$("#label_nombres").text(nombres);

		var apellidos = $("#apellidos").val();
		$("#label_apellidos").text(apellidos);

		var cedula = $("#cedula").val();
		$("#label_cedula").text(cedula);

		var telefono1 = $("#telefono1").val();
		$("#label_telefono1").text(telefono1);


		// var telefono2 = $("#telefono2").val();
		// $("#label_telefono2").text(telefono2);

		var direccion = $("#direccion").val();
		$("#label_direccion").text(direccion);

		var tipo = $("#tipo").val();
		// $("#label_tipo").text(tipo);

		var marca = $("#marca :selected").text();
		$("#label_marca").text(marca);

		var modelo = $("#modelo :selected").text();
		$("#label_modelo").text(modelo);

		var ano = $("#ano").val();
		$("#label_ano").text(ano);

		var chassis = $("#chassis").val();
		$("#label_chassis").text(chassis);

		var placa = $("#placa").val();
		$("#label_placa").text(placa);

		if (aseguradora == "") {
			var HayError = true;
			$("#aseguradora").css("border", "solid 1px #F00");
		} else {
			$("#aseguradora").css("border", "solid 1px #CCC");
		}

		if (HayError == true) {
			//alert('Por Favor! \n Asegurate de Completar todos los campos abligatorios');
		} else {
			//alert("ya no hay error");	
			$("#tab4").fadeIn(0);
			$("#tab1").fadeOut(0);
			$("#tab2").fadeOut(0);
			$("#tab3").fadeOut(0);
		}

	}

	function ImprimirTicket(id) {
		CargarAjax2('Admin/Sist.Sucursal/Seguro/ticket.php?id=' + id + '', '', 'GET', 'formprinc');
	}

	function EnviarSeguro() {
		// validar FECHAS
		const fecha = new Date();
		var HayError = false;
		var fecha1 = $('#fecha_inicio').val();
		var fechaD = fecha1.split("/");
		var fechaF = fechaD[2] + "-" + fechaD[1] + "-" + (parseInt(fechaD[0]) +1) ;
		var fechaH = fecha.getFullYear() + "-" + (fecha.getMonth() +1) + "-" + fecha.getDate();
		var fechaValida =  fecha.getDate()+ "/" + (fecha.getMonth() +1) + "/" + fecha.getFullYear();
		var fechaActtual = new Date(fechaH);
		var fechaPoliza = new Date(fechaF);

		if (fechaActtual.getTime()  > fechaPoliza.getTime()) {
			$('#error_fecha_ini').fadeIn('9');
			HayError = true;
		} else {
			$('#error_fecha_ini').fadeOut('3');
		}

		// si envia error
		if (HayError == true) {
			alert('Por Favor! \n Asegúrate que la fecha de emisión no anterior a la fecha actual);
		} else {
			if (confirm('Realmente deseas comprar este seguro?')) {
				CargarAjax2_form('Admin/Sist.Sucursal/Seguro/seguroV2.php', 'form_edit_prof', 'formprinc');
				$(this).attr('disabled', true);
			}
		}
	}



	// PARA VALIDAR K SOLO SEA NUMERO
	var nav4 = window.Event ? true : false;

	function acceptNum(evt) {
		var key = nav4 ? evt.which : evt.keyCode;
		return (key <= 13 || (key >= 48 && key <= 57));
	}

	function soloLetras(e) {
		var key = e.keyCode || e.which;
		var tecla = String.fromCharCode(key).toLowerCase();
		var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
		var especiales = [8, 37, 39, 46];

		var tecla_especial = false;
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



	// para la cedula
	function DivGuionesCed(key) {
		var v = $('#cedula').val();
		if (v.length == '3' && key != '9') {
			$('#cedula').val(v + '-');
		}
		if (v.length == '11' && key != '9') {
			$('#cedula').val(v + '-');
		}
	}

	$('#cedula').keyup(function(event) {
		var key = event.which;
		DivGuionesCed(key);
	});
	//para la cedula-- -- -- -- -- -- -- -- >


	//para telefono1-- -- -- -- -- -- -- -- >


	function DivGuionesTel1(key) {
		var v = $('#telefono1').val();
		if (v.length == '3' && key != '8') {
			$('#telefono1').val(v + '-');
		}
		if (v.length == '7' && key != '8') {
			$('#telefono1').val(v + '-');
		}
	}

	$('#telefono1').keyup(function(event) {
		var key = event.which;
		DivGuionesTel1(key);
	});
	// para telefono1-- -- -- -- -- -- -- -- >
</script>

<div id="ver">
	<form action="" method="post" enctype="multipart/form-data" id="form_edit_prof">
		<div id="formprinc">

			<!-- Modal heading -->
			<div class="modal-header" style="margin-top: -18px; margin-bottom: -5px; padding-bottom: 0px;">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Vender seguro de vehículo de motor </h3>
			</div>
			<!-- // Modal heading END -->

			<!-- Modal body -->
			<div class="modal-body">
				<!-- Form Wizard / Arrow navigation & Progress bar -->
				<div id="rootwizard" class="wizard">

					<div class="widget">

						<div class="widget-body">
							<div class="tab-content">

								<!-- Step 1 -->
								<style>
									.Menu1C {
										margin-top: -17px;
										margin-bottom: 15px;
										background-color: #F0F0F0;
										padding-bottom: 31px;
										padding-top: 10px;
										margin-left: -3px;
										margin-right: 1px;
										border.radius: 5px 5px 5px 5px;
										-moz-border-radius: 5px 5px 5px 5px;
										-webkit-border-radius: 5px 5px 5px 5px;
										border-style: solid;
										border-width: 1px;
										border-color: #DFDFDF;
									}

									.Menu2Actual1 {
										background-color: #23CDFD;
										border-radius: 5px 1px 1px 5px;
										padding-bottom: 12px;
										padding-top: 11px;
										margin-top: -11px;
										padding-left: 42px;
										color: #FFF;
									}

									.Menu2Actual2 {
										background-color: #23CDFD;
										border-radius: 1px 1px 1px 1px;
										padding-bottom: 12px;
										padding-top: 11px;
										margin-top: -11px;
										padding-left: 42px;
										color: #FFF;
									}

									.Menu2Actual3 {
										background-color: #23CDFD;
										border-radius: 1px 5px 5px 1px;
										padding-bottom: 11px;
										padding-top: 12px;
										margin-top: -11px;
										padding-left: 42px;
										color: #FFF;
									}
								</style>

								<div class="tab-pane active" id="tab1">

									<div class="Menu1C">
										<div class="col-md-3 Menu2Actual1">Vehiculo</div>
										<div class="col-md-3">Propietario</div>
										<div class="col-md-3">Vigencia</div>
										<div class="col-md-3">Confirmar</div>

									</div>

									<div class="row">

										<!-- Group -->
										<div class="col-md-4 control-group">

											<label class="control-label">Tipo *</label>
											<div class="controls">



												<select name="tipo" id="tipo" style="display:compact" class="form-control">
													<option value="">- Seleccionar - </option>
													<?php
													$tipoVehiculo = new vehiculoController;
													$rescat2 = $tipoVehiculo->getTypes();
													while ($cat2 = mysql_fetch_array($rescat2)) {
														$c2 = $cat2['nombre'];
														$c_id2 = $cat2['veh_tipo'];

														echo "<option value=\"$c_id2\" >$c2</option>";
													}
													?>
												</select>



											</div>

											<!-- // Group END -->
											<p class="error help-block" id="errortipo" style="display:none"><span class="label label-important">Por favor seleccione tipo</span></p>



											<script>
												$("#tipo").change(
													function() {
														var id = $(this).val();
														CargarAjax2('Admin/Sist.Sucursal/Seguro/AJAX/Tipo.php?tipo_id=' + id + '', '', 'GET', 'tipo_desc');
														CargarAjax2('Admin/Sist.Sucursal/Seguro/seguroV2.php?tipo_id=' + id + '', '', 'GET', 'kk');



													});

												$("#tipo").change(
													function() {
														var id = $(this).val();
														//alert(id);
														if (id == '1') { // Autobus
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '2') { //Automovil

															$("#tabla101").css("display", "block"); // casa del conductor

															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '3') { // Camion
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '4') { // Camion Cabezote
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '5') { // Camion Volteo
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); //  asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '6') { // Camioneta
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "block"); //  asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '7') { // Four Wheel
															$("#tabla100").css("display", "none"); // casa del conductor
															$("#tabla101").css("display", "none"); //  asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "block"); // casa del conductor motocicleta
															$("#HR1").css("display", "none");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '8') { // Furgoneta
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "block");
														}
														if (id == '9') { // Grua
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '10') { // jeep
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "block"); // asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '11') { // jeepeta
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "block"); // asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '12') { // maquinaria pesada
															$("#tabla100").css("display", "none"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "none");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '13') { // miniban
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "block"); // asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '14') { // motocicleta
															$("#tabla100").css("display", "none"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "block"); // casa del conductor motocicleta
															$("#HR1").css("display", "none");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '15') { // motoneta
															$("#tabla100").css("display", "none"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "block"); // casa del conductor motocicleta
															$("#HR1").css("display", "none");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '16') { //  station wagon
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "block"); // asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '17') { // trailer 
															$("#tabla100").css("display", "none"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "none");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '18') { // van
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "block"); // asistencia vial
															$("#tabla102").css("display", "block"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "block");
															$("#HR3").css("display", "block");
														}
														if (id == '19') { // minubus
															$("#tabla100").css("display", "block"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "block");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
														if (id == '20') { // remolque
															$("#tabla100").css("display", "none"); // casa del conductor
															$("#tabla101").css("display", "none"); // asistencia vial
															$("#tabla102").css("display", "none"); // aumento de fianza
															$("#tabla103").css("display", "none"); // casa del conductor motocicleta
															$("#HR1").css("display", "none");
															$("#HR2").css("display", "none");
															$("#HR3").css("display", "none");
														}
													});
											</script>




										</div>

										<!-- Group -->
										<div class="col-md-4 control-group">
											<label class="control-label">Marca *<?= $_GET['tipo_id'] ?></label>
											<div class="controls">
												<select name="marca" id="marca" style="display:compact" class="form-control">
													<option value="">- Seleccionar - </option>
													<?php
													$rescat = mysql_query(
														"SELECT ID, DESCRIPCION from seguro_marcas order by DESCRIPCION ASC"
													);
													while ($cat = mysql_fetch_array($rescat)) {
														$c = $cat['DESCRIPCION'];
														$c_id = $cat['ID'];
														if ($v['veh_marca'] == $c_id) {
															echo "<option value=\"$c_id\" selected>$c</option>";
														} else {
															echo "<option value=\"$c_id\">$c</option>";
														}
													}
													?>
												</select>


												<script>
													$("#marca").change(

														function() {
															var id = $(this).val();
															var model = document.getElementById("tipo").value;
															CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id=' + id + '&tipo=' + model + '', '', 'GET', 'modelo');
															console.log(model)
														});
														$("#tipo").change(

															function() {
																var id = document.getElementById("marca").value;
																var model = document.getElementById("tipo").value;
																CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id=' + id + '&tipo=' + model + '', '', 'GET', 'modelo');
															});
												</script>
											</div>
											<p class="error help-block" id="errormarca" style="display:none"><span class="label label-important">Por favor seleccione marca</span></p>
										</div>
										<!-- // Group END -->
										<!-- Group -->
										<div class="col-md-4 control-group">
											<label class="control-label">Modelo</label>
											<div class="controls">

												<?php if ($v['modelo']) {
													echo "
												<script>
												CargarAjax2('Admin/Sist.Sucursal/Seguro/Vehiculos/AJAX/Modelos.php?marca_id=" .
														$v['veh_marca'] .
														"&tipo=".$cat2['id'].
														"&selec=" .
														$v['modelo'] .
														
														"','','GET','modelo');
												
												</script>
												";
												} ?>

												<div id="modelo" disabled="disabled" class="col-md-12" style="margin-left:-15px;">
													<select name="modelo" id="modelo" style="display:compact" disabled="disabled" class="form-control">
														<option selected="selected" value="0" tabindex="12">Seleccione la marca...</option>
													</select>
												</div>
												<p class="error help-block" id="errormodelo" style="display:none"><span class="label label-important">Por favor seleccione modelo</span></p>
											</div>

										</div>
										<!-- // Group END -->
									</div>
									<div class="row">
										<!-- Group -->
										<div class="col-md-4 control-group">
											<label class="control-label">Año *</label>
											<div class="controls">
												<select name="year" id="year" class="form-control">
													<option value="">- Seleccionar -</option>
													<?php
													$yaerAct = date('Y'); //2016

													$yaerAct = $yaerAct + 1;
													$year = '50'; //100
													$Total = $yaerAct - $year; // 2016 - 100 = 1916
													for ($i = $yaerAct; $i >= $Total; $i--) { ?>
														<option value="<?= $i ?>" <?php if (
																						$v['veh_year'] == '$i'
																					) { ?> selected="selected" <?php } ?>><?= $i ?></option>
													<?php }
													?>

												</select>
											</div>
											<p class="error help-block" id="errorano" style="display:none"><span class="label label-important">Por favor seleccione año</span></p>
										</div>
										<!-- // Group END -->

										<!-- Group -->
										<div class="col-md-4 control-group">
											<label class="control-label">Chasis *</label>
											<div class="controls" id="chasis">
												<input name="chassis" type="text" class="form-control" id="chassis" value="<?= $v['veh_chassis'] ?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" maxlength="17" />

											</div>
											<p class="error help-block" id="errorchassis" style="display:none"><span class="label label-important">Digitar chasis</span></p>
										</div>
										<!-- // Group END -->
										<!-- Group -->
										<div class="col-md-4 control-group">
											<label class="control-label">Placa *</label>
											<div class="controls">
												<input type="text" name="placa" id="placa" class="form-control" onKeyUp="javascript:this.value=this.value.toUpperCase();" maxlength="10" />
											</div>
											<p class="error help-block" id="errorplaca" style="display:none"><span class="label label-important">Digitar placa</span></p>
										</div>
										<!-- // Group END -->

									</div>
									<div class="pagination margin-bottom-none">
										<ul>
											<input name="acep" type="button" id="acep" value="Siguiente" class="btn btn-primary" onClick="IrPaso2();" tabindex="8" />
										</ul>
									</div>
								</div>


								<!-- // Step 1 END -->

								<!-- Step 2 -->
								<div class="tab-pane" id="tab2" style="display:none">
									<div class="Menu1C">
										<div class="col-md-3">Vehiculo</div>
										<div class="col-md-3 Menu2Actual2">Propietario</div>
										<div class="col-md-3">Vigencia</div>
										<div class="col-md-3">Confirmar</div>
									</div>

									<div class="row">
										<!-- Group -->
										<div class="col-md-6 control-group">
											<label class="control-label">Nombres *</label>
											<div class="controls">
												<input type="text" class="form-control" name="nombres" id="nombres" value="<?= $row['nombres'] ?>" onKeyPress="return soloLetras(event)" autocomplete="off" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
											</div>
											<p class="error help-block" id="errornombres" style="display:none"><span class="label label-important">Digitar nombre</span></p>
										</div>
										<!-- // Group END -->
										<!-- Group -->
										<div class="col-md-6 control-group">
											<label class="control-label">Apellidos *</label>
											<div class="controls">
												<input type="text" class="form-control" name="apellidos" id="apellidos" value="<?= $row['apellidos'] ?>" onKeyPress="return soloLetras(event)" autocomplete="off" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
											</div>
											<p class="error help-block" id="errorapellido" style="display:none"><span class="label label-important">Digitar apellido</span></p>
										</div>
										<!-- // Group END -->
									</div>
									<div class="row">
										<!-- Group -->
										<div class="col-md-3 control-group">
											<label class="control-label">Cédula *</label>
											<div class="controls">
												<input type="text" class="form-control" name="cedula" id="cedula" value="<?= $row['cedula'] ?>" onKeyPress="return acceptNum(event)" maxlength="13" />
											</div>
											<p class="error help-block" id="errorcedula" style="display:none"><span class="label label-important">Digitar cedula</span></p>
										</div>
										<!-- // Group END -->
										<!-- Group -->
										<div class="col-md-3 control-group">
											<label class="control-label">Celular *</label>
											<div class="controls">
												<input type="text" class="form-control" name="telefono1" id="telefono1" value="<?= $row['telefono1'] ?>" onKeyPress="return acceptNum(event)" maxlength="12" />
											</div>
											<p class="error help-block" id="errortelefono" style="display:none"><span class="label label-important">Digitar telefono</span></p>
										</div>
										<!-- // Group END -->
										<!-- Group -->
										<div class="col-md-6 control-group">
											<label class="control-label">Email </label>
											<div class="controls">
												<input type="text" class="form-control" name="email" id="email" value="<?= $row['email'] ?>" />
											</div>
										</div>
										<!-- // Group END -->

									</div>
									<div class="row">
										<!-- Group -->
										<div class="col-md-8 control-group">
											<label class="control-label">Dirección *</label>
											<div class="controls">
												<input type="text" class="form-control" name="direccion" id="direccion" value="<?= $row['direccion'] ?>" />
											</div>
											<p class="error help-block" id="errordireccion" style="display:none"><span class="label label-important">Digitar direccion</span></p>
										</div>
										<!-- // Group END -->
										<!-- Group -->
										<div class="col-md-4 control-group">
											<label class="control-label">Ciudad *</label>
											<div class="controls">

												<select name="ciudad" id="ciudad" class="form-control" style="display:compact">
													<option value="">- Seleccionar -</option>
													<?php
													$resprov3 = mysql_query("
													SELECT id, descrip, activo from ciudad WHERE activo ='si' order by descrip ASC");
													while ($prov = mysql_fetch_array($resprov3)) {
														$c = $prov['descrip'];
														$c_id = $prov['id'];
														if ($c_id == $row['ciudad']) {
															echo "<option value=\"$c_id\" selected=\"selected\">$c
													</option>";
														} else {
															echo "<option value=\"$c_id\">$c</option>";
														}
													}
													?>
												</select>

											</div>
											<!-- // Group END -->
											<p class="error help-block" id="errorciudad" style="display:none"><span class="label label-important">Por favor seleccione ciudad</span></p>

										</div>

										<!-- Group -->

									</div>

									<div class="pagination margin-bottom-none">
										<ul>
											<input name="acep" type="button" id="acep" value="Atras" class="btn btn-primary" onClick="IrPaso1();" tabindex="8" />
											<input name="acep" type="button" id="acep" value="Siguiente" class="btn btn-primary" onClick="IrPaso3();" tabindex="8" />
											<!--<li class="primary previous"><a href="javascript:;" onclick="IrPaso1();">Atras</a></li>					  	
                        <li class="next primary"><a href="javascript:;" onclick="IrPaso3();">Siguiente</a></li>
				-->
										</ul>
									</div>
								</div>
								<!-- // Step 2 END -->

								<script>
									$("#elegir1").click(function() {
										$(this).addClass("btn-success");
										$("#elegir2").addClass("btn-default").removeClass("btn-success");
										$("#elegir3").addClass("btn-default").removeClass("btn-success");
										$("#vigencia_poliza").val(3);

										$(".3-meses").css("display", "block");
										$(".6-meses").css("display", "none");
										$(".12-meses").css("display", "none");
									});

									$("#elegir2").click(function() {
										$(this).addClass("btn-success");
										$("#elegir1").addClass("btn-default").removeClass("btn-success");
										$("#elegir3").addClass("btn-default").removeClass("btn-success");
										$("#vigencia_poliza").val(6);
										$("#vigencia_poliza").html('6');

										$(".3-meses").css("display", "none");
										$(".6-meses").css("display", "block");
										$(".12-meses").css("display", "none");
									});

									$("#elegir3").click(function() {
										$(this).addClass("btn-success");
										$("#elegir1").addClass("btn-default").removeClass("btn-success");
										$("#elegir2").addClass("btn-default").removeClass("btn-success");
										$("#vigencia_poliza").val(12);

										$(".3-meses").css("display", "none");
										$(".6-meses").css("display", "none");
										$(".12-meses").css("display", "block");
									});
								</script>



								<!-- Step 3 -->
								<div class="tab-pane" id="tab3" style="display:none">
									<div class="Menu1C">
										<div class="col-md-3">Vehiculo</div>
										<div class="col-md-3">Propietario</div>
										<div class="col-md-3 Menu2Actual2">Vigencia</div>
										<div class="col-md-3">Confirmar</div>
									</div>


									<div class="row" style="width: 100%;padding-left: 24px; margin-bottom: 13px; font-weight: bold;">
										<!-- Group -->
										<div class="col-md-12 control-group">
											<label class="control-label">Seleccionar aseguradora</label>
											<div class="controls">


												<select name="aseguradora" id="aseguradora" style="font-size: large; color: #09b6e7;" class="form-control">
													<option value="">- Seleccionar -</option>
													<?php
													$R2 = mysql_query(
														"SELECT id, nombre, activo from seguros WHERE activo ='si' order by nombre ASC"
													);
													while ($C2 = mysql_fetch_array($R2)) {
														$c_nombre = $C2['nombre'];
														$c_id = $C2['id'];
														echo "<option value=\"$c_id\">$c_nombre</option>";
													}
													?>
												</select>


											</div>

										</div>
										<!-- // Group END -->
									</div>
									<script>
										$("#aseguradora").change(function() {

											var id = $(this).val();


											if (id == 1) {
												$("#logo1").attr('src', 'images/Aseguradora/dominicana.jpg');
											}

											if (id == 2) {
												$("#logo1").attr('src', 'images/Aseguradora/patria.png');
											}

											if (id == 3) {
												$("#logo1").attr('src', 'images/Aseguradora/general.png');
											}


										});
									</script>

									<div class="row" style="width: 100%;padding-left: 24px;">
										<!-- 3 Meses -->
										<div class="col-md-4 widget widget-heading-simple widget-body-gray" margin-left: 5px;>
											<div class="center widget-body" style="    border: solid 1px #ccc;
    background-color: #F5F5F5; color:#000000; width: 128px; height: 103px; padding-top: 0px;">
												<h4>3 Meses</h4>
												<h5 class="label label-important" id="label_vigencia3" style="color:#000000; font-size:14px;">RD$0</h5>
												<div class="separator bottom"></div>
												<button type="button" class="btn-default btn-default" id="elegir1">Elegir</button>

											</div>
										</div>
										<!-- 3 Meses END-->
										<!-- 6 Meses -->
										<div class="col-md-4 widget widget-heading-simple widget-body-gray">
											<div class="center widget-body" style="    border: solid 1px #ccc;
    background-color: #F5F5F5; color:#000000; width: 128px; height: 103px; padding-top: 0px;">
												<h4>6 Meses</h4>
												<h5 class="label label-important" id="label_vigencia6" style="color:#000000; font-size:14px;">RD$0</h5>
												<div class="separator bottom"></div>
												<button type="button" class="btn-default btn-default" id="elegir2">Elegir</button>

											</div>
										</div>
										<!-- 6 Meses END-->
										<!-- 12 Meses -->
										<div class="col-md-4 widget widget-heading-simple widget-body-gray">
											<div class="center widget-body" style="    border: solid 1px #ccc;
    background-color: #F5F5F5; color:#000000; width: 128px; height: 103px; padding-top: 0px;">
												<h4>12 Meses</h4>
												<h5 class="label label-important" id="label_vigencia12" style="color:#000000; font-size:14px;">RD$0</h5>
												<div class="separator bottom"></div>
												<button type="button" class="btn-default btn-success" id="elegir3">Elegir</button>

											</div>
										</div>
										<!-- 12 Meses END-->

									</div>
									<!-- Row END-->
									<!-- Row-->
									<style>
										hr.style14 {
											border: 0;
											height: 1px;
											background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
											background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
											background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
											background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
											margin-bottom: 8px;
											margin-top: 5px;
										}
									</style>
									<div class="row" style="width: 100%;padding-left: 24px;" id="textserv">
										<div class="col-md-12" style="margin-top: -21px;">
											<h3>Servicios Adicionales</h3>
										</div>
									</div>

									<?php
									$query = mysql_query("
	SELECT * FROM servicios 
	WHERE activo ='si'
	ORDER BY id DESC ");
									$numDisp = '0';
									while ($nominadep = mysql_fetch_array($query)) {
										$numDisp++; ?>


										<div class="row" id="tabla<?= $nominadep['id'] ?>" style="display:none">
											<div class="col-md-12">

												<div class="row">
													<div class="col-md-9"><b><?= $nominadep['nombre'] ?></b> </div>
													<div class="col-md-2 3-meses" id="M1<?= $nominadep['id'] ?>" style="display:none"> <?= FormatDinero(
																																			$nominadep['3meses']
																																		) ?> </div>
													<div class="col-md-2 6-meses" id="M2<?= $nominadep['id'] ?>" style="display:none"> <?= FormatDinero(
																																			$nominadep['6meses']
																																		) ?> </div>
													<div class="col-md-2 12-meses" id="M3<?= $nominadep['id'] ?>"> <?= FormatDinero(
																														$nominadep['12meses']
																													) ?> </div>
													<div class="col-md-1"> <input name="servicios[]" type="checkbox" value="<?= $nominadep['id'] ?>" style="width: 19px; height: 16px;" /></div>
												</div>
											</div>
										</div>
										<hr class="style14" id="HR<?= $nominadep['id'] ?>" style="display:none">
									<?php
									}
									?>

									<div class="row" style="width: 100%; padding-left: 24px; margin-top: -33px;">
										<!-- Inicio de vigencia -->
										<div class="col-md-12 widget widget-heading-simple widget-body-gray">
											<div class="center widget-body">
												<h4 class="span5" style="margin-bottom: -2px;">Inicio de vigencia</h4>
												<!--<?= $vg_12 ?> -->
												<!-- Group -->
												<div class="controls">
													<!--<div class="input-append">-->

													<b> </b>





													<div id="sandbox-container"> <input type="text" class="form-control" value="<?= $fecha1 ?>" name="fecha_inicio" id="fecha_inicio"></div>
													<span id="error_fecha_ini" class="span_error_fecha" style="width:100px; display:none;"><b>Fecha Invalida!</b></span>
												</div>
												<!-- // Group END -->
											</div>
										</div>
										<!-- Inicio de vigencia END-->
									</div>
									<!-- Row END-->

									<div class="pagination margin-bottom-none" style="margin-top: -15px;">
										<ul>
											<input name="acep" type="button" id="acep" value="Atras" class="btn btn-primary" onClick="IrPaso2();" tabindex="8" />
											<input name="acep" type="button" id="acep" value="Siguiente" class="btn btn-primary" onClick="IrPaso4();" tabindex="8" />
											<!-- <li class="primary previous"><a href="javascript:;" onclick="IrPaso2();">Atras</a></li>					  	
                             <li class="next primary"><a href="javascript:;" onclick="IrPaso4();">Siguiente</a></li>-->
										</ul>
									</div>

								</div>
								<!-- // Step 3 END -->

								<!-- Step 4 -->
								<div class="tab-pane" id="tab4" style="display:none">
									<div class="Menu1C">
										<div class="col-md-3">Vehiculo</div>
										<div class="col-md-3">Propietario</div>
										<div class="col-md-3">Vigencia</div>
										<div class="col-md-3 Menu2Actual3">Confirmar</div>
									</div>
									<img src="images/Logo-Dominicana-de-Seguros.jpg" width="360" height="102" id="logo1">
									<h3>Esta a punto de vender un seguro de ley</h3>
									<i> Por favor verifique los datos antes de proceder a realizar la venta</i>
									<div class="separator bottom"></div>
									<h5 class="heading strong text-uppercase">Vehiculo</h5>
									<table class="table table-striped table-bordered table-condensed table-white dataTable">
										<tbody role="alert" aria-live="polite" aria-relevant="all">
											<tr class="gradeA odd">
												<td class=" sorting_1">
													<div id="label_tipo"></div>
												</td>
												<td class="sorting_1">
													<div id="label_ano"></div>
												</td>
											</tr>
											<tr class="sorting_1">
												<td class=" sorting_1"><span id="label_marca"></span></td>
												<td class="sorting_1 ">Chasis: <span id="label_chassis"></span></td>
											</tr>
											<tr class="sorting_1">
												<td class=" sorting_1">
													<div id="label_modelo"></div>
												</td>
												<td class="sorting_1 ">Placa: <span id="label_placa"></span></td>
											</tr>
										</tbody>
									</table>
									<h5 class="heading strong text-uppercase">Propietario</h5>
									<table class="table table-striped table-bordered table-condensed table-white dataTable">
										<tbody role="alert" aria-live="polite" aria-relevant="all">
											<tr class="gradeA odd">
												<td class=" sorting_1">Nombres: <span id="label_nombres"> </span></td>
												<td class="sorting_1">Teléfono: <span id="label_telefono1"></span></td>
											</tr>
											<tr class="sorting_1">
												<td class=" sorting_1">Apellidos: <span id="label_apellidos"></span></td>
												<td class="sorting_1">Cédula: <span id="label_cedula"></span></td>
											</tr>
											<tr class="sorting_1">
												<td class="sorting_1" colspan="2">Dirección: <span id="label_direccion"></span></td>
											</tr>
										</tbody>
									</table>

									<h5 class="heading strong text-uppercase">Vigencia</h5>
									<table class="table table-striped table-bordered table-condensed table-white dataTable">
										<tbody role="alert" aria-live="polite" aria-relevant="all">
											<tr class="gradeA odd">
												<td class=" sorting_1"><span id="label_vigencia_poliza"></span> Meses</td>
												<td class="sorting_1">Vigente desde el



													<script>
														$(function() {
															$("#fecha_inicio").datepicker({
																dateFormat: 'dd/mm/yy'
															});
														});


														var f = new Date();
														var fechas = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();

														$("#verfecha").html(fechas);

														$("#fecha_inicio").change(
															function() {
																fec = $(this).val();
																$("#verfecha").html(fec);
															});
													</script>

													<b id="verfecha"></b>

												</td>
											</tr>
										</tbody>
									</table>

									<h5 class="heading strong text-uppercase">Cobertura</h5>
									<table class="table table-striped table-bordered table-condensed table-white dataTable">
										<tbody role="alert" aria-live="polite" aria-relevant="all">
											<tr class="gradeA odd">
												<td class=" sorting_1"><span id="label_vigencia_poliza"></span> Da&ntilde;o a la propoiedad ajena</td>
												<td class="sorting_1"><span id="DPA"> </span></td>
											</tr>
											<tr class="gradeA odd">
												<td class=" sorting_1"><span id="label_vigencia_poliza"></span> Responsabilidad civil<br />
													Muerte accidental de 1 persona</td>
												<td class="sorting_1"><span id="RCA"> </span></td>
											</tr>
											<tr class="gradeA odd">
												<td class=" sorting_1"><span id="label_vigencia_poliza"></span> Responsabilidad civil<br />
													Muerte accidental mas de 1 persona</td>
												<td class="sorting_1"><span id="RCA2"> </span></td>
											</tr>
											<tr class="gradeA odd">
												<td class=" sorting_1"><span id="label_vigencia_poliza"></span> Fianza judicial</td>
												<td class="sorting_1"><span id="FJ"> </span></td>
											</tr>
										</tbody>
									</table>


									<div class="pagination margin-bottom-none">
										<ul>

											<input name="acep" type="button" id="acep" value="Inicio" class="btn btn-primary" onClick="IrPaso1();" tabindex="8" />

											<input name="acep" type="button" id="acep" value="Atras" class="btn btn-primary" onClick="IrPaso3();" tabindex="8" />

											<input name="acep" type="button" id="acep" value="Realizar Venta" class="btn btn-primary" onClick="EnviarSeguro();" tabindex="8" />
											<!--<li class="primary previous first"><a href="javascript:;" onclick="IrPaso1();">Inicio</a></li>
                          <li class="primary previous"><a href="javascript:;"  onclick="IrPaso3();">Atras</a></li>					  	
                          <li class="primary previous"><a href="javascript:;" onClick="EnviarSeguro();" >Realizar venta</a></li>-->
										</ul>
									</div>

								</div>



							</div>

							<!-- Wizard pagination controls -->

							<!-- // Wizard pagination controls END -->
							<input name="vigencia_poliza" id="vigencia_poliza" type="hidden" value="12" />





						</div>
					</div>
				</div>
				<!-- // Form Wizard / Arrow navigation & Progress bar END -->
			</div>
			<!-- // Modal body END -->

			<!-- Modal footer -->
			<!--<div class="modal-footer">
	</div>-->
			<!-- // Modal footer END -->

			<!-- Bootstrap Form Wizard Plugin -->

			<div style="display:none" id="tipo_desc"></div>
		</div>
	</form>


	<!--<script src="js/bootstrap.min.js"></script>-->
	<script src="js/jquery.bootstrap.wizard.js"></script>
	<!--<script src="http://multiplesrecargas.com/recharge_Mod_New/common/bootstrap/extend/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js"></script>-->
	<script src="js/form-wizards.init.js"></script>
</div>