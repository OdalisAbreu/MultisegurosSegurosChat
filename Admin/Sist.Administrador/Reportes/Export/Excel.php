<?php ini_set('display_errors', 1);
$fecha1 = $_GET['fecha1'];
$fecha2 = $_GET['fecha2'];

// header("Content-Type: application/vnd.ms-excel");
// header("Expires: 0");
// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// header(
// 	"content-disposition: attachment;filename=Reporte desde - " .
// 		$fecha1 .
// 		" - hasta - " .
// 		$fecha2 .
// 		".xls"
// );

session_start();

include "../../../../incluidos/conexion_inc.php";
include "../../../../incluidos/fechas.func.php";
include "../../../../incluidos/nombres.func.php";
Conectarse();

if ($_GET['aseguradora'] != '1aseg') {
	$aseg = "AND id_aseg='" . $_GET['aseguradora'] . "' ";
	$nombre = NombreSeguroS($_GET['aseguradora']);
	$clase = "1";
	$columna = "22";
	$colspan = "8";
	$colspan2 = "14";
	$calt = "17";
} else {
	$nombre = "TODAS LAS ASEGURADORAS";
	$columna = "23";
	$clase = "0";
	$colspan = "9";
	$colspan2 = "13";
	$calt = "18";
}

function MontoPorServ($vigencia_poliza, $serv_adc)
{
	$Servicios =  array(
		'casaConductor' => 0,
		'asistenciaVial' => 0,
		'accidentesPersonales' => 0,
		'planPremium' => 0,
		'ultimosGastos' => 0
	);

	if ($vigencia_poliza == 3) {
		$vigencia = 'tresMeses';
	}
	if ($vigencia_poliza == 6) {
		$vigencia = 'seismeses';
	} else {
		$vigencia = 'docemeses';
	}

	//print_r($serv_adc);

	$ServOpcional = explode("-", $serv_adc);
	for ($i = 0; $i < count($ServOpcional); $i++) {


		$qprec2 = mysql_query(
			"SELECT id,sumar, 3meses AS tresMeses, 6meses AS seismeses, 12meses AS docemeses FROM servicios WHERE id='" .
				$ServOpcional[$i] .
				"' LIMIT 1"
		);
		$rprec2 = mysql_fetch_array($qprec2);

		if ($rprec2['id'] == 116 or $rprec2['id'] == 118 or $rprec2['id'] == 126) {
			$Servicios['casaConductor'] = $rprec2[$vigencia];
		}
		if ($rprec2['id'] == 101 or $rprec2['id'] == 119 or $rprec2['id'] == 123) {
			$Servicios['asistenciaVial'] = $rprec2[$vigencia];
		}
		if ($rprec2['id'] == 107 or $rprec2['id'] == 122 or $rprec2['id'] == 124) {
			$Servicios['accidentesPersonales'] = $rprec2[$vigencia];
		}
		if ($rprec2['id'] == 113 or $rprec2['id'] == 120) {
			$Servicios['planPremium'] = $rprec2[$vigencia];
		}
		if ($rprec2['id'] == 108 or $rprec2['id'] == 121 or $rprec2['id'] == 125) {
			$Servicios['ultimosGastos'] = $rprec2[$vigencia];
		}
	}
	return $Servicios;
}

function CiudadRep($id)
{
	$query = mysql_query(
		"SELECT * FROM  seguro_clientes WHERE id='" . $id . "' LIMIT 1"
	);
	$row = mysql_fetch_array($query);

	$queryp1 = mysql_query(
		"SELECT * FROM  ciudad WHERE id='" . $row['ciudad'] . "' LIMIT 1"
	);
	$rowp1 = mysql_fetch_array($queryp1);

	$queryp2 = mysql_query(
		"SELECT * FROM  municipio WHERE id='" . $rowp1['id_muni'] . "' LIMIT 1"
	);
	$rowp2 = mysql_fetch_array($queryp2);

	$queryp3 = mysql_query(
		"SELECT * FROM   provincia WHERE id='" . $rowp2['id_prov'] . "' LIMIT 1"
	);
	$rowp3 = mysql_fetch_array($queryp3);

	return $rowp3['descrip'];
}
?>

