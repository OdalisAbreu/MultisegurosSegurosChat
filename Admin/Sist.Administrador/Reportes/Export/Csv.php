<?
ini_set('display_errors',1);
$fecha1  =  $_GET['fecha1'];
$fecha2  =  $_GET['fecha2'];
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte desde - ".$fecha1." - hasta - ".$fecha2.".csv");
	session_start();
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/fechas.func.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	if($_GET['aseguradora'] !='1aseg'){
		$aseg = "AND id_aseg='".$_GET['aseguradora']."' ";
		$nombre = NombreSeguroS($_GET['aseguradora']);
		$clase = "1";
		$columna = "22";
		$colspan ="8";
		$colspan2 ="14";
		$calt = "17";
	}else{
		$nombre = "TODAS LAS ASEGURADORAS";
		$columna = "23";
		$clase = "0";
		$colspan ="9";
		$colspan2 ="13";
		$calt = "18";
	}
function CiudadRep($id){
	$query=mysql_query("SELECT * FROM  seguro_clientes WHERE id='".$id."' LIMIT 1");
	$row=mysql_fetch_array($query);
	$queryp1=mysql_query("SELECT * FROM  ciudad WHERE id='".$row['ciudad']."' LIMIT 1");
	$rowp1=mysql_fetch_array($queryp1);
	$queryp2=mysql_query("SELECT * FROM  municipio WHERE id='".$rowp1['id_muni']."' LIMIT 1");
	$rowp2=mysql_fetch_array($queryp2);
	$queryp3=mysql_query("SELECT * FROM   provincia WHERE id='".$rowp2['id_prov']."' LIMIT 1");
	$rowp3=mysql_fetch_array($queryp3);
	return $rowp3['descrip'];
}
?>#,No.Poliza<? if($clase=='0'){?>,Aseguradora<? } ?>,Nombres,Apellidos,C&eacute;dula,Direcci&oacute;n,Ciudad,Tel&eacute;fono,Tipo,Marca,Modelo,A&ntilde;o,Chassis,Placa,Fecha Emisi&oacute;n,Inicio Vigencia,Fin Vigencia,DPA,RC,RC2,FJ,Prima

  <? 
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 24:00:00'";
	
	
$query=mysql_query("
   SELECT * FROM seguro_transacciones 
   WHERE user_id !='' $wFecha $aseg order by id ASC");

  while($row=mysql_fetch_array($query)){
	  $total +=$row['monto'];
	  $ganancia += $row['ganancia'];
	  $fh1		= explode(' ',$row['fecha']);
	  $Cliente = explode("|", Cliente($row['id_cliente']));
	  $Client = str_replace("|", "", $Cliente[0]);
	  $i++;
	  
	  $pref = GetPrefijo($row['id_aseg']);
	  $idseg = str_pad($row['id_poliza'], 6, "0", STR_PAD_LEFT);
	  $prefi = $pref."-".$idseg;
	  
	  $TipoM = explode("/", Tipo($row['id_vehiculo']));
	  $TipoM['1'] = substr(formatDinero($TipoM['1']), 0, -3);
	  $TipoM['2'] = substr(formatDinero($TipoM['2']), 0, -3);
	  $TipoM['3'] = substr(formatDinero($TipoM['3']), 0, -3);
	  $TipoM['4'] = substr(formatDinero($TipoM['4']), 0, -3);
	  $monto 	  = substr(formatDinero($row['monto']), 0, -3);

?><?=$i?>,<?=$prefi?><? if($clase=='0'){?>,<?=NombreSeguroS($row['id_aseg'])?><? } ?>,<?=$Client?>,<?=$Cliente[1]?>,<?=Cedula($row['id_cliente'])?>,<?=Direccion($row['id_cliente'])?>,<?=CiudadRep($row['id_cliente']);?>,<?=Telefono($row['id_cliente'])?>,<?=$TipoM['0']?>,<?
	$marca = VehiculoExport($row['id_vehiculo']);
    $MarcaMod = explode("/", $marca);
	echo VehiculoMarca($MarcaMod['0']);
	?>,<?=VehiculoModelos($MarcaMod['1']);?>,<?=$MarcaMod['2']?>,<?=$MarcaMod['3']?>,<?=$MarcaMod['4']?>,<?=$row['fecha']?>,<?=FechaReporte($row['fecha_inicio'])?>,<?=FechaReporte($row['fecha_fin'])?>,<?=$TipoM['1']?>,<?=$TipoM['2']?>,<?=$TipoM['3']?>,<?=$TipoM['4']?>,<?=$monto?>

  <? } ?> 
  
<h4>Total de primas</h4>
<h4><?=formatDinero($total)?></h4>