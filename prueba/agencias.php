<?
	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");
	//ini_set('session.cache_expire','3000'); 
	session_start();
	ini_set('display_errors',1);
	
	include("../incluidos/conexion_inc.php");
	include("../incluidos/nombres.func.php");
	Conectarse();

   

	
	
function Remplazar($text) { 
	$text = str_replace("Ñ", 'N', $text); 
	$text = str_replace("ñ", 'n', $text); 
	$text = str_replace("ā", 'a', $text); 
	$text = str_replace("Ā", 'A', $text); 
	$text = str_replace("É", 'E', $text); 
	$text = str_replace("é", 'e', $text); 
	$text = str_replace("í", 'i', $text); 
	$text = str_replace("Í", 'I', $text); 
	$text = str_replace("ú", 'u', $text); 
	$text = str_replace("Ú", 'U', $text); 
	$text = str_replace("Ó", 'O', $text); 
	$text = str_replace("ó", 'o', $text); 
	$text = str_replace("�", ' ', $text); 
	return $text; 
}
	
	$qR=mysql_query("SELECT * FROM agencia_via WHERE  user_id ='20' AND id = '918' order by ejecutivo ASC ");
	
	$num_agencia .= "0";
	 while($rev=mysql_fetch_array($qR)){ 
	    //echo Remplazar($rev['razon_social'])."<br>";
		echo utf8_encode(Remplazar($rev['razon_social']));
	 }
	 
?>