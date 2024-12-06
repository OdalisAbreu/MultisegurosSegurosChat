<?
ini_set('display_errors',1);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=modelos.xls");

session_start();
include("../../../../incluidos/conexion_inc.php");
include("../../../../incluidos/fechas.func.php");
Conectarse();
	
?>
<table cellpadding="4" cellspacing="0">
   <tr >
   		<td style="background-color:#B1070A; color:#FFFFFF; font-size:14px; width:80px">ID MODELO</td>
        <td style="background-color:#B1070A; color:#FFFFFF; font-size:14px; width:150px">Marca</td>
        <td style="background-color:#B1070A; color:#FFFFFF; font-size:14px; width:150px">Modelo</td>
     <td style="background-color:#B1070A; color:#FFFFFF; font-size:14px; width:50px">Estado</td>
        <td style="background-color:#B1070A; color:#FFFFFF; font-size:14px; width:50px">Usado</td>
   </tr>
   <?

	$qR=mysql_query("SELECT * FROM seguro_vehiculo WHERE id !=''");
	$reversadas .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    $reversadas .= "[".$rev['veh_modelo']."]";
		//$reversadas 	.= ",".$rev['id_trans'];
	 }
	
	
	function Marcas($id){
		$qR=mysql_query("SELECT * FROM seguro_marcas WHERE id ='".$id."'");
	 	$rev=mysql_fetch_array($qR);
	    return $rev['DESCRIPCION'];
	}
	
	
	$quer1 = mysql_query("SELECT * FROM seguro_modelos order by IDMARCA ASC");
	while($u=mysql_fetch_array($quer1)){
?>
	<tr>
   		<td align="left"><?=$u['ID']?></td>
        <td align="left"><?=Marcas($u['IDMARCA'])?></td>
      <td align="left"><?=$u['descripcion']?></td>
        <td align="left"><? if ($u['activo']=='si'){ 
		echo "<font color='#1D0CD6'><b>".$u['activo']."</b></font>";
	   }else{
		echo "<font color='#F6060A'><b>".$u['activo']."</b></font>";
	   }
	?></td>
    <td align="left">
    
    <?
    	if((substr_count($reversadas,"[".$u['ID']."]")>0)){
			echo "Usado";
		}
	?>
    
    </td>
   </tr>
		 
<?		  

    } 
	
?>

</table>