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
		<h3 class="page-header">Reporte de polizas remitidas</h3>
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
							<input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?= $fecha1 ?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
							<label style="margin-left:5px;">Hasta:</label>
							<input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?= $fecha2 ?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">



							<label style="margin-left:5px;">Ruta:</label>
							<select name="ruta_id" id="ruta_id" style="display: inline; width: 170px;" class="form-control">
								<option value="1todos">- Todos - </option>
								<? ///  SELECCION DEL TIPO .....................................
								$rescat2 = mysql_query("SELECT * from agencia_via WHERE user_id !=''AND ejecutivo !=''  group by ejecutivo order by ejecutivo ASC");
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

							<? if ($_GET['consul'] == '1') { ?>




								<a href="Admin/Sist.Dependientes/Reportes/Export/listado.polizs.remitidas.php?fecha1=<?= $fecha1; ?>&fecha2=<?= $fecha2; ?>&idpers=<?= $_GET['idpers'] ?>&ruta_id=<?= $_GET['ruta_id'] ?>&consul=1" class="btn btn-primary btn-icon glyphicons download_alt hidden-print" id="descargar">Export

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
							//var id 		= $('#id').val();
							var ruta_id = $('#ruta_id').val();

							CargarAjax2('Admin/Sist.Dependientes/Reportes/listado.polizs.remitidas.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&ruta_id=' + ruta_id + '&consul=1', '', 'GET', 'cargaajax');
							$(this).attr('disabled', true);
							setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ", 0);
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
								<th>Poliza</th>
								<th>Fecha de Emisión</th>
								<th>Nombre</th>
								<th>Agencia</th>
								<th>Ruta</th>
							</tr>
						</thead>
						<tbody>
							<?

							if ($_GET['consul'] == '1') {

								$fd1	= explode('/', $fecha1);
								$fh1	= explode('/', $fecha2);
								$fDesde 	= $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
								$fHasta 	= $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];
								$wFecha 	= "AND trans.fecha >= '$fDesde 00:00:00' AND trans.fecha < '$fHasta 23:59:59'";

								if ($_GET['ruta_id'] != '1todos') {
									$ejecutivo = " ejecutivo LIKE '%" . $_GET['ruta_id'] . "%' ";
								} else {
									//$ejecutivo = "id !='' ";
								}


								$idpers = " AND user_id ='" . $_SESSION['dist_id'] . "' ";


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
												rever.id_trans IS NULL AND trans.monto !='' AND trans.user_id ='" . $_SESSION['dist_id'] . "'  $wFecha $resulAgen order by id DESC");

								while ($row = mysql_fetch_array($query)) {

									$Agent = explode("-", $row['x_id']);
									$Agencia = explode("/", AgenciaVia($Agent[0]));
									$varia = array("Ruta ", "RUTA", " ", "-", "/");
									$ruta = str_replace($varia, "", $Agencia[1]);

									$array[$Agencia[1]][] = $row;
								}




								ksort($array);

								/*echo "<pre>";
		print_r($array);
	echo  "</pre>";*/


								foreach ($array as $key => $val) {


									foreach ($val as $key2 => $row) {

										$client2 = explode("|", ClientesVerRemesa($row['id_cliente']));
										$Agent2 = explode("-", $row['x_id']);
										$Agencia2 = explode("/", AgenciaVia($Agent2[0]));

										$varia2 = array("Ruta ", "RUTA", " ", "-", "/");
										$ruta2 = str_replace($varia2, "", $Agencia2[1]);

										/*echo "KEY: "."$key2"."<br>";
			echo "ID: ".$row['id']."<br><br>";*/




							?>
										<tr>
											<td><?= GetPrefijo($row['id_aseg']) . "-" . str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT); ?></td>
											<td><?= FechaListPDF($row['fecha']) ?></td>
											<td><?= $client2[0] . " " . $client2[1] ?></td>
											<td><?= $Agent2[0] . " - " . strtoupper($Agencia2[0]) ?></td>
											<td><?= strtoupper($Agencia2[1]) ?></td>
										</tr>
							<?

									}
								}
							}


							/* $query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE user_id ='20' $wFecha order by id DESC LIMIT 10"); 
 
  while($row=mysql_fetch_array($query)){
	  $xid	= explode('-',$row['x_id']);
	  
	  echo "<b>XID explode:</b>".$xid[0]."<br>";
	  
	   if((substr_count($num_agencia,"[".$xid[0]."]")>0)){
		 echo "<b>HAY ID:</b> ".$row['id']."<br>"; 
		 echo "<b>X_ID:</b> ".$row['x_id']."<br>";  
	  }else{
		 echo "<b>NO ID:</b> ".$row['id']."<br>"; 
		 echo "<b>X_ID:</b> ".$row['x_id']."<br><br>";  
	  }
	  
	  
  }*/
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>