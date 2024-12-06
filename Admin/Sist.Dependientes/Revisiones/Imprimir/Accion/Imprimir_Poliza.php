<?php
session_start();
ini_set('display_errors', 1);
set_time_limit(0);

include("../../../../../incluidos/conexion_inc.php");
include("../../../../../incluidos/fechas.func.php");
include("../../../../../incluidos/nombres.func.php");
Conectarse();

$directorio = "https://multiseguros.com.do/SegurosChat/images/";
$logo = "https://multiseguros.com.do/SegurosChat/images/Aseguradora/";

$ancho  = "690";
$anchoP = "345";
$altura = "3100";

//BUSCAR TRANSACCION
$query = mysql_query("select * from seguro_transacciones   
	WHERE id ='" . $_GET['id_trans'] . "' LIMIT 1");
//echo "select * from seguro_transacciones   
//WHERE id ='".$_GET['id_trans']."' LIMIT 1";

$row = mysql_fetch_array($query);
$id_aseguradora = $row['id_aseg'];

switch ($id_aseguradora) {
	case '1':
		$NombreImg = "dominicana.jpg";
		break;
	case '2':
		$NombreImg = "patria.png";
		break;
	case '3':
		$NombreImg = "general.png";
		break;
	case '4':
		$NombreImg = "atrio.png";
		break;
	default:
		$NombreImg = "";
		break;
}


//BUSCAR DATOS DEL CLIENTE
$QClient = mysql_query("select * from seguro_clientes WHERE id ='" . $row['id_cliente'] . "' LIMIT 1");
//echo "select * from seguro_clientes WHERE id ='".$row['id_cliente']."' LIMIT 1";
$RQClient = mysql_fetch_array($QClient);

//BUSCAR DATOS DEL VEHICULO
$QVeh = mysql_query("select * from seguro_vehiculo WHERE id ='" . $row['id_vehiculo'] . "' LIMIT 1");
//echo "select * from seguro_vehiculo WHERE id ='".$row['id_vehiculo']."' LIMIT 1";
$RQVehi = mysql_fetch_array($QVeh);

$tarifa = explode("/", TarifaVehiculo($RQVehi['veh_tipo']));

$dpa 	= substr(FormatDinero($tarifa[0]), 0, -3);
$rc 		= substr(FormatDinero($tarifa[1]), 0, -3);
$rc2 	= substr(FormatDinero($tarifa[2]), 0, -3);
$ap 		= substr(FormatDinero($tarifa[3]), 0, -3);
$fj 		= substr(FormatDinero($tarifa[4]), 0, -3);

$montoSeguro = RepMontoSeguro($row['id']);

$poliza = GetPrefijo($row['id_aseg']) . '-' . str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
$Agent = explode("-", $row['x_id']);
$Agencia = explode("/", AgenciaVia($Agent[0]));
?>



<script type="text/javascript">
	function imprSelec(nombre) {
		$("#tick").css("display", "block");
		$("#tick2").css("display", "block");
		var ficha = document.getElementById(nombre);
		var ventimp = window.open(' ', 'popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
	}
</script>
<!---->
<div id="ImprimirPoliza" align="center" style="display:none">
	<table style="width:690px; margin-bottom: 5px;" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<td width="60%" align="center" style="font-size: 18.5px;">CERTIFICADO DE SEGURO<br>VEHICULOS DE MOTOR</td>
			<td width="40%" align="center"><img src="<?= $directorio ?>/logo.png" style="height:60px" alt="" /></td>
		</tr>
	</table>


	<table width="<?= $ancho ?>px;" style="font-size:11px;" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td width="462" align="left" valign="top"><b>ASEGURADO: <?= $RQClient['asegurado_nombres'] ?> <?= $RQClient['asegurado_apellidos'] ?></b></td>
			<td width="447" align="left" valign="top"><b>POLIZA NO: <?= $poliza ?></b></td>
		</tr>
		<tr>
			<td valign="top" align="left"><b>CEDULA: <?= CedulaPDF($RQClient['asegurado_cedula']) ?></b></td>
			<td valign="top" align="left"><b>ASEGURADORA: <?= NombreSeguroS($row['id_aseg']) ?></b></td>
		</tr>
		<tr>
			<td valign="top" align="left"><b>DIRECCION: <?= $RQClient['asegurado_direccion'] ?></b></td>
			<td valign="top" align="left"><b>FECHA DE EMISION: <?= FechaListPDF($row['fecha']) ?></b></td>
		</tr>
		<tr>
			<td valign="top" align="left"><b>TELEFONO: <?= TelefonoPDF($RQClient['asegurado_telefono1']) ?></b></td>
			<td valign="top" align="left"><b>INICIO DE VIGENCIA: <?= FechaListPDFn($row['fecha_inicio']) ?></b></td>
		</tr>
		<tr>
			<td valign="top" align="left"><b>AGENCIA: <?= strtoupper($Agencia[0]) ?></b></td>
			<td valign="top" align="left"><b>FIN DE VIGENCIA: <?= FechaListPDFin($row['fecha_fin']) ?></b></td>
		</tr>
		<tr>
			<td valign="top" align="left" colspan="2"><b><?= strtoupper($Agencia[1]) ?> &nbsp;</b></td>
		</tr>
		<tr>
			<td valign="top" colspan="2" style="text-align:justify; border-top:solid 1px #000; font-size:11.5px !important">
				<font style="margin-top:15px"><b>Términos y Partes</b></font><br>
				En virtud del pago de la prima estipulada y basándose en las declaraciones y garantías expresas más abajo, la Aseguradora se obliga a indemnizar al asegurado hasta una cantidad que no exceda los límites que se consignan, por las pérdidas o daños por él sostenidos de hecho y por los riesgos que, según se explican es esta póliza, puedan sufrir o causar el vehículo que se descrito en la misma, mientras esté dentro del territorio de la República Dominicana y siempre que tales pérdidas o daños hayan sido sufridos por el Asegurado debido a accidentes dentro del período de tiempo comprendido entre el día y la hora señalados como inicio de vigencia y las doce (12) meridiano del día señalado como fin de fin de vigencia. Esta póliza solamente asegura contra aquellos riesgos por los cuales aparezca específicamente cargada una prima.
				<p>Este Certificado de Seguro está sujeto a todos los demás términos, cláusulas, endosos y condiciones de la póliza de Vehículos de Motor aprobados por la Superintendencia de Seguros y contemplados en la Ley 146-02 sobre Seguros y Fianzas, salvo sus excepciones y los servicios opcionales que son contratados con sus respectivos suplidores.</p>

				<b>Declaraciones y Garantías por el Asegurado</b> <br>
				Las informaciones contenidas en este documento son las declaraciones y garantías suministradas por el asegurado, quien garantiza la exactitud y veracidad de las mismas y, basándose en ellas, la Aseguradora emite esta póliza, limitándose a aplicar las primas que correspondan con arreglo a dichas declaraciones.
			</td>
		</tr>

		<tr>
			<td valign="top" colspan="2" align="center" style="border-top:solid 1px #000;">
				<font style="margin-top:7px; margin-bottom: 0px; font-size:11px"><b>PLAN BASICO DE LEY - CONDICIONES PARTICULARES</b></font>
			</td>
		</tr>
		<tr>
			<td valign="bottom" align="left"><b>TIPO:</b> <?= TipoVehiculo($RQVehi['veh_tipo']) ?></td>
			<td valign="bottom" align="left"><b>AÑO:</b> <?= $RQVehi['veh_ano'] ?></td>
		</tr>
		<tr>
			<td valign="bottom" align="left"><b>MARCA:</b> <?= VehiculoMarca($RQVehi['veh_marca']) ?></td>
			<td valign="bottom" align="left"><b>CHASSIS:</b> <?= $RQVehi['veh_chassis'] ?></td>
		</tr>
		<tr>
			<td valign="bottom" align="left"><b>MODELO:</b> <?= VehiculoModelos($RQVehi['veh_modelo']) ?></td>
			<td valign="bottom" align="left"><b>REGISTRO:</b> <?= $RQVehi['veh_matricula'] ?></td>
		</tr>
		<tr>
			<td valign="top" style="border-top:solid 1px #000;">



				<table width="<?= $anchoP ?>px;" cellpadding="2" cellspacing="0" style="font-size:11px;">
					<tr>
						<td colspan="2" align="left"><b>COBERTURAS Y LIMITES (En RD$)</b></td>
					</tr>
					<tr>
						<td align="left" width="260">Daños a la Propiedad Ajena</td>
						<td align="left"><?= $dpa ?></td>
					</tr>
					<tr>
						<td align="left">Lesiones Corporales o Muerte 1 Persona</td>
						<td align="left"><?= $rc ?></td>
					</tr>
					<tr>
						<td align="left">Lesiones Corporales o Muerte Más de 1 Persona</td>
						<td align="left"><?= $rc2 ?></td>
					</tr>
					<tr>
						<td align="left">Lesiones Corporales o Muerte 1 Pasajero</td>
						<td align="left"><?= $rc ?></td>
					</tr>
					<tr>
						<td align="left">Lesiones Corporales o Muerte Más de 1 Pasajero</td>
						<td align="left"><?= $rc2 ?></td>
					</tr>
					<tr>
						<td align="left">Accidentes Personales Conductor</td>
						<td align="left"><?= $ap ?></td>
					</tr>
					<tr>
						<td align="left">Fianza Judicial</td>
						<td align="left"><?= $fj ?></td>
					</tr>
				</table>



			</td>
			<td valign="top" style="border-top:solid 1px #000; border-left:solid 1px #000;">



				<table width="<?= $anchoP ?>px;" cellpadding="2" cellspacing="0" style="font-size:11px;">
					<tr>
						<td colspan="2" align="left"><b><b>SERVICIOS ADICIONALES</b></b></td>
					</tr>

					<?

					if ($row['serv_adc'] != '') {
						//BUSCAR CANTAIDAD DE LOS SERVICIOS ADICIONALES
						/*$porciones = explode("-", $row['serv_adc']);
	 
	for($i =0; $i < count($porciones); $i++){ 
	
	if($porciones>0){
	$r = explode("|", ServAdicional($porciones[$i],$row['vigencia_poliza']));
	$NombreServ = $r[0];
	$MontoServ = $r[1];
	*/
						$montoServAdc += $MontoServ;

						$QueryH = mysql_query("select * from seguro_trans_history   
	WHERE id_trans ='" . $_GET['id_trans'] . "'");
						while ($RowHist = mysql_fetch_array($QueryH)) {

							if ($RowHist['tipo'] == 'serv') {
								$montoServAdc += $RowHist['monto'];



					?>
								<tr>
									<td align="left" width="265"><?= ServAdicHistory($RowHist['id_serv_adc']) . " - Incluido" ?></td>
									<td align="left">RD$ <?= FormatDinero($RowHist['monto']) ?></td>
								</tr>
					<?

							}
						}
					}

					?>

				</table>




			</td>
		</tr>
		<tr style="background-color:#E0E0E0;">
			<td align="left" style="border-top:solid 1px #000; border-left:solid 1px #000; border-bottom:solid 1px #000; padding-left:25px;  background-color:#E0E0E0; " valign="middle">



				<table style="height:25px; font-size:12px" cellpadding="1" cellspacing="0">
					<tr>
						<td align="left" width="221"><b>Prima Seguro Básico</b></td>
						<td width="97" align="left"><b>RD$ <?= FormatDinero($montoSeguro - $montoServAdc) ?></b></td>
					</tr>
				</table>




			</td>
			<td align="left" style="border-top:solid 1px #000; border-bottom:solid 1px #000; border-right:solid 1px #000; background-color:#E0E0E0;  " valign="middle">



				<table style="height:25px; font-size:12px" cellpadding="1" cellspacing="0">
					<tr>
						<td align="left" width="221"><b>Prima Servicios Adicionales</b></td>
						<td width="97" align="left"><b>RD$ <?= FormatDinero($montoServAdc) ?></b></td>
					</tr>
				</table>



			</td>
		</tr>

		<tr>
			<td colspan="2" align="right" height="25" style="font-size:14px">
				<strong>Total Póliza RD$ <?= FormatDinero($montoSeguro) ?></strong>
			</td>
		</tr>

	<!---	<tr style="color: #1760a5;
    font-weight: bold;
    font-size: 17px; " valign="top">
			<td align="center">
				<font style="font-size:13px"> Servicio al Cliente</font>
				<img src="https://multiseguros.com.do/SegurosChat/images/VIA/4.jpg" height="37" />
				<br> +1 809 200 1842
			</td>
			<td valign="middle" align="left">
				<div style="padding-top:10px margin-left:0px; height:15px !important; font-size: 16px;">
					ES F&Aacute;CIL, ES VIA.
				</div>
			</td>
		</tr> --->
		<tr>
			<td colspan="2" align="left">

				<table align="center" cellpadding="2" style="margin-top:15px; " width="650px">

					<tr>
						<td width="317" align="left" valign="top" style="border-right-style: dashed; border-left-style: dashed; border-top-style: dashed; border-bottom-style: dashed;  border-width:1px; ">


							<table border="0" align="center" cellpadding="1" style="font-size: 10px; margin-left:5px;">
								<tr>
									<td colspan="2">

										<table width="310px">
											<tr>
												<td align="left"><img src="<?= $logo . $NombreImg ?>" alt="" width="130px" style="margin-bottom: 10px;" /></td>
												<td align="left"><img src="<?= $directorio ?>/logo.png" alt="" width="130px" style="margin-bottom: 10px;" /></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="left" width="105"><b>NO. POLIZA:</b></td>
									<td align="left" width="204"><b><?= GetPrefijo($row['id_aseg']) ?>-<?= str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT) ?></b></td>
								</tr>
								<tr>
									<td align="left"><b>NOMBRES:</b></td>
									<td align="left"><b><?= $RQClient['asegurado_nombres'] ?> <?= $RQClient['asegurado_apellidos'] ?></b></td>
								</tr>
								<tr>
									<td align="left"><b>VEHICULO:</b></td>
									<td align="left"><b><?= TipoVehiculo($RQVehi['veh_tipo']) ?> <?= VehiculoMarca($RQVehi['veh_marca']) ?></b></td>
								</tr>
								<tr>
									<td align="left"><b>AÑO:</b></td>
									<td align="left"><b><?= $RQVehi['veh_ano'] ?></b></td>
								</tr>
								<tr>
									<td align="left"><b>CHASSIS:</b></td>
									<td align="left"><b><?= $RQVehi['veh_chassis'] ?></b></td>
								</tr>
								<tr>
									<td align="left"><b>VIGENCIA:</b></td>
									<td align="left">
										<b style="font-size:6px">DESDE</b>
										<b><?= FechaListPDFn($row['fecha_inicio']) ?></b>
										<b style="font-size:6px">HASTA</b>
										<b><?= FechaListPDFin($row['fecha_fin']) ?></b>
									</td>
								</tr>
								<tr>
									<td align="left"><b>FIANZA JUDICIAL:</b></td>
									<td align="left"><b>RD$ <?= $fj ?></b></td>
								</tr>
							</table>



						</td>
						<td width="318" valign="top" style="border-right-style: dashed; border-left-style: dashed; border-top-style: dashed; border-bottom-style: dashed; border-width:1px; ">




							<table align="center" cellpadding="1" border="0" style="font-size:8px" width="315px">
								<tr>
									<td colspan="2" align="left">
										El vehículo descrito en el anverso está asegurado bajo la póliza emitida por La Aseguradora, <br>
										sujeto a los términos, límites y condiciones que en ella se expresan y al pago de la prima. <br>
										<br>
										<b>En caso de accidente:</b> <br>
										&nbsp;&nbsp;1- Asista a los lesionados, si los hubiere. Con cuidado, retire los vehículos de la vía. <br>
										&nbsp;&nbsp;2- No acepte responsabilidad al momento del accidente; reserve su derecho. <br>
										&nbsp;&nbsp;3- Obtenga el nombre y la dirección del conductor y el propietario del otro vehículo. <br>
										&nbsp;&nbsp;4- Obtenga el número de placa, aseguradora, y número de póliza. <br>
										&nbsp;&nbsp;5- Obtenga el nombre y dirección de los lesionados y testigos. <br>
										<br>
										<b style="text-align:center !important">Comuníquese con la aseguradora antes de iniciar cualquier trámite</b><br>
									</td>
								</tr>

								<tr>
									<td colspan="2" align="left"><img src="<?= $logo . $NombreImg ?>" alt="" width="100px" /></td>
								</tr>

								<tr>
									<td align="left" style="font-size:8px">
										<?
										$Descp = mysql_query("select * from ticket_poliza WHERE id_aseg ='" . $id_aseguradora . "' LIMIT 4");
										while ($rDescp = mysql_fetch_array($Descp)) {

											echo $rDescp['ciudad'] . ': ' . $rDescp['telefono'] . '<br>';
										}
										?>


									</td>
									<td align="center" valign="top" style="color:#6886FD; font-size:9px">
										<br>Asistencia Vial <br>
										Casa del Conductor <br>
										809 381 2424
									</td>
								</tr>

							</table>





						</td>
					</tr>
				</table>

			</td>
		</tr>


	</table>
</div>

<table align="center" style="margin-top: 35px; font-size: 22px; text-align: center; margin-bottom: 10px;">
	<tr>
		<td><strong align="center">MENSAJE</strong><br>Seguro que desea imprimir la poliza</td>
	</tr>
	<tr>
		<td>
			<center> <input type="button" class="btn btn-success" value="IMPRIMIR" onclick="javascript:imprSelec('ImprimirPoliza');" /></center>
		</td>
	</tr>
</table>