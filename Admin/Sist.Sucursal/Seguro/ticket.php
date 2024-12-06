<?
session_start();
set_time_limit(0);
include("../../../incluidos/conexion_inc.php");
include("../../../incluidos/nombres.func.php");
Conectarse();
?>

<script type="text/javascript">
  function imprSelec(nombre) {
    $("#tick").css("display", "block");
    $("#tick2").css("display", "block");
    var ficha = document.getElementById(nombre);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
  }
</script>

<DIV ID="ImprimirTicket" align="center">
  <table style="border:solid 1px #CCC; border-radius: 10px;">
    <tr>
      <td>
        <!-- TABLA UNO -->
        <table width="375" border="0" style=" font-size: 14px;  padding-left:10px; padding-right:10px;" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2">
              <center>
                <?  //$_GET['id']=LimpiarCampos($_GET['id']);

                if ($_SESSION['user_id'] == '6') {
                } else {
                  $var = "user_id !='' AND";
                }

                $query = mysql_query("
		select * from seguro_transacciones 
	WHERE  
		  $var id ='" . $_GET['id'] . "' LIMIT 1");

                //hasta aqui
                $row = mysql_fetch_array($query);


                //BUSCAR DATOS DEL CLIENTE
                $QClient = mysql_query("select asegurado_nombres,asegurado_apellidos,asegurado_cedula 
  from seguro_clientes
  WHERE id ='" . $row['id_cliente'] . "' LIMIT 1");
                $RQClient = mysql_fetch_array($QClient);

                $fecha = explode(' ', $row['fecha']);
                $hora1 = explode('-', $fecha[0]);
                $fecha = $hora1[2] . '-' . $hora1[1] . '-' . $hora1[0];

                if ($hora1[1] == '1') $mes = "Enero";
                if ($hora1[1] == '2') $mes = "Febrero";
                if ($hora1[1] == '3') $mes = "Marzo";
                if ($hora1[1] == '4') $mes = "Abril";
                if ($hora1[1] == '5') $mes = "Mayo";
                if ($hora1[1] == '6') $mes = "Junio";
                if ($hora1[1] == '7') $mes = "Julio";
                if ($hora1[1] == '8') $mes = "Agosto";
                if ($hora1[1] == '9') $mes = "Septiembre";
                if ($hora1[1] == '10') $mes = "Octubre";
                if ($hora1[1] == '11') $mes = "Noviembre";
                if ($hora1[1] == '12') $mes = "Diciembre";

                $fecha2       = explode(' ', $row['fecha_inicio']);
                $hora12      = explode('-', $fecha2[0]);
                $fecha_inicio = $hora12[2] . '-' . $hora12[1] . '-' . $hora12[0];
                if ($hora12[1] == '1') $mes2 = "Enero";
                if ($hora12[1] == '2') $mes2 = "Febrero";
                if ($hora12[1] == '3') $mes2 = "Marzo";
                if ($hora12[1] == '4') $mes2 = "Abril";
                if ($hora12[1] == '5') $mes2 = "Mayo";
                if ($hora12[1] == '6') $mes2 = "Junio";
                if ($hora12[1] == '7') $mes2 = "Julio";
                if ($hora12[1] == '8') $mes2 = "Agosto";
                if ($hora12[1] == '9') $mes2 = "Septiembre";
                if ($hora12[1] == '10') $mes2 = "Octubre";
                if ($hora12[1] == '11') $mes2 = "Noviembre";
                if ($hora12[1] == '12') $mes2 = "Diciembre";

                $fecha3    = explode(' ', $row['fecha_fin']);
                $hora13     = explode('-', $fecha3[0]);
                $fecha_fin = $hora13[2] . '-' . $hora13[1] . '-' . $hora13[0];
                if ($hora13[1] == '1') $mes3 = "Enero";
                if ($hora13[1] == '2') $mes3 = "Febrero";
                if ($hora13[1] == '3') $mes3 = "Marzo";
                if ($hora13[1] == '4') $mes3 = "Abril";
                if ($hora13[1] == '5') $mes3 = "Mayo";
                if ($hora13[1] == '6') $mes3 = "Junio";
                if ($hora13[1] == '7') $mes3 = "Julio";
                if ($hora13[1] == '8') $mes3 = "Agosto";
                if ($hora13[1] == '9') $mes3 = "Septiembre";
                if ($hora13[1] == '10') $mes3 = "Octubre";
                if ($hora13[1] == '11') $mes3 = "Noviembre";
                if ($hora13[1] == '12') $mes3 = "Diciembre";


                //echo $row['fecha']."<br>";
                $a1a   = explode(' ', $row['fecha']);
                //echo $a1a[1];
                $a12a   = explode(':', $a1a[1]);


                if ($a12a[0] == '00') $fHora = "12";
                $T = "AM";
                if ($a12a[0] == '01') $fHora = "1";
                $T = "AM";
                if ($a12a[0] == '02') $fHora = "2";
                $T = "AM";
                if ($a12a[0] == '03') $fHora = "3";
                $T = "AM";
                if ($a12a[0] == '04') $fHora = "4";
                $T = "AM";
                if ($a12a[0] == '05') $fHora = "5";
                $T = "AM";
                if ($a12a[0] == '06') $fHora = "6";
                $T = "AM";
                if ($a12a[0] == '07') $fHora = "7";
                $T = "AM";
                if ($a12a[0] == '08') $fHora = "8";
                $T = "AM";
                if ($a12a[0] == '09') $fHora = "9";
                $T = "AM";
                if ($a12a[0] == '10') $fHora = "10";
                $T = "AM";
                if ($a12a[0] == '11') $fHora = "11";
                $T = "AM";
                if ($a12a[0] == '12') $fHora = "12";
                $T = "PM";
                if ($a12a[0] == '13') $fHora = "1";
                $T = "PM";
                if ($a12a[0] == '14') $fHora = "2";
                $T = "PM";
                if ($a12a[0] == '15') $fHora = "3";
                $T = "PM";
                if ($a12a[0] == '16') $fHora = "4";
                $T = "PM";
                if ($a12a[0] == '17') $fHora = "5";
                $T = "PM";
                if ($a12a[0] == '18') $fHora = "6";
                $T = "PM";
                if ($a12a[0] == '19') $fHora = "7";
                $T = "PM";
                if ($a12a[0] == '20') $fHora = "8";
                $T = "PM";
                if ($a12a[0] == '21') $fHora = "9";
                $T = "PM";
                if ($a12a[0] == '22') $fHora = "10";
                $T = "PM";
                if ($a12a[0] == '23') $fHora = "11";
                $T = "PM";



                ?>


                <img src="https://multiseguros.com.do/SegurosChat/images/multiseg.png" style="width: 315px; height: 70px; margin-bottom: 10px; margin-top: 10px;">
              </center>
            </td>

          </tr>



          <tr>
            <td>Fecha / Hora:</td>
            <td><? echo $hora1[2] . '-' . $mes . '-' . $hora1[0]; ?>&nbsp;&nbsp;&nbsp;<b><?= $fHora . ":" . $a12a[1] . " " . $T; ?></b></td>
          </tr>
          <tr>
            <td>Nombre:</td>
            <td><?= $RQClient['asegurado_nombres']; ?></td>
          </tr>
          <tr>
            <td>Apellidos:</td>
            <td><?=
                $RQClient['asegurado_apellidos']; ?></td>
          </tr>
          <tr>
            <td>Cedula:</td>
            <td><?


                $bodytag0 = str_replace("-", "", $RQClient['asegurado_cedula']);
                $bodytag = str_replace(" ", "", $bodytag0);
                $rest3 = substr($bodytag, -1);    // devuelve "3"
                $rest2 = substr($bodytag, 3, 7);    // devuelve "ef"
                $rest1 = substr($bodytag, 0, 3); // devuelve "d"

                echo $rest1 . "-" . $rest2 . "-" . $rest3;
                ?></td>
          </tr>

          <tr>
            <td>Aseguradora:</td>
            <td><b><?= NombreSeguroS($row['id_aseg']) ?></b></td>
          </tr>
          <tr>

          <tr>
            <td>No. Poliza:</td>
            <td><b><?= GetPrefijo($row['id_aseg']) . '-' . str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT) ?></b></td>
          </tr>
          <tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?
          $qVeh = mysql_query("
		SELECT id,veh_marca,veh_modelo,veh_tipo,veh_ano,veh_chassis,veh_matricula
		FROM seguro_vehiculo WHERE id='" . $row['id_vehiculo'] . "' LIMIT 1");
          $rVehiculo = mysql_fetch_array($qVeh);

          $r2s = mysql_query("SELECT * from seguro_marcas WHERE id ='" . $rVehiculo['veh_marca'] . "' LIMIT 1");
          $rows = mysql_fetch_array($r2s); {
            $veh_marca     = $rows['DESCRIPCION'];
          }

          $r2s2 = mysql_query("SELECT * from seguro_modelos WHERE ID ='" . $rVehiculo['veh_modelo'] . "' LIMIT 1");
          $rows2 = mysql_fetch_array($r2s2); {
            $veh_modelo     = $rows2['descripcion'];
          }

          $qTipo = mysql_query("
		SELECT id,veh_tipo,nombre,dpa,rc,rc2,fj
		FROM seguro_tarifas WHERE veh_tipo='" . $rVehiculo['veh_tipo'] . "' LIMIT 1");
          $rTipo = mysql_fetch_array($qTipo);
          ?>
          <tr>
            <td>Tipo:</td>
            <td><?= $rTipo['nombre'] ?></td>
          </tr>
          <tr>
            <td>Marca:</td>
            <td><?= $veh_marca . " " . $veh_modelo ?></td>
          </tr>
          <tr>
            <td>A&ntilde;o:</td>
            <td><?= $rVehiculo['veh_ano'] ?></td>
          </tr>
          <tr>
            <td>Placa:</td>
            <td><?= $rVehiculo['veh_matricula'] ?></td>
          </tr>
          <tr>
            <td>Chassis:</td>
            <td><?= $rVehiculo['veh_chassis'] ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Valido desde:</td>
            <td><?= $hora12[2] . '-' . $mes2 . '-' . $hora12[0]; ?></td>
          </tr>
          <tr>
            <td>Valido hasta:</td>
            <td><?= $hora13[2] . '-' . $mes3 . '-' . $hora13[0]; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td colspan="2"><strong>Coberturas</strong></td>
          </tr>
          <tr>
            <td>Da&ntilde;os Propiedad Ajena:</td>
            <td><?= FormatDinero($rTipo['dpa']) ?></td>
          </tr>
          <tr>
            <td>Responsabilidad Civil:
              <br>
              <font style="font-size:10px"><b>Una persona</b></font>
            </td>
            <td><?= FormatDinero($rTipo['rc']) ?></td>
          </tr>
          <tr>
            <td>Responsabilidad Civil:<br>
              <font style="font-size:10px"><b>M&aacute;s de una persona</b></font>
            </td>
            <td><?= FormatDinero($rTipo['rc2']) ?></td>
          </tr>
          <tr>
            <td>Fianza Judicial:</td>
            <td><?= FormatDinero($rTipo['fj']) ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><strong>Servicios Opcionales</strong></td>
          </tr>
          <?
          function Servicios($id)
          {
            $QServ = mysql_query("
		SELECT id,nombre
		FROM servicios WHERE id='" . $id . "' LIMIT 1");
            $RQServ = mysql_fetch_array($QServ);
            return $RQServ['nombre'];
          }

          $myString = trim($row['serv_adc'], '-');
          $pieces = explode("-", $myString);
          for ($i = 0; $i < count($pieces); $i++) {

            if ($pieces[$i] != '0') {
          ?>
              <tr>
                <td colspan="2"><?= Servicios($pieces[$i]) . "- <b>Incluido</b>" ?> </td>

              </tr>
          <? }
          } ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>Prima Total:</td>
            <td>
              <b>
                <font size="4">RD$ <?= FormatDinero($row['monto']) ?></font>
              </b>

            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              Gracias por elegir MultiSeguros
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
        </table>
        <!-- TABLA UNO -->

      </td>

    </tr>
  </table>
</DIV>

<table align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <center> <input type="button" value="IMPRIMIR" onclick="javascript:imprSelec('ImprimirTicket');" class="button" /></center>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>