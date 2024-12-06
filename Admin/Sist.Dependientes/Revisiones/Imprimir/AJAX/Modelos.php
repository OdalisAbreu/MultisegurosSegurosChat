<?
	ini_set('display_errors',1);
	$login ='7bhoi';
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	 
		$veh_tipo2 	= $_GET['idseg'];
		
		$rescat = mysql_query("SELECT * FROM seguros WHERE id = '$veh_tipo2' ");
		$cat = mysql_fetch_array($rescat);
		echo $cat['prefijo'];	
?>


