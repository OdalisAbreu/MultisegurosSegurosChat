<?
	session_start();
	include("../../incluidos/conexion_inc.php");
	Conectarse();
	
 
	
	$r22s =mysql_query("
	SELECT email from personal WHERE email ='".$_GET['email']."' AND id !='".$_GET['user_id']."' "); 
	echo "SELECT email from personal WHERE email ='".$_GET['email']."' AND id !='".$_GET['user_id']."' ";
	$r12 = mysql_fetch_array($r22s);
	$cuenta = mysql_num_rows($r22s);
	
	if($cuenta['id'] >1){
		echo "2";
	}else{
		echo "1";
	}
	
	

?>