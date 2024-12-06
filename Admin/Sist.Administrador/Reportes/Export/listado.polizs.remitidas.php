<?
$fecha1  =  $_GET['fecha1'];
$fecha2  =  $_GET['fecha2'];

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte de polizas remitidas desde - ".$fecha1." - hasta - ".$fecha2.".xls");
	
	 
	session_start();
	ini_set('display_errors',1);
	
	include("../../../../incluidos/conexion_inc.php");
	include("../../../../incluidos/nombres.func.php");
	Conectarse();
	include("../../../../incluidos/fechas.func.php");
	
	// --------------------------------------------	
	if($_GET['fecha1']){
		$fecha1 = $_GET['fecha1'];
	}else{
		$fecha1 = fecha_despues(''.date('d/m/Y').'',-0);
	}
	// --------------------------------------------
	if($_GET['fecha2']){
		$fecha2 = $_GET['fecha2'];
	}else{
		$fecha2 = fecha_despues(''.date('d/m/Y').'',0);
	}
?>


		
<table>
  <tr>
      <td colspan="5" align="center">
        <h1><strong>Reporte de polizas remitidas</strong></h1>
       </td>
  </tr>
    <tr>
      <td colspan="5" align="center">
        <h3>
            <strong>Fecha desde:</strong> <?=$fecha1;?> 
            <strong>Fecha Hasta:</strong> <?=$fecha2;?>
        </h3>
       </td>
  </tr>	
  <tr style="font-size:16px; font-weight:bold; background-color:#d5d5d5;">
    <td>Poliza</td>
    <td style="width:150px">Fecha de Emisión</td>
    <td style="width:220px">Nombre</td>
    <td>Agencia</td>
    <td>Ruta</td>
  </tr>
                     
  <? 
  
  if($_GET['consul']=='1'){
	  	
	$fd1	= explode('/',$fecha1);
	$fh1	= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	$wFecha 	= "AND fecha >= '$fDesde 00:00:00' AND fecha < '$fHasta 23:59:59'";
	
	if($_GET['ruta_id'] !='1todos'){
		$ejecutivo = " ejecutivo LIKE '%".$_GET['ruta_id']."%' ";
	}else{
		//$ejecutivo = "id !='' ";
	}
	
	if($_GET['idpers']){
		$idpers = "AND user_id ='".$_GET['idpers']."' ";
	}else{
		$idpers = "AND user_id !='' ";
	}

	$ED = mysql_query("SELECT * from agencia_via WHERE $ejecutivo $idpers ");
	 //echo "<br>SELECT * from agencia_via WHERE $ejecutivo $idpers  <br>";
    while ($RED = mysql_fetch_array($ED)) {
		$agenci .= "x_id LIKE '%".$RED['num_agencia']."-%' OR "; 
	}
	
	$resulAgen = rtrim($agenci, 'OR ');

/*$qR=mysql_query("SELECT * FROM agencia_via WHERE id !='' $idpers  order by ejecutivo ASC ");
	$num_agencia .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $num_agencia .= "[".$rev['num_agencia']."]";
		$reversadas 	.= ",".$rev['id_trans'];
	 }*/
	
	if($resulAgen){
		$resulAgen = "AND (".$resulAgen.") ";
	}
	
	
	$qR1=mysql_query("SELECT * FROM seguro_transacciones_reversos");
	$reversadas1 .= "0";
	 while($rev1=mysql_fetch_array($qR1)){ 
	    $reversadas1 .= "[".$rev1['id_trans']."]";
		//$reversadas1 	.= ",".$rev1['id_trans'];
	 }
	 
	 
  $query=mysql_query("SELECT * FROM seguro_transacciones 
  WHERE monto !='' $idpers  $wFecha $resulAgen order by id DESC");
  
  while($row=mysql_fetch_array($query)){
	 
	 if((substr_count($reversadas1,"[".$row['id']."]")>0)){ 
	 }else{
		 $Agent = explode("-", $row['x_id']);
		 $Agencia = explode("/", AgenciaVia($Agent[0]));
		 $varia = array("Ruta ", "RUTA", " ", "-", "/");
		 $ruta = str_replace($varia, "", $Agencia[1]);
		 
		$array[$Agencia[1]][] = $row; 
	 }

  }

	ksort($array);
	
	/*echo "<pre>";
		print_r($array);
	echo  "</pre>";*/
	
	
	foreach ($array as $key => $val) {
		
		
		foreach ($val as $key2 => $row) {
			
			 $client2 = explode("|", ClientesVerRemesa($row['id_cliente']) );
			 $Agent2 = explode("-", $row['x_id']);
			 $Agencia2 = explode("/", AgenciaVia($Agent2[0]));
			 
			 $varia2 = array("Ruta ", "RUTA", " ", "-", "/");
			 $ruta2 = str_replace($varia2, "", $Agencia2[1]);
	  
?>
<tr>
    <td><?=GetPrefijo($row['id_aseg'])."-".str_pad($row['id_poliza'],6, "0", STR_PAD_LEFT);?></td>
    <td><?=FechaListPDF($row['fecha'])?></td>
    <td><?=$client2[0]." ".$client2[1]?></td>
    <td><?=$Agent2[0]." - ".strtoupper($Agencia2[0])?></td>
    <td><?=strtoupper($Agencia2[1])?></td>
</tr>
  <?
   
		}
      } 
  	}
	

  ?>
                  </table>
