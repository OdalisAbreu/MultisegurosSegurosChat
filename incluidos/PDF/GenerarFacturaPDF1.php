<?php

	ini_set('display_errors', 1);
	date_default_timezone_set('America/Santo_Domingo');
	require_once('tcpdf/config/lang/eng.php');
	require_once('tcpdf/tcpdf.php');
	
	session_start();
	ini_set('display_errors',1);
	include("../conexion_inc.php");
	include("../nombres.func.php");
	include("../fechas.func.php");
	Conectarse();
	
	
	$html = '<table width="100%" align="center" cellspacing="0" >
	<tr>
    	<td colspan="9" align="center">
			<b>Listados de venta de Seguros</b><br>Desde: 25/07/2017 Hasta: 25/07/2017 
		</td>
    </tr>
    <tr>
    	
		
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 100px;">Fecha</td>
		
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; ">Nombre</td>
		
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; ">Asegurado</td>
		
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 110px;">Cedula</td>
		
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 100px;">Monto</td>
		
		<td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px;  width: 90px;">Ganancia</td>
		
		<td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; ">Vigencia</td>
		
		<td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; ">Vehiculo</td>
		
    </tr>';
   
  
	$query=mysql_query("
   SELECT id,fecha,id_cliente,fecha_inicio,vigencia_poliza,id_vehiculo,user_id,monto,ganancia2 FROM seguro_transacciones WHERE ( user_id='15' OR user_id='16' OR user_id='18' ) AND fecha >= '2017-07-25 00:00:00' AND fecha < '2017-07-25 24:00:00' order by id ASC");

  while($row=mysql_fetch_array($query)){
	  $total 	+=$row['monto'];
	  $ganancia += $row['ganancia2'];
	  $fh1		= explode(' ',$row['fecha']);

$html .= '
      <tr>
       
        <td>'.$fh1[0].'</td>
        <td>'.Clientepers($row['user_id']).'</td>
        <td>'.ClienteRepS($row['id_cliente']).'</td>
        <td>'.Cedula($row['id_cliente']).'</td>
        <td>'."$".FormatDinero($row['monto']).'</td>
        <td>'."$".FormatDinero($row['ganancia2']).'</td>
        <td>'.Vigencia($row['vigencia_poliza']).'</td>
        <td>'.Vehiculo($row['id_vehiculo']).'</td>
    </tr>';

  } 



$html .= '
<tr>
    <td colspan="7"></td>
    <td><strong>Total</strong></td>
    <td><strong>'."$".FormatDinero($total).'</strong></td>
</tr>
 <tr>
    <td colspan="7"></td>
    <td><strong>Ganancia</strong></td>
    <td><strong>'."$".FormatDinero($ganancia).'</strong></td>
</tr>

</table>'; 
	// * * * Direccion del Archivo
	 
	if($html !=='0'){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setLanguageArray($l);
		$pdf->AddPage();
		
		$pdf->writeHTML($html, true, 0, true, false, '');
		$pdf->lastPage();
		$nombreFile = 'Ventas_'.$_GET['user_id'].'_'.date('d-m-Y');
		$pdf->Output("Archivos/$nombreFile.pdf", 'F');
		echo $nombreFile.".pdf";
}

?>