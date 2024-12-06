<?
session_start();
set_time_limit(0);
include("../../../incluidos/conexion_inc.php");
include("../../../nombres.func.php");
include("../../../fechas.func.php");
Conectarse();
?>

<script type="text/javascript">
	function imprSelec(nombre) {
		var ficha = document.getElementById(nombre);
		var ventimp = window.open(' ', 'popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
	}
</script>

<DIV ID="ImprimirTicket" align="center">

	<?  //$_GET['id']=LimpiarCampos($_GET['id']);
	$query = mysql_query("
		select * from seguro_transacciones 
	WHERE  
		id ='" . $_GET['id'] . "' LIMIT 1");

	//hasta aqui
	$row = mysql_fetch_array($query);


	//BUSCAR DATOS DEL CLIENTE
	$QClient = mysql_query("select asegurado_nombres,asegurado_apellidos,asegurado_cedula 
  from seguro_clientes
  WHERE id ='" . $row['id_cliente'] . "' LIMIT 1");
	$RQClient = mysql_fetch_array($QClient);

	$fecha = explode(' ', $row['fecha']);
	$hora1 = explode('-', $fecha[0]);
	$fecha = $hora1[2] . '-' . $hora1[1] . '-' . $hora1[0];

	if ($hora1[1] == '1') $mes = "Enero";
	if ($hora1[1] == '2') $mes = "Febrero";
	if ($hora1[1] == '3') $mes = "Marzo";
	if ($hora1[1] == '4') $mes = "Abril";
	if ($hora1[1] == '5') $mes = "Mayo";
	if ($hora1[1] == '6') $mes = "Junio";
	if ($hora1[1] == '7') $mes = "Julio";
	if ($hora1[1] == '8') $mes = "Agosto";
	if ($hora1[1] == '9') $mes = "Septiembre";
	if ($hora1[1] == '10') $mes = "Octubre";
	if ($hora1[1] == '11') $mes = "Noviembre";
	if ($hora1[1] == '12') $mes = "Diciembre";

	$fecha2       = explode(' ', $row['fecha_inicio']);
	$hora12		  = explode('-', $fecha2[0]);
	$fecha_inicio = $hora12[2] . '-' . $hora12[1] . '-' . $hora12[0];
	if ($hora12[1] == '1') $mes2 = "Enero";
	if ($hora12[1] == '2') $mes2 = "Febrero";
	if ($hora12[1] == '3') $mes2 = "Marzo";
	if ($hora12[1] == '4') $mes2 = "Abril";
	if ($hora12[1] == '5') $mes2 = "Mayo";
	if ($hora12[1] == '6') $mes2 = "Junio";
	if ($hora12[1] == '7') $mes2 = "Julio";
	if ($hora12[1] == '8') $mes2 = "Agosto";
	if ($hora12[1] == '9') $mes2 = "Septiembre";
	if ($hora12[1] == '10') $mes2 = "Octubre";
	if ($hora12[1] == '11') $mes2 = "Noviembre";
	if ($hora12[1] == '12') $mes2 = "Diciembre";

	$fecha3    = explode(' ', $row['fecha_fin']);
	$hora13	   = explode('-', $fecha3[0]);
	$fecha_fin = $hora13[2] . '-' . $hora13[1] . '-' . $hora13[0];
	if ($hora13[1] == '1') $mes3 = "Enero";
	if ($hora13[1] == '2') $mes3 = "Febrero";
	if ($hora13[1] == '3') $mes3 = "Marzo";
	if ($hora13[1] == '4') $mes3 = "Abril";
	if ($hora13[1] == '5') $mes3 = "Mayo";
	if ($hora13[1] == '6') $mes3 = "Junio";
	if ($hora13[1] == '7') $mes3 = "Julio";
	if ($hora13[1] == '8') $mes3 = "Agosto";
	if ($hora13[1] == '9') $mes3 = "Septiembre";
	if ($hora13[1] == '10') $mes3 = "Octubre";
	if ($hora13[1] == '11') $mes3 = "Noviembre";
	if ($hora13[1] == '12') $mes3 = "Diciembre";


	//echo $row['fecha']."<br>";
	$a1a   = explode(' ', $row['fecha']);
	//echo $a1a[1];
	$a12a   = explode(':', $a1a[1]);


	if ($a12a[0] == '00') $fHora = "12";
	$T = "AM";
	if ($a12a[0] == '01') $fHora = "1";
	$T = "AM";
	if ($a12a[0] == '02') $fHora = "2";
	$T = "AM";
	if ($a12a[0] == '03') $fHora = "3";
	$T = "AM";
	if ($a12a[0] == '04') $fHora = "4";
	$T = "AM";
	if ($a12a[0] == '05') $fHora = "5";
	$T = "AM";
	if ($a12a[0] == '06') $fHora = "6";
	$T = "AM";
	if ($a12a[0] == '07') $fHora = "7";
	$T = "AM";
	if ($a12a[0] == '08') $fHora = "8";
	$T = "AM";
	if ($a12a[0] == '09') $fHora = "9";
	$T = "AM";
	if ($a12a[0] == '10') $fHora = "10";
	$T = "AM";
	if ($a12a[0] == '11') $fHora = "11";
	$T = "AM";
	if ($a12a[0] == '12') $fHora = "12";
	$T = "PM";
	if ($a12a[0] == '13') $fHora = "1";
	$T = "PM";
	if ($a12a[0] == '14') $fHora = "2";
	$T = "PM";
	if ($a12a[0] == '15') $fHora = "3";
	$T = "PM";
	if ($a12a[0] == '16') $fHora = "4";
	$T = "PM";
	if ($a12a[0] == '17') $fHora = "5";
	$T = "PM";
	if ($a12a[0] == '18') $fHora = "6";
	$T = "PM";
	if ($a12a[0] == '19') $fHora = "7";
	$T = "PM";
	if ($a12a[0] == '20') $fHora = "8";
	$T = "PM";
	if ($a12a[0] == '21') $fHora = "9";
	$T = "PM";
	if ($a12a[0] == '22') $fHora = "10";
	$T = "PM";
	if ($a12a[0] == '23') $fHora = "11";
	$T = "PM";



	$qVeh = mysql_query("
		SELECT id,veh_marca,veh_modelo,veh_tipo,veh_ano,veh_chassis,veh_matricula
		FROM seguro_vehiculo WHERE id='" . $row['id_vehiculo'] . "' LIMIT 1");
	$rVehiculo = mysql_fetch_array($qVeh);


	$r2s = mysql_query("SELECT * from seguro_marcas WHERE id ='" . $rVehiculo['veh_marca'] . "' LIMIT 1");
	$rows = mysql_fetch_array($r2s); {
		$veh_marca 		= $rows['DESCRIPCION'];
		//echo $veh_marca;
	}


	$r2s2 = mysql_query("SELECT * from seguro_modelos WHERE ID ='" . $rVehiculo['veh_modelo'] . "' LIMIT 1");
	$rows2 = mysql_fetch_array($r2s2); {
		$veh_modelo 		= $rows2['descripcion'];
		//echo $veh_modelo;
	}


	$qTipo = mysql_query("
SELECT id,veh_tipo,nombre,dpa,rc,rc2,fj
FROM seguro_tarifas WHERE veh_tipo='" . $rVehiculo['veh_tipo'] . "' LIMIT 1");
	$rTipo = mysql_fetch_array($qTipo);

	?>

	<?
	function Servicios($id)
	{
		$QServ = mysql_query("
		SELECT id,nombre
		FROM servicios WHERE id='" . $id . "' LIMIT 1");
		$RQServ = mysql_fetch_array($QServ);
		return $RQServ['nombre'];
	}
	$pieces = explode("-", $row['serv_adc']);
	for ($i = 0; $i < count($pieces); $i++) { ?>
		<!--<tr>
        <td colspan="2"><?= Servicios($pieces[$i]) ?> - <b>Incluido</b></td> 
       
  	</tr>-->
	<? } ?>




	<style>
		table.tick td {
			padding: 0 1em;
		}
	</style>
	<!-- TABLA DOS -->

	<table border="0" style="border:solid 1px #CCC; font-size: 14px; border-radius: 10px; margin-left: 30px; width:460px;" cellspacing="2" cellpadding="0" class="tick" id="tick">

		<tr>
			<td colspan="2" align="right" style="padding-right:10px;">No. <b><?= str_pad($_GET['id'], 10, "0", STR_PAD_LEFT); ?></b></td>
		</tr>
		<tr>
			<td width="144">Asegurado:</td>
			<td width="308" style="padding-right: 0.5em;"><strong>
					<?
					$nombre = strtolower($RQClient['asegurado_apellidos']);
					$apellido = strtolower($RQClient['asegurado_nombres']);

					?>


					<?= ucwords($nombre); ?>
					, <?= ucwords($apellido); ?>
				</strong></td>
		</tr>
		<tr>
			<td>Desde</td>
			<td style="padding-right: 0.5em;"><strong>
					<?= $hora12[2] . '/' . $hora12[1] . '/' . $hora12[0]; ?>
				</strong> &nbsp;&nbsp;&nbsp;Hasta <strong>
					<?= $hora13[2] . '/' . $hora13[1] . '/' . $hora13[0] ?>
				</strong></td>
		</tr>

		<tr>
			<td>Tipo:</td>
			<td style="padding-right: 0.5em;"><strong>
					<?= strtoupper($rTipo['nombre']) ?>
				</strong></td>
		</tr>
		<tr>
			<td>Marca:</td>
			<td style="padding-right: 0.5em;"><strong>
					<?= strtoupper($veh_marca . " " . $veh_modelo) ?>
				</strong></td>
		</tr>
		<tr>
			<td>A&ntilde;o:</td>
			<td style="padding-right: 0.5em;"><strong>
					<?= $rVehiculo['veh_ano'] ?>
				</strong> &nbsp;&nbsp;&nbsp;Placa
				<strong>
					<?= $rVehiculo['veh_matricula'] ?>
				</strong>
			</td>
		</tr>
		<tr>
			<td>Chassis No.</td>
			<td style="padding-right: 0.5em;"><strong>
					<?= $rVehiculo['veh_chassis'] ?>
				</strong></td>
		</tr>

		<tr>
			<td colspan="2">
				<table width="312" border="0" cellspacing="1" cellpadding="0">
					<tr>
						<td width="141"><img src="http://seguros101.net/SegurosChat/images/Logo-Dominicana-de-Seguros.jpg" style="    height: 26px;
    margin-left: -25px;
    margin-right: -20px;	"></td>
						<td width="168">Limite Fianza &nbsp;&nbsp;&nbsp; <strong><?= FormatDinero($rTipo['fj']) ?></strong>
							<br>
							<?
							function Servicioss($id)
							{
								$QServ = mysql_query("
		SELECT id,nombre
		FROM servicios WHERE id='" . $id . "' LIMIT 1");
								$RQServ = mysql_fetch_array($QServ);
								return $RQServ['nombre'];
							}

							$myString = trim($row['serv_adc'], '-');
							$pieces = explode("-", $myString);
							for ($i = 0; $i < count($pieces); $i++) { ?>
								<strong>**<?= Servicioss($pieces[$i]) . "<br>" ?></strong>
							<? } ?>

						</td>
					</tr>
				</table>
			</td>
		</tr>


	</table>
	<style>
		hr {
			border: 1px dashed grey;
			height: 0;
			width: 100%;
			margin-bottom: 15px;
			margin-top: 15px;
		}
	</style>
	<hr>

	<table border="0" style="border:solid 1px #CCC; font-size: 14px; border-radius: 10px; margin-left: 30px; width:460px; " cellspacing="2" cellpadding="0" class="tick" id="tick2">

		<tr>
			<td colspan="2" align="center" style="font-size: 12px;font-weight:bold;">EN CASO DE ACCIDENTE OBTENGA LA SIGUIENTE INFORMACIÓN: <b></b></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:left">
				1- Nombre y dirección del propietario y del conductor del otro vehículo.<br>

				2- Número de placa, compañía aseguradora y número de póliza de dicho vehículo.<br>

				3- Nombre y dirección de todos los testigos.<br>

				4- Nombre y dirección de los lesionados, si los hay.<br>


				<strong> - En caso de robo, notifíquelo inmediatamente a la Policía Nacional.<br>

					- Antes de iniciar cualquier trámite, comuníquese con nosotros.<br>

					- Este seguro es intransferible.<br><br>
				</strong>
			</td>

		</tr>
		<tr>
			<td colspan="2" style="font-size:12px; font-weight:bold; text-align:center">NO ACEPTE RESPONSABILIDAD EN EL MOMENTO DEL ACCIDENTE, RESERVE SUS DERECHOS</td>

		</tr>

		<tr>
			<td>

				<table style="font-size:11px; width:100%">
					<tr>
						<td colspan="2"><img src="https://multiseguros.com.do/SegurosChat/images/logo.dom.jpg" style="height: 40px;"></td>
					</tr>

					<tr>
						<td>
							Santo Domingo : </td>
						<td><strong>(809) 535-1030</strong></td>
					</tr>
					<tr>
						<td>Santiago<br>
							Región Norte: </td>
						<td><strong>(809) 582-3638</strong></td>
					</tr>
					<tr>
						<td>La Romana<br>
							Región Este: </td>
						<td><strong>(809) 813-5200</strong></td>
					</tr>
					<tr>
						<td style="text-align:center" colspan="2"><strong>** Sin Cargos 1 (200) 809-0172 **</strong></td>

					</tr>

				</table>



			</td>
			<td valign="top">
				<table style="font-size:11px;">
					<tr>
						<td colspan="2"><img src="https://multiseguros.com.do/SegurosChat/images/multiseg.png" style="height: 28px;"></td>
					</tr>

					<tr>
						<td colspan="2" style="text-align:center; font-weight:bold;">Servicio al Cliente</td>
					</tr>
					<tr>
						<td>Santo Domingo :</td>
						<td><strong> (809) 732-6589</strong></td>
					</tr>

					<tr>
						<td style="text-align:center" colspan="2">9:00am a 5:00pm</td>

					</tr>

				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<table style="font-size:11px; width:100%">
					<tr>
						<td colspan="2"><img src="https://multiseguros.com.do/SegurosChat/images/casa.conductor.png" style="height: 56px;"></td>
					</tr>


					<tr>
						<td>Santo Domingo : </td>
						<td><strong>(809) 381-2424</strong></td>
					</tr>

					<tr>
						<td>Santiago<br>
							Región Norte: </td>
						<td><b>(809) 241-4848</b></td>

					</tr>

				</table>
			</td>
			<td valign="top">
				<table style="font-size:11px; width:100%">
					<tr>
						<td colspan="2"><img src="https://multiseguros.com.do/SegurosChat/images/casa.conductor.png" style="height: 56px;"></td>
					</tr>


					<tr>
						<td>Santo Domingo : </td>
						<td><strong>(809) 381-2424</strong></td>
					</tr>

					<tr>
						<td>Santiago<br>
							Región Norte: </td>
						<td><b>(809) 241-4848</b></td>

					</tr>

				</table>
			</td>
		</tr>
	</table>

</DIV>

<center> <input type="button" value="IMPRIMIR" onclick="javascript:imprSelec('ImprimirTicket');" class="button" /></center>