<?php session_start();
ini_set('display_errors', 1);
include "../../../incluidos/conexion_inc.php";
include "../../../incluidos/nombres.func.php";
include "../../../incluidos/fechas.func.php";
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

//print_r($_GET);
?>

<div class="row">
  <div class="col-lg-12" style="margin-top:-35px;">
    <h3 class="page-header">Ventas por servicios opcionales</h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="filter-bar">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="form_edit_prof">
          <table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">

            <tr>
              <td>

                <label>Desde:</label>
                <input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?= $fecha1 ?>" style="width: 130px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                <label style="margin-left:5px;">
                  <p>
                    Hasta:
                </label>
                <input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?= $fecha2 ?>" style="width: 130px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
              </td>

              <td>
                <label class="control-label">Servicio opt</label>
                <select name="serv" id="serv" style="display: inline; width: 170px;" class="form-control">
                  <option value="t" selected>-- Todos --</option>
                  <?php
                  $rescat2 = mysql_query(
                    "SELECT * from servicios WHERE activo ='si' order by nombre ASC"
                  );
                  while ($cat2 = mysql_fetch_array($rescat2)) {
                    $nombre = $cat2['nombre'];
                    $id = $cat2['id'];

                    if ($_GET['serv'] == $id) {
                      echo "<option value=\"$id\"  selected>$id - $nombre</option>";
                    } else {
                      echo "<option value=\"$id\" >$id - $nombre</option>";
                    }
                  }
                  ?>
                </select>


                <script>
                  $("#serv").change(

                    function() {
                      id = $(this).val();

                      CargarAjax2('Admin/Sist.Administrador/Reportes/AJAX/Suplidor.php?suplid_id2=' + id + '', '', 'GET', 'suplidor');

                    });
                </script>

              </td>
              <td>

                <?php if ($_GET['suplid_id2']) {
                  echo "
						<script>
						CargarAjax2('Admin/Sist.Administrador/Reportes/AJAX/Suplidor.php?suplid_id2=" .
                    $_GET['suplid_id2'] .
                    "','','GET','suplidor');
						
						</script>
						";
                } ?>

                <label class="control-label">Suplidor</label>

                <div id="suplidor" disabled="disabled" class="col-md-12" style="margin-left:-15px; display:compact; width:200px">
                  <select name="suplid_id" id="suplid_id2" style="display:compact" class="form-control">
                  </select>
                </div>

              </td>
              <td>


                <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                  Actualizar
                </button>



                <?php if ($_GET['consul'] == '1') { ?>

                  <a href="Admin/Sist.Administrador/Reportes/Export/ExcelServOpc.php?fecha1=<?= $fecha1 ?>&fecha2=<?= $fecha2 ?>&serv=<?= $_GET[
  'serv'
] ?>&suplid_id2=<?= $_GET['suplid_id2'] ?>" class="btn btn-success">
                    <i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
                  </a>

                <?php } ?>


              </td>

            </tr>
          </table>
        </form>
        <script type="text/javascript">
          $('#bt_buscar').click(
            function() {
              var fecha1 = $('#fecha1').val();
              var fecha2 = $('#fecha2').val();
              var serv = $('#serv').val();
              var suplid_id2 = $('#suplid_id2').val();




              CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_por_serv_opcional2.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&serv=' + serv + '&suplid_id2=' + suplid_id2 + '&consul=1', '', 'GET', 'cargaajax');
              $(this).attr('disabled', true);
              //setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
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
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Aseguradora</th>
                <th>Asegurado</th>
                <th>Servicio Opcional</th>
                <th>Vigencia</th>
                <th>Vehiculo</th>
                <th>Estado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php if ($_GET['consul'] == '1') {
                $fd1 = explode('/', $fecha1);
                $fh1 = explode('/', $fecha2);
                $fDesde = $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
                $fHasta = $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];
                $wFecha = "fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59'";

                $qR = mysql_query(
                  "SELECT * FROM seguro_transacciones_reversos WHERE $wFecha"
                );
                while ($rev = mysql_fetch_array($qR)) {
                  $reversadas .= "[" . $rev['id_trans'] . "]";
                }

                //DIVIDIR EL SUPLIDOR QUE ELEGIMOS
                $SUP = explode('|', $_GET['suplid_id2']);
                $id = $SUP[0];
                $tipo = $SUP[1];

                //echo $_GET['suplid_id2'];
                if ($_GET['suplid_id2'] == 't') {
                  $aseg = "";
                } else {
                  $esc1 = mysql_query(
                    "SELECT * from suplidores WHERE reporte ='si' 
		AND id_seguro ='" .
                      $_GET['suplid_id2'] .
                      "' LIMIT 1"
                  );
                  $resc1 = mysql_fetch_array($esc1);

                  if ($resc1['tipo'] == 'seg') {
                    $aseg = "AND id_aseg='" . $id . "' ";
                  } elseif ($resc1['tipo'] == 'serv') {
                    $aseg = "AND id_serv_adc = '" . $id . "' ";
                  }
                }

                if ($_GET['serv'] == 't') {
                  $serv = "";
                } else {
                  $serv = "AND id_serv_adc = '" . $_GET['serv'] . "' ";
                }

                $query = mysql_query("
   SELECT * FROM seguro_trans_history 
   WHERE $wFecha $serv $aseg AND tipo='serv' AND tipo = 'serv' order by id ASC");
                /*echo "<br><b>CONSULTA:</b> SELECT * FROM seguro_trans_history
                 WHERE $wFecha $serv $aseg AND tipo='serv' AND tipo = 'serv' order by id ASC";*/
                while ($row = mysql_fetch_array($query)) {

                  if (
                    substr_count($reversadas, "[" . $row['id_trans'] . "]") > 0
                  ) {
                    $mensaje = "<b style='color:#F40408'>Anulado</b>";
                  } else {
                    $mensaje = "<b style='color:#0844C3'>Vendido</b>";
                    $Tmonto += $row['monto'];
                  }

                  $fh1 = explode(' ', $row['fecha']);
                  $i++;

                  $validar = ServOpc($row['id_aseg'], $_GET['serv']);
                  $val = explode('|', $validar);

                  if ($val[0] == 's') {
                    $pref = $val[1];
                  } else {
                    $pref = GetPrefijo($row['id_aseg']);
                  }

                  $poliza = DatosTrans($row['id_trans']);
                  $PolVal = explode('|', $poliza);
                  $x_id = $PolVal[0];
                  $num_poliza = $PolVal[1];
                  $id_vehiculo = $PolVal[2];
                  $vigencia_poliza = $PolVal[3];
                  $id_cliente = $PolVal[4];

                  $Cliente = explode("|", Cliente($id_cliente));
                  $Client = str_replace("|", "", $Cliente[0]);

                  $idseg = str_pad($num_poliza, 6, "0", STR_PAD_LEFT);
                  $prefi = $pref . "-" . $idseg;

                  $TipoVeh = explode('/', Tipo($id_vehiculo));
                  ?>
                  <tr>
                    <td><b><?= $row['id_trans'] ?></b>
                      <br><?= FechaList($fh1[0]) ?></td>
                    <td><b><?= NombreSeguroS($row['id_aseg']) ?></b>
                      <br><?= $prefi ?></td>
                    <td><?= $Client ?></td>
                    <td> <b> <?= ServAdicHistory(
                      $row['id_serv_adc']
                    ) ?></b></td>
                    <td><?= Vigencia($vigencia_poliza) ?></td>
                    <td> <b style='color:#0844C3'><?= $TipoVeh[0] ?></b> <br><?= Vehiculo(
  $row['id_vehiculo']
) ?>

                    </td>
                    <td>
                      RD$ <?= formatDinero($row['monto']) ?><br>
                      <?= $mensaje ?></td>
                    <td><a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?= $row[
                      'id_trans'
                    ] ?>','','GET','cargaajax'); " data-title="Visualizar" class="btn btn-danger">
                        <i class="fa fa-eye fa-lg"></i>
                      </a></td>
                  </tr>
              <?php
                }
              } ?>
              <tr>
                <td colspan="5"> <b><?= $i ?> Transacciones</b></td>
                <td>Total:</td>
                <td>RD$ <?= formatDinero($Tmonto) ?></td>

              </tr>

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