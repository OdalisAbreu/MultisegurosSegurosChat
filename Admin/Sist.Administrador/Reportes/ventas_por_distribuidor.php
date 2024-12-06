<?
//ini_set("session.cookie_lifetime","7200");
//ini_set("session.gc_maxlifetime","7200");
//ini_set('session.cache_expire','3000'); 
session_start();
ini_set('display_errors', 1);

include("../../../incluidos/conexion_inc.php");
include("../../../incluidos/nombres.func.php");
Conectarse();
include("../../../incluidos/fechas.func.php");

// --------------------------------------------	
if ($_GET['fecha1']) {
	$fecha1 = $_GET['fecha1'];
} else {
	$fecha1 = fecha_despues('' . date('d/m/Y') . '', -0);
}
// --------------------------------------------
if ($_GET['fecha2']) {
	$fecha2 = $_GET['fecha2'];
} else {
	$fecha2 = fecha_despues('' . date('d/m/Y') . '', 0);
}
?>

<div class="row">
	<div class="col-lg-12" style="margin-top:-35px;">
		<h3 class="page-header">Listados de venta por distribuidores</h3>
	</div>
</div>





<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="filter-bar">

				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">

					<tr>
						<td>

							<label>Desde:</label>
							<input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?= $fecha1 ?>" style="width: 83px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
							<label style="margin-left:5px;">Hasta:</label>
							<input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?= $fecha2 ?>" style="width: 83px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">


							<button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
								Actualizar
							</button>
						</td>
					</tr>
				</table>

				<script type="text/javascript">
					$('#bt_buscar').click(
						function() {
							var fecha1 = $('#fecha1').val();
							var fecha2 = $('#fecha2').val();
							var aseguradora = $('#aseguradora').val();
							var tipo = $('#tipo').val();
							var user_id = $('#user_id').val();

							CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_por_distribuidor.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&consul=1', '', 'GET', 'cargaajax');
							$(this).attr('disabled', true);
							//setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
						});

					$(function() {
						$("#fecha1").datepicker({
							dateFormat: 'dd/mm/yy'
						});
						$("#fecha2").datepicker({
							dateFormat: 'dd/mm/yy'
						});
					});
				</script>



			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Fecha Desde</th>
								<th>Fecha Hasta</th>
								<th>Nombre</th>
								<th>Transacciones</th>
								<th>Monto</th>
								<th>Anulado</th>
							</tr>
						</thead>
						<tbody>
							<?

							if ($_GET['consul'] == '1') {

								$fd1	= explode('/', $fecha1);
								$fh1	= explode('/', $fecha2);
								$fDesde 	= $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
								$fHasta 	= $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];

								function Ventas($id)
								{
									global $fDesde, $fHasta;
									$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";

									$qR = mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
									$reversadas .= "0";
									while ($rev = mysql_fetch_array($qR)) {
										$reversadas .= "[" . $rev['id_trans'] . "]";
										//$reversadas 	.= ",".$rev['id_trans'];
									}

									$w_user = "(
	user_id='" . $id . "'";

									// PUNTOS DE VENTAS
									$quer1 = mysql_query("
	SELECT id FROM personal WHERE id_dist ='" . $id . "'");
									while ($u = mysql_fetch_array($quer1)) {

										$w_user .= " OR user_id='" . $u['id'] . "'";

										$quer2 = mysql_query("
		SELECT id FROM personal WHERE id_dist ='" . $u['id'] . "'");
										while ($u2 = mysql_fetch_array($quer2)) {
											$w_user .= " OR user_id='" . $u2['id'] . "'";
										}
									}
									$w_user .= " )";

									$query = mysql_query("
		   SELECT * FROM seguro_transacciones 
		   WHERE $w_user $wFecha order by id ASC");

									$trans = 0;
									while ($row = mysql_fetch_array($query)) {
										$trans++;
										if ((substr_count($reversadas, "[" . $row['id'] . "]") > 0)) {
											$Rtotal += $row['totalpagar'];
										} else {
											$total   += $row['monto'];
										}
									}


									return $total . "/" . $Rtotal . "/" . $trans;
								}

								$Q1 = mysql_query("SELECT * FROM personal WHERE funcion_id='2' order by id ASC");
								while ($R1 = mysql_fetch_array($Q1)) {
									$t[] = $R1;
								}


								foreach ($t as $key => $row) {

									$vent = explode('/', Ventas($row['id']));
									$MontoTotal = $vent[0];
									$AnulaTotal = $vent[1];
									$TransTotal = $vent[2];

									if ($AnulaTotal > 0) {
										$AnulTotal = $AnulaTotal;
									} else {
										$AnulTotal = 0;
									}

									if ($MontoTotal > 0) {
										$MontVendido += $MontoTotal;
										$montoAnul   += $AnulTotal;
										?>

										<tr>
											<td><?= $row['id'] ?></td>
											<td><?= $fDesde ?></td>
											<td><?= $fHasta ?></td>
											<td>
												[ <b><?= $row['id'] ?></b> ] <?= $row['nombres'] ?>
												( <a href="#" onClick="CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_agrupadas_por_distribuidor.php?fecha1=<?= $fecha1 ?>&fecha2=<?= $fecha2 ?>&dist_id=<?= $row['id'] ?>&consul=1','','GET','cargaajax');"><b>ventas</b></a> )
											</td>
											<td><?= $TransTotal ?></td>
											<td>$RD <?= formatDinero($MontoTotal) ?></td>

											<td>$RD <?= formatDinero($AnulTotal) ?></td>
										</tr>

							<?
									}
								}
							}
							?>

							<? if ($MontVendido > 0) { ?>
								<tr>
									<td colspan="5">&nbsp;</td>
									<td><strong>$RD
											<?= formatDinero($MontVendido) ?>
										</strong></td>
									<? if ($montoAnul > 0) { ?>
										<td><strong>$RD
												<?= formatDinero($montoAnul) ?>
											</strong></td>
									<? } else { ?>
										<td><strong>$RD 0.00
											</strong></td>
									<? } ?>
								</tr>
							<? } ?>



						</tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>