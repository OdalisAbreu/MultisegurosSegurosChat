<?
	// RETORNA EL BALANCE ACTUAL
	//ini_set('display_errors',1);
	session_start();
	include("../conexion_inc.php");
	include("../nombres.func.php");
	Conectarse();
	
	if(!$_GET['id']){
		$idu = $_SESSION['user_id'];
	}else{
		
		$idu = $_GET['id'];
	}
	
	//$_SESSION['show_bl_princ'];
	if($_SESSION['show_bl_princ']=='si'){
		$bl_actual 	= InfoDistribuidor2($_SESSION['dist_id']);
	}else{
			
		$bl_actual 	= BalanceCuenta($idu);
	}
	//echo 'RD$ '.FormatDinero($bl_actual).'';
?>

<script>
	
	 $('#bl_actual').text('$<?=FormatDinero($bl_actual)?>'); 
	 $('#balancemovil').text('$<?=FormatDinero($bl_actual)?>'); 

</script>
