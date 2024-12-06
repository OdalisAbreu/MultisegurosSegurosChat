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
                  #  SELECCION DEL TIPO .....................................
                  #  SELECCION DEL TIPO .....................................

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
                <label class="control-label">Distribuidor</label>
                <select name="distribuidor" id="distribuidor" style="display: inline; width: 170px;" class="form-control">
                  <option value="t" selected>-- Todos --</option>
                  <?php
                  $distQuery = mysql_query(
                    "SELECT 
                          id, nombres
                      FROM
                          personal
                      WHERE
                          funcion_id = 2 AND activo = 'si'"
                  );
                  while ($distRow = mysql_fetch_array($distQuery)) {
                    $distNombre = $distRow['nombres'];
                    $distId = $distRow['id'];

                    if ($_GET['distribuidor'] == $id) {
                      echo "<option value=\"$distId\"  selected>$distId - $distNombre</option>";
                    } else {
                      echo "<option value=\"$distId\" >$distId - $distNombre</option>";
                    }
                  }
                  ?>
                </select>
              </td>
              <td>


                <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-primary" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                  Actualizar
                </button>



                <?php if ($_GET['consul'] == '1') { ?>

                  <a href="Admin/Sist.Administrador/Reportes/Export/ExcelServOpc.php?fecha1=<?= $fecha1 ?>&fecha2=<?= $fecha2 ?>&serv=<?= $_GET['serv'] ?>&suplid_id2=<?= $_GET['suplid_id2'] ?>" class="btn btn-success">
                    <i class="fa fa-file-excel-o fa-lg" title="Descargar en Excel"></i>
                  </a>

                <?php } ?>


              </td>

            </tr>
          </table>
        </form>

        <script type="text/javascript">
          var request_dist = '<?= $_GET['distribuidor'] ?>';
          if (request_dist && request_dist != 't') {
            $("#distribuidor").val(request_dist);
          }
          $('#bt_buscar').click(
            function() {
              var fecha1 = $('#fecha1').val();
              var fecha2 = $('#fecha2').val();
              var serv = $('#serv').val();
              var suplid_id2 = $('#suplid_id2').val();
              var distId = $("#distribuidor").val();




              CargarAjax2('Admin/Sist.Administrador/Reportes/ventas_por_serv_opcional.php?fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&serv=' + serv + '&suplid_id2=' + suplid_id2 + "&distribuidor=" + distId + '&consul=1', '', 'GET', 'cargaajax');
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
                <th>Distribuidor</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php if ($_GET['consul'] == '1') {
                $fd1 = explode('/', $fecha1);
                $fh1 = explode('/', $fecha2);
                $fDesde = $fd1[2] . '-' . $fd1[1] . '-' . $fd1[0];
                $fHasta = $fh1[2] . '-' . $fh1[1] . '-' . $fh1[0];
                $wFecha = " AND trans.fecha >= '$fDesde 00:00:00' AND trans.fecha <= '$fHasta 23:59:59' ";

                if ($_GET['serv'] == 't') {
                  $serv = "";
                } else {
                  $serv = " AND trans.id_serv_adc = '" . $_GET['serv'] . "' ";
                }

                if ($_GET['distribuidor'] === 't') {
                  $distribuidor = "";
                } else {
                  $distribuidor =
                    " AND (distribuidor_multiseguros.id = " .
                    $_GET['distribuidor'] .
                    " OR distribuidor_via.id = " .
                    $_GET['distribuidor'] .
                    " OR vendedor_pagosmultiples.id = " .
                    $_GET['distribuidor'] .
                    ") ";
                }
                $queryString =  "SELECT 
                      trans.id_trans,
                      IF(serv.mod_pref = 's',
                          serv.prefijo1,
                          seg.prefijo) 'prefijo',
                      segt.id_poliza num_poliza,
                      seg.nombre 'aseguradora',
                      segcli.asegurado_nombres nombre_cliente,
                      segcli.asegurado_apellidos apellido_cliente,
                      segcli.asegurado_cedula cedula,
                      segcli.asegurado_direccion direccion,
                      ciu.descrip ciudad,
                      IF(reve.id IS NOT NULL,
                          'Anulado',
                          'Vendido') 'estado',
                      IF(supli.nombre IS NULL,
                          seg.nombre,
                          supli.nombre) 'suplidor',
                      serv.nombre 'nombre_servicio',
                      trans.costo,
                      trans.monto,
                      segt.fecha_inicio 'fecha_inicio_poliza',
                      segt.fecha_fin 'fecha_fin_poliza',
                      IF(agencia_via.razon_social IS NULL,
                          IF(vendedor_multiseguros.nombres IS NULL,
                              vendedor_pagosmultiples.nombres,
                              vendedor_multiseguros.nombres),
                          CONCAT(agencia_via.num_agencia,
                                  ' - ',
                                  agencia_via.razon_social)) Vendedor,
                      IF(distribuidor_via.nombres IS NULL,
                          IF(distribuidor_multiseguros.nombres IS NULL,
                              vendedor_pagosmultiples.nombres,
                              distribuidor_multiseguros.nombres),
                          distribuidor_via.nombres) Distribuidor,
                      segt.id_vehiculo,
                      segt.vigencia_poliza,
                      DATE_FORMAT(trans.fecha, '%d/%m/%Y %h:%i %p') fecha
                  FROM
                      seguro_trans_history trans
                          INNER JOIN
                      servicios serv ON trans.id_serv_adc = serv.id
                          INNER JOIN
                      seguro_transacciones segt ON segt.id = trans.id_trans
                          INNER JOIN
                      seguros seg ON seg.id = trans.id_aseg
                          INNER JOIN
                      seguro_clientes segcli ON segt.id_cliente = segcli.id
                          LEFT JOIN
                      ciudad ciu ON ciu.id = segcli.ciudad
                          LEFT JOIN
                      seguro_transacciones_reversos reve ON trans.id_trans = reve.id_trans
                          LEFT JOIN
                      suplidores supli ON supli.id = serv.id_suplid
                          LEFT JOIN
                      agencia_via ON agencia_via.num_agencia = SUBSTRING_INDEX(segt.x_id, '-', 1)
                          AND SUBSTRING_INDEX(segt.x_id, '-', 1) != 'WEB'
                          LEFT JOIN
                      personal distribuidor_via ON agencia_via.user_id = distribuidor_via.id
                          LEFT JOIN
                      personal vendedor_multiseguros ON vendedor_multiseguros.id = segt.user_id
                          AND SUBSTRING_INDEX(segt.x_id, '-', 1) = 'WEB'
                          LEFT JOIN
                      personal distribuidor_multiseguros ON distribuidor_multiseguros.funcion_id = 2
                          AND vendedor_multiseguros.id_dist = distribuidor_multiseguros.id
                          LEFT JOIN
                      personal vendedor_pagosmultiples ON vendedor_pagosmultiples.id = segt.user_id
                          AND SUBSTRING_INDEX(segt.x_id, '-', 1) = '86'
                  WHERE
                      trans.tipo = 'serv' $serv $wFecha $distribuidor order by Distribuidor, id_trans ASC";
                $query = mysql_query(
                  $queryString
                );

                $el_dist = '';
                $dist_monto = 0;
                $i = -1;
                $p = -1;
                while ($row = mysql_fetch_array($query)) {
                  $p++;
                  $i++;
                  if ($el_dist != $row['Distribuidor']) {

                    if ($el_dist != '') {
                      $footer_dist = '<tr>
                        <td colspan="6"> <b>' . ($i == 0 ? 1 : $i) . ' Transacci' . ($i > 1 ? 'ones' : '&oacute;n') . ' de ' . $el_dist . '</b></td>
                        <td>Total:</td>
                        <td>RD$ ' . formatDinero($dist_monto) . '</td>
                        <td></td>
                      </tr>';
                      echo $footer_dist;
                    }
                    $header_dist = '<tr>
                      <td colspan="9"><b>' . $row['Distribuidor'] . '</b></td>
                    </tr>';
                    echo $header_dist;
                    $i = 0;
                    $dist_monto = 0;
                    $el_dist = $row['Distribuidor'];
                  }

                  if (
                    $row['estado'] == "Anulado"
                  ) {
                    $mensaje = "<b style='color:#F40408'>Anulado</b>";
                  } else {
                    $mensaje = "<b style='color:#0844C3'>Vendido</b>";
                    $Mtotal += $row['monto'];
                    if ($el_dist == $row['Distribuidor']) {
                      $dist_monto += $row['monto'];
                    }
                  }


                  $TipoVeh = explode('/', Tipo($row['id_vehiculo']));
                  ?>

                  <tr>
                    <td><b><?= $row['id_trans'] ?></b>
                      <br><?= $row['fecha'] ?></td>
                    <td><b><?= $row['aseguradora'] ?></b>
                      <br><?= $row['prefijo'] .
                                '-' .
                                str_pad(
                                  $row['num_poliza'],
                                  6,
                                  "0",
                                  STR_PAD_LEFT
                                ) ?>
                    </td>
                    <td><?= $row['nombre_cliente'] ?></td>
                    <td> <b> <?= $row['nombre_servicio'] ?></b></td>
                    <td><?= Vigencia($row["vigencia_poliza"]) ?></td>
                    <td><?= Vehiculo(
                              $row['id_vehiculo']
                            ) ?>

                    </td>
                    <td>
                      RD$ <?= formatDinero($row['monto']) ?><br>
                      <?= $mensaje ?></td>
                    <td><?= "<b>" .
                              $row['Vendedor'] .
                              " </b>	<br><font style='font-size:11px'>" .
                              $row["Distribuidor"] .
                              "</font>" ?></td>
                    <td><a href="javascript:void(0)" onclick=" CargarAjax_win('Admin/Sist.Administrador/Revisiones/Imprimir/Accion/poliza.php?id_trans=<?= $row['id_trans'] ?>','','GET','cargaajax'); " data-title="Visualizar" class="btn btn-danger">
                        <i class="fa fa-eye fa-lg"></i>
                      </a></td>
                  </tr>
              <?php
                }
              }
              $footer_dist = '<tr>
                        <td colspan="6"> <b>' . ($i == 0 ? 1 : $i) . ' Transacci' . ($i > 1 ? 'ones' : '&oacute;n') . ' de ' . $el_dist . '</b></td>
                        <td>Total:</td>
                        <td>RD$ ' . formatDinero($dist_monto) . '</td>
                        <td></td>
                      </tr>';
              echo $footer_dist;
              ?>
              <tr>
                <td colspan="6"> <b><?= $p == 0 ? 1 : $p ?> Transacciones</b></td>
                <td>Total:</td>
                <td>RD$ <?= formatDinero($Mtotal) ?></td>
                <td></td>
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