<?
session_start();
ini_set('display_errors', 1);
include("../../../incluidos/conexion_inc.php");
include("../../../incluidos/nombres.func.php");
include('../../../incluidos/bd_manejos.php');
include('../../../incluidos/fechas.func.php');
Conectarse();

$acc1 = $_POST['accion'] . $_GET['action'];
// EDITAR
if ($acc1 == 'Editar') {

	$fd1	= explode('/', $_POST['fecha_pago']);
	$_POST['fecha_pago']	= $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0] . " " . date("H:i:s");

	EditarForm('remesas');

	echo '
		<script>
			$("#myModal").modal("hide"); 
			$("#actul").fadeIn(0); 
			$("#actul").fadeOut(10000);
		</script> ';


	$getWS 	= file_get_contents("https://multiseguros.com.do/ws_schat/TareasProg/AwsMailer/ReporteRemesas.php?id=" . $_POST['id'] . "&key=Ed4F45%");

	echo "enviando";

	$respuesta = explode("/", $getWS);

	//echo "Resp: ".$respuesta[0]."<br>";

	/*if($respuesta[0]=='00'){
			
			echo "email enviado";
		}else{
			echo "email  <b>NO</b> enviado";
		}*/
}


?>

<div class="row">
	<div class="col-lg-12" style="margin-top:-35px;">
		<h3 class="page-header">Listado de remesas generadas </h3>
	</div>
</div>





