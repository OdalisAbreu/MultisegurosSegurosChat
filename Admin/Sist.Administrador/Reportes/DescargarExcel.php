<? ini_set('display_errors',1);
$a = str_pad($_GET['num'], 4, "0", STR_PAD_LEFT);
$numero = $_GET['sigla']."-".$_GET['year']."-".$a;
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Remesa ".$numero.".xls");
session_start();

include("../../../incluidos/conexion_inc.php");
include("../../../incluidos/fechas.func.php");
//include("../../../incluidos/nombres.func.php");
Conectarse();

$Rem = mysql_query("SELECT * FROM remesas WHERE id='".$_GET['id']."' LIMIT 1");
$Res = mysql_fetch_array($Rem);

$fecha1 = explode(" ", $Res['fecha_desde']);
$fecha2 = explode(" ", $Res['fecha_hasta']);
$fp  	= explode(' ',$Res['fecha_pago']);
$fp2  	= explode('-',$fp[0]);
$fecha_pago = $fp2[2]."-".$fp2[1]."-".$fp2[0];

$Desdew = $Res['fecha_desde'];
$Hastaw = $Res['fecha_hasta'];

$wFecha = "fecha >= '$Desdew' AND fecha <= '$Hastaw' AND ";


function NombreSeguroS($id){
	$r5 = mysql_query("SELECT id, nombre FROM seguros WHERE id='".$id."' LIMIT 1");
    $row5=mysql_fetch_array($r5);
	return $row5['nombre'];
}

function Fecha($id){
	$clear1 = explode(' ',$id);  
	$fecha_vigente1 = explode('-',$clear1[0]); 
	   
	   if($fecha_vigente1[1] =='01'){ $mes =' Enero'; }
	   if($fecha_vigente1[1] =='02'){ $mes =' Febrero'; }
	   if($fecha_vigente1[1] =='03'){ $mes =' Marzo'; }
	   if($fecha_vigente1[1] =='04'){ $mes =' Abril'; }
	   if($fecha_vigente1[1] =='05'){ $mes =' Mayo'; }
	   if($fecha_vigente1[1] =='06'){ $mes =' Junio'; }
	   if($fecha_vigente1[1] =='07'){ $mes =' Julio'; }
	   if($fecha_vigente1[1] =='08'){ $mes =' Agosto'; }
	   if($fecha_vigente1[1] =='09'){ $mes =' Septiembre'; }
	   if($fecha_vigente1[1] =='10'){ $mes =' Octubre'; }
	   if($fecha_vigente1[1] =='11'){ $mes =' Noviembre'; }
	   if($fecha_vigente1[1] =='12'){ $mes =' Diciembre'; }
	   return $Vard = $fecha_vigente1[2].' de '.$mes.' del '.$fecha_vigente1[0];
}

