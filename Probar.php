 <?  
 
 	$servicios = $_POST['servicios'];
 	session_start();
	ini_set("display_errors",0);
	include("incluidos/conexion_inc.php");
	
	Conectarse(); 
?>

<form action="http://seguros101.net/SegurosChat/Probar.php" method="post">
<?

if($_POST){
	include("incluidos/nombres.func.php");
	echo "<br><br>Monto===============> ".$_POST['monto']."<br>";
	echo "Vigencia=============> ".$_POST['vigencia_poliza']."<br>";
	
	
	
	//print_r($_POST);
	echo "<br>";
	
	
	$_POST['servicios'] = $servicios;
		 
	//echo "Count ".count($_POST['servicios'])."<br>";
		
		$MontoServicio= "0";
		
		for($i =0; $i < count($_POST['servicios']); $i++){
				$_POST['serv'] .= "".$_POST['servicios'][$i]."-";
				
			$MontoServicio += MontoServicio($_POST['servicios'][$i],$_POST["vigencia_poliza"]);
		}
		
		echo "Monto servicio========> ".$MontoServicio."<br>";
		echo "Monto total===========> ".$total = $MontoServicio + $_POST['monto']."<br>";
		/*$serv1 = explode(",", $_POST['serv']);
		for($i =0; $i < count($_POST['servicios']); $i++){
				$_POST['serv'] .= "".$_POST['servicios'][$i].",";
				
			
		}*/
		
		
		
		echo "serv ".$_POST['serv']."<br>";
		
		$desglose = explode("-",$_POST['serv']);
		
		for ($i=0;$i<count($desglose);$i++){ 
			echo $desglose[$i];
		}
		
	unset($_POST['servicios']);
	
	
	
	
}

 
	 

 $query=mysql_query("
	SELECT * FROM servicios 
	WHERE activo ='si'
	ORDER BY id ASC ");
  while($nominadep=mysql_fetch_array($query)){
	  ?>
                             
                        <table cellspacing="5" style="margin-bottom: 12px;">
                        	<tr>
                             	<td><b><?=$nominadep['id']." - ".$nominadep['nombre']?></b> </td>
                             	<td style="width:20px">&nbsp;</td>
                             	<td align="center"><b>3 Meses</b></td>
                                <td style="width:20px">&nbsp;</td>
                                <td align="center"><b>6 Meses</b></td>
                                <td style="width:20px">&nbsp;</td>
                                <td align="center"><b>1 A&ntilde;o</b></td>
                                <td style="width:20px">&nbsp;</td>
                                <td>&nbsp;</td>
                             </tr>
                             <tr>
                             	<td>&nbsp;</td>
                                <td>&nbsp;</td>
                             	<td align="center"><?=FormatDinero($nominadep['3meses'])?></td>
                                <td>&nbsp;</td>
                                <td align="center"><?=FormatDinero($nominadep['6meses'])?></td>
                                <td>&nbsp;</td>
                                <td align="center"><?=FormatDinero($nominadep['12meses'])?></td>
                                <td>&nbsp;</td>
                                <td align="right">
                                <input name="servicios[]" type="checkbox"   value="<?=$nominadep['id']?>" />
                                
                                
                                </td>
                             </tr>
                           </table>
                          
                            
                             
                             <? } ?>
                 <input  type="submit" value="Realizar Venta" class="btn btn-primary"/>   
                 <input name="vigencia_poliza" id="vigencia_poliza" type="hidden" value="3" /> 
                 <input name="monto" id="monto" type="hidden" value="3755" />        
             </form>