<?
	//ini_set('display_errors',1);
	session_start();
	include("../conexion_inc.php");
	Conectarse();
	
	$idu = $_GET['id'];
	
	$query=mysql_query("SELECT * FROM recarga_retiro 
	WHERE id_pers ='".$idu."' order by id DESC LIMIT 1");
    $row=mysql_fetch_array($query);
	
	$bl_cred 	= $row['cred_actual'];
	
?>
<script> $('#bl_cred<?=$idu?>').text('$<?=FormatDinero($bl_cred)?>');</script>