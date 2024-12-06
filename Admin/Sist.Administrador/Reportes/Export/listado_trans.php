<?
$fecha1  =  $_GET['fecha1'];
$fecha2  =  $_GET['fecha2'];

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte desde - ".$fecha1." - hasta - ".$fecha2.".xls");
	
	ini_set('display_errors',1);
	session_start();
	
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	include("../../../../incluidos/fechas.func.php");
	include("../../../../incluidos/nombres.func.php");
	
	
?>

<table >
    <tr>
      <td colspan="23">
Desde:&nbsp;&nbsp;<?=$fecha1?>&nbsp;&nbsp;&nbsp;Hasta:&nbsp;&nbsp;<?=$fecha2?>
      </td>
    </tr>
  <tr>
    <td>Poliza No.</td>
    <td>Fecha</td>
    <td>Nombre</td>
    <td>Apellido</td>
    <td>Cedula</td>
    <td>Telefono</td>
    <td>Direccion</td>
	<td>Ciudad</td>
    <td>Tipo</td>
    <td>Marca</td>
    <td>Modelo</td>
    <td>A&ntilde;o</td>
    <td>Chassis</td>
    <td>Precio</td>
    <td>Costo</td>
    <td>Plan</td>
    <td>Inicio Vigencia </td>
    <td>Vigencia Fin</td>
    <td>DPA</td>
    <td>RC</td>
    <td>RC2</td>
    <td>FJ</td>
  </tr>
                     
                      
  <? 
  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
	 }
	 
$query=mysql_query("
   SELECT id,fecha,id_cliente,fecha_inicio,fecha_fin,vigencia_poliza,id_vehiculo,user_id,monto,totalpagar
   FROM seguro_transacciones 
   WHERE user_id !='' $wFecha order by id ASC");

  while($row=mysql_fetch_array($query)){
	 
	 if((substr_count($reversadas,"[".$row['id']."]")>0)){
	}else{
	 
	  $total +=$row['monto'];
	  $ganancia += $row['ganancia'];
	  $fh1		= explode(' ',$row['fecha']);

?>
<tr>
    <td><?=$row['id']?></td>
    <td><?=$fh1[0]?></td>
    <td><?=Clientepers($row['user_id'])?></td>
    <td><?=Cliente($row['id_cliente'])?></td>
    <td><?=Cedula($row['id_cliente'])?></td>
    <td><?=Telefono($row['id_cliente'])?></td>
    <td><?=Direccion($row['id_cliente'])?></td>
   <td><?=Ciudad($row['id_cliente']);?></td>
    <td><?
    $TipoM = explode("/", Tipo($row['id_vehiculo']));
	echo $TipoM['0'];
	?></td>
    <td><?
	$marca = VehiculoExport($row['id_vehiculo']);
    $MarcaMod = explode("/", $marca);
	echo $MarcaMod['0'];
	?></td>
    <td><?=$MarcaMod['1'];?></td>
    <td><?=$MarcaMod['2']?></td>
    <td><?=$MarcaMod['3']?></td>
    <td><?="$".FormatDinero($row['monto'])?></td>
    <td><?="$".FormatDinero($row['totalpagar'])?></td>
    <td><?="$".FormatDinero($row['ganancia'])?></td>
    <td><?=Fecha($row['fecha_inicio'])?></td>
    <td><?=Fecha($row['fecha_fin'])?></td>
    <td><?="$".FormatDinero($TipoM['1']);?></td>
    <td><?="$".FormatDinero($TipoM['2']);?></td>
    <td><?="$".FormatDinero($TipoM['3']);?></td>
    <td><?="$".FormatDinero($TipoM['4']);?></td>
</tr>
  <? } }?>   
</table>