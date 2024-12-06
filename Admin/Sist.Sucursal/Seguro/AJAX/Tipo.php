<?
	ini_set('display_errors',1);
	$login ='7bhoi';
	include("../../../../incluidos/conexion_inc.php");
	Conectarse();
	 
		$veh_tipo2 	= $_GET['tipo_id'];
		
		$rescat = mysql_query("SELECT * FROM seguro_tarifas WHERE veh_tipo = '$veh_tipo2'");
		//echo "SELECT * FROM seguro_tarifas WHERE veh_tipo = '$veh_tipo2'";
		$cat = mysql_fetch_array($rescat);
		//echo "3 ".$cat['3meses']."<br>";	
		//echo "6 ".$cat['6meses']."<br>";
		//echo "12 ".$cat['12meses'];
?>

<script>
//alert(<?=$cat['id']?>);
	$("#label_tipo").html('<?=$cat['nombre']?>');
	$("#label_vigencia3").html('<b>RD$ <?=FormatDinero($cat['3meses'])?></b>');  
	$("#label_vigencia6").html('<b>RD$ <?=FormatDinero($cat['6meses'])?></b>');
	$("#label_vigencia12").html('<b>RD$ <?=FormatDinero($cat['12meses'])?></b>');
	$("#DPA").html('<b>RD$ <?=FormatDinero($cat['dpa'])?></b>');
	$("#RCA").html('<b>RD$ <?=FormatDinero($cat['rc'])?></b>');  
	$("#FJ").html('<b>RD$ <?=FormatDinero($cat['fj'])?></b>');
	$("#RCA2").html('<b>RD$ <?=FormatDinero($cat['rc2'])?></b>');
	
	$("#id_serv").html('<?=$cat['id_serv']?>');

</script>


<?

for( $x = 99; $x < 130; $x++ ){ ?>
  <script>
        $('#tabla<?=$x?>').fadeOut('0');
        $('#HR<?=$x?>').fadeOut('0'); 
  </script>
<? }



$array 		= explode("-", $cat['id_serv']);
$longitud 	= count($array);

for($i=0; $i<$longitud; $i++){
			if($array[$i]>0){
			$IDenc .= $array[$i].",";	
	}
}

$IDenc2 = substr($IDenc, 0, -1);

$rescat2 = mysql_query("SELECT * FROM servicios WHERE id IN (".$IDenc2.")  ");
//echo "SELECT * FROM servicios WHERE id IN (".$IDenc2.")  ";
$numeroRegistros=mysql_num_rows($rescat2); 

if($numeroRegistros > 0){ ?>
	<script>
         $('#textserv').fadeIn('0');
    </script>
<?
while($cat2 = mysql_fetch_array($rescat2)){
	
	//echo "id: ".$cat2['id']."<br>";
?>
	<script>
        $('#tabla<?=$cat2['id']?>').fadeIn('0');
        $('#HR<?=$cat2['id']?>').fadeIn('0'); 
    </script>
<? } }?>
