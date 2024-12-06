<?
	session_start();
	include("../../../../../incluidos/conexion_inc.php");
	Conectarse();
	
	 if (isset($_REQUEST['q']) && $_REQUEST['q'] !="") {
			$user_mail = strip_tags(addslashes($_REQUEST['q']));
		}
		
	
	$r22s =mysql_query("
	SELECT email from personal WHERE email ='".$user_mail."' AND id !='".$_REQUEST['id']."' "); 
	echo "SELECT email from personal WHERE email ='".$user_mail."' AND id !='".$_REQUEST['id']."' ";
	$r12 = mysql_fetch_array($r22s);
	$row_cnt = mysql_num_rows($r22s);
	
	if ($row_cnt==1) {
		echo "1";
	} else {
		echo "0";
	}

?>