function VehiculoImp($id){
		$query=mysql_query("
		SELECT id,veh_tipo FROM  seguro_vehiculo
		WHERE id='".$id."' LIMIT 1");
		$row=mysql_fetch_array($query);
		return $row['veh_tipo'];
	}

	
	
	function Clientes($id){
		$query=mysql_query("
		SELECT * FROM  seguro_clientes
		WHERE id='".$id."' LIMIT 1");
		$row=mysql_fetch_array($query);
		return $row['asegurado_nombres']."|".$row['asegurado_apellidos']."|".$row['asegurado_cedula'];
	}

	function GetPrefijo2($id){
		$queryp=mysql_query("SELECT * FROM  seguros WHERE id='".$id."' LIMIT 1");
		$rowp=mysql_fetch_array($queryp);
		return $rowp['prefijo'];
	}


	function FechaImp2W($id){
		$clear1 = explode(' ',$id);  //2018-02-01 23:33:45
		$fp2 = explode('-',$clear1[0]); 
	   
		//return $fp2[0]."-".$fp2[1]."-".$fp2[2];
		
	   if($fp2[1] =='01'){ $mes2 ='Ene'; }
	   if($fp2[1] =='02'){ $mes2 ='Feb'; }
	   if($fp2[1] =='03'){ $mes2 ='Mar'; }
	   if($fp2[1] =='04'){ $mes2 ='Abr'; }
	   if($fp2[1] =='05'){ $mes2 ='May'; }
	   if($fp2[1] =='06'){ $mes2 ='Jun'; }
	   if($fp2[1] =='07'){ $mes2 ='Jul'; }
	   if($fp2[1] =='08'){ $mes2 ='Ago'; }
	   if($fp2[1] =='09'){ $mes2 ='Sep'; }
	   if($fp2[1] =='10'){ $mes2 ='Oct'; }
	   if($fp2[1] =='11'){ $mes2 ='Nov'; }
	   if($fp2[1] =='12'){ $mes2 ='Dic'; }
	   return "&nbsp;".$fp2[2]."-".$mes2."-".$fp2[0];
		
	   //return $Vard = $fecha_vigente1[2].'-'.$mes2.'-'.$fecha_vigente1[0];
	   //return $clear1[0];
	   
}


	function PrecioSeg($id){
	   $queryT=mysql_query("SELECT id, id_trans, monto, costo
	   FROM seguro_trans_history WHERE id_trans ='".$id."' AND tipo='seg' LIMIT 1");
	   $rowTs=mysql_fetch_array($queryT);
		  return $rowTs['costo']."|".$rowTs['monto']; 
	}
	
	
	$qR=mysql_query("SELECT * FROM seguro_transacciones_reversos WHERE id !=''");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['id_trans']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	 
	function NombreBancoRep($id){
	$querbancy=mysql_query("SELECT * FROM cuentas_de_banco 
	WHERE id ='".$id."' LIMIT 1");
    $ssd=mysql_fetch_array($querbancy);
	return $ssd['nombre_banc']." (<font style='font-size: 13px; color: #2196F3;'>No. Cta. ".$ssd['num_cuenta']."</font>)";
}


function NombreBancoSuplidoresRep($id){
	$querbancy=mysql_query("SELECT * FROM bancos_suplidores 
	WHERE id ='".$id."' LIMIT 1");
    $ssd=mysql_fetch_array($querbancy);
	
	return BancoNomNew($ssd['id_banc'])." (<font style='font-size: 13px; color: #2196F3;'>No. Cta. ".$ssd['num_cuenta']."</font>)";
}

function NombreSuplidoresRep($id){
	$querbancy1=mysql_query("SELECT * FROM bancos_suplidores 
	WHERE id ='".$id."' LIMIT 1");
    $ssd1=mysql_fetch_array($querbancy1);
	return $ssd1['nombres'];
}	

function BancoNomNew($id){
	$r6 = mysql_query("SELECT id, nombre_banc FROM bancos WHERE id='".$id."' LIMIT 1");
  while($row6=mysql_fetch_array($r6)){
	  return $row6['nombre_banc'];
  	}	
}

?>

<table cellpadding="4" cellspacing="0">
	<tr>
		<td colspan="11"> 
		
		
		
		<table width="100%" cellpadding="9" cellspacing="0">
	<tr>
    	<td colspan="4">
		
		<b style="font-size: 35px; color: #d9261c;">Multi</b><b style="font-size: 35px; color: #828282;">Seguros 
			</b>	
		</td>
    	
   
	  <td align="center" colspan="4">
		  <font style="font-size: 19px; color: #828282; font-weight: bold;">
		  	<b>REPORTE DE REMESA</b>
		  </font>
		  
		  <br>
		   <font style="font-size: 16px; color: #828282; font-weight: bold;">  
		  	<?=NombreSeguroS($Res['id_aseg'])?>
		  </font>  <br>
          
		  <font style="font-size: 14px; color: #828282; font-weight: bold;">
		  	<b>Desde:</b> <?=$fecha1[0]?> <b>Hasta:</b> <?=$fecha2[0]?>
			</font>
	  </td>
	  <td colspan="3" align="right" style="font-size: 14px;">
	  	Remesa No. <?=$numero?><br>	
		<b>Fecha de Impresi&oacute;n:</b> <br>	
			<?=Fecha(date("Y-m-d"))?>
	  </td>
  </tr>
	
</table>


		</td>
	</tr>
	
	
   <tr style="background-color:#B1070A; color:#FFFFFF; font-size:14px;">
   		<td></td>
        <td>No. Poliza</td>
        <td>Nombres</td>
        <td>Apellidos</td>
        <td>C&eacute;dula</td>
        <td>Fecha Emisi&oacute;n</td>
        <td>Inicio Vigencia</td>
        <td>Fin Vigencia</td>
        <td>Prima</td>
		<td>Comisi&oacute;n</td>
		<td>Total a Remesar</td>
   </tr>
    
	<?
	
function CedulaExport($id){
  
	  $cedula 	= str_replace("-","",$id);
	  $in  		= $cedula;
  	  $ced 	= substr($in,0,3)."-".substr($in,3,-1)."-".substr($in,-1);
  	  
	  return $ced;	
  }	
	
	 
$quer1 = mysql_query("SELECT * FROM seguro_transacciones WHERE $wFecha id_aseg='".$Res['id_aseg']."' order by id ASC");
	while($u=mysql_fetch_array($quer1)){
	
	if((substr_count($reversadas,"[".$u['id']."]")>0)){
	}else{
		
	$t++;
		
	 
	$Remn 	= explode("|", PrecioSeg($u['id']));
	$Tremesar += $Remn[0];
	$Tmonto	  += $Remn[1];
	$remesar   = $Remn[0];
	$monto     = $Remn[1];
	
	$cliente =  explode("|", Clientes($u['id_cliente']));
	$pref = GetPrefijo2($u['id_aseg']);
	$idseg = str_pad($u['id_poliza'], 6, "0", STR_PAD_LEFT);
	$prefi = $pref."-".$idseg;
	
	$comision = $monto - $remesar;
	
	$tComsion += $comision;
	
	
?>
	<tr>
   		<td><?=$t?></td>
        <td><?=$prefi?></td>
        <td><?=$cliente[0]?></td>
        <td><?=$cliente[1]?></td>
        <td><?=CedulaExport($cliente[2])?></td>
        <td><?=FechaImp2W($u['fecha'])?></td>
        <td><?=FechaImp2W($u['fecha_inicio'])?></td>
        <td><?=FechaImp2W($u['fecha_fin'])?></td>
        <td>$<?=formatDinero($monto)?></td>
		<td>$<?=formatDinero($comision)?></td>
		<td>$<?=formatDinero($remesar)?></td>
   </tr>
		 
<?		  

    } }
	
?>
<tr style="font-size:14px; font-weight:bold">
	<td colspan="8" align="right"></td>
	<td></td>
	<td></td>
	<td></td>
</tr>


<tr style="font-size:14px; font-weight:bold">
	<td colspan="9" align="right"> Total Primas:</td>
	<td>$<?=formatDinero($Tmonto)?></td>
	<td></td>
</tr>

<tr style="font-size:14px; font-weight:bold">
	<td colspan="9" align="right"> Total Remesas:</td>
	<td>$<?=formatDinero($Tremesar)?></td>
	<td></td>
</tr>



<tr>
	<td colspan="11">&nbsp;</td>
</tr>
<tr>
	<td colspan="11">&nbsp;</td>
</tr>
<tr>
	<td colspan="11" style="font-size: 14px;">
    
    
    Saludos, estimado cliente:
		<p>
		<br />

El balance fue transferido de la cuenta del <?=NombreBancoRep($Res['banc_emp'])?> a la cuenta del <?=NombreBancoSuplidoresRep($Res['banc_benef'])?> a nombre de <?=NombreSuplidoresRep($Res['banc_benef'])?>, con el No. de el documento <b>#<?=$Res['num_doc']?></b>, depositado el dia <b><?=$fecha_pago?></b>



<p>
<b>Descripci&oacute;n del documento:</b><br><?=$Res['descrip']?>
<p><p>
Este mensaje puede contener información privilegiada y confidencial. Dicha información es exclusivamente para el uso del individuo o entidad al cual es enviada. Si el lector de este mensaje no es el destinatario del mismo, queda formalmente notificado que cualquier divulgación, distribución, reproducción o copiado de esta comunicación está estrictamente prohibido. Si este es el caso, favor de eliminar el mensaje de su computadora e informar al emisor a través de un mensaje de respuesta. <br />

<br />
<br />
 MultiSeguros
    
    </td>
</tr>








</table>