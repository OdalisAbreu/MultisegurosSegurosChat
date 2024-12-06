<?php

session_start();
ini_set('display_errors', 1);
set_time_limit(0);
$login = '7bhoi';
include("../../../../../incluidos/conexion_inc.php");
include("../../../../../incluidos/fechas.func.php");
include("nombres.func.php");
Conectarse();

$directorio = "https://multiseguros.com.do/SegurosChat/images/";
$logo = "https://multiseguros.com.do/SegurosChat/images/Aseguradora/";

$ancho  = "570";
$anchoP = "0";
$altura = "3100";

date_default_timezone_set('America/Santo_Domingo');


//BUSCAR TRANSACCION
$query = mysql_query("select * from seguro_transacciones   
	WHERE id ='" . $_GET['id_trans'] . "' LIMIT 1");

$row = mysql_fetch_array($query);
$Agent = explode("-", $row['x_id']);
$Agencia = explode("/", AgenciaVia($Agent[0]));
$NomAgencia = $Agencia[0];

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
	case '5':
		$NombreImg = "sura.png";
		break;
	default:
		$NombreImg = "otras.png";
		break;
}

//BUSCAR DATOS DEL CLIENTE
$QClient = mysql_query("select * from seguro_clientes WHERE id ='" . $row['id_cliente'] . "' LIMIT 1");
$RQClient = mysql_fetch_array($QClient);

//BUSCAR DATOS DEL VEHICULO
$QVeh = mysql_query("select * from seguro_vehiculo WHERE id ='" . $row['id_vehiculo'] . "' LIMIT 1");
$RQVehi = mysql_fetch_array($QVeh);

$tarifa = explode("/", TarifaVehiculo($RQVehi['veh_tipo']));

function ServOpc($idserv)
{
	$qRz = mysql_query("SELECT * FROM `servicios` WHERE `id` = '" . $idserv . "' LIMIT 1");
	$revz = mysql_fetch_array($qRz);
	return $revz['mod_pref'] . "|" . $revz['cambiar'] . "|" . $revz['dpa'] . "|" . $revz['rc'] . "|" . $revz['rc2'] . "|" . $revz['ap'] . "|" . $revz['fj'] . "";

	//s|n|0|0|0|0|0
	//n|s|0|0|0|0|1000000
}




$QueryH2 = mysql_query("select * from seguro_trans_history WHERE id_trans ='" . $_GET['id_trans'] . "' AND tipo = 'serv'");
//echo "select * from seguro_trans_history WHERE id_trans ='".$_GET['id_trans']."' AND tipo = 'serv'";
while ($RowHist = mysql_fetch_array($QueryH2)) {

	$ServOpc_id 		= $RowHist['id_serv_adc'];
	$validar 			= ServOpc($RowHist['id_serv_adc']);
	$val				= explode('|', $validar);


	$ServOpc_cambiar 	= $val[1];
	$ServOpc_dpa 		= $val[2];
	$ServOpc_rc 		= $val[3];
	$ServOpc_rc2 		= $val[4];
	$ServOpc_ap 		= $val[5];
	$ServOpc_fj 		= $val[6];
	$ServOpc_mod_pref	= $val[7];

	if ($ServOpc_cambiar == 's') {

		// ---- DPA
		if ($ServOpc_dpa > 0) {
			$dpa = substr(formatDinero($ServOpc_dpa), 0, -3);
		} else {
			$dpa = substr(formatDinero($tarifa['0']), 0, -3);
		}

		// ---- RC
		if ($ServOpc_rc > 0) {
			$rc = substr(formatDinero($ServOpc_rc), 0, -3);
		} else {
			$rc = substr(formatDinero($tarifa['1']), 0, -3);
		}

		// ---- RC2
		if ($ServOpc_rc2 > 0) {
			$rc2 = substr(formatDinero($ServOpc_rc2), 0, -3);
		} else {
			$rc2 = substr(formatDinero($tarifa['2']), 0, -3);
		}

		// ---- FJ
		if ($ServOpc_fj > 0) {
			$fj = substr(formatDinero($ServOpc_fj), 0, -3);
		} else {
			$fj = substr(formatDinero($tarifa['4']), 0, -3);
		}

		// ---- AP
		if ($ServOpc_ap > 0) {
			$ap = substr(formatDinero($ServOpc_ap), 0, -3);
		} else {
			$ap = substr(formatDinero($tarifa['3']), 0, -3);
		}
	} else if ($ServOpc_cambiar == 'n') {

		$dpa 			= substr(formatDinero($tarifa['0']), 0, -3);
		$rc 			= substr(formatDinero($tarifa['1']), 0, -3);
		$rc2 			= substr(formatDinero($tarifa['2']), 0, -3);
		$ap 			= substr(formatDinero($tarifa['3']), 0, -3);
		$fj 			= substr(formatDinero($tarifa['4']), 0, -3);
	}
}

