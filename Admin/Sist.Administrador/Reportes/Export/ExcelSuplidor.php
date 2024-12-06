<?
ini_set('display_errors', 1);
$fecha1  =  $_GET['fecha1'];
$fecha2  =  $_GET['fecha2'];
$suplidor = $_GET['suplidor'];

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte desde - " . $fecha1 . " - hasta - " . $fecha2 . ".xls");


session_start();

include("../../../../incluidos/conexion_inc.php");
include("../../../../incluidos/fechas.func.php");
include("../../../../incluidos/nombres.func.php");
Conectarse();

if ($_GET['suplidor'] != '1aseg') {
	$aseg = "AND serv_adc LIKE '%" . $_GET['suplidor'] . "%' ";
	$nombre = NombreProgS($_GET['suplidor']);
	$clase = "0";
	$columna = "22";

	$colspan = "8";
	$colspan2 = "14";
	//$calt = "17";
	$calt = "13";
} else {
	$nombre = "TODOS LOS SUPLIDORES";
	$columna = "23";
	$clase = "0";
	$colspan = "9";
	$colspan2 = "13";
	$calt = "18";
}


function CiudadRep($id)
{
	$query = mysql_query("SELECT * FROM  seguro_clientes WHERE id='" . $id . "' LIMIT 1");
	$row = mysql_fetch_array($query);

	$queryp1 = mysql_query("SELECT * FROM  ciudad WHERE id='" . $row['ciudad'] . "' LIMIT 1");
	$rowp1 = mysql_fetch_array($queryp1);

	$queryp2 = mysql_query("SELECT * FROM  municipio WHERE id='" . $rowp1['id_muni'] . "' LIMIT 1");
	$rowp2 = mysql_fetch_array($queryp2);

	$queryp3 = mysql_query("SELECT * FROM   provincia WHERE id='" . $rowp2['id_prov'] . "' LIMIT 1");
	$rowp3 = mysql_fetch_array($queryp3);

	return $rowp3['descrip'];
}

?>

