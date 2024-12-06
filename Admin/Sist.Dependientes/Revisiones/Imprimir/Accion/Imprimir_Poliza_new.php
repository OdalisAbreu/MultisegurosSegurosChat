<?php
session_start();
ini_set('display_errors', 1);
set_time_limit(0);

include("../../../../../incluidos/conexion_inc.php");
include("../../../../../incluidos/fechas.func.php");
include("../../../../../incluidos/nombres.func.php");
Conectarse();

$directorio = "https://multiseguros.com.do/SegurosChat/images/";
$logo = "https://multiseguros.com.do/SegurosChat/images/Aseguradora/";

$ancho  = "690";
$anchoP = "345";
$altura = "3100";

//BUSCAR TRANSACCION
$query = mysql_query("select * from seguro_transacciones   
	WHERE id ='" . $_GET['id_trans'] . "' LIMIT 1");
//echo "select * from seguro_transacciones   
//WHERE id ='".$_GET['id_trans']."' LIMIT 1";

$row = mysql_fetch_array($query);
$id_aseguradora = $row['id_aseg'];

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
    default:
        $NombreImg = "";
        break;
}


//BUSCAR DATOS DEL CLIENTE
$QClient = mysql_query("select * from seguro_clientes WHERE id ='" . $row['id_cliente'] . "' LIMIT 1");
//echo "select * from seguro_clientes WHERE id ='".$row['id_cliente']."' LIMIT 1";
$RQClient = mysql_fetch_array($QClient);

//BUSCAR DATOS DEL VEHICULO
$QVeh = mysql_query("select * from seguro_vehiculo WHERE id ='" . $row['id_vehiculo'] . "' LIMIT 1");
//echo "select * from seguro_vehiculo WHERE id ='".$row['id_vehiculo']."' LIMIT 1";
$RQVehi = mysql_fetch_array($QVeh);

$tarifa = explode("/", TarifaVehiculo($RQVehi['veh_tipo']));

$dpa     = substr(FormatDinero($tarifa[0]), 0, -3);
$rc         = substr(FormatDinero($tarifa[1]), 0, -3);
$rc2     = substr(FormatDinero($tarifa[2]), 0, -3);
$ap         = substr(FormatDinero($tarifa[3]), 0, -3);
$fj         = substr(FormatDinero($tarifa[4]), 0, -3);

$montoSeguro = RepMontoSeguro($row['id']);

$poliza = GetPrefijo($row['id_aseg']) . '-' . str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
$Agent = explode("-", $row['x_id']);
$Agencia = explode("/", AgenciaVia($Agent[0]));
?>



