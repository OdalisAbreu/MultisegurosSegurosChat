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
	$fecha1 = fecha_despues('' . date('d/m/Y') . '', -1);
}
// --------------------------------------------
if ($_GET['fecha2']) {
	$fecha2 = $_GET['fecha2'];
} else {
	$fecha2 = fecha_despues('' . date('d/m/Y') . '', -1);
}
?>

<div class="row">
	<div class="col-lg-12" style="margin-top:-35px;">
		<h3 class="page-header">Formulario para generar las remesas</h3>
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


							<label class="control-label">Aseg</label>



							<select name="aseguradora" id="aseguradora" style="display: inline; width: 170px;" class="form-control">

								<? ///  SELECCION DEL TIPO .....................................
								$rescat2 = mysql_query("SELECT id, nombre from seguros  order by nombre ASC");
								while ($cat2 = mysql_fetch_array($rescat2)) {
									$nombre = $cat2['nombre'];
									$id 		= $cat2['id'];

									if ($_GET['aseguradora'] == $id) {
										echo "<option value=\"$id\"  selected>$nombre</option>";
									} else {
										echo "<option value=\"$id\" >$nombre</option>";
									}
								} ?>
							</select>






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

							CargarAjax2('Admin/Sist.Administrador/Reportes/Form.Gen.Remesas.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&aseguradora=' + aseguradora + '&tipo=' + tipo + '&consul=1', '', 'GET', 'cargaajax');
							$(this).attr('disabled', true);
							//setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
						});


					$('#descargar').click(
						function() {
							var fecha1 = $('#fecha1').val();
							var fecha2 = $('#fecha2').val();
							var aseguradora = $('#aseguradora').val();

							CargarAjax2('Admin/Sist.Administrador/Reportes/Export/listado_trans_aseg.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&aseguradora=' + aseguradora + '&consul=1', '', 'GET', 'cargaajax2');
							$(this).attr('disabled', true);

						});

					$(this).attr('disabled', false);

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

					<?

					if ($_GET['consul'] == '1') {

						//https://multiseguros.com.do/ws_schat/TareasProg/Gen.Rep.Remesas.Aseg.php?id_aseg=3&fecha1=04/12/2017&fecha2=17/12/2017
						//multiseguros.com.do/ws_schat/TareasProg/Gen.Rep.Remesas.Aseg.php?id_aseg=3&fecha1=04/12/2017&fecha2=17/12/2017
						//$url ="https://multiseguros.com.do/~multiseguroscom/ws_schat/TareasProg/Gen.Rep.Remesas.Aseg.php?id_aseg="
						//.trim($_GET['aseguradora'])."&fecha1=".trim($fecha1)."&fecha2=".trim($fecha2)."";


						$url = "https://multiseguros.com.do/ws_schat/TareasProg/Gen.Rep.Remesas.Aseg.php?id_aseg="
							. trim($_GET['aseguradora']) . "&fecha1=" . trim($fecha1) . "&fecha2=" . trim($fecha2) . "";
						$getWS 	= file_get_contents($url);

						$respuesta = explode("/", $getWS);


						echo "<h2 align='center' style='color:#428bca'>REALIZANDO REMESA</h2>";
						/*echo "<strong>Fecha Desde:</strong> ".$fecha1."<br>";
	echo "<strong>Fecha Hasta:</strong> ".$fecha2."<br>";
	echo "<strong>Aseguradora:</strong> ".NombreSeguroS($_GET['aseguradora'])."<br>";
	
	if($respuesta[0] =='00'){
		echo "<strong style='color:#2b910d'>Resultado:</strong> Remesa realizada<br>";
	}
	
	if($respuesta[0] =='15'){
		echo "<strong style='color:#FF0000'>Resultado:</strong> Remesa ya fue realizada<br>";
	}*/

						echo $getWS;



					?>

					<?
					}

					?>




				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>