<table>
	<tr>
		<td colspan="<?= $columna ?>">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="3">
			<!-- VALIDO PARA VISTA DE ADMINISTRADOR -->
		</td>
		<td colspan="<?= $colspan2 ?>" align="center">
			<b style="font-size:23px">REPORTE DIARIO DE VENTAS</b>
			<b style="font-size:18px"><br><?= $nombre ?>
				<br><b>Desde:</b>&nbsp;&nbsp;<?= $fecha1 ?>&nbsp;&nbsp;&nbsp;<b>Hasta:</b>&nbsp;&nbsp;<?= $fecha2 ?>
			</b>
		</td>
	</tr>

	<tr style="font-size:16px; color:#FFFFFF; font-weight:bold">
		<td style="background-color:#1d4ed7;">#</td>

		<td style="background-color:#1d4ed7;">No.Poliza</td>
		<td style="background-color:#1d4ed7;">Aseguradora</td>
		<td style="background-color:#1d4ed7;">Nombres</td>
		<td style="background-color:#1d4ed7;">Apellidos</td>
		<td style="background-color:#1d4ed7;">C&eacute;dula</td>
		<td style="background-color:#1d4ed7;">Pasaporte</td>
		<td style="background-color:#1d4ed7;">Direcci&oacute;n</td>
		<td style="background-color:#1d4ed7;">Ciudad</td>
		<td style="background-color:#1d4ed7;">Tel&eacute;fono</td>
		<td style="background-color:#1d4ed7;">Tipo</td>
		<td style="background-color:#1d4ed7;">Marca</td>
		<td style="background-color:#1d4ed7;">Modelo</td>
		<td style="background-color:#1d4ed7;">A&ntilde;o</td>
		<td style="background-color:#1d4ed7;">Chassis</td>
		<td style="background-color:#1d4ed7;">Placa</td>
		<td style="background-color:#1d4ed7;">Fecha Emisi&oacute;n</td>
		<td style="background-color:#1d4ed7;">Inicio Vigencia</td>
		<td style="background-color:#1d4ed7;">Fin Vigencia</td>
		<td style="background-color:#1d4ed7;">DPA</td>
		<td style="background-color:#1d4ed7;">AP</td>
		<td style="background-color:#1d4ed7;">RC</td>
		<td style="background-color:#1d4ed7;">RC2</td>
		<td style="background-color:#1d4ed7;">FJ</td>
		<td style="background-color:#1d4ed7;">Cod. Confirmación</td>
		<?php
		if ($_GET['aseguradora'] == 7 or $_GET['aseguradora'] == 5) {
			echo '<td style="background-color:#1d4ed7;">Centro Del Automovilista</td>';
		} else {
			echo '<td style="background-color:#1d4ed7;">Casa del Conductor</td>';
		}
		?>
		<td style="background-color:#1d4ed7;">Asistencia Vial (Grua)</td>
		<td style="background-color:#1d4ed7;">Accidentes Personales</td>
		<td style="background-color:#1d4ed7;">Plan Premium</td>
		<td style="background-color:#1d4ed7;">Ultimos Gastos</td>
		<td style="background-color:#1d4ed7;">Poliza </td>
		<td style="background-color:#1d4ed7;">Codigo Descuento</td>
		<td style="background-color:#1d4ed7;">% Descuento</td>
		<td style="background-color:#1d4ed7;">Prima antes de descuento</td>
		<td style="background-color:#1d4ed7;">Monto Descuento</td>
		<td style="background-color:#1d4ed7;">Prima</td>

	</tr>


	<?php
	$fd1 = explode('/', $fecha1);
	$fh1 = explode('/', $fecha2);
	$fDesde = $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
	$fHasta = $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];
	$wFecha = "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";

	$qR = mysql_query("SELECT * FROM seguro_transacciones_reversos");
	while ($rev = mysql_fetch_array($qR)) {
		$reversadas .= "[" . $rev['id_trans'] . "]";
	}

	$query = mysql_query(
		"SELECT * FROM seguro_transacciones WHERE $wFecha $aseg order by id ASC"
	);
	while ($u = mysql_fetch_array($query)) {
		if (substr_count($reversadas, "[" . $u['id'] . "]") > 0) {
		} else {
			$t++;
			$RepMontoSeguro = RepMontoSeguro($u['id']);
			$veh = explode("|", CrearVehiculo($u['id_vehiculo']));
			//print_r($u['serv_adc']);
			$ServMonto = MontoPorServ($u['vigencia_poliza'], $u['serv_adc']);
			//print_r($ServMonto);
			//		$ServMonto = $u['serv_adc'];
			$precio = $RepMontoSeguro;
			$Tprecio += $precio;
			$precio = substr(formatDinero($precio), 0, -3);
			$tipo = explode("|", RepTipo($veh[0]));
			$Nombretipo = $tipo[0];
			$id = $u['id'];
			$confirmacion = explode("-", $u['x_id']);
			// Calcual el total de solo la poliza
			$newPrecio = str_replace(",", '', $precio);
			if ($u['codigo_descuento'] == '') {
				$totalGeneral = round($newPrecio);
			} else {
				$totalGeneral = round($newPrecio / (1 - ($u['codigo_value'] / 100)));
			}

			$totalServicios = $ServMonto['casaConductor'] + $ServMonto['asistenciaVial'] + $ServMonto['accidentesPersonales'] + $ServMonto['planPremium'] + $ServMonto['ultimosGastos'];
			$totalPoliza = intval($totalGeneral) - intval($totalServicios);

			$dd = explode("|", VerVariable($u['serv_adc']));
			if ($u['id_aseg']  == '5' || $u['id_aseg'] == '7') {
				$dpa_1 = 500000;
				$ap_1 = 500000;
				$rc_1 = 500000;
				$rc2_1 = 1000000;
				$fj_1 = 1000000;
			} else {
				$dpa_1 = $dd[0];
				$ap_1 = $dd[1];
				$rc_1 = $dd[2];
				$rc2_1 = $dd[3];
				$fj_1 = $dd[4];
			}

			if ($dpa_1 > 0) {
				$dpa = substr(formatDinero($dpa_1), 0, -3);
			} else {
				$dpa = substr(formatDinero($tipo[1]), 0, -3);
			}

			if ($ap_1 > 0) {
				$ap = substr(formatDinero($ap_1), 0, -3);
			} else {
				$ap = substr(formatDinero($tipo[2]), 0, -3);
			}

			if ($rc_1 > 0) {
				$rc = substr(formatDinero($rc_1), 0, -3);
			} else {
				$rc = substr(formatDinero($tipo[3]), 0, -3);
			}

			if ($rc2_1 > 0) {
				$rc2 = substr(formatDinero($rc2_1), 0, -3);
			} else {
				$rc2 = substr(formatDinero($tipo[4]), 0, -3);
			}

			if ($fj_1 > 0) {
				$fj = substr(formatDinero($fj_1), 0, -3);
			} else {
				$fj = substr(formatDinero($tipo[5]), 0, -3);
			}

			$marca = VehiculoMarca($veh[1]);
			$modelo = VehiculoModelos($veh[2]);
			$cliente = explode("|", Clientes($u['id_cliente']));
			$pref = GetPrefijo($u['id_aseg']);
			$idseg = str_pad($u['id_poliza'], 6, "0", STR_PAD_LEFT);
			$prefi = $pref . "-" . $idseg;
	?>

			<tr style="font-size:12px; text-align:left">
				<td><b><?= $u['id'] ?></b></td>
				<td><?= $prefi ?></td>
				<td style=" <?= $clase ?>"><?= NombreSeguroS($u['id_aseg']) + ' ' +  $dist_id ?></td>
				<td><?= $cliente[0] + ' ' + $u['id_aseg']  ?></td>
				<td><?= $cliente[1] ?></td>
				<td><?= CrearCedula($cliente[2]) ?></td>
				<td><?= $cliente[6] ?></td>
				<td><?= $cliente[3] ?></td>
				<td><?= Ciudad($cliente[4]) != null ? Ciudad($cliente[4]) : CiudadVia($u['id']) ?> </td>
				<td><?= CrearTelefono($cliente[5]) ?></td>
				<td><?= $Nombretipo ?></td>
				<td><?= $marca ?></td>
				<td><?= $modelo ?></td>
				<td><?= $veh[3] ?></td>
				<td><?= $veh[5] ?></td>
				<td align="right"><?= $veh[4] ?></td>
				<td align="center" style="width:150px"><?= $u['fecha'] ?></td>
				<td align="center" style="width:150px"><?= FechaReporte(
															$u['fecha_inicio']
														) ?></td>
				<td align="center" style="width:150px"><?= FechaReporte(
															$u['fecha_fin']
														) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $dpa ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $ap ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $rc ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $rc2 ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $fj ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $confirmacion[1] ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= formatDinero($ServMonto['casaConductor']) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= formatDinero($ServMonto['asistenciaVial']) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= formatDinero($ServMonto['accidentesPersonales']) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= formatDinero($ServMonto['planPremium']) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= formatDinero($ServMonto['ultimosGastos']) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><? echo formatDinero($totalPoliza);
																	// $totalCOnReversoDescuento = 0;
																	// if ($u['codigo_descuento'] == '') {
																	// 	echo formatDinero($totalPoliza);
																	// } else {
																	// 	$totalCOnReversoDescuento = $totalPoliza / (1 - ($u['codigo_value'] / 100));
																	// 	echo formatDinero(round($totalCOnReversoDescuento));
																	// }

																	?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><? echo $u['codigo_descuento']; ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= $u['codigo_value'] ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?= formatDinero($totalGeneral) ?></td>
				<td style="padding-left: 10px;padding-right: 10px;"><?
																	if ($u['codigo_descuento'] == '') {
																		echo 0;
																	} else {
																		echo formatDinero($totalGeneral - $newPrecio);
																	}
																	?></td>

				<td align="right"><?= formatDinero($newPrecio) ?> </td>
			</tr>
	<?php
		}
	}
	?>

	<tr>
		<td colspan="<?= $calt ?>"></td>
		<td colspan="4" align="right">
			<h4>Total de primas&nbsp;</h4>
		</td>
		<td>
			<h4><?= formatDinero($Tprecio) ?></h4>
		</td>
	</tr>

</table>