<script type="text/javascript">
    function imprSelec2(nombre) {
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
<!---->
<div id="ImprimirPoliza2" align="center" style="display:none">
    <table style="width:690px; margin-bottom: 5px;" align="center" cellpadding="2" cellspacing="0">
        <tr>
            <td colspan="2">

                <div style="height:103px !important; border:solid 0px #ABA6A6 !important;"></div>

            </td>
        </tr>
    </table>


    <table width="<?= $ancho ?>px;" style="font-size:11px;" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="462" align="left" valign="top">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:87px !important;">&nbsp;</td>
                        <td><?= $RQClient['asegurado_nombres'] ?> <?= $RQClient['asegurado_apellidos'] ?></td>
                    </tr>
                </table>

            </td>
            <td width="447" align="left" valign="top">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:123px !important;">&nbsp;</td>
                        <td><?= $poliza ?></td>
                    </tr>
                </table>


            </td>
        </tr>
        <tr>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:87px !important;">&nbsp;</td>
                        <td><?= CedulaPDF($RQClient['asegurado_cedula']) ?></td>
                    </tr>
                </table>

            </td>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:123px !important;">&nbsp;</td>
                        <td><?= NombreSeguroS($row['id_aseg']) ?></td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:87px !important;">&nbsp;</td>
                        <td><?= $RQClient['asegurado_direccion'] ?></td>
                    </tr>
                </table>

            </td>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:123px !important;">&nbsp;</td>
                        <td><?= FechaListPDF($row['fecha']) ?></td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:87px !important;">&nbsp;</td>
                        <td><?= TelefonoPDF($RQClient['asegurado_telefono1']) ?></td>
                    </tr>
                </table>

            </td>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:123px !important;">&nbsp;</td>
                        <td><?= FechaListPDFn($row['fecha_inicio']) ?></td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:87px !important;">&nbsp;</td>
                        <td><?= strtoupper($Agencia[0]) ?></td>
                    </tr>
                </table>

            </td>
            <td valign="top" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:123px !important;">&nbsp;</td>
                        <td><?= FechaListPDFin($row['fecha_fin']) ?></td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td valign="top" align="left" colspan="2">
                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:20px !important;">&nbsp;</td>
                        <td><b><?= strtoupper($Agencia[1]) ?> &nbsp;</b></td>
                    </tr>
                </table>
                <div style="height:1px !important; border:solid 0px #ABA6A6 !important;"> </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">

                <div style="height:178px !important; border:solid 0px #ABA6A6 !important;"> </div>

            </td>
        </tr>

        <tr>
            <td colspan="2">

                <div style="height:22px !important; border:solid 0px #ABA6A6 !important;"> </div>

            </td>
        </tr>
        <tr>
            <td valign="bottom" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:46px !important;">&nbsp;</td>
                        <td><?= TipoVehiculo($RQVehi['veh_tipo']) ?></td>
                    </tr>
                </table>

            </td>
            <td valign="bottom" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:17px !important;">&nbsp;</td>
                        <td><?= $RQVehi['veh_ano'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="bottom" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:66px !important;">&nbsp;</td>
                        <td><?= VehiculoMarca($RQVehi['veh_marca']) ?></td>
                    </tr>
                </table>
            </td>
            <td valign="bottom" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:39px !important;">&nbsp;</td>
                        <td><?= $RQVehi['veh_chassis'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="bottom" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:71px !important;">&nbsp;</td>
                        <td><?= VehiculoModelos($RQVehi['veh_modelo']) ?></td>
                    </tr>
                </table>

            </td>
            <td valign="bottom" align="left">

                <table width="100%" style=" font-size:11px;">
                    <tr>
                        <td style="width:80px !important;">&nbsp;</td>
                        <td><?= $RQVehi['veh_matricula'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>



                <table width="<?= $anchoP ?>px;" cellpadding="2" cellspacing="0" style="font-size:11px;">
                    <tr>
                        <td colspan="2" align="left">

                            <div style="height:17px !important; border:solid 0px #ABA6A6 !important;"></div>

                        </td>
                    </tr>
                    <tr>
                        <td align="left" width="260">&nbsp;</td>
                        <td align="left"><?= $dpa ?></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><?= $rc ?></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><?= $rc2 ?></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><?= $rc ?></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><?= $rc2 ?></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><?= $ap ?></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><?= $fj ?></td>
                    </tr>
                </table>



            </td>
            <td valign="top">



                <table width="<?= $anchoP ?>px;" cellpadding="2" cellspacing="0" style="font-size:11px;">
                    <tr>
                        <td colspan="2" align="left">

                            <div style="height:17px !important; border:solid 0px #ABA6A6 !important;"></div>

                        </td>
                    </tr>

                    <?

                    if ($row['serv_adc'] != '') {
                        //BUSCAR CANTAIDAD DE LOS SERVICIOS ADICIONALES
                        /*$porciones = explode("-", $row['serv_adc']);
	 
	for($i =0; $i < count($porciones); $i++){ 
	
	if($porciones>0){
	$r = explode("|", ServAdicional($porciones[$i],$row['vigencia_poliza']));
	$NombreServ = $r[0];
	$MontoServ = $r[1];
	*/
                        $montoServAdc += $MontoServ;

                        $QueryH = mysql_query("select * from seguro_trans_history   
	WHERE id_trans ='" . $_GET['id_trans'] . "'");
                        while ($RowHist = mysql_fetch_array($QueryH)) {

                            if ($RowHist['tipo'] == 'serv') {
                                $montoServAdc += $RowHist['monto'];



                    ?>
                                <tr>
                                    <td align="left" width="265"><?= ServAdicHistory($RowHist['id_serv_adc']) . " - Incluido" ?></td>
                                    <td align="left">RD$ <?= FormatDinero($RowHist['monto']) ?></td>
                                </tr>
                    <?

                            }
                        }
                    }

                    ?>

                </table>




            </td>
        </tr>
        <tr>
            <td align="left" style="padding-left:25px; " valign="middle">



                <table style="height:25px; font-size:12px" cellpadding="1" cellspacing="0">
                    <tr>
                        <td align="left" width="221">&nbsp;</td>
                        <td width="97" align="left"><b><?= FormatDinero($montoSeguro - $montoServAdc) ?></b></td>
                    </tr>
                </table>




            </td>
            <td align="left" valign="middle">



                <table style="height:25px; font-size:12px" cellpadding="1" cellspacing="0">
                    <tr>
                        <td align="left" width="221">&nbsp;</td>
                        <td width="97" align="left"><b><?= FormatDinero($montoServAdc) ?></b></td>
                    </tr>
                </table>



            </td>
        </tr>

        <tr>
            <td colspan="2" align="right" height="25" style="font-size:14px">
                <strong><?= FormatDinero($montoSeguro) ?></strong>
            </td>
        </tr>

        <tr>
            <td colspan="2">

                <div style="height:60px !important; border:solid 0px #ABA6A6 !important;"></div>

            </td>
        </tr>


        <tr>
            <td colspan="2" align="left">

                <table align="center" cellpadding="0" style="margin-top:15px; " width="650px">

                    <tr>
                        <td width="317" align="left" valign="top">


                            <table border="0" align="center" cellpadding="0" style="font-size: 10px; margin-left:5px;">
                                <tr>
                                    <td colspan="2">

                                        <table width="310px">
                                            <tr>
                                                <td align="left"><img src="<?= $logo . $NombreImg ?>" alt="" width="130px" style="margin-bottom: 10px;" /></td>
                                                <td align="left"><img src="<?= $directorio ?>/logo.png" alt="" width="130px" style="margin-bottom: 10px;" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2">

                                        <table width="100%" style=" font-size:11px;">
                                            <tr>
                                                <td style="width:73px !important;">&nbsp;</td>
                                                <td><b><?= GetPrefijo($row['id_aseg']) ?>-<?= str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT) ?></b></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2">

                                        <table width="100%" style=" font-size:11px;">
                                            <tr>
                                                <td style="width:73px !important;">&nbsp;</td>
                                                <td><b><?= $RQClient['asegurado_nombres'] ?> <?= $RQClient['asegurado_apellidos'] ?></b></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2">

                                        <table width="100%" style=" font-size:11px;">
                                            <tr>
                                                <td style="width:73px !important;">&nbsp;</td>
                                                <td><b><?= TipoVehiculo($RQVehi['veh_tipo']) ?> <?= VehiculoMarca($RQVehi['veh_marca']) ?></b></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2">

                                        <table width="100%" style=" font-size:11px;">
                                            <tr>
                                                <td style="width:73px !important;">&nbsp;</td>
                                                <td><b><?= $RQVehi['veh_ano'] ?></b></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2">

                                        <table width="100%" style=" font-size:11px;">
                                            <tr>
                                                <td style="width:73px !important;">&nbsp;</td>
                                                <td><b><?= $RQVehi['veh_chassis'] ?></b></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="left"><b>VIGENCIA:</b></td>
                                    <td align="left">
                                        <b style="font-size:6px">DESDE</b>
                                        <b><?= FechaListPDFn($row['fecha_inicio']) ?></b>
                                        <b style="font-size:6px">HASTA</b>
                                        <b><?= FechaListPDFin($row['fecha_fin']) ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" colspan="2">

                                        <table width="100%" style=" font-size:11px;">
                                            <tr>
                                                <td style="width:78px !important;">&nbsp;</td>
                                                <td><b>RD$ <?= $fj ?></b></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>



                        </td>
                        <td width="318" valign="top">




                            <table align="center" cellpadding="1" border="0" style="font-size:8px" width="315px">
                                <tr>
                                    <td colspan="2" align="left">
                                        El vehículo descrito en el anverso está asegurado bajo la póliza emitida por La Aseguradora, <br>
                                        sujeto a los términos, límites y condiciones que en ella se expresan y al pago de la prima. <br>
                                        <br>
                                        <b>En caso de accidente:</b> <br>
                                        &nbsp;&nbsp;1- Asista a los lesionados, si los hubiere. Con cuidado, retire los vehículos de la vía. <br>
                                        &nbsp;&nbsp;2- No acepte responsabilidad al momento del accidente; reserve su derecho. <br>
                                        &nbsp;&nbsp;3- Obtenga el nombre y la dirección del conductor y el propietario del otro vehículo. <br>
                                        &nbsp;&nbsp;4- Obtenga el número de placa, aseguradora, y número de póliza. <br>
                                        &nbsp;&nbsp;5- Obtenga el nombre y dirección de los lesionados y testigos. <br>
                                        <br>
                                        <b style="text-align:center !important">Comuníquese con la aseguradora antes de iniciar cualquier trámite</b><br>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" align="left"><img src="<?= $logo . $NombreImg ?>" alt="" width="100px" /></td>
                                </tr>

                                <tr>
                                    <td align="left" style="font-size:8px">
                                        <?
                                        $Descp = mysql_query("select * from ticket_poliza WHERE id_aseg ='" . $id_aseguradora . "' LIMIT 4");
                                        while ($rDescp = mysql_fetch_array($Descp)) {

                                            echo $rDescp['ciudad'] . ': ' . $rDescp['telefono'] . '<br>';
                                        }
                                        ?>


                                    </td>
                                    <td align="center" valign="top" style="color:#6886FD; font-size:9px">
                                        <br>Asistencia Vial <br>
                                        Casa del Conductor <br>
                                        809 381 2424
                                    </td>
                                </tr>

                            </table>





                        </td>
                    </tr>
                </table>

            </td>
        </tr>


    </table>
</div>

<table align="center" style="margin-top: 35px; font-size: 22px; text-align: center; margin-bottom: 10px;">
    <tr>
        <td><strong align="center">MENSAJE</strong><br>Seguro que desea imprimir la poliza</td>
    </tr>
    <tr>
        <td>
            <center> <input type="button" class="btn btn-success" value="IMPRIMIR" onclick="javascript:imprSelec2('ImprimirPoliza2');" /></center>
        </td>
    </tr>
</table>