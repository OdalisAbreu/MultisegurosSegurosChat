<?php

	ini_set('display_errors', 1);
	date_default_timezone_set('America/Santo_Domingo');
	require_once('tcpdf/config/lang/eng.php');
	require_once('tcpdf/tcpdf.php');
	
	
	$html = '<table width="100%" align="center" cellspacing="0" >
	<tr>
    	<td colspan="6" align="center"><b>Publicacion de nota</b><br>Primer cuatrimestre | 3ro. A (Primaria) | Lengua Española</td>
    </tr>
    <tr>
    	<td align="left" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px;">Nombre</td>
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 120px;">Enero</td>
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 120px;">Febrero</td>
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 120px;">Marzo</td>
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 120px;">Abril</td>
        <td align="center" style="background-color:#2196f3; color:#FFFFFF; padding-bottom: 5px;  padding-top: 5px; padding-left: 3px; width: 120px;">Mayo</td>
    </tr>
    
      <tr>
    	<td align="left">william alberto</td>
        <td align="center">90</td>
        <td align="center">80</td>
        <td align="center">65</td>
        <td align="center">78</td>
        <td align="center">89</td>
    </tr>
    
    <tr>
    	<td align="left">jose alberto</td>
        <td align="center">95</td>
        <td align="center">88</td>
        <td align="center">85</td>
        <td align="center">70</td>
        <td align="center">69</td>
    </tr>
    
    
      <tr>
    	<td align="left">evaristo alberto</td>
        <td align="center">75</td>
        <td align="center">78</td>
        <td align="center">75</td>
        <td align="center">70</td>
        <td align="center">79</td>
    </tr>
    
     <tr>
    	<td align="left">julio alberto</td>
        <td align="center">85</td>
        <td align="center">88</td>
        <td align="center">75</td>
        <td align="center">60</td>
        <td align="center">69</td>
    </tr>
    
    
     <tr>
    	<td align="left">Ana julia perez</td>
        <td align="center">95</td>
        <td align="center">98</td>
        <td align="center">95</td>
        <td align="center">90</td>
        <td align="center">99</td>
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
		$nombreFile = 'Notas_'.$_GET['user_id'].'_'.date('d-m-Y');
		$pdf->Output("Archivos/$nombreFile.pdf", 'F');
		echo $nombreFile.".pdf";
}

?>