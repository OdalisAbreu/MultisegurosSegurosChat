<?
session_start();
ini_set('display_errors', 0);
include("../../../incluidos/conexion_inc.php");
include("../../../incluidos/nombres.func.php");
include("../../../incluidos/fechas.func.php");
Conectarse();

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
	<div class="col-lg-12">
		<h3 class="page-header">Listados de venta de Seguros <?php echo $_SESSION['user_id'] ;?></h3>
	</div>
</div>


<? if ($_GET['consul'] !== '1') { ?>
	<center>
		<div id="div_ultimo_acc2" class="alert alert-success" style=" font-size:14px; width:95%;" align="center">
			<strong>Por favor proporcionar la fecha que desea buscar</strong>
			<script>
				setTimeout(function() {
					$("#div_ultimo_acc2").fadeOut(3000);
				}, 20000);
			</script>
		</div>
	</center><? } ?>


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="filter-bar">

				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">

					<tr>
						<td>

							<label>Desde:</label>
							<input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?= $fecha1 ?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
							<label style="margin-left:5px;">Hasta:</label>
							<input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?= $fecha2 ?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">

							<label style="margin-left:5px;">Ruta:</label>
							<select name="ruta_id" id="ruta_id" style="display: inline; width: 170px;" class="form-control">
								<option value="1todos">- Todos - </option>
								<? ///  SELECCION DEL TIPO .....................................
								if($_SESSION['dist_id'] == 20){
									$rescat2 = mysql_query("SELECT * from agencia_via WHERE user_id ='".$_SESSION['dist_id']."'AND ejecutivo !=''  group by ejecutivo order by ejecutivo ASC");	
								}else{
									$rescat2 = mysql_query("SELECT * from agencia_via WHERE user_id ='".$_SESSION['user_id']."'AND ejecutivo !=''  group by ejecutivo order by ejecutivo ASC");
								}
								while ($cat2 = mysql_fetch_array($rescat2)) {
									$nombre = $cat2['ejecutivo'];
									$id 		= $cat2['id'];

									if ($_GET['ruta_id'] == $nombre) {
										echo "<option value=\"$nombre\"  selected>$nombre</option>";
									} else {
										echo "<option value=\"$nombre\" >$nombre</option>";
									}
								} ?>
							</select>



							<button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
								Actualizar
							</button>

							<? if ($_GET['consul']) { ?>

								<a href="#" onClick="CargarAjax_win('Admin/Sist.Dependientes/Reportes/GenerarPeticion.php?fecha1=<?= $_GET['fecha1'] ?>&fecha2=<?= $_GET['fecha2'] ?>&ruta_id=<?= $_GET['ruta_id'] ?>&user_id=<?= $_SESSION['dist_id'] ?>','','GET','cargaajax');">
									<button type="button" id="descargar" class="btn btn-danger" style="margin-left:10px; margin-left:15px; margin-left:5px;">
										Generar Descargar
									</button>
								</a>

								<a href="#" onClick="CargarAjax_win('Admin/Sist.Dependientes/Reportes/GenerarPeticion.php?fecha1=<?= $_GET['fecha1'] ?>&fecha2=<?= $_GET['fecha2'] ?>&ruta_id=<?= $_GET['ruta_id'] ?>&user_id=<?= $_SESSION['dist_id'] ?>&nuevo=1','','GET','cargaajax');">
									<button type="button" id="descargar2" class="btn btn-danger" style="margin-left:10px; margin-left:15px; margin-left:5px;">
										Generar Descargar Nuevo
									</button>
								</a>

							<? } ?>

						</td>

					</tr>

				</table>

				<script type="text/javascript">
					$('#bt_buscar').click(
						function() {
							var fecha1 = $('#fecha1').val();
							var fecha2 = $('#fecha2').val();
							var ruta_id = $('#ruta_id').val();

							CargarAjax2('Admin/Sist.Dependientes/Reportes/listado_trans.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&ruta_id=' + ruta_id + '&consul=1', '', 'GET', 'cargaajax');
							$(this).attr('disabled', true);
							setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ", 0);
						});



					// CODIGO PARA SACAR CALENDARIO
					// ****************************
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
			<? if ($_GET['consul'] == '1') { ?>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 82px;">#</th>
									<th>Asegurado</th>
									<th>Agencia</th>
									<th>Monto</th>
									<th>Inicio Vigencia</th>
									<th>Vehiculo</th>
									<th>Opcion</th>
								</tr>
							</thead>
							<tbody>
								<?

									$fd1		= explode('/', $fecha1);
									$fh1		= explode('/', $fecha2);
									$fDesde 	= $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
									$fHasta 	= $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];
									$wFecha 	= "AND trans.fecha >= '$fDesde 00:00:00' AND trans.fecha <= '$fHasta 23:59:59'";

									$w_user = "(
	trans.user_id='" . $_SESSION['dist_id'] . "'";

									// PUNTOS DE VENTAS
									$quer1 = mysql_query("
	SELECT id FROM personal WHERE id_dist ='" . $_SESSION['dist_id'] . "'");
									while ($u = mysql_fetch_array($quer1)) {

										$w_user .= " OR trans.user_id='" . $u['id'] . "'";

										$quer2 = mysql_query("
		SELECT id FROM personal WHERE id_dist ='" . $u['id'] . "'");
										while ($u2 = mysql_fetch_array($quer2)) {
											$w_user .= " OR trans.user_id='" . $u2['id'] . "'";
										}
									}
									$w_user .= " )";


									if ($_GET['ruta_id'] != '1todos') {
										$ejecutivo = " ejecutivo LIKE '%" . $_GET['ruta_id'] . "%' ";
									} else {
										//$ejecutivo = "id !='' ";
									}

									$ED = mysql_query("SELECT * from agencia_via WHERE $ejecutivo $idpers ");
									//echo "<br>SELECT * from agencia_via WHERE $ejecutivo $idpers  <br>";
									while ($RED = mysql_fetch_array($ED)) {
										$agenci .= "trans.x_id LIKE '%" . $RED['num_agencia'] . "-%' OR ";
									}

									$resulAgen = rtrim($agenci, 'OR ');


									if ($resulAgen) {
										$resulAgen = "AND (" . $resulAgen . ") ";
									}

									$query = mysql_query("SELECT 
												trans.*
											FROM
												seguro_transacciones trans
													LEFT JOIN
												seguro_transacciones_reversos rever ON rever.id_trans = trans.id
											WHERE
												rever.id_trans IS NULL AND $w_user $wFecha  $resulAgen order by id ASC");

									while ($row = mysql_fetch_array($query)) {
										$total += $row['monto'];
										$ganancia += $row['ganancia2'];
										$fh1		= explode(' ', $row['fecha']);
										//apellido tipo inicio de vigencia
										$CRepDep = explode('/', ClienteRepDependientes($row['id_cliente']));
										$agencia = explode('-', $row['x_id']);
										?>
									<tr>
										<td><?= $row['id'] ?><br>
											<font style="font-size:12px; color:#0B197C"><?= $fh1[0] ?></font>
										</td>
										<td><?= $CRepDep[0] ?> <?= $CRepDep[1] ?><br>
											<font style="font-size:12px; color:#0B197C"><?= Cedula($row['id_cliente']) ?></font>
										</td>
										<td><?= "<b>" . $agencia[0] . "</b>" ?><br><?= GetPrefijo($row['id_aseg']) . '-' . str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT) ?></td>
										<td><?= "$" . FormatDinero($row['monto']) ?></td>
										<td><b><?= FechaListPDFn($row['fecha_inicio']) ?></b><br><?= Vigencia($row['vigencia_poliza']) ?></td>
										<td><?= Vehiculo($row['id_vehiculo']) ?></td>
										<td> <a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Dependientes/Revisiones/Imprimir/Accion/polizaVia.php?id_trans=<?= $row['id'] ?>','','GET','cargaajax'); " data-title="Visualizar" class="btn btn-danger">
												<i class="fa fa-eye fa-lg"></i>
											</a></td>
									</tr>
								<? } ?>


								<tr>
									<td colspan="5" rowspan="2"></td>
									<td><strong>Total</strong></td>
									<td><strong><?= "$" . FormatDinero($total) ?></strong></td>
								</tr>
								<tr>
									<!--<td></td>-->
								</tr>

							</tbody>
						</table>
					</div>
					<!-- /.table-responsive -->
				</div>
			<? } ?>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>