/*$dpa 	= substr(FormatDinero($tarifa[0]), 0, -3);
	$rc 		= substr(FormatDinero($tarifa[1]), 0, -3);
	$rc2 	= substr(FormatDinero($tarifa[2]), 0, -3);
	$ap 		= substr(FormatDinero($tarifa[3]), 0, -3);
	$fj 		= substr(FormatDinero($tarifa[4]), 0, -3);*/




//$montoSeguro	= montoSeguro($row['vigencia_poliza'],$RQVehi['veh_tipo']);
$polizaNum		= GetPrefijo($row['id_aseg']) . "-" . str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
$dir			= "../../../../../../ws_schat/TareasProg/PDF/IMPRIMIR/" . $polizaNum . ".pdf";
?>

<div id="ver">
	<table width="590" style="font-size:17px;" align="center" cellpadding="4" cellspacing="0" border="0">
		<tr>
			<td width="60%" style="text-align:center">
				<font style="font-size:20px; ">CERTIFICADO DE SEGURO<br>
					VEHICULOSDE MOTOR</font>
			</td>

			<td width="40%"><img src="<?= $directorio ?>/logo.png" alt="" style="width:300px" /></td>
		</tr>
	</table>


	<table border="0" align="center" cellpadding="4" cellspacing="0" style="font-size:11px; margin-left:15px; margin-right:15px; width:95.5%">
		<tr>
			<td valign="top" align="left"><b>ASEGURADO: <?= $RQClient['asegurado_nombres'] ?> <?= $RQClient['asegurado_apellidos'] ?></b></td>
			<td valign="top" align="left"><b>POLIZA NO: <?= $polizaNum ?></b></td>
		</tr>
		<tr>
			<?php if ($RQClient['asegurado_cedula'] != '') { ?>
				<td valign="top" align="left"><b>CEDULA: <?= CedulaPDF($RQClient['asegurado_cedula']) ?></b></td>
			<?php } ?>
			<?php if ($RQClient['asegurado_pasaporte'] != '') { ?>
				<td valign="top" align="left"><b>PASAPORTE: <?= CedulaPDF($RQClient['asegurado_pasaporte']) ?></b></td>
			<?php } ?>
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
			<td valign="top" align="left"><b>AGENCIA: <?= $Agent[0] . ' - ' . strtoupper(Remplazar($NomAgencia)) ?></b> </td>
			<td valign="top" align="left"><b>FIN DE VIGENCIA: <?= FechaListPDFin($row['fecha_fin']) ?></b></td>
		</tr>

		<tr>
			<td valign="top" align="left"> </td>
			<td valign="top" align="left"></td>
		</tr>

		<tr>
			<td valign="top" colspan="2" align="center" style="border-top:solid 1px #000; ">
				<h3 style="margin-top:9px; font-size: 18px;"><b>PLAN BASICO DE LEY - CONDICIONES PARTICULARES</b></h3>
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
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" style="border-top:solid 1px #000; border-left:solid 1px #000; width: 293px;">



				<table cellpadding="3" cellspacing="0" style="margin-left:5px; margin-top:5px">
					<tr>
						<td align="left" colspan="2"><b>COBERTURAS Y LIMITES (En RD$)</b></td>
					</tr>
					<tr>
						<td align="left" style="width:229px !important; font-size: 10px;">Daños a la Propiedad Ajena</td>
						<td style="font-size: 10px;"><strong>RD$<?= $dpa ?></strong></td>
					</tr>
					<tr>
						<td align="left" style="font-size: 10px;">Lesiones Corporales o Muerte 1 Persona</td>
						<td style="font-size: 10px;"><strong>RD$<?= $rc ?></strong></td>
					</tr>
					<tr>
						<td align="left" style="font-size: 10px;">Lesiones Corporales o Muerte Más de 1 Persona</td>
						<td style="font-size: 10px;"><strong>RD$<?= $rc2 ?></strong></td>
					</tr>
					<tr>
						<td align="left" style="font-size: 10px;">Lesiones Corporales o Muerte 1 Pasajero</td>
						<td style="font-size: 10px;"><strong>RD$<?= $rc ?></strong></td>
					</tr>
					<tr>
						<td align="left" style="font-size: 10px;">Lesiones Corporales o Muerte Más de 1 Pasajero</td>
						<td style="font-size: 10px;"><strong>RD$<?= $rc2 ?></strong></td>
					</tr>
					<tr>
						<td align="left" style="font-size: 10px;">Accidentes Personales Conductor</td>
						<td style="font-size: 10px;"><strong>RD$<?= $ap ?></strong></td>
					</tr>
					<tr>
						<td align="left" style="font-size: 10px;">Fianza Judicial</td>
						<td style="font-size: 10px;"><strong>RD$<?= $fj ?></strong></td>
					</tr>
				</table>



			</td>
			<td valign="top" style="border-top:solid 1px #000; border-left:solid 1px #000; border-right:solid 1px #000;">



				<table cellpadding="3" cellspacing="0" style="margin-left:10px; margin-top:5px">
					<tr>
						<td colspan="2" align="left"><b><b>SERVICIOS ADICIONALES</b></b></td>
					</tr>

					<?

					$QueryH = mysql_query("select * from seguro_trans_history WHERE id_trans ='" . $_GET['id_trans'] . "'");
					while ($RowHist = mysql_fetch_array($QueryH)) {
						if ($RowHist['tipo'] == 'serv') {
							$montoServAdc += $RowHist['monto'];
					?>
							<tr>
								<td align="left" width="265"><?= ServAdicHistory($RowHist['id_serv_adc']) ?> - Incluido
									<br>
									<strong>RD$
										<?= FormatDinero($RowHist['monto']) ?>
									</strong>
								</td>
							</tr>
					<?
						} else {
							$montoSeguro = $RowHist['monto'];
						}
					}
					$totalFactura = $montoSeguro;
					if ($row['codigo_descuento'] == '') {
						$seguroBasico = $montoSeguro - $montoServAdc;
					} else {
						$montoSeguro = 	round($montoSeguro  / (1 - ($row['codigo_value'] / 100)));
						$seguroBasico  = $montoSeguro - $montoServAdc;
					}
					$descuento = $montoSeguro - $totalFactura;
					?>

				</table>

			</td>
		</tr>
		<tr>
			<td align="left" style="border-top:solid 1px #000; border-left:solid 1px #000; border-bottom:solid 1px #000; padding-left:25px; padding-bottom:25px; padding-top:25px; background-color:#E0E0E0; margin-bottom:10px; margin-top:10px; " valign="middle">



				<table width="100%" cellpadding="1" cellspacing="0" style="margin-right:10px; margin-left: -14px;">
					<tr>
						<td align="left"><b>Prima Seguro Básico</b></td>
						<td align="right"><b>RD$ <?= FormatDinero($seguroBasico) ?></b></td>
					</tr>
				</table>


			</td>
			<td align="left" style="border-top:solid 1px #000; border-left:solid 1px #000; border-bottom:solid 1px #000; border-right:solid 1px #000; padding-left:25px; padding-bottom:25px; padding-top:25px; background-color:#E0E0E0; margin-bottom:10px; margin-top:10px; " valign="middle">



				<table width="100%" cellpadding="1" cellspacing="0" style="margin-right:10px; margin-left: -12px;">
					<tr>
						<td align="left"><b>Prima Servicios Adicionales</b></td>
						<td align="right"><b>RD$ <?= FormatDinero($montoServAdc) ?></b></td>
					</tr>
				</table>



			</td>
		</tr>

		<tr>
			<td colspan="2" align="right" height="15" style="font-size:14px">
				<strong>Sub Total Póliza RD$ <?= FormatDinero($montoSeguro) ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right" height="15" style="font-size:14px">
				<strong>Descuento RD$ <?= FormatDinero($descuento) ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right" height="25" style="font-size:18px">
				<strong>Total Póliza RD$ <?= FormatDinero($totalFactura) ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<table style="width: 95%;">
					<tr>
						<td align="right"><a href="javascript:void(0)" class="btn btn-success" onClick="CargarAjax2('Admin/Sist.Sucursal/Seguro/ticket.php?id=<?= $row['id'] ?>','','GET','ver');"><b>Imprimir Ticket</b></a>

						</td>

						<td align="right"><a href="javascript:void(0)" class="btn btn-success" onClick="CargarAjax2('Admin/Sist.Sucursal/Seguro/Imprimir_Poliza.php?id_trans=<?= $row['id'] ?>','','GET','ver');"><b>Imprimir Poliza</b></a></td>

						<td align="right">

							<a href="javascript:void(0)" class="btn btn-success" onclick="location.replace('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/Imprimir.php?polizaNum=<?= $polizaNum ?>');"><b>Descargar Poliza Aqui</b></a>

						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">&nbsp;</td>
		</tr>
	</table>
</div>
<script>
	$(window).load(function() {
</script>
<?

if (file_exists($dir)) {
	// echo "<br>El fichero  existe";
	$getWS 	= file_get_contents("https://multiseguros.com.do/ws_dev/TareasProg/GenerarReporteAseguradoraPdfUnico.php?sms=1&id_trans=" . $_GET['id_trans'] . "");
} else {
	$getWS 	= file_get_contents("https://multiseguros.com.do/ws_dev/TareasProg/GenerarReporteAseguradoraPdfUnico.php?sms=1&id_trans=" . $_GET['id_trans'] . "");
	// echo "<br>El fichero  no existe";
}


?>

<script>
	});
</script>