<table>
	<tr>
		<td colspan="<?= $columna ?>">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="<?= $colspan ?>">

			<b style="font-size: 70px; color: #d9261c;">Multi</b><b style="font-size: 70px; color: #828282;">Seguros</b>
		</td>
		<td colspan="<?= $colspan2 ?>" align="center">
			<b style="font-size:23px">REPORTE DIARIO DE VENTAS</b>
			<b style="font-size:18px"><br><?= $nombre ?>
				<br><b>Desde:</b>&nbsp;&nbsp;<?= $fecha1 ?>&nbsp;&nbsp;&nbsp;<b>Hasta:</b>&nbsp;&nbsp;<?= $fecha2 ?>
			</b>
		</td>
	</tr>

	<tr style="font-size:16px; color:#FFFFFF; font-weight:bold">
		<td style="background-color:#B1070A;">#</td>

		<td style="background-color:#B1070A;">No.Poliza</td>
		<? if ($clase == '0') { ?>
			<td style="background-color:#B1070A;">Aseguradora</td>
		<? } ?>
		<td style="background-color:#B1070A;">Nombres</td>
		<td style="background-color:#B1070A;">Apellidos</td>
		<td style="background-color:#B1070A;">C&eacute;dula</td>
		<td style="background-color:#B1070A;">Direcci&oacute;n</td>
		<td style="background-color:#B1070A;">Ciudad</td>
		<td style="background-color:#B1070A;">Tel&eacute;fono</td>
		<td style="background-color:#B1070A;">Tipo</td>
		<td style="background-color:#B1070A;">Marca</td>
		<td style="background-color:#B1070A;">Modelo</td>
		<td style="background-color:#B1070A;">A&ntilde;o</td>
		<td style="background-color:#B1070A;">Chassis</td>
		<td style="background-color:#B1070A;">Placa</td>
		<td style="background-color:#B1070A;">Fecha Emisi&oacute;n</td>
		<td style="background-color:#B1070A;">Inicio Vigencia</td>
		<td style="background-color:#B1070A;">Fin Vigencia</td>
		<td style="background-color:#B1070A;">Prima</td>
	</tr>


	<?

	$fd1	= explode('/', $fecha1);
	$fh1	= explode('/', $fecha2);
	$fDesde 	= $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
	$fHasta 	= $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];
	$wFecha 	= "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";

	$qR = mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	while ($rev = mysql_fetch_array($qR)) {
		$reversadas .= "[" . $rev['id_trans'] . "]";
	}


	$w_user = "(
	serv_adc LIKE '%" . $_GET['suplidor'] . "-%'
	";

	// PUNTOS DE VENTAS
	$quer1 = mysql_query("
	SELECT id FROM servicios WHERE id_suplid ='" . $_GET['suplidor'] . "'");
	while ($u = mysql_fetch_array($quer1)) {

		$w_user .= " OR serv_adc LIKE '%" . $u['id'] . "-%'";

		$quer2 = mysql_query("
		SELECT id FROM servicios WHERE id_suplid ='" . $u['id'] . "'");
		while ($u2 = mysql_fetch_array($quer2)) {
			$w_user .= " OR serv_adc LIKE '%" . $u2['id'] . "-%'";
		}
	}
	$w_user .= " )";


	$query = mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE $w_user AND $wFecha  order by id ASC");
	while ($row = mysql_fetch_array($query)) {

		if ((substr_count($reversadas, "[" . $row['id'] . "]") > 0)) {
		} else {

			//BUSCAR CANTAIDAD DE LOS SERVICIOS ADICIONALES
			$porciones = explode("-", $row['serv_adc']);
			$monto = 0;
			for ($i = 0; $i < count($porciones); $i++) {

				if ($porciones[$i] > 0) {
					$serv_adcs  = ValidarServicioOpcional($_GET['suplidor'], $porciones[$i]);
					$monto 		+= MontoCostoServicioOpcional($serv_adcs, $row['vigencia_poliza']);
				}
			}

			//$monto = CostoSuplid($_GET['suplidor'],$row['vigencia_poliza']);
			$total += $monto;

			//$total +=$row['monto'];
			//$ganancia += $row['ganancia'];
			$fh1		= explode(' ', $row['fecha']);
			$Cliente = explode("|", Cliente($row['id_cliente']));
			$Client = str_replace("|", "", $Cliente[0]);
			$i++;

			$pref = GetPrefijo($row['id_aseg']);
			$idseg = str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
			$prefi = $pref . "-" . $idseg;

			$TipoM = explode("/", Tipo($row['id_vehiculo']));
			$TipoM['1'] = substr(formatDinero($TipoM['1']), 0, -3);
			$TipoM['2'] = substr(formatDinero($TipoM['2']), 0, -3);
			$TipoM['3'] = substr(formatDinero($TipoM['3']), 0, -3);
			$TipoM['4'] = substr(formatDinero($TipoM['4']), 0, -3);
			//$monto 	  = substr(formatDinero($row['monto']), 0, -3);

			$marca = VehiculoExport($row['id_vehiculo']);
			$MarcaMod = explode("/", $marca);
			$direccion = str_replace(",", "", Direccion($row['id_cliente']));
	?>
			<tr style="font-size:12px; text-align:left">
				<td><?= $i ?></td>

				<td><?= $prefi ?></td>

				<? if ($clase == '0') { ?>
					<td style=" <?= $clase ?>"><?= NombreSeguroS($row['id_aseg']) ?></td>
				<? } ?>
				<td><?= $Client ?></td>
				<td><?= $Cliente[1] ?></td>
				<td><?= Cedula($row['id_cliente']) ?></td>
				<td><?= $direccion ?></td>
				<td><?= CiudadRep($row['id_cliente']) ?></td>
				<td><?= Telefono($row['id_cliente']) ?></td>
				<td><?= $TipoM['0'] ?></td>
				<td><?= Marcas($MarcaMod['0']) ?></td>
				<td><?= VehiculoModelos($MarcaMod['1']) ?></td>
				<td><?= $MarcaMod['2'] ?></td>
				<td><?= $MarcaMod['3'] ?></td>
				<td><?= $MarcaMod['4'] ?></td>
				<td align="center" style="width:150px"><?= $row['fecha'] ?></td>
				<td align="center" style="width:150px"><?= FechaReporte($row['fecha_inicio']) ?></td>
				<td align="center" style="width:150px"><?= FechaReporte($row['fecha_fin']) ?></td>
				<td align="right"><?= formatDinero($monto) ?></td>
			</tr>
	<? }
	} ?>

	<tr>
		<td colspan="<?= $calt ?>"></td>
		<td>&nbsp;</td>
		<td colspan="3" align="right">
			<h4>Total de primas &nbsp;</h4>
		</td>
		<td>
			<h4><?= formatDinero($total) ?></h4>
		</td>
	</tr>

</table>