<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="filter-bar">

				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">

					<tr>
						<td>

							<label>Suplidor:</label>

							<select class="form-control" id="suplidor" name="suplidor" style="width: 180px; display: inline;">
								<option value="t1" <? if ($_GET['suplidor'] == 't1') { ?>selected<? } ?>>Todas</option>
								<?

								///  SELECCION DEL TIPO .....................................
								$rescat2 = mysql_query("SELECT * from seguros  order by nombre ASC");
								while ($cat2 = mysql_fetch_array($rescat2)) {
									$c2 = $cat2['nombre'];
									$c_id2 = $cat2['id'];

									if ($_GET['suplidor'] == $c_id2) {
										echo "<option value=\"$c_id2\" selected>$c2</option>";
									} else {
										echo "<option value=\"$c_id2\" >$c2</option>";
									}
								} ?>
							</select>


							<label style="margin-left:5px;"> Estatus:</label>
							<select class="form-control" id="estatus" name="estatus" style="width: 100px; display: inline;">
								<option value="t" <? if ($_GET['estatus'] == 't') { ?>selected<? } ?>>Todas</option>
								<option value="s" <? if ($_GET['estatus'] == 's') { ?>selected<? } ?>>Pagadas</option>
								<option value="n" <? if ($_GET['estatus'] == 'n') { ?>selected<? } ?>>Pendientes</option>
							</select>

							<button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
								Actualizar
							</button>

							<? if ($_GET['consul'] == '1') { ?>
								<!--<a href="Admin/Sist.Administrador/Reportes/Export/listado_trans.php?fecha1=<?= $fecha1; ?>&fecha2=<?= $fecha2; ?>">
                        <button type="button" data-toggle="button-loading pdf" data-target="#pdfTarget" class="btn btn-primary btn-icon glyphicons download_alt hidden-print" id="descargar"><i></i> Export</button>
                        
                        </a>-->
							<? } ?>
						</td>

					</tr>

				</table>

				<script type="text/javascript">
					$('#bt_buscar').click(
						function() {
							var fecha1 = $('#fecha1').val();
							var fecha2 = $('#fecha2').val();
							var suplidor = $('#suplidor').val();
							var estatus = $('#estatus').val();

							CargarAjax2('Admin/Sist.Administrador/Reportes/remesas.php?estatus=' + estatus + '&suplidor=' + suplidor + '&consul=1', '', 'GET', 'cargaajax');
							$(this).attr('disabled', true);
							setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ", 0);
						});

					$('#bt_buscar').fadeIn(0);
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
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Fecha</th>
								<th>Suplidor</th>
								<th>Numero</th>
								<th>Monto</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?

							if ($_GET['consul'] == '1') {


								if ($_GET['suplidor'] == 't1') {
								} else {
									$suplidor = "AND id_aseg = '" . $_GET['suplidor'] . "' ";
								}


								if ($_GET['estatus'] == 't') {
								} else {
									$estatus = "AND pago = '" . $_GET['estatus'] . "' ";
								}

								$query = mysql_query("
   SELECT * FROM remesas 
   WHERE id_dist ='" . $_SESSION['user_id'] . "'  $suplidor $estatus order by id DESC");

								while ($row = mysql_fetch_array($query)) {
									//$Tmonto += $row['monto'];
									$i++;

									//DATOS PARA EXPORTAR
									$fechaExport = explode(" ", $row['fecha_desde']);
									$archivo 	 = "MS_RDR_" . $fechaExport[0] . ".xls";
									$carpeta 	 = $row['id_aseg'];

									$edd = explode(' ', $row['fecha_desde']);

							?>
									<tr>
										<td><?= $row['id'] ?></td>
										<td><?= $row['fecha_desde'] . "<br>" . $row['fecha_hasta'];
											if ($row['pago'] == 's') {
												echo "<br> <b style='font-size:12px; color:#1D04F1'>" . $row['fecha_pago'] . "</b>";
											}

											?></td>
										<td><?
											if ($row['tipo_serv'] == 'prog') {
												echo NombreProgS($row['id_aseg']);
											} else {
												echo NombreSeguroS($row['id_aseg']);
											}


											if ($row['pago'] == 's') {
												echo "<br> <b style='font-size:12px; color:#1D04F1'>" . NombreBancoRep($row['banc_emp']) . "</b>";
												echo "<br> <b style='font-size:12px; color:#1D04F1'>" . NombreBancoSuplidoresRep($row['banc_benef']) . "</b>";
											}



											?></td>
										<td><?

											$a = str_pad($row['num'], 4, "0", STR_PAD_LEFT);
											if ($row['tipo_serv'] == 'prog') {
												echo $row['year'] . "-" . $a;
											} else {
												echo Sigla($row['id_aseg']) . "-" . $row['year'] . "-" . $a;
											}

											?>

										</td>
										<td><?= "$" . FormatDinero($row['monto']) ?></td>
										<td>


											<?
											if ($row['pago'] == 'n') {
												$TnoPagas += $row['monto'];
											?>
												<!--banco -->
												<a href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Reportes/Opcion/editar-registar.php?id=<?= $row['id'] ?>','','GET','cargaajax'); " data-title="Pagar remesa" class="btn btn-primary">
													Pagar
												</a>
												<!--banco -->
											<?  } else {
												$Tpagas += $row['monto'];
												echo "Pago";
											}

											?>
										</td>
										<td>

											<a class="btn btn-social-icon btn-primary" href="javascript:" onclick="CargarAjax_win('Admin/Sist.Administrador/Reportes/Opcion/View.php?id=<?= $row['id'] ?>','','GET','cargaajax'); " data-title="Ver detalle de remesa"><i class="fa fa-eye"></i></a>

											<!-- <a class="btn btn-social-icon btn-info" href="../../../../ws_schat/TareasProg/Excel/ASEGURADORA/REMESAS/<?= $carpeta ?>/<?= $archivo ?>"  data-title="Descargar remesa" target='_blank'><i class="fa fa-cloud-download"></i></a>-->

											<!--    <a class="btn btn-social-icon btn-info" href="Admin/Sist.Administrador/Reportes/DescargarExcel.php?id=<?= $row['id'] ?>&id_aseg=<?= $row['id_aseg'] ?>&year=<?= $row['year'] ?>&num=<?= $row['num'] ?>&sigla=<?= Sigla($row['id_aseg']) ?>"  data-title="Descargar remesa"><i class="fa fa-cloud-download"></i></a>-->

											<a class="btn btn-social-icon btn-info" href="../ws_schat/TareasProg/Excel/ASEGURADORA/REMESAS/<?= $row['id_aseg'] ?>/MS_RDR_<?= $edd[0] ?>.xls" target="_blank" data-title="Descargar remesa"><i class="fa fa-cloud-download"></i></a>



										</td>
									</tr>
							<?
								}
							}
							?>


							<? if ($Tpagas > 0) { ?>
								<tr>
									<td colspan="4"></td>
									<td><strong>Total Pagas</strong></td>
									<td colspan="2"><strong><?= "$" . FormatDinero($Tpagas) ?></strong></td>
								</tr>

							<? } ?>

							<? if ($TnoPagas > 0) { ?>
								<tr>
									<td colspan="4"></td>
									<td><strong>Total Pendientes</strong></td>
									<td colspan="2"><strong><?= "$" . FormatDinero($TnoPagas) ?></strong></td>
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